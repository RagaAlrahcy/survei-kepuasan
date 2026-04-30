<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepuasan_surveior extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Surveior_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $id_member = $this->input->get('surveyor_id');
        
        // Defaults to 'all' if not provided
        if (!$id_member) {
            $id_member = 'all';
        }

        $data['surveyor_id'] = $id_member;
        $data['surveyors'] = $this->Surveior_model->get_all_surveyors();
        $data['stats'] = $this->Surveior_model->get_satisfaction_stats($id_member);
        $data['survey_details'] = $this->Surveior_model->get_survey_details($id_member);

        $this->load->view('survei_kepuasan/dashboard_surveior', $data);
    }

    public function export_excel()
    {
        // Load Library
        require_once APPPATH . 'libraries/SimpleXLSXGen.php';

        $id_member = $this->input->get('surveyor_id');
        if (!$id_member) {
            $id_member = 'all';
        }

        $survey_details = $this->Surveior_model->get_survey_details($id_member);
        
        $sheet = [
            ['<b>Tanggal Pengisian</b>', '<b>Kode RS</b>', '<b>Nama RS</b>', '<b>Nama Surveior</b>', '<b>Interaksi</b>', '<b>Waktu</b>', '<b>Komunikasi</b>', '<b>Sikap</b>', '<b>Rata-rata</b>']
        ];

        foreach ($survey_details as $row) {
            $avg_row = ($row['InteraksiSurveior'] + $row['KetepatanWaktu'] + $row['KemampuanKomunikasi'] + $row['SikapPerilaku']) / 4;
            $sheet[] = [
                date('d/m/Y H:i', strtotime($row['TglPengisian'])),
                $row['kode_rs'],
                $row['nama_rs'],
                $row['nama_surveior'],
                $row['InteraksiSurveior'],
                $row['KetepatanWaktu'],
                $row['KemampuanKomunikasi'],
                $row['SikapPerilaku'],
                number_format($avg_row, 2)
            ];
        }

        $filename = 'Export_Feedback_Surveior_' . date('Ymd') . '_' . $id_member . '.xlsx';
        $xlsx = Shuchkin\SimpleXLSXGen::fromArray($sheet);
        $xlsx->downloadAs($filename);
        exit;
    }
}
