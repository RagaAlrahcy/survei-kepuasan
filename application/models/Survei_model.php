<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei_model extends CI_Model
{

    private $db_speak;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Load database 'speak' group defined in config/database.php
        $this->db_speak = $this->load->database('speak', TRUE);
    }

    /**
     * Get Survey Data from Database
     * 
     * Mengambil data dari tabel t_survei_kepuasan dan t_kepuasan_surveior
     * 
     * @param string $start_date YYYY-MM-DD
     * @param string $end_date YYYY-MM-DD
     * @return array
     */
    public function get_survei_data($start_date = null, $end_date = null)
    {
        // Set default dates if not provided
        if (!$start_date)
            $start_date = date('Y-m-d', strtotime('-1 year'));
        if (!$end_date)
            $end_date = date('Y-m-d');

        // Query untuk mendapatkan data survei kepuasan berdasarkan Bulan
        // Kategori dihitung per individu responden (rata-rata 12 pertanyaan)
        // Skor: 1-4. Sangat Baik >= 3.5, Baik >= 2.5, Cukup >= 1.5, Kurang < 1.5
        // Total skor minimal = 12 * 3.5 = 42 for Sangat Baik
        $formula_sum = '(PersiapanWeb + PersiapanSpeak + PersiapanKomunikasiPic + 
                        PersiapanKecepatanRespon + PersiapanJadwalSurveior + 
                        PersiapanAlurMekanisme + PersiapanKualitasIT + 
                        PelaksanaanKetepatanWaktu + PelaksanaanDaring + 
                        PelaksanaanLuring + PelaksanaanInstrumen + 
                        PelaksanaanExitConference)';

        $this->db->select('
            DATE_FORMAT(TglPengisian, "%Y-%m") as bulan_id,
            DATE_FORMAT(TglPengisian, "%M %Y") as bulan_nama,
            COUNT(*) as total_survei,
            SUM(CASE WHEN (' . $formula_sum . ' / 12) >= 3.5 THEN 1 ELSE 0 END) as sangat_baik,
            SUM(CASE WHEN (' . $formula_sum . ' / 12) >= 2.5 AND (' . $formula_sum . ' / 12) < 3.5 THEN 1 ELSE 0 END) as baik,
            SUM(CASE WHEN (' . $formula_sum . ' / 12) >= 1.5 AND (' . $formula_sum . ' / 12) < 2.5 THEN 1 ELSE 0 END) as cukup,
            SUM(CASE WHEN (' . $formula_sum . ' / 12) < 1.5 THEN 1 ELSE 0 END) as kurang,
            ROUND(AVG(' . $formula_sum . ' / 12), 2) as skor_rata_rata
        ');
        $this->db->from('t_survei_kepuasan');
        $this->db->where('DATE(TglPengisian) >=', $start_date);
        $this->db->where('DATE(TglPengisian) <=', $end_date);
        $this->db->group_by('bulan_id');
        $this->db->order_by('bulan_id', 'ASC');

        $query = $this->db->get();
        $results = $query->result_array();

        // Format data untuk dashboard
        $data = [];
        $en_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $id_months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($results as $row) {
            $bulan_label = str_ireplace($en_months, $id_months, $row['bulan_nama']);

            $data[] = [
                'tanggal' => $bulan_label, // Tetap gunakan key 'tanggal' agar kompatibel dengan View
                'sangat_baik' => (int) $row['sangat_baik'],
                'baik' => (int) $row['baik'],
                'cukup' => (int) $row['cukup'],
                'kurang' => (int) $row['kurang'],
                'total_responden' => (int) $row['total_survei'],
                'skor_rata_rata' => (float) $row['skor_rata_rata']
            ];
        }

        return $data;
    }

    /**
     * Get Surveior Satisfaction Data
     * 
     * Mengambil data kepuasan terhadap surveior
     * 
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function get_surveior_data($start_date = null, $end_date = null)
    {
        if (!$start_date)
            $start_date = date('Y-m-d', strtotime('-7 days'));
        if (!$end_date)
            $end_date = date('Y-m-d');

        $this->db->select('
            ks.IdKepuasanSurveior,
            sk.TglPengisian,
            ROUND(AVG(ks.InteraksiSurveior), 2) as avg_interaksi,
            ROUND(AVG(ks.KetepatanWaktu), 2) as avg_ketepatan,
            ROUND(AVG(ks.KemampuanKomunikasi), 2) as avg_komunikasi,
            ROUND(AVG(ks.SikapPerilaku), 2) as avg_sikap,
            ROUND(AVG((ks.InteraksiSurveior + ks.KetepatanWaktu + 
                       ks.KemampuanKomunikasi + ks.SikapPerilaku) / 4), 2) as skor_rata_rata
        ');
        $this->db->from('t_kepuasan_surveior ks');
        $this->db->join('t_survei_kepuasan sk', 'ks.IdSurveiKepuasan = sk.IdSurveiKepuasan', 'left');
        $this->db->where('DATE(sk.TglPengisian) >=', $start_date);
        $this->db->where('DATE(sk.TglPengisian) <=', $end_date);
        $this->db->group_by('ks.IdKepuasanSurveior');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get Detail Survey by ID
     */
    public function get_survey_by_id($id)
    {
        $this->db->where('IdSurveiKepuasan', $id);
        $query = $this->db->get('t_survei_kepuasan');
        return $query->row_array();
    }

    /**
     * Get All Surveys with Pagination
     */
    public function get_all_surveys($limit = 10, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('t_survei_kepuasan');
        $this->db->order_by('TglPengisian', 'DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count Total Surveys
     */
    public function count_surveys($start_date = null, $end_date = null)
    {
        if ($start_date && $end_date) {
            $this->db->where('DATE(TglPengisian) >=', $start_date);
            $this->db->where('DATE(TglPengisian) <=', $end_date);
        }
        return $this->db->count_all_results('t_survei_kepuasan');
    }

    /**
     * Simpan Data Survei
     * Menyimpan ke tabel t_survei_kepuasan dan t_kepuasan_surveior
     */
    public function simpan_survei($data_survei, $data_surveior_array)
    {
        $this->db->trans_start();

        // 1. Insert ke t_survei_kepuasan
        $this->db->insert('t_survei_kepuasan', $data_survei);
        $id_survei = $this->db->insert_id();

        // 2. Insert ke t_kepuasan_surveior (multiple rows)
        foreach ($data_surveior_array as $data_surveior) {
            $data_surveior['IdSurveiKepuasan'] = $id_survei;
            $this->db->insert('t_kepuasan_surveior', $data_surveior);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    /**
     * Get Kegiatan Akreditasi from SPEAK Database
     */
    public function get_kegiatan_by_id($id_kegiatan)
    {
        $this->db_speak->select('
            ta.IdKegiatanAkreditasi,
            ta.Slug,
            mrs.Nama as nama_rs,
            mr.NamaPanggilan as pic,
            mr.NomorHp as no_hp,
            mrs.Alamat as alamat,
            ta.TglMulai as tgl_survei,
            "" as dokumentasi -- Placeholder if file link is not in DB yet
        ');
        $this->db_speak->from('t_akreditasi ta');
        $this->db_speak->join('m_rumah_sakit mrs', 'mrs.IdRumahSakit = ta.IdRumahSakit', 'left');
        $this->db_speak->join('m_register mr', 'mr.KodeRs = mrs.KodeRs', 'left');
        $this->db_speak->where('ta.IdKegiatanAkreditasi', $id_kegiatan);

        $query = $this->db_speak->get();
        return $query->row_array();
    }

    /**
     * Get Kegiatan Akreditasi by Slug
     */
    public function get_kegiatan_by_slug($slug)
    {
        $this->db_speak->select('
            ta.IdKegiatanAkreditasi,
            ta.Slug,
            mrs.Nama as nama_rs,
            mr.NamaPanggilan as pic,
            mr.NomorHp as no_hp,
            mrs.Alamat as alamat,
            ta.TglMulai as tgl_survei,
            "" as dokumentasi
        ');
        $this->db_speak->from('t_akreditasi ta');
        $this->db_speak->join('m_rumah_sakit mrs', 'mrs.IdRumahSakit = ta.IdRumahSakit', 'left');
        $this->db_speak->join('m_register mr', 'mr.KodeRs = mrs.KodeRs', 'left');
        $this->db_speak->where('ta.Slug', $slug);

        $query = $this->db_speak->get();
        return $query->row_array();
    }

    /**
     * Get Surveyors by Kegiatan
     * Mengambil data surveior dari tabel t_surveyor_manual di database speak
     */
    public function get_surveyors_by_kegiatan($id_kegiatan)
    {
        // Join dengan mst_member di database surveyor (management-surveior)
        // Asumsi kolom join: IdMemberData
        $this->db_speak->select('tsm.*, mm.NamaGelar');
        $this->db_speak->from('t_surveyor_manual tsm');
        $this->db_speak->join('`management-surveior`.mst_member_data mm', 'mm.ID = tsm.IdMemberData', 'left');
        $this->db_speak->where('tsm.IdKegiatanAkreditasi', $id_kegiatan);

        $query = $this->db_speak->get();
        return $query->result_array();
    }

    /**
     * Get Aggregated Statistics for Report
     * 
     * Mengambil jumlah data per skor (1-4) untuk setiap pertanyaan
     */
    public function get_aggregated_stats($start_date, $end_date)
    {
        if (!$start_date)
            $start_date = date('Y-m-d', strtotime('-1 year'));
        if (!$end_date)
            $end_date = date('Y-m-d');

        $columns = [
            'PersiapanWeb',
            'PersiapanSpeak',
            'PersiapanKomunikasiPic',
            'PersiapanKecepatanRespon',
            'PersiapanJadwalSurveior',
            'PersiapanAlurMekanisme',
            'PersiapanKualitasIT',
            'PelaksanaanKetepatanWaktu',
            'PelaksanaanDaring',
            'PelaksanaanLuring',
            'PelaksanaanInstrumen',
            'PelaksanaanExitConference'
        ];

        $selects = [];
        foreach ($columns as $col) {
            for ($i = 1; $i <= 4; $i++) {
                $selects[] = "SUM(CASE WHEN $col = $i THEN 1 ELSE 0 END) as {$col}_{$i}";
            }
        }

        $this->db->select(implode(', ', $selects));
        $this->db->from('t_survei_kepuasan');
        $this->db->where('DATE(TglPengisian) >=', $start_date);
        $this->db->where('DATE(TglPengisian) <=', $end_date);

        $result = $this->db->get()->row_array();

        // Handle nulls if no data
        if (!$result) {
            $result = [];
            foreach ($columns as $col) {
                for ($i = 1; $i <= 4; $i++) {
                    $result["{$col}_{$i}"] = 0;
                }
            }
        } else {
            // Convert nulls to 0
            foreach ($result as $k => $v) {
                if ($v === null)
                    $result[$k] = 0;
            }
        }

        return $result;
    }

    /**
     * Check if survey exists for a given activity ID
     */
    public function check_existing_survey($id_kegiatan)
    {
        $this->db->where('IdKegiatanAkreditasi', $id_kegiatan);
        $count = $this->db->count_all_results('t_survei_kepuasan');
        return $count > 0;
    }
}
