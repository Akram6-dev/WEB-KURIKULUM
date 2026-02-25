<?php
$host = "localhost";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->query("DROP DATABASE IF EXISTS smkn1_kurikulum_v3");
echo "Database lama dihapus\n";

$sql = file_get_contents(__DIR__ . '/public/kurikulum/smkn1_kurikulum_v3.sql');
$conn->multi_query($sql);

do {
    if ($result = $conn->store_result()) {
        $result->free();
    }
} while ($conn->next_result());

echo "Database berhasil diimport!";
$conn->close();
?>
