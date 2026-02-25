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
    'TL' => 9, 'TJKT' => 2, 'AKL' => 3, 'TO' => 7, 'MPLB' => 5,
    'TM' => 8, 'KL' => 10, 'PS' => 6, 'DKV' => 4, 'PPLG' => 1,
    'TPM' => 8, 'TDM' => 8, 'TSM' => 7, 'RPL' => 1, 'MP' => 5,
    'TKJ' => 2, 'AK' => 3, 'BR' => 6, 'BD' => 6
];

$kelas = [
    ['X TL', '10'], ['X TJKT 1', '10'], ['X TJKT 2', '10'], ['X AKL 1', '10'], ['X AKL 2', '10'], ['X AKL 3', '10'],
    ['X TO 1', '10'], ['X TO 2', '10'], ['X TO 3', '10'], ['X MPLB 1', '10'], ['X MPLB 2', '10'], ['X MPLB 3', '10'],
    ['X TM 1', '10'], ['X TM 2', '10'], ['X TM 3', '10'], ['X KL', '10'], ['X PS 1', '10'], ['X PS 2', '10'],
    ['X DKV 1', '10'], ['X DKV 2', '10'], ['X PPLG 1', '10'], ['X PPLG 2', '10'], ['X PS 3', '10'], ['X PS 4', '10'],
    ['XI KL', '11'], ['XI DKV 1', '11'], ['XI DKV 2', '11'], ['XI TPM 1', '11'], ['XI TDM 2', '11'],
    ['XI TSM 1', '11'], ['XI RPL 2', '11'], ['XI MP 1', '11'], ['XI TL', '11'], ['XI TKJ 2', '11'],
    ['XII TKJ 1', '12'], ['XII AK 1', '12'], ['XII DKV 1', '12'], ['XII KL', '12'],
    ['XII TKJ 2', '12'], ['XII AK 2', '12'], ['XII DKV 2', '12'], ['XII RPL 1', '12'],
    ['XII TPM 1', '12'], ['XII TSM 1', '12'], ['XII MP 1', '12'], ['XII BR 1', '12'],
    ['XII TPM 2', '12'], ['XII TSM 2', '12'], ['XII MP 2', '12'], ['XII BR 2', '12'],
    ['XII TPM 3', '12'], ['XII TSM 3', '12'], ['XII MP 3', '12'], ['XII BR 3', '12'],
    ['XII TL', '12'], ['XII AK 3', '12'], ['XII RPL 2', '12'], ['XII BD', '12']
];

$conn->query("DELETE FROM kelas");

foreach ($kelas as $k) {
    $namaKelas = $k[0];
    $tingkat = $k[1];
    
    preg_match('/[A-Z]+/', str_replace(['X ', 'XI ', 'XII '], '', $namaKelas), $matches);
    $jurusan = $matches[0] ?? 'PPLG';
    $idJurusan = $jurusanMap[$jurusan] ?? 1;
    
    $sql = "INSERT INTO kelas (nama_kelas, tingkat, id_jurusan, wali_kelas, jumlah_siswa, laki, perempuan) 
            VALUES ('$namaKelas', '$tingkat', $idJurusan, '-', 0, 0, 0)";
    $conn->query($sql);
}

echo "Berhasil insert " . count($kelas) . " kelas!";
$conn->close();
?>
