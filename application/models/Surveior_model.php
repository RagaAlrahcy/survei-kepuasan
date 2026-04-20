<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surveior_model extends CI_Model
{
    private $db_speak;
    private $db_surveyor;

    public function __construct()
    {
        parent::__construct();

        // DB utama
        $this->db = $this->load->database('default', TRUE);

        // DB lain
        $this->db_speak = $this->load->database('speak', TRUE);
        $this->db_surveyor = $this->load->database('surveyor', TRUE);
    }

    /**
     * Ambil semua surveyor yang pernah dinilai
     */
    public function get_all_surveyors()
    {
        // 1. Ambil data dari DB utama
        $this->db->select('IdMemberData');
        $this->db->from('t_kepuasan_surveior');
        $this->db->group_by('IdMemberData');

        $result = $this->db->get()->result_array();

        if (empty($result))
            return [];

        $ids = array_column($result, 'IdMemberData');

        // 2. Ambil nama dari DB surveyor
        $this->db_surveyor->select('ID, NamaGelar');
        $this->db_surveyor->from('mst_member_data');
        $this->db_surveyor->where_in('ID', $ids);

        $members = $this->db_surveyor->get()->result_array();

        // 3. Mapping
        $map = [];
        foreach ($members as $m) {
            $map[$m['ID']] = $m['NamaGelar'];
        }

        // 4. Gabungkan
        $final = [];
        foreach ($result as $r) {
            $final[] = [
                'IdMemberData' => $r['IdMemberData'],
                'nama' => isset($map[$r['IdMemberData']]) ? $map[$r['IdMemberData']] : 'Unknown'
            ];
        }

        // Sort manual
        usort($final, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });

        return $final;
    }

    /**
     * Ambil statistik kepuasan surveyor (TIDAK PERLU DIUBAH)
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

        // distribution
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

                $distribution[$m . '_' . $i] = $this->db->get()->row()->count;
            }
        }

        return [
            'summary' => $result,
            'distribution' => $distribution
        ];
    }

    /**
     * FIX get_survey_details (hapus cross DB join)
     */
    public function get_survey_details($id_member = null)
    {
        // 1. Ambil data utama
        $this->db->select('ks.*, sk.TglPengisian, sk.IdKegiatanAkreditasi');
        $this->db->from('t_kepuasan_surveior ks');
        $this->db->join('t_survei_kepuasan sk', 'ks.IdSurveiKepuasan = sk.IdSurveiKepuasan', 'left');

        if ($id_member && $id_member != 'all') {
            $this->db->where('ks.IdMemberData', $id_member);
        }

        $this->db->order_by('sk.TglPengisian', 'DESC');
        $details = $this->db->get()->result_array();

        if (empty($details))
            return [];

        // 2. Ambil nama surveyor (DB surveyor)
        $member_ids = array_unique(array_column($details, 'IdMemberData'));

        $this->db_surveyor->select('ID, NamaGelar');
        $this->db_surveyor->where_in('ID', $member_ids);
        $members = $this->db_surveyor->get('mst_member_data')->result_array();

        $member_map = [];
        foreach ($members as $m) {
            $member_map[$m['ID']] = $m['NamaGelar'];
        }

        // 3. Ambil RS (DB speak)
        $ids = array_unique(array_column($details, 'IdKegiatanAkreditasi'));
        $ids = array_filter($ids);

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

        // 4. Final mapping
        foreach ($details as &$row) {
            $row['nama_surveior'] = $member_map[$row['IdMemberData']] ?? 'Unknown';
            $row['nama_rs'] = $rs_map[$row['IdKegiatanAkreditasi']] ?? 'Unknown RS';
        }

        return $details;
    }
}