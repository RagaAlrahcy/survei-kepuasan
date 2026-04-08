<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surveior_model extends CI_Model
{
    private $db_speak;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Database 'speak' might be needed for names if not in default
        $this->db_speak = $this->load->database('speak', TRUE);
    }

    /**
     * Ambil semua surveyor yang pernah dinilai
     */
    public function get_all_surveyors()
    {
        $this->db->select('ks.IdMemberData, mm.NamaGelar as nama');
        $this->db->from('t_kepuasan_surveior ks');
        $this->db->join('`management-surveior`.mst_member_data mm', 'mm.ID = ks.IdMemberData', 'left');
        $this->db->group_by('ks.IdMemberData');
        $this->db->order_by('mm.NamaGelar', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Ambil statistik kepuasan surveyor
     */
    public function get_satisfaction_stats($id_member = null)
    {
        $this->db->select('
            COUNT(*) as total_penilaian,
            ROUND(AVG(InteraksiSurveior), 2) as avg_interaksi,
            ROUND(AVG(KetepatanWaktu), 2) as avg_ketepatan,
            ROUND(AVG(KemampuanKomunikasi), 2) as avg_komunikasi,
            ROUND(AVG(SikapPerilaku), 2) as avg_sikap,
            ROUND(AVG((InteraksiSurveior + KetepatanWaktu + KemampuanKomunikasi + SikapPerilaku) / 4), 2) as skor_total
        ');
        $this->db->from('t_kepuasan_surveior');
        
        if ($id_member && $id_member != 'all') {
            $this->db->where('IdMemberData', $id_member);
        }

        $result = $this->db->get()->row_array();

        // Count distribution (1-4) for each metric
        $metrics = ['InteraksiSurveior', 'KetepatanWaktu', 'KemampuanKomunikasi', 'SikapPerilaku'];
        $distribution = [];

        foreach ($metrics as $m) {
            for ($i = 1; $i <= 4; $i++) {
                $this->db->select("COUNT(*) as count");
                $this->db->from('t_kepuasan_surveior');
                $this->db->where($m, $i);
                if ($id_member && $id_member != 'all') {
                    $this->db->where('IdMemberData', $id_member);
                }
                $count_res = $this->db->get()->row_array();
                $distribution[$m . '_' . $i] = $count_res['count'];
            }
        }

        return [
            'summary' => $result,
            'distribution' => $distribution
        ];
    }
    
    /**
     * Ambil data per bulan untuk trend
     */
    public function get_monthly_trend($id_member = null)
    {
        $this->db->select('
            DATE_FORMAT(sk.TglPengisian, "%Y-%m") as bulan_id,
            DATE_FORMAT(sk.TglPengisian, "%M %Y") as bulan_nama,
            ROUND(AVG((ks.InteraksiSurveior + ks.KetepatanWaktu + ks.KemampuanKomunikasi + ks.SikapPerilaku) / 4), 2) as skor_rata_rata
        ');
        $this->db->from('t_kepuasan_surveior ks');
        $this->db->join('t_survei_kepuasan sk', 'ks.IdSurveiKepuasan = sk.IdSurveiKepuasan', 'left');
        
        if ($id_member && $id_member != 'all') {
            $this->db->where('ks.IdMemberData', $id_member);
        }
        
        $this->db->group_by('bulan_id');
        $this->db->order_by('bulan_id', 'ASC');
        
        return $this->db->get()->result_array();
    }

    /**
     * Ambil data detail survei per responden/RS
     */
    public function get_survey_details($id_member = null)
    {
        $this->db->select('
            ks.*,
            sk.TglPengisian,
            sk.IdKegiatanAkreditasi,
            mm.NamaGelar as nama_surveior
        ');
        $this->db->from('t_kepuasan_surveior ks');
        $this->db->join('t_survei_kepuasan sk', 'ks.IdSurveiKepuasan = sk.IdSurveiKepuasan', 'left');
        $this->db->join('`management-surveior`.mst_member_data mm', 'mm.ID = ks.IdMemberData', 'left');

        if ($id_member && $id_member != 'all') {
            $this->db->where('ks.IdMemberData', $id_member);
        }

        $this->db->order_by('sk.TglPengisian', 'DESC');
        $query = $this->db->get();
        $details = $query->result_array();

        if (empty($details)) return [];

        // Ambil semua IdKegiatanAkreditasi unik
        $ids = array_unique(array_column($details, 'IdKegiatanAkreditasi'));
        $ids = array_filter($ids); // hapus null/empty

        $rs_map = [];
        if (!empty($ids)) {
            $this->db_speak->select('ta.IdKegiatanAkreditasi, mrs.Nama as nama_rs');
            $this->db_speak->from('t_akreditasi ta');
            $this->db_speak->join('m_rumah_sakit mrs', 'mrs.IdRumahSakit = ta.IdRumahSakit', 'left');
            $this->db_speak->where_in('ta.IdKegiatanAkreditasi', $ids);
            $rs_results = $this->db_speak->get()->result_array();
            
            foreach ($rs_results as $rs) {
                $rs_map[$rs['IdKegiatanAkreditasi']] = $rs['nama_rs'];
            }
        }

        // Mapping nama RS ke details
        foreach ($details as &$row) {
            $row['nama_rs'] = isset($rs_map[$row['IdKegiatanAkreditasi']]) ? $rs_map[$row['IdKegiatanAkreditasi']] : 'Unknown RS';
        }

        return $details;
    }
}

