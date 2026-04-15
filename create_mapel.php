<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "smkn1_kurikulum_v3";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$conn->query("CREATE TABLE IF NOT EXISTS mata_pelajaran (
    id_mapel INT AUTO_INCREMENT PRIMARY KEY,
    nama_mapel VARCHAR(255) NOT NULL,
    kategori ENUM('Umum','Produktif') DEFAULT 'Umum'
)");

$conn->query("DELETE FROM mata_pelajaran");

$data = [
    ['Pendidikan Agama dan Budi Pekerti', 'Umum'],
    ['Pendidikan Pancasila dan Kewarganegaraan (PPKn)', 'Umum'],
    ['Bahasa Indonesia', 'Umum'],
    ['Bahasa Inggris', 'Umum'],
    ['Bahasa Jepang', 'Umum'],
    ['Matematika', 'Umum'],
    ['Sejarah Indonesia', 'Umum'],
    ['Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)', 'Umum'],
    ['Seni Budaya', 'Umum'],
    ['Prakarya dan Kewirausahaan (PKWU)', 'Umum'],
    ['Produktif RPL', 'Produktif'],
    ['Produktif TKJ', 'Produktif'],
    ['Produktif DKV', 'Produktif'],
    ['Produktif TO', 'Produktif'],
    ['Produktif TM', 'Produktif'],
    ['Produktif KULINER', 'Produktif'],
    ['Produktif AKL', 'Produktif'],
    ['Produktif MPLB', 'Produktif'],
    ['Produktif PEMASARAN', 'Produktif'],
    ['Produktif TEKNIK LOGISTIK', 'Produktif'],
];

$stmt = $conn->prepare("INSERT INTO mata_pelajaran (nama_mapel, kategori) VALUES (?, ?)");
foreach ($data as $d) {
    $stmt->bind_param('ss', $d[0], $d[1]);
    $stmt->execute();
    echo "Inserted: {$d[0]}\n";
}

echo "\nTotal: " . count($data) . " mata pelajaran berhasil diinsert!";
$conn->close();
?>
