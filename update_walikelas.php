<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "smkn1_kurikulum_v3";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$dataWaliKelas = [
    'X KULINER' => 'Hermawati Setyani Aksari, S.Pd.',
    'XI KULINER' => 'Elin Neli Novianti, S.Pd.',
    'XII KULINER' => 'Asep Saepulloh, S.S.',
    'X TL' => 'Faisal Akbar, S.E.',
    'XI TL' => 'Deni Ariyanto, S.Pd.',
    'XII TL' => 'Rizky Hakiki, S.T.',
    'X DKV 1' => 'Asep Dani Noviandi, S.An.',
    'XI DKV 1' => 'Jelin, S.Pd.I.',
    'XII DKV 1' => 'Cici Harisningsih, S.Pd.',
    'X DKV 2' => 'Hj. Iin Indriasari, S.Pd.',
    'XI DKV 2' => 'Dra. Hj. Heti Perdiati',
    'XII DKV 2' => 'Yayang Willy Rukmana, S.Ds.',
    'X TM 1' => 'Asep Romdon, S.T.',
    'XI TPM 1' => 'Keresna Bayu Wijaya Kusuma, S.Pd.',
    'XII TPM 1' => 'Sri Andani, S.Pd.',
    'X TM 2' => 'Ace Shobandi, S.E.',
    'XI TPM 2' => 'Iin Irmayanti, S.Pd.',
    'XII TPM 2' => 'Isep Rahmanto, S.T.',
    'X TM 3' => 'Rahmat Hidayat, S.Pd.',
    'XI TPM 3' => 'H. Johan Suhendi, S.T.',
    'XII TPM 3' => 'Mas Achmad Yusuf Wibisono, S.T.',
    'X TO 1' => 'Dadang, S.Pd. I.',
    'XI TSM 1' => 'Ahmad Ruhyanto, S.Pd.',
    'XII TSM 1' => 'Firmansyah, S.T.',
    'X TO 2' => 'Nia Amalia, S.Pd.',
    'XI TSM 2' => 'Eko Agus Prasetiyo, S.Pd.',
    'XII TSM 2' => 'Guntur Widiantono, S.T.',
    'X TO 3' => 'Hj. Siti Maemunah, S.Pd., M.M.Pd.',
    'XI TSM 3' => 'Asep Rohendi, S.Pd.',
    'XII TSM 3' => 'Ari Wahyudani, S.Pd.',
    'X PPLG 1' => 'Wendy Supriatna, S.Pd.',
    'XI RPL 1' => 'Buyung Supriadi, S.S.',
    'XII RPL 1' => 'Retno Novia Andriani, S.Kom',
    'X PPLG 2' => 'Iis Ismayati, S.T.',
    'XI RPL 2' => 'Ai Sa\'adatuddaroin, S.Pd.',
    'XII RPL 2' => 'Deni Rahman Hakim, S.Pd.',
    'X TJKT 1' => 'Dede Iskandar, S.T.',
    'XI TKJ 1' => 'Gelar Laksana Cita, S.Pd.',
    'XII TKJ 1' => 'Lisna Herliani, S.Pd.I.',
    'X TJKT 2' => 'Annia Devalusiani Nurul Jaeni, M.Pd.',
    'XI TKJ 2' => 'Elis Waliah, S.Ag.',
    'XII TKJ 2' => 'Asep Ridwan, S.T.',
    'X AKL 1' => 'Fippa Insani, S.Pd.',
    'XI AK 1' => 'Putri Maulida Hutami, S.Pd.',
    'XII AK 1' => 'Kartiwi, S.Pd.I.',
    'X AKL 2' => 'Irwan Saputra, S.Pd.',
    'XI AK 2' => 'Titah Utami, S.Pd.',
    'XII AK 2' => 'H. Pepen Apendi, S.Pd., M.Pd.I.',
    'X AKL 3' => 'Aang Awaludin, S.Pd.I.',
    'XI AK 3' => 'Hafizh Handitia, S.Pd.',
    'XII AK 3' => 'Sapa Oktapiani, S.Pd.',
    'X MPLB 1' => 'Andina Nurma Fadhila, S.Hum.',
    'XI MP 1' => 'Wida Widianingsih, S.Pd.',
    'XII MP 1' => 'Regina Srinita Chatulistiwa Putri, S.Pd.',
    'X MPLB 2' => 'Puttu Aliyah Setia Raya, S.Pd.',
    'XI MP 2' => 'Dini Nurmaladewi, S.An.',
    'XII MP 2' => 'Dra. Hj. Yayah Bahriah',
    'X MPLB 3' => 'Hibar Rahayu, S.Pd.',
    'XI MP 3' => 'Dini Wulandari, S.Pd.',
    'XII MP 3' => 'Sari Utami, S.E.',
    'X PS 1' => 'Asep Komara, S.Pd.',
    'XI BR 1' => 'Hj. Siti Halimah, S.Pd.',
    'XII BR 1' => 'Hj. Chairzawati, S.E.',
    'X PS 2' => 'Reni Ika Wijayanti, M.Pd.',
    'XI BR 2' => 'Heni Ariska, S.Pd.',
    'XII BR 2' => 'Dra. Carsih',
    'X PS 3' => 'Ismaela, S.E.',
    'XI BR 3' => 'Rika Tri Mulyawati, S.Pd.',
    'XII BR 3' => 'Setyasih, S.E.',
    'X PS 4' => 'Nani Suryani, S.Pd.',
    'XI BD' => 'Fahmi Ibrahim S., S.Pd.',
    'XII BD' => 'Lia Yuliasari, S.Pd.'
];

$updated = 0;
foreach ($dataWaliKelas as $namaKelas => $waliKelas) {
    $stmt = $conn->prepare("UPDATE kelas SET wali_kelas = ? WHERE nama_kelas = ?");
    $stmt->bind_param('ss', $waliKelas, $namaKelas);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $updated++;
        echo "Updated: $namaKelas => $waliKelas\n";
    }
}

echo "\nTotal updated: $updated kelas";
$conn->close();
?>
