-- Database: survei_kepuasan

CREATE DATABASE IF NOT EXISTS survei_kepuasan;
USE survei_kepuasan;

-- Table structure for table `survei_data`
CREATE TABLE IF NOT EXISTS `survei_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `sangat_puas` int(11) DEFAULT 0,
  `puas` int(11) DEFAULT 0,
  `cukup` int(11) DEFAULT 0,
  `tidak_puas` int(11) DEFAULT 0,
  `sangat_tidak_puas` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `survei_data` (`tanggal`, `sangat_puas`, `puas`, `cukup`, `tidak_puas`, `sangat_tidak_puas`) VALUES
('2026-01-01', 120, 85, 30, 10, 5),
('2026-01-02', 135, 90, 25, 8, 2),
('2026-01-03', 140, 95, 28, 12, 5),
('2026-01-04', 125, 88, 32, 15, 10),
('2026-01-05', 150, 100, 20, 5, 5),
('2026-01-06', 160, 105, 18, 7, 3);
