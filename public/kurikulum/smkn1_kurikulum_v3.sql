-- DATABASE: smkn1_kurikulum_v3
CREATE DATABASE IF NOT EXISTS smkn1_kurikulum_v3;
USE smkn1_kurikulum_v3;

CREATE TABLE jurusan (
  id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
  nama_jurusan VARCHAR(100),
  keterangan TEXT,
  deskripsi TEXT,
  logo VARCHAR(255)
);

CREATE TABLE kelas (
  id_kelas INT AUTO_INCREMENT PRIMARY KEY,
  nama_kelas VARCHAR(50),
  tingkat ENUM('10','11','12'),
  id_jurusan INT,
  wali_kelas VARCHAR(100),
  jumlah_siswa INT DEFAULT 0,
  laki INT DEFAULT 0,
  perempuan INT DEFAULT 0,
  FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan)
);

CREATE TABLE siswa (
  id_siswa INT AUTO_INCREMENT PRIMARY KEY,
  nama_siswa VARCHAR(100),
  nis VARCHAR(20),
  id_kelas INT,
  jk VARCHAR(2),
  foto VARCHAR(255),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);

CREATE TABLE guru (
  id_guru INT AUTO_INCREMENT PRIMARY KEY,
  nama_guru VARCHAR(100),
  nip VARCHAR(30),
  mapel VARCHAR(100)
);

CREATE TABLE jadwal (
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

CREATE TABLE absensi (
  id_absen INT AUTO_INCREMENT PRIMARY KEY,
  id_kelas INT,
  tanggal DATE,
  nama VARCHAR(100),
  status ENUM('Hadir','Izin','Sakit','Alpa'),
  foto VARCHAR(255),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);

CREATE TABLE tugas (
  id_tugas INT AUTO_INCREMENT PRIMARY KEY,
  id_kelas INT,
  judul VARCHAR(255),
  deskripsi TEXT,
  tanggal_upload DATE,
  deadline DATE,
  file_tugas VARCHAR(255),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);

CREATE TABLE materi (
  id_materi INT AUTO_INCREMENT PRIMARY KEY,
  id_kelas INT,
  judul VARCHAR(255),
  deskripsi TEXT,
  tanggal_upload DATE,
  file_materi VARCHAR(255),
  FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas)
);

CREATE TABLE admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO jurusan (nama_jurusan,keterangan,deskripsi,logo) VALUES
('PPLG','Pengembangan Perangkat Lunak dan Gim','Pengembangan Perangkat Lunak dan Gim','pplg.png'),
('TJKT','Teknik Jaringan Komputer dan Telekomunikasi','Teknik Jaringan Komputer dan Telekomunikasi','tjkt.png'),
('AKL','Akuntansi dan Keuangan Lembaga','Akuntansi dan Keuangan Lembaga','akl.png'),
('DKV','Desain Komunikasi Visual','Desain Komunikasi Visual','dkv.png'),
('MPLB','Manajemen Perkantoran dan Layanan Bisnis','Manajemen Perkantoran dan Layanan Bisnis','mplb.png'),
('PEMASARAN','Pemasaran dan Bisnis Daring','Pemasaran dan Bisnis Daring','pemasaran.png'),
('TO','Teknik Otomotif','Teknik Otomotif','to.png'),
('TM','Teknik Mesin','Teknik Mesin','tm.png'),
('TL','Teknik Listrik','Teknik Listrik','tl.png'),
('KULINER','Tata Boga dan Kuliner','Tata Boga dan Kuliner','kuliner.png');

INSERT INTO kelas (nama_kelas,tingkat,id_jurusan,wali_kelas,jumlah_siswa,laki,perempuan) VALUES
('PPLG 1','10',1,'Bapak Asep Suherman',35,20,15),
('PPLG 2','10',1,'Ibu Dewi Marlina',33,18,15),
('PPLG 1','11',1,'Siti Nurhayati',30,17,13),
('PPLG 1','12',1,'Agus Salim',28,15,13),
('TJKT 1','10',2,'Irfan Hidayat',36,22,14),
('DKV 1','11',3,'Andi Setiawan',32,15,17),
('AKL 1','10',4,'Nuraini',34,10,24),
('MPLB 1','11',5,'Rina Agustin',30,9,21),
('TO 1','12',7,'Deni Rahman',31,25,6),
('KULINER 1','12',10,'Siti Mulyani',33,8,25);

INSERT INTO siswa (nama_siswa,nis,id_kelas,jk) VALUES
('Adit Permana','12345',1,'L'),
('Rani Ayu','12346',1,'P'),
('Budi Pratama','12347',1,'L');

INSERT INTO admin (username, password) VALUES ('admin', 'NESAS_CEREN');
