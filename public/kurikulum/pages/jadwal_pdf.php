<?php
session_start();
include '../config/db.php';

// Fetch jadwal data
$res = $conn->query('SELECT * FROM jadwal ORDER BY FIELD(hari,"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"),jam_mulai');
$jadwal = [];
while ($row = $res->fetch_assoc()) {
    $jadwal[] = $row;
}

// Group jadwal by guru and hari to eliminate duplicates
$jadwalGrouped = [];
foreach ($jadwal as $row) {
    $key = $row['guru_pengampu'] . '|' . $row['hari'] . '|' . $row['jam_mulai'] . '|' . $row['jam_selesai'] . '|' . $row['mapel'];
    if (!isset($jadwalGrouped[$key])) {
        $jadwalGrouped[$key] = $row;
    }
}

// Sort by hari order and jam_mulai
$hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
usort($jadwalGrouped, function($a, $b) use ($hariOrder) {
    $hariCmp = ($hariOrder[$a['hari']] ?? 999) - ($hariOrder[$b['hari']] ?? 999);
    if ($hariCmp !== 0) return $hariCmp;
    return strcmp($a['jam_mulai'], $b['jam_mulai']);
});

// Generate PDF as HTML (printable format)
header('Content-Type: text/html; charset=utf-8');
header('Content-Disposition: inline; filename="jadwal.pdf"');

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Pelajaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table thead {
            background-color: #2c3e50;
            color: white;
        }
        
        table th {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 13px;
        }
        
        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            color: #666;
            font-size: 12px;
        }
        
        .print-btn {
            margin: 20px 0;
            text-align: right;
        }
        
        button {
            padding: 10px 20px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        button:hover {
            background: #34495e;
        }
        
        @media print {
            .print-btn {
                display: none;
            }
            body {
                margin: 0;
            }
            @page {
                margin: 0.5in;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
        
        /* Menghilangkan header/footer URL dan tanggal saat print */
        @page {
            margin: 0.5in;
            @bottom-left {
                content: "";
            }
            @bottom-right {
                content: "";
            }
            @bottom-center {
                content: "";
            }
            @top-left {
                content: "";
            }
            @top-right {
                content: "";
            }
            @top-center {
                content: "";
            }
        }
    </style>
</head>
<body>
    <div class="print-btn">
        <button onclick="window.print()">🖨️ Cetak / Simpan sebagai PDF</button>
    </div>
    
    <div class="header">
        <p>SMKN 1 Subang</p>
        <p>Tanggal: <?php echo date('d-m-Y H:i:s'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengampu</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jadwalGrouped as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['hari']); ?></td>
                <td><?php echo htmlspecialchars($row['jam_mulai']); ?></td>
                <td><?php echo htmlspecialchars($row['jam_selesai']); ?></td>
                <td><?php echo htmlspecialchars($row['mapel']); ?></td>
                <td><?php echo htmlspecialchars($row['guru_pengampu']); ?></td>
                <td><?php echo htmlspecialchars($row['kelas']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem SMKN 1 Subang</p>
    </div>
</body>
</html>
