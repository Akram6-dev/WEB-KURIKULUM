# Sistem Kurikulum SMKN 1 Subang

Sistem Informasi Kurikulum berbasis web untuk SMKN 1 Subang.

## Fitur
- ✅ Manajemen Data Guru
- ✅ Manajemen Data Siswa
- ✅ Manajemen Jadwal Pelajaran
- ✅ Export Jadwal ke PDF
- ✅ Detail Jurusan & Kelas
- ✅ Custom Time Picker
- ✅ Responsive Design

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd PROJECT-LARAVEL
```

### 2. Setup Database
```bash
mysql -u root -p < public/kurikulum/database/schema.sql
```

Atau import via phpMyAdmin: `public/kurikulum/database/schema.sql`

### 3. Konfigurasi
Edit `public/kurikulum/config/db.php` sesuai setting MySQL kamu.

### 4. Jalankan
```bash
php artisan serve
```

Akses: `http://localhost:8000/kurikulum`

## Login Admin
- Username: `admin`
- Password: `NESAS_CEREN`

## Teknologi
- PHP 8.x
- MySQL
- Laravel 10.x
- JavaScript (Custom Time Picker)
- CSS3

## Struktur Folder
```
public/kurikulum/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── templates/
├── config/
├── database/
└── pages/
```

## Update Database

Jika ada perubahan data yang ingin di-share:
```bash
mysqldump -u root -p smkn1_kurikulum_v3 > public/kurikulum/database/backup.sql
git add .
git commit -m "Update database"
git push
```

## License
MIT License
