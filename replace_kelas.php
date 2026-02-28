<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "smkn1_kurikulum_v3";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mapping jurusan
$jurusanMap = [
    'KULINER' => 10, 'TL' => 9, 'DKV' => 4, 'TM' => 8, 'TPM' => 8,
    'TO' => 7, 'TSM' => 7, 'PPLG' => 1, 'RPL' => 1, 'TJKT' => 2,
    'TKJ' => 2, 'AKL' => 3, 'AK' => 3, 'MPLB' => 5, 'MP' => 5,
    'PS' => 6, 'BR' => 6, 'BD' => 6
];

$dataKelas = [
    ['X KULINER', '10', 'Hermawati Setyani Aksari, S.Pd.'],
    ['XI KULINER', '11', 'Elin Neli Novianti, S.Pd.'],
    ['XII KULINER', '12', 'Asep Saepulloh, S.S.'],
    ['X TL', '10', 'Faisal Akbar, S.E.'],
    ['XI TL', '11', 'Deni Ariyanto, S.Pd.'],
    ['XII TL', '12', 'Rizky Hakiki, S.T.'],
    ['X DKV 1', '10', 'Asep Dani Noviandi, S.An.'],
    ['XI DKV 1', '11', 'Jelin, S.Pd.I.'],
    ['XII DKV 1', '12', 'Cici Harisningsih, S.Pd.'],
    ['X DKV 2', '10', 'Hj. Iin Indriasari, S.Pd.'],
    ['XI DKV 2', '11', 'Dra. Hj. Heti Perdiati'],
    ['XII DKV 2', '12', 'Yayang Willy Rukmana, S.Ds.'],
    ['X TM 1', '10', 'Asep Romdon, S.T.'],
    ['XI TPM 1', '11', 'Keresna Bayu Wijaya Kusuma, S.Pd.'],
    ['XII TPM 1', '12', 'Sri Andani, S.Pd.'],
    ['X TM 2', '10', 'Ace Shobandi, S.E.'],
    ['XI TPM 2', '11', 'Iin Irmayanti, S.Pd.'],
    ['XII TPM 2', '12', 'Isep Rahmanto, S.T.'],
    ['X TM 3', '10', 'Rahmat Hidayat, S.Pd.'],
    ['XI TPM 3', '11', 'H. Johan Suhendi, S.T.'],
    ['XII TPM 3', '12', 'Mas Achmad Yusuf Wibisono, S.T.'],
    ['X TO 1', '10', 'Dadang, S.Pd. I.'],
    ['XI TSM 1', '11', 'Ahmad Ruhyanto, S.Pd.'],
    ['XII TSM 1', '12', 'Firmansyah, S.T.'],
    ['X TO 2', '10', 'Nia Amalia, S.Pd.'],
    ['XI TSM 2', '11', 'Eko Agus Prasetiyo, S.Pd.'],
    ['XII TSM 2', '12', 'Guntur Widiantono, S.T.'],
    ['X TO 3', '10', 'Hj. Siti Maemunah, S.Pd., M.M.Pd.'],
    ['XI TSM 3', '11', 'Asep Rohendi, S.Pd.'],
    ['XII TSM 3', '12', 'Ari Wahyudani, S.Pd.'],
    ['X PPLG 1', '10', 'Wendy Supriatna, S.Pd.'],
    ['XI RPL 1', '11', 'Buyung Supriadi, S.S.'],
    ['XII RPL 1', '12', 'Retno Novia Andriani, S.Kom'],
    ['X PPLG 2', '10', 'Iis Ismayati, S.T.'],
    ['XI RPL 2', '11', 'Ai Sa\'adatuddaroin, S.Pd.'],
    ['XII RPL 2', '12', 'Deni Rahman Hakim, S.Pd.'],
    ['X TJKT 1', '10', 'Dede Iskandar, S.T.'],
    ['XI TKJ 1', '11', 'Gelar Laksana Cita, S.Pd.'],
    ['XII TKJ 1', '12', 'Lisna Herliani, S.Pd.I.'],
    ['X TJKT 2', '10', 'Annia Devalusiani Nurul Jaeni, M.Pd.'],
    ['XI TKJ 2', '11', 'Elis Waliah, S.Ag.'],
    ['XII TKJ 2', '12', 'Asep Ridwan, S.T.'],
    ['X AKL 1', '10', 'Fippa Insani, S.Pd.'],
    ['XI AK 1', '11', 'Putri Maulida Hutami, S.Pd.'],
    ['XII AK 1', '12', 'Kartiwi, S.Pd.I.'],
    ['X AKL 2', '10', 'Irwan Saputra, S.Pd.'],
    ['XI AK 2', '11', 'Titah Utami, S.Pd.'],
    ['XII AK 2', '12', 'H. Pepen Apendi, S.Pd., M.Pd.I.'],
    ['X AKL 3', '10', 'Aang Awaludin, S.Pd.I.'],
    ['XI AK 3', '11', 'Hafizh Handitia, S.Pd.'],
    ['XII AK 3', '12', 'Sapa Oktapiani, S.Pd.'],
    ['X MPLB 1', '10', 'Andina Nurma Fadhila, S.Hum.'],
    ['XI MP 1', '11', 'Wida Widianingsih, S.Pd.'],
    ['XII MP 1', '12', 'Regina Srinita Chatulistiwa Putri, S.Pd.'],
    ['X MPLB 2', '10', 'Puttu Aliyah Setia Raya, S.Pd.'],
    ['XI MP 2', '11', 'Dini Nurmaladewi, S.An.'],
    ['XII MP 2', '12', 'Dra. Hj. Yayah Bahriah'],
    ['X MPLB 3', '10', 'Hibar Rahayu, S.Pd.'],
    ['XI MP 3', '11', 'Dini Wulandari, S.Pd.'],
    ['XII MP 3', '12', 'Sari Utami, S.E.'],
    ['X PS 1', '10', 'Asep Komara, S.Pd.'],
    ['XI BR 1', '11', 'Hj. Siti Halimah, S.Pd.'],
    ['XII BR 1', '12', 'Hj. Chairzawati, S.E.'],
    ['X PS 2', '10', 'Reni Ika Wijayanti, M.Pd.'],
    ['XI BR 2', '11', 'Heni Ariska, S.Pd.'],
    ['XII BR 2', '12', 'Dra. Carsih'],
    ['X PS 3', '10', 'Ismaela, S.E.'],
    ['XI BR 3', '11', 'Rika Tri Mulyawati, S.Pd.'],
    ['XII BR 3', '12', 'Setyasih, S.E.'],
    ['X PS 4', '10', 'Nani Suryani, S.Pd.'],
    ['XI BD', '11', 'Fahmi Ibrahim S., S.Pd.'],
    ['XII BD', '12', 'Lia Yuliasari, S.Pd.']
];

// Hapus data lama dengan disable foreign key check
$conn->query("SET FOREIGN_KEY_CHECKS=0");
$conn->query("DELETE FROM kelas");
$conn->query("SET FOREIGN_KEY_CHECKS=1");
echo "Data lama dihapus\n\n";

// Insert data baru
$inserted = 0;
foreach ($dataKelas as $k) {
    $namaKelas = $k[0];
    $tingkat = $k[1];
    $waliKelas = $k[2];
    
    preg_match('/[A-Z]+/', str_replace(['X ', 'XI ', 'XII '], '', $namaKelas), $matches);
    $jurusan = $matches[0] ?? 'PPLG';
    $idJurusan = $jurusanMap[$jurusan] ?? 1;
    
    $stmt = $conn->prepare("INSERT INTO kelas (nama_kelas, tingkat, id_jurusan, wali_kelas, jumlah_siswa, laki, perempuan) VALUES (?, ?, ?, ?, 0, 0, 0)");
    $stmt->bind_param('ssis', $namaKelas, $tingkat, $idJurusan, $waliKelas);
    if ($stmt->execute()) {
        $inserted++;
        echo "Inserted: $namaKelas - $waliKelas\n";
    }
}

echo "\nTotal inserted: $inserted kelas";
$conn->close();
?>
