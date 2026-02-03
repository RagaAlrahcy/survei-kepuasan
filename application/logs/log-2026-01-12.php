<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-12 08:10:35 --> 404 Page Not Found: Input/index
ERROR - 2026-01-12 08:10:38 --> 404 Page Not Found: Input/index
ERROR - 2026-01-12 10:54:39 --> Query error: Table 'speak_production.m_fasyankes' doesn't exist - Invalid query: SELECT `mf`.`NamaFasyankes` as `nama_rs`, `mf`.`Narahubung` as `pic`, `mf`.`NoInactivated` as `no_hp`, `mf`.`AlamatFasyankes` as `alamat`, `ta`.`TglMulai` as `tgl_survei`, "" as `dokumentasi -- Placeholder if file link is not in DB yet`
FROM `t_akreditasi` `ta`
LEFT JOIN `m_fasyankes` `mf` ON `mf`.`IdFasyankes` = `ta`.`IdFasyankes`
WHERE `ta`.`IdKegiatan` = '1'
ERROR - 2026-01-12 10:54:39 --> Severity: Warning --> include(C:\xampp\htdocs\survei-kepuasan\application\views\errors\html\error_db.php): failed to open stream: No such file or directory C:\xampp\htdocs\survei-kepuasan\system\core\Exceptions.php 182
ERROR - 2026-01-12 10:54:39 --> Severity: Warning --> include(): Failed opening 'C:\xampp\htdocs\survei-kepuasan\application\views\errors\html\error_db.php' for inclusion (include_path='C:\xampp\php\PEAR') C:\xampp\htdocs\survei-kepuasan\system\core\Exceptions.php 182
ERROR - 2026-01-12 10:56:13 --> Query error: Table 'speak_production.m_fasyankes' doesn't exist - Invalid query: SELECT `mf`.`NamaFasyankes` as `nama_rs`, `mf`.`Narahubung` as `pic`, `mf`.`NoInactivated` as `no_hp`, `mf`.`AlamatFasyankes` as `alamat`, `ta`.`TglMulai` as `tgl_survei`, "" as `dokumentasi -- Placeholder if file link is not in DB yet`
FROM `t_akreditasi` `ta`
LEFT JOIN `m_fasyankes` `mf` ON `mf`.`IdFasyankes` = `ta`.`IdFasyankes`
WHERE `ta`.`IdKegiatanAkreditasi` = '1'
ERROR - 2026-01-12 11:01:35 --> Query error: Unknown column 'ta.KodeRs' in 'on clause' - Invalid query: SELECT `mrs`.`Nama` as `nama_rs`, `mr`.`NamaPanggilan` as `pic`, `mr`.`NomorHp` as `no_hp`, `mrs`.`Alamat` as `alamat`, `ta`.`TglMulai` as `tgl_survei`, "" as `dokumentasi -- Placeholder if file link is not in DB yet`
FROM `t_akreditasi` `ta`
LEFT JOIN `m_rumah_sakit` `mrs` ON `mrs`.`IdRumahSakit` = `ta`.`IdRumahSakit`
LEFT JOIN `m_register` `mr` ON `mr`.`KodeRs` = `ta`.`KodeRs`
WHERE `ta`.`IdKegiatanAkreditasi` = '1'
