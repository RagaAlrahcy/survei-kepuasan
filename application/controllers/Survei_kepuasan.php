<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei_kepuasan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the model
        // Note: In a real CI3 app, you might autoload this or load it here.
        // We assume the file exists relative to standard CI3 path.
        $this->load->model('Survei_model');
        $this->load->helper('url');
    }

    public function index()
    {
        // Load dashboard directly
        $this->dashboard();
    }

    public function dashboard()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Defaults
        if (!$start_date)
            $start_date = date('Y-m-d', strtotime('-7 days'));
        if (!$end_date)
            $end_date = date('Y-m-d');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['chart_data'] = $this->Survei_model->get_survei_data($start_date, $end_date);
        $data['stats_data'] = $this->Survei_model->get_aggregated_stats($start_date, $end_date);

        $this->load->view('survei_kepuasan/dashboard', $data);
    }

    public function export_csv()
    {
        // Load Library
        require_once APPPATH . 'libraries/SimpleXLSXGen.php';

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (!$start_date)
            $start_date = date('Y-m-d', strtotime('-7 days'));
        if (!$end_date)
            $end_date = date('Y-m-d');

        // Get Data
        $daily_data = $this->Survei_model->get_survei_data($start_date, $end_date);
        $stats_data = $this->Survei_model->get_aggregated_stats($start_date, $end_date);

        // --- Sheet 1: Ringkasan Harian --- //
        $sheet1 = [
            ['<b>Tanggal</b>', '<b>Sangat Baik</b>', '<b>Baik</b>', '<b>Cukup</b>', '<b>Kurang</b>', '<b>Total Responden</b>', '<b>Skor Rata-rata</b>']
        ];
        foreach ($daily_data as $row) {
            $sheet1[] = [
                $row['tanggal'],
                $row['sangat_baik'],
                $row['baik'],
                $row['cukup'],
                $row['kurang'],
                $row['total_responden'],
                $row['skor_rata_rata']
            ];
        }

        // --- Sheet 2: Detail Hasil --- //
        $sheet2 = [];
        $sheet2[] = ['<b>ANALISIS KEPUASAN DETAIL</b>'];
        $sheet2[] = ['<b>Periode</b>', $start_date . ' s/d ' . $end_date];
        $sheet2[] = [];

        // Config match with View
        $tables_config = [
            'Persiapan' => [
                'title' => 'Hasil Persentase Persiapan Survei',
                'items' => [
                    ['no' => '1', 'label' => 'Kemudahan akses dan kelengkapan informasi pada Website LAM-KPRS', 'col' => 'PersiapanWeb'],
                    ['no' => '2', 'label' => 'Kemudahan akses dan penggunaan aplikasi SPEAK', 'col' => 'PersiapanSpeak'],
                    ['no' => '3', 'label' => 'Komunikasi narahubung lembaga dengan rumah sakit', 'col' => 'PersiapanKomunikasiPic'],
                    ['no' => '4', 'label' => 'Kecepatan respon lembaga kepada rumah sakit', 'col' => 'PersiapanKecepatanRespon'],
                    ['no' => '5', 'label' => 'Ketepatan penetapan jadwal pelaksanaan dan nama – nama surveyor', 'col' => 'PersiapanJadwalSurveior'],
                    ['no' => '6', 'label' => 'Kejelasan alur mekanisme survei akreditasi', 'col' => 'PersiapanAlurMekanisme'],
                    ['no' => '7', 'label' => 'Kualitas penggunaan media komunikasi / teknologi informasi', 'col' => 'PersiapanKualitasIT'],
                ]
            ],
            'Pelaksanaan' => [
                'title' => 'Hasil Persentase Pelaksanaan Survei',
                'items' => [
                    ['no' => '1', 'label' => 'Ketepatan waktu pelaksanaan survei akreditasi', 'col' => 'PelaksanaanKetepatanWaktu'],
                    ['no' => '2a', 'label' => 'Pelaksanaan Survei Akreditasi [Dalam Jaringan (Daring)]', 'col' => 'PelaksanaanDaring'],
                    ['no' => '2b', 'label' => 'Pelaksanaan Survei Akreditasi [Luar Jaringan (Luring)]', 'col' => 'PelaksanaanLuring'],
                    ['no' => '2c', 'label' => 'Pelaksanaan Survei Akreditasi [Penggunaan instrumen]', 'col' => 'PelaksanaanInstrumen'],
                    ['no' => '3', 'label' => 'Kejelasan penyampaian hasil (exit conference)', 'col' => 'PelaksanaanExitConference'],
                ]
            ]
        ];

        foreach ($tables_config as $key => $config) {
            $sheet2[] = ['<b>' . $config['title'] . '</b>'];
            $sheet2[] = ['<b>No</b>', '<b>Pernyataan</b>', '<b>Kurang (1)</b>', '<b>Cukup (2)</b>', '<b>Baik (3)</b>', '<b>Sangat Baik (4)</b>'];

            // Totals
            $total_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            $sum_all_counts = 0;

            // Loop Rows
            foreach ($config['items'] as $item) {
                $col = $item['col'];
                $c1 = isset($stats_data["{$col}_1"]) ? (int) $stats_data["{$col}_1"] : 0;
                $c2 = isset($stats_data["{$col}_2"]) ? (int) $stats_data["{$col}_2"] : 0;
                $c3 = isset($stats_data["{$col}_3"]) ? (int) $stats_data["{$col}_3"] : 0;
                $c4 = isset($stats_data["{$col}_4"]) ? (int) $stats_data["{$col}_4"] : 0;

                $total_counts[1] += $c1;
                $total_counts[2] += $c2;
                $total_counts[3] += $c3;
                $total_counts[4] += $c4;
                $sum_all_counts += ($c1 + $c2 + $c3 + $c4);

                $sheet2[] = [
                    $item['no'],
                    $item['label'],
                    $c1,
                    $c2,
                    $c3,
                    $c4
                ];
            }

            // Calculations
            $num_questions = count($config['items']);
            $est_respondents = $num_questions > 0 ? $sum_all_counts / $num_questions : 0;
            $max_score_total = $est_respondents * $num_questions * 4;

            $jumlah_skor = [
                1 => $total_counts[1] * 1,
                2 => $total_counts[2] * 2,
                3 => $total_counts[3] * 3,
                4 => $total_counts[4] * 4,
            ];
            $total_skor_final = array_sum($jumlah_skor);

            // Percentage
            $pecentage = [];
            foreach ($jumlah_skor as $k => $v) {
                $pecentage[$k] = $max_score_total > 0 ? ($v / $max_score_total) * 100 : 0;
            }
            $avg_percentage = array_sum($pecentage);

            // Summary Rows in Excel
            $sheet2[] = ['', '<b>JUMLAH</b>', $total_counts[1], $total_counts[2], $total_counts[3], $total_counts[4]];
            $sheet2[] = ['', '<b>JUMLAH SKOR</b>', $jumlah_skor[1], $jumlah_skor[2], $jumlah_skor[3], $jumlah_skor[4]];
            $sheet2[] = ['', '<b>TOTAL SKOR</b>', '', '', '', '<b>' . number_format($total_skor_final) . '</b>'];
            $sheet2[] = ['', '<b>PERSENTASE (%)</b>', number_format($pecentage[1], 2) . '%', number_format($pecentage[2], 2) . '%', number_format($pecentage[3], 2) . '%', number_format($pecentage[4], 2) . '%'];
            $sheet2[] = ['', '<b>PERSENTASE RATA-RATA</b>', '', '', '', '<b>' . number_format($avg_percentage, 2) . '%</b>'];

            $sheet2[] = []; // Spacer
        }

        // Generate
        $xlsx = new Shuchkin\SimpleXLSXGen();
        $xlsx->addSheet($sheet1, 'Data Harian');
        $xlsx->addSheet($sheet2, 'Detail Per Kategori');
        $xlsx->downloadAs('Laporan_Survei_' . $start_date . '_' . $end_date . '.xlsx');
        exit;
    }

    public function input($slug = null)
    {
        $data['slug'] = $slug;
        $data['id_kegiatan'] = null;

        if ($slug) {
            $kegiatan = $this->Survei_model->get_kegiatan_by_slug($slug);

            if ($kegiatan) {
                $data['kegiatan'] = $kegiatan;
                $data['id_kegiatan'] = $kegiatan['IdKegiatanAkreditasi'];

                // Cek apakah survei sudah diisi sebelumnya
                if ($this->Survei_model->check_existing_survey($data['id_kegiatan'])) {
                    $this->load->view('survei_kepuasan/thank_you_survey_done');
                    return;
                }

                // Update slug if we found it by ID - NO LONGER NEEDED as we searched by slug
                $data['slug'] = $kegiatan['Slug'];

                $data['surveyors'] = $this->Survei_model->get_surveyors_by_kegiatan($data['id_kegiatan']);
            } else {
                // Invalid Slug -> Show Error Page
                $this->load->view('survei_kepuasan/error_invalid_slug');
                return; // Stop execution
            }
        } else {
            // No slug provided -> maybe show dashboard or error? 
            // Previous logic just showed empty form. User request implies if slug "diganti" (changed/wrong).
            // But if they visit /form without slug, maybe show error too?
            // "di url form cukup ambil Slug nya" implies slug is mandatory now.
            $this->load->view('survei_kepuasan/error_invalid_slug');
            return;
        }

        $this->load->view('survei_kepuasan/form_input', $data);
    }

    public function submit_survei()
    {
        // Data untuk tabel t_survei_kepuasan
        $data_survei = array(
            'IdKegiatanAkreditasi' => $this->input->post('id_kegiatan'),
            'TglPengisian' => date('Y-m-d H:i:s'),
            'PersiapanWeb' => $this->input->post('persiapan_web'),
            'PersiapanSpeak' => $this->input->post('persiapan_speak'),
            'PersiapanKomunikasiPic' => $this->input->post('persiapan_komunikasi'),
            'PersiapanKecepatanRespon' => $this->input->post('persiapan_respon'),
            'PersiapanJadwalSurveior' => $this->input->post('persiapan_jadwal'),
            'PersiapanAlurMekanisme' => $this->input->post('persiapan_alur'),
            'PersiapanKualitasIT' => $this->input->post('persiapan_it'),
            'PelaksanaanKetepatanWaktu' => $this->input->post('pelaksanaan_waktu'),
            'PelaksanaanDaring' => $this->input->post('pelaksanaan_daring'),
            'PelaksanaanLuring' => $this->input->post('pelaksanaan_luring'),
            'PelaksanaanInstrumen' => $this->input->post('pelaksanaan_instrumen'),
            'PelaksanaanExitConference' => $this->input->post('pelaksanaan_exit'),
            'SaranMasukan' => $this->input->post('saran_masukan'),
        );

        // Data untuk tabel t_kepuasan_surveior (Array)
        $surveior_inputs = $this->input->post('surveior_data');
        $data_surveior_array = [];

        if ($surveior_inputs && is_array($surveior_inputs)) {
            foreach ($surveior_inputs as $surveior) {
                // Pastikan ID Surveior diisi
                if (!empty($surveior['id'])) {
                    $data_surveior_array[] = array(
                        'IdMemberData' => $surveior['id'],
                        'InteraksiSurveior' => isset($surveior['interaksi']) ? $surveior['interaksi'] : 0,
                        'KetepatanWaktu' => isset($surveior['waktu']) ? $surveior['waktu'] : 0,
                        'KemampuanKomunikasi' => isset($surveior['komunikasi']) ? $surveior['komunikasi'] : 0,
                        'SikapPerilaku' => isset($surveior['sikap']) ? $surveior['sikap'] : 0,
                    );
                }
            }
        }

        if (empty($data_surveior_array)) {
            $this->session->set_flashdata('error', 'Mohon isi data penilaian untuk minimal satu surveior.');
            $id = $this->input->post('id_kegiatan');
            redirect($id ? 'form/' . $id : 'form');
            return;
        }

        if ($this->Survei_model->simpan_survei($data_survei, $data_surveior_array)) {
            $this->session->set_flashdata('success', 'Data survei berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data survei.');
        }

        $id = $this->input->post('id_kegiatan');
        $slug = $this->input->post('slug');

        if ($slug) {
            redirect('form/' . $slug);
        } else {
            redirect($id ? 'form/' . $id : 'form');
        }
    }

    /**
     * AJAX: Cek Surveior berdasarkan ID Kegiatan
     * Contoh implementasi untuk mengambil data surveior
     */
    public function check_kegiatan_surveiors()
    {
        $id_kegiatan = $this->input->post('id_kegiatan');

        // TODO: Integrasikan dengan model Kegiatan/Jadwal jika ada
        // Saat ini kita return mock data atau kosong agar user input manual
        // Jika ada tabel relasi kegiatan->surveior, query di sini.

        /* 
        $surveiors = $this->Some_model->get_surveiors_by_kegiatan($id_kegiatan);
        echo json_encode(['status' => 'success', 'data' => $surveiors]);
        */

        echo json_encode(['status' => 'success', 'message' => 'Silakan input data surveior secara manual.', 'data' => []]);
    }
}
