-- Insert Sample Data for t_survei_kepuasan
-- Data survei kepuasan untuk testing dashboard

INSERT INTO `t_survei_kepuasan` 
(`IdSurveiKepuasan`, `IdKegiatanAkreditasi`, `TglPengisian`, `PersiapanWeb`, `PersiapanSpeak`, 
 `PersiapanKomunikasiPic`, `PersiapanKecepatanRespon`, `PersiapanJadwalSurveior`, 
 `PersiapanAlurMekanisme`, `PersiapanKualitasIT`, `PelaksanaanKetepatanWaktu`, 
 `PelaksanaanDaring`, `PelaksanaanLuring`, `PelaksanaanInstrumen`, 
 `PelaksanaanExitConference`, `SaranMasukan`) 
VALUES
-- Data 1 Januari 2026
(1, 1, '2026-01-01 09:00:00', 5, 5, 4, 5, 5, 4, 5, 5, 4, 5, 5, 5, 'Pelayanan sangat memuaskan'),
(2, 1, '2026-01-01 10:30:00', 4, 5, 5, 4, 4, 5, 4, 5, 5, 4, 4, 5, 'Surveior sangat profesional'),
(3, 1, '2026-01-01 14:15:00', 5, 4, 5, 5, 5, 5, 5, 4, 5, 5, 5, 4, 'Sistem online sangat membantu'),

-- Data 2 Januari 2026
(4, 2, '2026-01-02 08:30:00', 5, 5, 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 'Proses akreditasi berjalan lancar'),
(5, 2, '2026-01-02 11:00:00', 4, 4, 5, 4, 5, 4, 4, 5, 4, 5, 4, 5, 'Tim surveior sangat kooperatif'),
(6, 2, '2026-01-02 13:45:00', 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 5, 5, 'Dokumentasi lengkap dan jelas'),
(7, 2, '2026-01-02 15:20:00', 4, 5, 5, 4, 4, 5, 4, 5, 4, 4, 5, 4, 'Komunikasi sangat baik'),

-- Data 3 Januari 2026
(8, 3, '2026-01-03 09:15:00', 5, 4, 5, 5, 5, 4, 5, 5, 5, 5, 4, 5, 'Website mudah digunakan'),
(9, 3, '2026-01-03 10:00:00', 4, 5, 4, 5, 4, 5, 4, 4, 5, 4, 5, 5, 'Respon cepat dari tim'),
(10, 3, '2026-01-03 14:30:00', 5, 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 4, 'Instrumen survei sangat detail'),
(11, 3, '2026-01-03 16:00:00', 4, 4, 5, 5, 4, 4, 5, 4, 5, 4, 4, 5, 'Exit conference informatif'),

-- Data 4 Januari 2026
(12, 4, '2026-01-04 08:00:00', 5, 5, 5, 5, 5, 5, 4, 5, 5, 5, 5, 5, 'Sangat puas dengan layanan'),
(13, 4, '2026-01-04 11:30:00', 4, 4, 4, 4, 4, 4, 5, 4, 4, 4, 4, 4, 'Pelaksanaan sesuai jadwal'),
(14, 4, '2026-01-04 13:00:00', 3, 4, 4, 3, 4, 4, 3, 4, 3, 4, 4, 4, 'Perlu perbaikan di beberapa area'),
(15, 4, '2026-01-04 15:45:00', 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 5, 5, 'Proses sangat transparan'),

-- Data 5 Januari 2026
(16, 5, '2026-01-05 09:30:00', 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 'Sempurna! Tidak ada kendala'),
(17, 5, '2026-01-05 10:45:00', 4, 5, 5, 4, 5, 4, 5, 5, 4, 5, 5, 4, 'Tim surveior sangat membantu'),
(18, 5, '2026-01-05 12:00:00', 5, 4, 5, 5, 4, 5, 4, 5, 5, 4, 5, 5, 'Sistem IT berfungsi dengan baik'),
(19, 5, '2026-01-05 14:15:00', 5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 4, 5, 'Komunikasi lancar sepanjang survei'),
(20, 5, '2026-01-05 16:30:00', 4, 4, 5, 4, 4, 4, 5, 5, 4, 4, 5, 4, 'Pelayanan memuaskan'),

-- Data 6 Januari 2026
(21, 6, '2026-01-06 08:15:00', 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 'Luar biasa! Sangat profesional'),
(22, 6, '2026-01-06 09:00:00', 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 'Surveior berpengalaman'),
(23, 6, '2026-01-06 10:30:00', 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 'Proses efisien dan terstruktur');

-- Insert Sample Data for t_kepuasan_surveior
INSERT INTO `t_kepuasan_surveior` 
(`IdKepuasanSurveior`, `IdSurveiKepuasan`, `IdMemberData`, `InteraksiSurveior`, 
 `KetepatanWaktu`, `KemampuanKomunikasi`, `SikapPerilaku`) 
VALUES
(1, 1, 101, 5, 5, 5, 5),
(2, 2, 102, 4, 5, 4, 5),
(3, 3, 103, 5, 4, 5, 5),
(4, 4, 104, 5, 5, 5, 4),
(5, 5, 105, 4, 4, 5, 5),
(6, 6, 106, 5, 5, 4, 5),
(7, 7, 107, 4, 5, 5, 4),
(8, 8, 108, 5, 5, 5, 5),
(9, 9, 109, 4, 4, 4, 5),
(10, 10, 110, 5, 5, 5, 4),
(11, 11, 111, 4, 4, 5, 5),
(12, 12, 112, 5, 5, 5, 5),
(13, 13, 113, 4, 4, 4, 4),
(14, 14, 114, 3, 4, 4, 4),
(15, 15, 115, 5, 5, 5, 5),
(16, 16, 116, 5, 5, 5, 5),
(17, 17, 117, 4, 5, 5, 4),
(18, 18, 118, 5, 4, 5, 5),
(19, 19, 119, 5, 5, 4, 5),
(20, 20, 120, 4, 4, 5, 4),
(21, 21, 121, 5, 5, 5, 5),
(22, 22, 122, 4, 5, 4, 5),
(23, 23, 123, 5, 4, 5, 4);
