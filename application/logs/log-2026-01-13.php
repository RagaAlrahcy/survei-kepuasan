<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-13 05:24:12 --> 404 Page Not Found: Input/index
ERROR - 2026-01-13 05:24:13 --> 404 Page Not Found: Input/index
ERROR - 2026-01-13 08:21:03 --> Query error: Table 'management-surveior.mst_member' doesn't exist - Invalid query: SELECT `tsm`.*, `mm`.`NamaGelar`
FROM `t_surveyor_manual` `tsm`
LEFT JOIN `management-surveior`.`mst_member` `mm` ON `mm`.`IdMemberData` = `tsm`.`IdMemberData`
WHERE `tsm`.`IdKegiatanAkreditasi` = '1'
ERROR - 2026-01-13 08:21:27 --> Query error: Unknown column 'mm.IdMemberData' in 'on clause' - Invalid query: SELECT `tsm`.*, `mm`.`NamaGelar`
FROM `t_surveyor_manual` `tsm`
LEFT JOIN `management-surveior`.`mst_member_data` `mm` ON `mm`.`IdMemberData` = `tsm`.`IdMemberData`
WHERE `tsm`.`IdKegiatanAkreditasi` = '1'
