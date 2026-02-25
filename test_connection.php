<?php
require_once 'config/database.php';

echo "<h2>Test Koneksi Database XAMPP</h2>";

try {
    // Test connection
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color: green;'>✓ Koneksi ke database berhasil!</p>";
    
    // Check if admin table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'admin'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Tabel admin sudah ada</p>";
        
        // Check admin data
        $stmt = $pdo->query("SELECT username FROM admin");
        $admins = $stmt->fetchAll();
        echo "<p>Admin users: ";
        foreach ($admins as $admin) {
            echo $admin['username'] . " ";
        }
        echo "</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Tabel admin belum ada. Jalankan create_admin_table.sql terlebih dahulu</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>