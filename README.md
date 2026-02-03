# Survey Kepuasan - CodeIgniter 3 Dashboard

## Cara Setup Aplikasi

### 1. Import Database
1. Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
2. Klik tab "SQL"
3. Import file database dengan urutan berikut:
   
   **Step 1: Buat struktur tabel**
   - Buka file `survei_kepuasan.sql`
   - Copy semua isi file
   - Paste di tab SQL phpMyAdmin
   - Klik "Go"
   
   **Step 2: Insert data sample (Optional untuk testing)**
   - Buka file `sample_data.sql`
   - Copy semua isi file
   - Paste di tab SQL phpMyAdmin
   - Klik "Go"

**Catatan:** File `survei_kepuasan.sql` berisi 2 tabel utama:
- `t_survei_kepuasan` - Data survei kepuasan akreditasi
- `t_kepuasan_surveior` - Data kepuasan terhadap surveior

### 2. Konfigurasi Database
File konfigurasi database sudah dibuat di `application/config/database.php` dengan setting:
- **Hostname**: localhost
- **Username**: root
- **Password**: (kosong)
- **Database**: survei_kepuasan

Jika setting XAMPP Anda berbeda, silakan edit file `application/config/database.php`

### 3. Jalankan Aplikasi
1. Pastikan **XAMPP Apache** dan **MySQL** sudah running
2. Buka browser dan akses: `http://localhost/survei-kepuasan/`
3. Aplikasi akan otomatis redirect ke dashboard

### Struktur URL
- **Home**: `http://localhost/survei-kepuasan/`
- **Dashboard**: `http://localhost/survei-kepuasan/dashboard`
- **Input Survei**: `http://localhost/survei-kepuasan/input`
- **Export CSV**: `http://localhost/survei-kepuasan/export-csv`

**Catatan:** URL menggunakan format clean dan sederhana. Akses langsung ke `survei-kepuasan/` akan menampilkan dashboard.

### Fitur Aplikasi
1. **Dashboard Survei Kepuasan**: Menampilkan grafik dan statistik
2. **Filter Tanggal**: Filter data berdasarkan range tanggal
3. **Export ke CSV**: Download laporan dalam format CSV

### Troubleshooting
- Jika ada error 404, pastikan mod_rewrite Apache sudah aktif di XAMPP
- Jika error database connection, cek konfigurasi di `application/config/database.php`
- Pastikan folder `application` memiliki file konfigurasi yang lengkap
