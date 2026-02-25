CREATE TABLE IF NOT EXISTS `jurusan` (
  `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(100) NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `jurusan` (`nama_jurusan`, `deskripsi`) VALUES
('RPL', 'Rekayasa Perangkat Lunak - Mempelajari pengembangan aplikasi dan sistem informasi'),
('TKJ', 'Teknik Komputer dan Jaringan - Mempelajari instalasi dan konfigurasi jaringan komputer'),
('AKL', 'Akuntansi dan Keuangan Lembaga - Mempelajari pencatatan dan pelaporan keuangan'),
('DKV', 'Desain Komunikasi Visual - Mempelajari desain grafis dan multimedia'),
('MPLB', 'Manajemen Perkantoran dan Layanan Bisnis - Mempelajari administrasi perkantoran'),
('PEMASARAN', 'Bisnis Daring dan Pemasaran - Mempelajari strategi pemasaran digital'),
('TO', 'Teknik Otomotif - Mempelajari perawatan dan perbaikan kendaraan bermotor'),
('TM', 'Teknik Pemesinan - Mempelajari pengoperasian mesin produksi dan manufaktur'),
('Teknik Logistik', 'Teknik Logistik - Mempelajari manajemen rantai pasok dan distribusi'),
('KULINER', 'Tata Boga - Mempelajari pengolahan makanan dan manajemen dapur');