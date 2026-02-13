<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Survei Kepuasan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f6f9fc;
            color: #2d3748;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .rating-group {
            display: flex;
            justify-content: space-between;
            max-width: 300px;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .section-title {
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.5rem;
        }
    </style>
</head>

<body class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">Input Survei Kepuasan</h2>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('submit-survei') ?>" method="POST" enctype="multipart/form-data">

                    <!-- 1. Data Umum -->
                    <!-- DATA DASAR -->
                    <div class="card mb-4 overflow-hidden border-0 shadow-sm">
                        <div class="card-header text-white p-3" style="background-color: #6f42c1;">
                            <h5 class="mb-0 fw-bold text-uppercase" style="font-size: 1rem; letter-spacing: 0.5px;">Data
                                Dasar</h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Nama Rumah Sakit -->
                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Nama Rumah Sakit <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-plaintext border-bottom"
                                    value="<?= isset($kegiatan['nama_rs']) ? $kegiatan['nama_rs'] : '' ?>" readonly>
                            </div>

                            <!-- Narahubung Rumah Sakit -->
                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Narahubung Rumah Sakit <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-plaintext border-bottom"
                                    value="<?= isset($kegiatan['pic']) ? $kegiatan['pic'] : '' ?>" readonly>
                            </div>

                            <!-- Nomor HP -->
                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Nomor HP <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-plaintext border-bottom"
                                    value="<?= isset($kegiatan['no_hp']) ? $kegiatan['no_hp'] : '' ?>" readonly>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Alamat <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control-plaintext border-bottom"
                                    value="<?= isset($kegiatan['alamat']) ? $kegiatan['alamat'] : '' ?>" readonly>
                            </div>

                            <!-- Tanggal Survei -->
                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Tanggal Survei <span
                                        class="text-danger">*</span></label>
                                <div>
                                    <small class="text-muted d-block mb-1">Tanggal</small>
                                    <div class="d-flex align-items-center border-bottom pb-1" style="max-width: 200px;">
                                        <input type="text" class="form-control-plaintext p-0"
                                            value="<?= isset($kegiatan['tgl_survei']) ? date('d/m/Y', strtotime($kegiatan['tgl_survei'])) : '' ?>"
                                            readonly>
                                        <i class="bi bi-calendar text-muted"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumentasi Kegiatan Survei -->
                            <div class="mb-2">
                                <label class="form-label text-dark fw-bold">Dokumentasi Kegiatan Survei <span
                                        class="text-danger">*</span></label>
                                <p class="small text-muted mb-3">
                                    Mohon memberikan dokumentasi kegiatan survei akreditasi mulai dari pembukaan,
                                    wawancara pimpinan, kegiatan telusur, sampai exit conference maksimal 10 foto dalam 1 file PDF
                                </p>
                                <p class="small text-muted mb-3">Upload 1 file yang didukung: PDF. Maks 10 MB.
                                </p>

                                <input type="file" class="form-control" name="dokumentasi_kegiatan" accept="application/pdf" required>
                            </div>

                            <!-- Hidden ID Kegiatan for submission -->
                            <input type="hidden" id="id_kegiatan" name="id_kegiatan"
                                value="<?= isset($id_kegiatan) ? $id_kegiatan : '' ?>">
                            <input type="hidden" id="slug" name="slug" value="<?= isset($slug) ? $slug : '' ?>">
                        </div>
                    </div>

                    <!-- 2. Penilaian Persiapan -->
                    <div class="card p-4 mb-4">
                        <h5 class="section-title"><i class="bi bi-clipboard-check me-2"></i>Tahap Persiapan</h5>
                        <p class="text-muted small mb-4">
                            <strong>Isilah pernyataan berikut ini pada angka yang sesuai:</strong>
                            <br>
                            1 : Kurang
                            <br>
                            2 : Cukup
                            <br>
                            3 : Baik
                            <br>
                            4 : Sangat Baik
                        </p>

                        <?php
                        $fields_persiapan = [
                            'persiapan_web' => '1. Kemudahan akses dan kelengkapan informasi pada Website LAM-KPRS (www.lam-kprs.id)',
                            'persiapan_speak' => '2. Kemudahan akses dan penggunaan aplikasi SPEAK pada registrasi online',
                            'persiapan_komunikasi' => '3. Komunikasi narahubung lembaga dengan rumah sakit',
                            'persiapan_respon' => '4. Kecepatan respon lembaga kepada rumah sakit yang telah teregistrasi',
                            'persiapan_jadwal' => '5. Ketepatan  penetapan jadwal pelaksanaaan dan nama – nama surveyor',
                            'persiapan_alur' => '6. Kejelasan alur mekanisme  survei akreditasi',
                            'persiapan_it' => '7. Kualitas penggunaan media komunikasi / teknologi informasi'
                        ];
                        foreach ($fields_persiapan as $name => $label):
                            ?>
                            <div class="mb-4 border-bottom pb-3">
                                <label class="form-label d-block"><?= $label ?></label>
                                <div class="d-flex justify-content-between px-2" style="max-width: 400px;">
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <div class="form-check text-center">
                                            <input class="form-check-input" type="radio" name="<?= $name ?>"
                                                id="<?= $name . $i ?>" value="<?= $i ?>" required>
                                            <label class="form-check-label d-block text-muted small"
                                                for="<?= $name . $i ?>"><?= $i ?></label>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <div class="d-flex justify-content-between px-1 text-muted small mt-1"
                                    style="max-width: 420px;">
                                    <span>Kurang</span>
                                    <span>Cukup</span>
                                    <span>Baik</span>
                                    <span>Sangat Baik</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- 3. Penilaian Pelaksanaan -->
                    <div class="card p-4 mb-4">
                        <h5 class="section-title"><i class="bi bi-play-circle me-2"></i>Tahap Pelaksanaan</h5>

                        <!-- 1. Pelaksanaan Waktu -->
                        <div class="mb-4 border-bottom pb-3">
                            <label class="form-label d-block">1. Ketepatan waktu pelaksanaan survei akreditasi</label>
                            <div class="d-flex justify-content-between px-2" style="max-width: 400px;">
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <div class="form-check text-center">
                                        <input class="form-check-input" type="radio" name="pelaksanaan_waktu"
                                            id="pelaksanaan_waktu<?= $i ?>" value="<?= $i ?>" required>
                                        <label class="form-check-label d-block text-muted small"
                                            for="pelaksanaan_waktu<?= $i ?>"><?= $i ?></label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="d-flex justify-content-between px-1 text-muted small mt-1"
                                style="max-width: 420px;">
                                <span>Kurang</span>
                                <span>Cukup</span>
                                <span>Baik</span>
                                <span>Sangat Baik</span>
                            </div>
                        </div>

                        <!-- 2. Group Sub Items -->
                        <div class="mb-4 border-bottom pb-3">
                            <label class="form-label d-block">2. Pelaksanaan kegiatan survei:</label>

                            <?php
                            $sub_items = [
                                'a' => ['pelaksanaan_daring', 'Dalam Jaringan (Daring)'],
                                'b' => ['pelaksanaan_luring', 'Luar Jaringan (Luring)'],
                                'c' => ['pelaksanaan_instrumen', 'Penggunaan instrumen survei akreditasi']
                            ];
                            foreach ($sub_items as $prefix => $item):
                                $name = $item[0];
                                $label = $item[1];
                                ?>
                                <div class="ms-3 mb-4">
                                    <label class="form-label d-block"><?= $prefix ?>. <?= $label ?></label>
                                    <div class="d-flex justify-content-between px-2" style="max-width: 400px;">
                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                            <div class="form-check text-center">
                                                <input class="form-check-input" type="radio" name="<?= $name ?>"
                                                    id="<?= $name . $i ?>" value="<?= $i ?>" required>
                                                <label class="form-check-label d-block text-muted small"
                                                    for="<?= $name . $i ?>"><?= $i ?></label>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="d-flex justify-content-between px-1 text-muted small mt-1"
                                        style="max-width: 420px;">
                                        <span>Kurang</span>
                                        <span>Cukup</span>
                                        <span>Baik</span>
                                        <span>Sangat Baik</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- 3. Exit Conference -->
                        <div class="mb-4 border-bottom pb-3">
                            <label class="form-label d-block">3. Kejelasan, dan sistematika pada waktu pembukaan dan
                                penyampaian hasil survei pada saat penutupan (exit conference)</label>
                            <div class="d-flex justify-content-between px-2" style="max-width: 400px;">
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <div class="form-check text-center">
                                        <input class="form-check-input" type="radio" name="pelaksanaan_exit"
                                            id="pelaksanaan_exit<?= $i ?>" value="<?= $i ?>" required>
                                        <label class="form-check-label d-block text-muted small"
                                            for="pelaksanaan_exit<?= $i ?>"><?= $i ?></label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="d-flex justify-content-between px-1 text-muted small mt-1"
                                style="max-width: 420px;">
                                <span>Kurang</span>
                                <span>Cukup</span>
                                <span>Baik</span>
                                <span>Sangat Baik</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Penilaian Surveior -->
                    <!-- 4. Penilaian Surveior (Dinamis) -->
                    <div class="card p-4 mb-4">
                        <h5 class="section-title"><i class="bi bi-person-badge me-2"></i>Penilaian Surveior</h5>
                        <p class="text-muted small mb-4">
                            <strong>Isilah pernyataan berikut ini pada angka yang sesuai:</strong>
                            <br>
                            1 : Kurang
                            <br>
                            2 : Cukup
                            <br>
                            3 : Baik
                            <br>
                            4 : Sangat Baik
                        </p>

                        <div id="surveyor-wrapper">
                            <!-- Surveyor Items will be appended here -->
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-primary" id="btn-add-surveyor">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Surveior Lain
                            </button>
                        </div>
                    </div>

                    <!-- Template for Surveyor Item (Hidden) -->
                    <template id="surveyor-template">
                        <div class="surveyor-item border rounded p-3 mb-3 bg-light position-relative">
                            <button type="button"
                                class="btn-close position-absolute top-0 end-0 m-2 btn-remove-surveyor"
                                aria-label="Close"></button>
                            <h6 class="fw-bold mb-3 surveyor-title">Surveior #1</h6>

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <!-- Name Display (Only if fetched from DB) -->
                                    <div class="surveyor-name-group mb-2" style="display:none;">
                                        <label class="form-label">Nama Surveior</label>
                                        <input type="text" class="form-control surveyor-name-input fw-bold" readonly
                                            style="background-color: #e9ecef;">
                                    </div>

                                    <!-- ID Input (Default / Fallback) -->
                                    <div class="surveyor-id-group">
                                        <label class="form-label">ID Surveior (Member Data)</label>
                                        <input type="number" class="form-control surveyor-id-input" required
                                            placeholder="Contoh: 101">
                                    </div>
                                </div>
                            </div>

                            <!-- Rating Fields -->
                            <div class="rating-fields"></div>
                        </div>
                    </template>

                    <script>
                        // Config for questions
                        const surveyorQuestions = [
                            { name: 'interaksi', label: 'Interaksi surveior dengan tim RS' },
                            { name: 'waktu', label: 'Ketepatan waktu pelaksanaan survei' },
                            { name: 'komunikasi', label: 'Kemampuan berkomunikasi dan edukasi' },
                            { name: 'sikap', label: 'Sikap dan perilaku selama survei' }
                        ];
                        // Existing Surveyors from Controller
                        const existingSurveyors = <?= json_encode(isset($surveyors) ? $surveyors : []) ?>;
                    </script>

                    <!-- 5. Saran & Masukan -->
                    <div class="card p-4 mb-4">
                        <h5 class="section-title"><i class="bi bi-chat-text me-2"></i>Saran & Masukan</h5>
                        <div class="mb-3">
                            <label for="saran_masukan" class="form-label">Saran dan Masukan untuk Perbaikan</label>
                            <textarea class="form-control" id="saran_masukan" name="saran_masukan" rows="4"
                                placeholder="Tuliskan saran Anda di sini..."></textarea>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                            <i class="bi bi-send-fill me-2"></i> Kirim Survei
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            <p>&copy;
                <?= date('Y') ?> Sistem Survei Kepuasan. All rights reserved.
            </p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('surveyor-wrapper');
            const template = document.getElementById('surveyor-template');
            const btnAdd = document.getElementById('btn-add-surveyor');
            let surveyorCount = 0;

            function addSurveyor(data = null) {
                surveyorCount++;
                const clone = template.content.cloneNode(true);
                const item = clone.querySelector('.surveyor-item');

                // Update Title
                item.querySelector('.surveyor-title').textContent = 'Surveior #' + surveyorCount;

                // Update inputs
                // Name format: surveyor_data[index][field]
                const index = surveyorCount - 1;

                const idInput = item.querySelector('.surveyor-id-input');
                idInput.name = `surveior_data[${index}][id]`;

                // Wrapper groups
                const nameGroup = item.querySelector('.surveyor-name-group');
                const nameInput = item.querySelector('.surveyor-name-input');
                const idGroup = item.querySelector('.surveyor-id-group');

                // Pre-fill data if available
                if (data && data.IdMemberData) {
                    idInput.value = data.IdMemberData;

                    if (data.NamaGelar) {
                        // If we have a name, show it and hide the visible ID input
                        // But we must keep the ID value submit-able. 
                        // The 'idInput' is correct. We just hide its container.
                        nameInput.value = data.NamaGelar;
                        nameGroup.style.display = 'block';
                        idGroup.style.display = 'none';
                    } else {
                        // Fallback: Show ID read-only
                        idInput.readOnly = true;
                    }
                }

                // Add Rating Questions
                const ratingContainer = item.querySelector('.rating-fields');

                surveyorQuestions.forEach(q => {
                    const div = document.createElement('div');
                    div.className = 'mb-3 border-bottom pb-2';

                    const label = document.createElement('label');
                    label.className = 'form-label d-block';
                    label.textContent = q.label;
                    div.appendChild(label);

                    const optionsDiv = document.createElement('div');
                    optionsDiv.className = 'd-flex justify-content-between px-2';
                    optionsDiv.style.maxWidth = '400px';

                    for (let i = 1; i <= 4; i++) {
                        const checkDiv = document.createElement('div');
                        checkDiv.className = 'form-check text-center';

                        const input = document.createElement('input');
                        input.className = 'form-check-input';
                        input.type = 'radio';
                        input.name = `surveior_data[${index}][${q.name}]`;
                        input.value = i;
                        input.required = true;
                        input.id = `sd_${index}_${q.name}_${i}`;

                        const lbl = document.createElement('label');
                        lbl.className = 'form-check-label d-block text-muted small';
                        lbl.htmlFor = `sd_${index}_${q.name}_${i}`;
                        lbl.textContent = i;

                        checkDiv.appendChild(input);
                        checkDiv.appendChild(lbl);
                        optionsDiv.appendChild(checkDiv);
                    }

                    div.appendChild(optionsDiv);

                    // Add Rating Scale Legend
                    const legendDiv = document.createElement('div');
                    legendDiv.className = 'd-flex justify-content-between px-1 text-muted small mt-1';
                    legendDiv.style.maxWidth = '420px';
                    legendDiv.innerHTML = `
                        <span>Kurang</span>
                        <span>Cukup</span>
                        <span>Baik</span>
                        <span>Sangat Baik</span>
                    `;
                    div.appendChild(legendDiv);

                    ratingContainer.appendChild(div);
                });

                // Remove Handler
                const btnRemove = item.querySelector('.btn-remove-surveyor');
                if (data && data.IdMemberData) {
                    // If from system, maybe disable remove?
                    // user says "sesuaikan", likely mandatory.
                    btnRemove.remove();
                } else {
                    btnRemove.addEventListener('click', function () {
                        item.remove();
                    });
                }

                wrapper.appendChild(item);
            }

            // Init based on existing data
            if (existingSurveyors && existingSurveyors.length > 0) {
                existingSurveyors.forEach(srv => {
                    addSurveyor(srv);
                });
                // Hide add button if we have fixed surveyors? 
                // Or allow adding extra? Usually strictly matches DB.
                // Converting button to hidden if we have system surveyors
                btnAdd.style.display = 'none';
            } else {
                // Default blank one
                addSurveyor();
            }

            // Event Listener
            btnAdd.addEventListener('click', () => addSurveyor());

            // Encapsulate Check Logic
            function checkKegiatan(id) {
                if (id) {
                    console.log('Checking activity ID: ' + id);
                    // fetch('<?= base_url('Survei_kepuasan/check_kegiatan_surveiors') ?>', {
                    //    method: 'POST',
                    //    body: new URLSearchParams('id_kegiatan=' + id)
                    // }).then(res => res.json()).then(data => { console.log(data); });
                }
            }

            // Check Activity Handler (Dummy)
            const idKegiatanInput = document.getElementById('id_kegiatan');
            idKegiatanInput.addEventListener('change', function () {
                checkKegiatan(this.value);
            });

            // Trigger on load if value exists
            if (idKegiatanInput.value) {
                checkKegiatan(idKegiatanInput.value);
            }
        });
    </script>
</body>

</html>