# Database Setup

## Cara Install Database

### 1. Import Schema
```bash
mysql -u root -p < database/schema.sql
```

Atau via phpMyAdmin:
1. Buka phpMyAdmin
2. Klik tab "Import"
3. Pilih file `database/schema.sql`
4. Klik "Go"

### 2. Konfigurasi Database
Edit file `config/db.php` sesuai dengan setting MySQL kamu:
```php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'smkn1_kurikulum_v3';
```

### 3. Login Admin
- Username: `admin`
- Password: `NESAS_CEREN`

## Export Database (Untuk Update)

Jika ada perubahan data dan ingin di-share:

```bash
mysqldump -u root -p smkn1_kurikulum_v3 > database/backup.sql
```

## Struktur Database

- **admin** - Data admin login
- **jurusan** - Program keahlian
- **kelas** - Data kelas per jurusan
- **guru** - Data guru
- **siswa** - Data siswa
- **jadwal** - Jadwal pelajaran
