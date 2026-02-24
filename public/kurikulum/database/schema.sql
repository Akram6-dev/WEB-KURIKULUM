-- Database: smkn1_kurikulum_v3
-- Buat database dan tabel untuk sistem kurikulum SMKN 1 Subang

CREATE DATABASE IF NOT EXISTS smkn1_kurikulum_v3;
USE smkn1_kurikulum_v3;

-- Tabel Admin
CREATE TABLE IF NOT EXISTS admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Tabel Jurusan
CREATE TABLE IF NOT EXISTS jurusan (
  id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
  nama_jurusan VARCHAR(100) NOT NULL,
  deskripsi TEXT
);

-- Tabel Kelas
CREATE TABLE IF NOT EXISTS kelas (
  id_kelas INT AUTO_INCREMENT PRIMARY KEY,
  nama_kelas VARCHAR(50) NOT NULL,
  tingkat INT NOT NULL,
  id_jurusan INT,
  wali_kelas VARCHAR(100),
  jumlah_siswa INT DEFAULT 0,
  FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan)
);

-- Tabel Guru
CREATE TABLE IF NOT EXISTS guru (
  id_guru INT AUTO_INCREMENT PRIMARY KEY,
  nama_guru VARCHAR(100) NOT NULL,
  nip VARCHAR(50),
  mapel VARCHAR(100)
);

-- Tabel Siswa
CREATE TABLE IF NOT EXISTS siswa (
  id_siswa INT AUTO_INCREMENT PRIMARY KEY,
  nama_siswa VARCHAR(100) NOT NULL,
  nis VARCHAR(50),
  id_kelas INT,
  jk ENUM('L', 'P'),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);

-- Tabel Jadwal
CREATE TABLE IF NOT EXISTS jadwal (
  id_jadwal INT AUTO_INCREMENT PRIMARY KEY,
  id_kelas INT,
  hari VARCHAR(20),
  jam_mulai TIME,
  jam_selesai TIME,
  mapel VARCHAR(100),
  guru_pengampu VARCHAR(100),
  kelas VARCHAR(50),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);

-- Insert data default admin
INSERT INTO admin (username, password) VALUES ('admin', 'NESAS_CEREN');

-- Insert data jurusan
INSERT INTO jurusan (nama_jurusan, deskripsi) VALUES
('RPL', 'Rekayasa Perangkat Lunak'),
('TKJ', 'Teknik Komputer dan Jaringan'),
('AKL', 'Akuntansi dan Keuangan Lembaga'),
('DKV', 'Desain Komunikasi Visual'),
('MPLB', 'Manajemen Perkantoran dan Layanan Bisnis'),
('PEMASARAN', 'Pemasaran'),
('TO', 'Teknik Otomotif'),
('TM', 'Teknik Pemesinan'),
('Teknik Logistik', 'Teknik Logistik'),
('KULINER', 'Tata Boga');
