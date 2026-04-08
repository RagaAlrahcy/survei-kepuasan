<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepuasan Surveior</title>
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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


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

        .stat-card {
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
        }

        .stat-card i {
            font-size: 2rem;
            opacity: 0.5;
        }

        .stat-card-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stat-card-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
            border-color: #764ba2;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Tidy table headers */
        #surveyTable thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            vertical-align: middle;
            background-color: #f8fafc;
            border-bottom: 2px solid #edf2f7;
        }

        .score-col {
            width: 80px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-people-fill me-2"></i>Kepuasan Surveior</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('dashboard') ?>"><i
                                class="bi bi-bar-chart-fill me-1"></i> Dashboard Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-house-door me-1"></i> Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <!-- Header Section -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6">
                <h1 class="display-6 fw-bold mb-1">Analisis Feedback Surveior</h1>
                <p class="text-muted mb-0">Pemantauan kepuasan berdasarkan penilaian responden</p>
            </div>
            <div class="col-md-6 text-md-end">
                <span class="badge bg-light text-primary p-3 rounded-pill">
                    <i class="bi bi-clock me-2"></i> Update Terakhir: <?= date('d M Y H:i') ?>
                </span>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-funnel me-2"></i> Filter Surveyor</span>
            </div>
            <div class="card-body">
                <form action="<?= base_url('feedback-surveior') ?>" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="surveyor_id" class="form-label text-muted small fw-bold">Nama Surveyor</label>
                        <select class="form-select select2" id="surveyor_id" name="surveyor_id">
                            <option value="all" <?= ($surveyor_id == 'all') ? 'selected' : '' ?>>Semua Surveyor</option>
                            <?php foreach ($surveyors as $s): ?>
                                <option value="<?= $s['IdMemberData'] ?>" <?= ($surveyor_id == $s['IdMemberData']) ? 'selected' : '' ?>>
                                    <?= $s['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-gradient flex-grow-1">
                            <i class="bi bi-search me-2"></i> Tampilkan
                        </button>
                        <a href="<?= base_url('feedback-surveior') ?>" class="btn btn-light" data-bs-toggle="tooltip"
                            title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-primary bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-card-title text-primary">Interaksi Surveyor</p>
                            <h3 class="stat-card-value text-primary">
                                <?= number_format($stats['summary']['avg_interaksi'], 2) ?>
                            </h3>
                        </div>
                        <i class="bi bi-chat-dots-fill text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-card-title text-success">Ketepatan Waktu</p>
                            <h3 class="stat-card-value text-success">
                                <?= number_format($stats['summary']['avg_ketepatan'], 2) ?>
                            </h3>
                        </div>
                        <i class="bi bi-alarm-fill text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-info bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-card-title text-info">Kemampuan Komunikasi</p>
                            <h3 class="stat-card-value text-info">
                                <?= number_format($stats['summary']['avg_komunikasi'], 2) ?>
                            </h3>
                        </div>
                        <i class="bi bi-mic-fill text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-warning bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-card-title text-warning">Sikap & Perilaku</p>
                            <h3 class="stat-card-value text-warning">
                                <?= number_format($stats['summary']['avg_sikap'], 2) ?>
                            </h3>
                        </div>
                        <i class="bi bi-person-badge-fill text-warning"></i>
                    </div>
                </div>
            </div>
        </div>


        <!-- Results Table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-table me-2"></i> Detail Penilaian Per Rumah Sakit</span>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-primary rounded-pill me-2"><?= count($survey_details) ?> Penilaian</span>
                    <a href="<?= base_url('export-feedback-surveior?surveyor_id=' . $surveyor_id) ?>"
                        class="btn btn-success btn-sm rounded-pill">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    <table id="surveyTable" class="table table-hover align-middle mb-0" style="width:100%">

                        <thead>
                            <tr>
                                <th class="ps-4">Tanggal Pengisian</th>
                                <th width="250px">Nama RS</th>
                                <?php if ($surveyor_id == 'all'): ?>
                                    <th>Nama Surveior</th>
                                <?php endif; ?>
                                <th class="text-center score-col" title="Interaksi Surveior" data-bs-toggle="tooltip">
                                    Interaksi</th>
                                <th class="text-center score-col" title="Ketepatan Waktu" data-bs-toggle="tooltip">Waktu
                                </th>
                                <th class="text-center score-col" title="Kemampuan Komunikasi" data-bs-toggle="tooltip">
                                    Komunikasi</th>
                                <th class="text-center score-col" title="Sikap & Perilaku" data-bs-toggle="tooltip">
                                    Sikap</th>
                                <th class="text-center score-col">Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($survey_details as $row):
                                $avg_row = ($row['InteraksiSurveior'] + $row['KetepatanWaktu'] + $row['KemampuanKomunikasi'] + $row['SikapPerilaku']) / 4;
                                ?>
                                <tr>
                                    <td class="ps-4 small text-muted">
                                        <?= date('d/m/Y H:i', strtotime($row['TglPengisian'])) ?>
                                    </td>
                                    <td class="fw-bold"><?= $row['nama_rs'] ?></td>
                                    <?php if ($surveyor_id == 'all'): ?>
                                        <td><span class="badge bg-light text-dark"><?= $row['nama_surveior'] ?></span></td>
                                    <?php endif; ?>
                                    <td class="text-center"><span
                                            class="badge <?= $row['InteraksiSurveior'] >= 3 ? 'bg-success' : 'bg-warning' ?> rounded-pill"><?= $row['InteraksiSurveior'] ?></span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge <?= $row['KetepatanWaktu'] >= 3 ? 'bg-success' : 'bg-warning' ?> rounded-pill"><?= $row['KetepatanWaktu'] ?></span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge <?= $row['KemampuanKomunikasi'] >= 3 ? 'bg-success' : 'bg-warning' ?> rounded-pill"><?= $row['KemampuanKomunikasi'] ?></span>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge <?= $row['SikapPerilaku'] >= 3 ? 'bg-success' : 'bg-warning' ?> rounded-pill"><?= $row['SikapPerilaku'] ?></span>
                                    </td>
                                    <td class="text-center fw-bold text-primary"><?= number_format($avg_row, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        <footer class="mt-5 text-center text-muted small">
            <p>&copy; <?= date('Y') ?> Monitoring Feedback Surveior | LAM-KPRS. All rights reserved.</p>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            $('#surveyTable').DataTable({

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "pageLength": 10,
                "order": [[0, "desc"]],
                "responsive": true,
                "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>'
            });
        });
    </script>

</body>

</html>