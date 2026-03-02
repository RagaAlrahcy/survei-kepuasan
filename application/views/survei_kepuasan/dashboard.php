<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Survei Kepuasan</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('public/assets/favicon/favicon-lam-kprs.png') ?>">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #2af598 0%, #009efd 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --border-radius: 16px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f6f9fc;
            color: #2d3748;
        }

        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            background: white;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            font-weight: 600;
            color: #4a5568;
        }

        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-gradient:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
            color: white;
        }

        .btn-success-gradient {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success-gradient:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 158, 253, 0.4);
            color: white;
        }

        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #718096;
            background-color: #f7fafc;
            border-bottom: none;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #4a5568;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
            border-color: #764ba2;
        }

        /* Chart container specific */
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-bar-chart-fill me-2"></i>Dashboard Survei</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="https://akreditasi.lam-kprs.id/"><i
                                class="bi bi-house-door me-1"></i> Beranda</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-gear me-1"></i> Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-person-circle me-1"></i> Admin</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <!-- Header Section -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6">
                <h1 class="display-6 fw-bold mb-1">Monitoring Kepuasan Survei</h1>
                <!-- <p class="text-muted mb-0">Pantau performa pelayanan secara real-time</p> -->
            </div>
            <div class="col-md-6 text-md-end">
                <span class="badge bg-light text-primary p-3 rounded-pill">
                    <i class="bi bi-clock me-2"></i> Update Terakhir:
                    <?= date('d M Y H:i') ?>
                </span>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-funnel me-2"></i> Filter Data</span>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard') ?>" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label text-muted small fw-bold">Tanggal Awal Survei</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="<?= $start_date ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label text-muted small fw-bold">Tanggal Akhir Survei</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>"
                            required>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-gradient flex-grow-1">
                            <i class="bi bi-search me-2"></i> Tampilkan
                        </button>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-light" data-bs-toggle="tooltip"
                            title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-graph-up me-2"></i> Grafik Kepuasan Per Bulan</span>
                        <button id="btn-export-chart" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-image me-1"></i> Simpan Gambar
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="satisfactionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-table me-2"></i> Data Detail Hasil Survei</span>
                <a href="<?= base_url('export-csv?start_date=' . $start_date . '&end_date=' . $end_date) ?>"
                    class="btn btn-success-gradient btn-sm">
                    <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
                </a>
            </div>
            <div class="card-body p-4">

                <?php
                $tables_config = [
                    'Persiapan' => [
                        'title' => 'Hasil Persentase Persiapan Survei',
                        'items' => [
                            ['no' => '1', 'label' => 'Kemudahan akses dan kelengkapan informasi pada Website LAM-KPRS (www.lam-kprs.id)', 'col' => 'PersiapanWeb'],
                            ['no' => '2', 'label' => 'Kemudahan akses dan penggunaan aplikasi SPEAK pada registrasi online', 'col' => 'PersiapanSpeak'],
                            ['no' => '3', 'label' => 'Komunikasi narahubung lembaga dengan rumah sakit', 'col' => 'PersiapanKomunikasiPic'],
                            ['no' => '4', 'label' => 'Kecepatan respon lembaga kepada rumah sakit yang telah teregistrasi', 'col' => 'PersiapanKecepatanRespon'],
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
                            ['no' => '2c', 'label' => 'Pelaksanaan Survei Akreditasi [Penggunaan instrumen survei akreditasi]', 'col' => 'PelaksanaanInstrumen'],
                            ['no' => '3', 'label' => 'Kejelasan, dan sistematika pada waktu pembukaan dan penyampaian hasil survei pada saat penutupan (exit conference)', 'col' => 'PelaksanaanExitConference'],
                        ]
                    ]
                ];

                foreach ($tables_config as $key => $config):
                    // Calculate Totals for this table
                    $total_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                    $total_respondents = 0; // Sum of all counts in this table? No, respondents is count per question usually same, but sum of counts across cols
                
                    // We need to calculate Total Respondents based on one row (assuming all required) or Average Count?
                    // In image: 9 + 30 + 172 + 853 = 1064. 
                    // Questions = 7. 
                    // Respondents = 1064 / 7 = 152.
                    // We need a stable Total Respondents count to calculate Max Score.
                    // Let's sum all counts across all questions and divide by num questions.
                
                    $sum_all_counts = 0;
                    foreach ($config['items'] as $item) {
                        $col = $item['col'];
                        for ($i = 1; $i <= 4; $i++) {
                            $c = isset($stats_data["{$col}_{$i}"]) ? (int) $stats_data["{$col}_{$i}"] : 0;
                            $total_counts[$i] += $c;
                            $sum_all_counts += $c;
                        }
                    }

                    $num_questions = count($config['items']);
                    // Avoid division by zero
                    $est_respondents = $num_questions > 0 ? $sum_all_counts / $num_questions : 0;
                    $max_score_total = $est_respondents * $num_questions * 4;

                    $jumlah_skor = [
                        1 => $total_counts[1] * 1,
                        2 => $total_counts[2] * 2,
                        3 => $total_counts[3] * 3,
                        4 => $total_counts[4] * 4,
                    ];

                    $total_skor_final = array_sum($jumlah_skor);

                    // Calculate Percentage per column
                    // Formula: (Column Total Score / Max Score Total) * 100
                    $pecentage = [];
                    foreach ($jumlah_skor as $k => $v) {
                        $pecentage[$k] = $max_score_total > 0 ? ($v / $max_score_total) * 100 : 0;
                    }

                    $avg_percentage = array_sum($pecentage);
                    ?>

                    <h5 class="text-center fw-bold text-primary mb-3">
                        <?= $config['title'] . ' ' . date('Y', strtotime($start_date)) ?>
                    </h5>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered table-sm align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th rowspan="2" style="width: 50px;">No</th>
                                    <th rowspan="2">Pernyataan</th>
                                    <th colspan="4">Skor</th>
                                </tr>
                                <tr>
                                    <th style="width: 100px;">Kurang</th>
                                    <th style="width: 100px;">Cukup</th>
                                    <th style="width: 100px;">Baik</th>
                                    <th style="width: 100px;">Sangat Baik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($config['items'] as $item):
                                    $col = $item['col'];
                                    $c1 = isset($stats_data["{$col}_1"]) ? $stats_data["{$col}_1"] : 0;
                                    $c2 = isset($stats_data["{$col}_2"]) ? $stats_data["{$col}_2"] : 0;
                                    $c3 = isset($stats_data["{$col}_3"]) ? $stats_data["{$col}_3"] : 0;
                                    $c4 = isset($stats_data["{$col}_4"]) ? $stats_data["{$col}_4"] : 0;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $item['no'] ?></td>
                                        <td><?= $item['label'] ?></td>
                                        <td class="text-center bg-danger bg-opacity-10"><?= $c1 ?></td>
                                        <td class="text-center bg-warning bg-opacity-10"><?= $c2 ?></td>
                                        <td class="text-center bg-primary bg-opacity-10"><?= $c3 ?></td>
                                        <td class="text-center bg-success bg-opacity-10"><?= $c4 ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- Summary Rows -->
                                <tr class="fw-bold bg-light">
                                    <td colspan="2" class="text-center">JUMLAH</td>
                                    <td class="text-center"><?= $total_counts[1] ?></td>
                                    <td class="text-center"><?= $total_counts[2] ?></td>
                                    <td class="text-center"><?= $total_counts[3] ?></td>
                                    <td class="text-center"><?= $total_counts[4] ?></td>
                                </tr>
                                <tr class="fw-bold bg-light">
                                    <td colspan="2" class="text-center">JUMLAH SKOR</td>
                                    <td class="text-center"><?= $jumlah_skor[1] ?></td>
                                    <td class="text-center"><?= $jumlah_skor[2] ?></td>
                                    <td class="text-center"><?= $jumlah_skor[3] ?></td>
                                    <td class="text-center"><?= $jumlah_skor[4] ?></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="2" class="text-center">TOTAL SKOR</td>
                                    <td colspan="4" class="text-center fs-5 text-primary">
                                        <?= number_format($total_skor_final) ?>
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="2" class="text-center">PERSENTASE (%)</td>
                                    <td class="text-center"><?= number_format($pecentage[1], 8) ?></td>
                                    <td class="text-center"><?= number_format($pecentage[2], 8) ?></td>
                                    <td class="text-center"><?= number_format($pecentage[3], 8) ?></td>
                                    <td class="text-center"><?= number_format($pecentage[4], 8) ?></td>
                                </tr>
                                <tr class="fw-bold table-primary">
                                    <td colspan="2" class="text-center">PERSENTASE RATA-RATA (%)</td>
                                    <td colspan="4" class="text-center fs-5"><?= number_format($avg_percentage, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Detail Charts Section -->
        <div class="row mb-4">
            <!-- Chart Persiapan -->
            <div class="col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-bar-chart-steps me-2"></i> Grafik Penilaian Persiapan Survei</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartPersiapan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Pelaksanaan -->
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-bar-chart-steps me-2"></i> Grafik Penilaian Pelaksanaan Survei</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartPelaksanaan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            <p>&copy;
                <?= date('Y') ?> Monitoring Kepuasan Survei. All rights reserved.
            </p>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Data passed from PHP
            const data = <?= json_encode($chart_data) ?>;
            const statsData = <?= json_encode($stats_data) ?>;

            const labels = data.map(item => item.tanggal);
            const datasetSangatBaik = data.map(item => item.sangat_baik);
            const datasetBaik = data.map(item => item.baik);
            const datasetCukup = data.map(item => item.cukup);
            const datasetKurang = data.map(item => item.kurang);

            // Setup Chart.js
            const ctx = document.getElementById('satisfactionChart').getContext('2d');

            // Gradients
            const gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient1.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
            gradient1.addColorStop(1, 'rgba(118, 75, 162, 0.2)');

            const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient2.addColorStop(0, 'rgba(42, 245, 152, 0.8)');
            gradient2.addColorStop(1, 'rgba(0, 158, 253, 0.2)');

            const myChart = new Chart(ctx, {
                type: 'bar', // Or 'line' if preferred
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Sangat Baik',
                            data: datasetSangatBaik,
                            backgroundColor: '#2af598',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Baik',
                            data: datasetBaik,
                            backgroundColor: '#009efd',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Cukup',
                            data: datasetCukup,
                            backgroundColor: '#ffc107',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Kurang',
                            data: datasetKurang,
                            backgroundColor: '#dc3545',
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    family: "'Outfit', sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#2d3748',
                            bodyColor: '#4a5568',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: true,
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    return ' ' + context.dataset.label + ': ' + context.parsed.y + ' Responden';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                font: { family: "'Outfit', sans-serif" },
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { family: "'Outfit', sans-serif" },
                                color: '#94a3b8'
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });

            // Export Chart Image Logic
            document.getElementById('btn-export-chart').addEventListener('click', function () {
                const canvas = document.getElementById('satisfactionChart');

                // Create a temporary canvas to handle background color
                const compositeCanvas = document.createElement('canvas');
                compositeCanvas.width = canvas.width;
                compositeCanvas.height = canvas.height;

                const context = compositeCanvas.getContext('2d');

                // Fill with white background (because JPEG doesn't support transparency)
                context.fillStyle = '#FFFFFF';
                context.fillRect(0, 0, canvas.width, canvas.height);

                // Draw the chart onto the white background
                context.drawImage(canvas, 0, 0);

                const link = document.createElement('a');
                link.download = 'grafik-kepuasan.jpg';
                link.href = compositeCanvas.toDataURL('image/jpeg', 1.0);
                link.click();
            });

            // --- Helper to parse stats data for charts ---
            function getChartData(keys) {
                const result = {
                    kurang: [],
                    cukup: [],
                    baik: [],
                    sangat_baik: []
                };

                keys.forEach(key => {
                    result.kurang.push(statsData[key + '_1'] ? parseInt(statsData[key + '_1']) : 0);
                    result.cukup.push(statsData[key + '_2'] ? parseInt(statsData[key + '_2']) : 0);
                    result.baik.push(statsData[key + '_3'] ? parseInt(statsData[key + '_3']) : 0);
                    result.sangat_baik.push(statsData[key + '_4'] ? parseInt(statsData[key + '_4']) : 0);
                });

                return result;
            }

            // --- Chart Persiapan ---
            const ctxPersiapan = document.getElementById('chartPersiapan').getContext('2d');
            const keysPersiapan = [
                'PersiapanWeb', 'PersiapanSpeak', 'PersiapanKomunikasiPic',
                'PersiapanKecepatanRespon', 'PersiapanJadwalSurveior',
                'PersiapanAlurMekanisme', 'PersiapanKualitasIT'
            ];
            const labelsPersiapan = [
                '1. Web KPRS', '2. Aplikasi SPEAK', '3. Komunikasi PIC',
                '4. Kecepatan Respon', '5. Jadwal & Surveyor', '6. Alur Mekanisme', '7. Kualitas IT'
            ];
            const dataPersiapan = getChartData(keysPersiapan);



            // --- Chart Pelaksanaan ---
            const ctxPelaksanaan = document.getElementById('chartPelaksanaan').getContext('2d');
            const keysPelaksanaan = [
                'PelaksanaanKetepatanWaktu', 'PelaksanaanDaring', 'PelaksanaanLuring',
                'PelaksanaanInstrumen', 'PelaksanaanExitConference'
            ];
            const labelsPelaksanaan = [
                '1. Ketepatan Waktu', '2a. Daring', '2b. Luring',
                '2c. Instrumen', '3. Exit Conference'
            ];
            const dataPelaksanaan = getChartData(keysPelaksanaan);

            // Shared Options
            const groupedBarOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ' ' + context.dataset.label + ': ' + context.parsed.y + ' RS';
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Jumlah RS' } },
                    x: { grid: { display: false } }
                }
            };

            new Chart(ctxPersiapan, {
                type: 'bar',
                data: {
                    labels: labelsPersiapan,
                    datasets: [
                        { label: 'Kurang', data: dataPersiapan.kurang, backgroundColor: '#6c757d', borderRadius: 4 }, // Gray
                        { label: 'Cukup', data: dataPersiapan.cukup, backgroundColor: '#4285f4', borderRadius: 4 }, // Google Blue
                        { label: 'Baik', data: dataPersiapan.baik, backgroundColor: '#ea4335', borderRadius: 4 },   // Google Red
                        { label: 'Sangat Baik', data: dataPersiapan.sangat_baik, backgroundColor: '#fbbc05', borderRadius: 4 } // Google Yellow
                    ]
                },
                options: groupedBarOptions
            });

            new Chart(ctxPelaksanaan, {
                type: 'bar',
                data: {
                    labels: labelsPelaksanaan,
                    datasets: [
                        { label: 'Kurang', data: dataPelaksanaan.kurang, backgroundColor: '#6c757d', borderRadius: 4 },
                        { label: 'Cukup', data: dataPelaksanaan.cukup, backgroundColor: '#4285f4', borderRadius: 4 },
                        { label: 'Baik', data: dataPelaksanaan.baik, backgroundColor: '#ea4335', borderRadius: 4 },
                        { label: 'Sangat Baik', data: dataPelaksanaan.sangat_baik, backgroundColor: '#fbbc05', borderRadius: 4 }
                    ]
                },
                options: groupedBarOptions
            });
        });
    </script>
</body>

</html>