# 📋 Panduan Sinkronisasi Data untuk Tim

Dokumen ini menjelaskan cara agar data yang diinput oleh satu developer bisa digunakan oleh developer lain setelah `git pull`.

---

## 🎯 Masalah
Ketika Admin Prodi input data mahasiswa, mata kuliah, atau nilai di local, data tersebut **tidak ikut** saat tim lain pull code karena:
- Database **tidak** di-commit ke Git (file `database.sqlite` ada di `.gitignore`)
- Setiap developer punya database lokal sendiri

---

## ✅ Solusi 1: Database Seeder (Recommended)

### Cara Kerja:
1. Data sample dimasukkan ke **Seeder File** (PHP code)
2. Seeder file di-commit ke Git
3. Tim lain jalankan `php artisan db:seed` untuk populate data

### Langkah untuk Developer yang Input Data:

**Step 1: Generate Seeder (sudah dibuat)**
```bash
php artisan make:seeder MahasiswaSeeder
```

**Step 2: Jalankan Seeder**
```bash
# Jalankan semua seeder
php artisan db:seed

# Atau spesifik satu seeder
php artisan db:seed --class=MahasiswaSeeder
```

### Langkah untuk Tim yang Pull Code:

```bash
# 1. Pull code terbaru
git pull

# 2. Jalankan migration (kalau ada yang baru)
php artisan migrate

# 3. Jalankan seeder untuk populate data
php artisan db:seed

# Atau kalau mau reset semua dan re-seed:
php artisan migrate:fresh --seed
```

---

## 🔄 Solusi 2: Export/Import Database (Quick & Dirty)

### Export Database (oleh yang punya data):

```bash
# Cara 1: Copy file database (SQLite)
# Kirim file database.sqlite ke tim via Google Drive/Dropbox
# File ada di: database/database.sqlite

# Cara 2: Export ke SQL
sqlite3 database/database.sqlite .dump > database_backup.sql
```

### Import Database (oleh tim yang terima):

```bash
# Cara 1: Replace file database
# Paste file database.sqlite yang diterima ke folder database/

# Cara 2: Import dari SQL
sqlite3 database/database.sqlite < database_backup.sql
```

**⚠️ Warning:** Jangan commit `database.sqlite` atau `database_backup.sql` ke Git!

---

## 📝 Solusi 3: Migration dengan Data (Advanced)

Buat migration yang juga insert data:

```bash
php artisan make:migration seed_sample_mahasiswa_data
```

Edit migration:
```php
public function up()
{
    DB::table('mahasiswas')->insert([
        [
            'nim' => '2301301001',
            'nama_mahasiswa' => 'Rizqia Febrianoor',
            'kode_prodi' => 'TI',
            'id_tahun_kurikulum' => 1,
            'status' => 'aktif',
        ],
        // ... data lainnya
    ]);
}
```

Tim lain tinggal:
```bash
git pull
php artisan migrate
```

---

## 🎓 Best Practice untuk Tim

### 1. Gunakan Seeder untuk Data Sample
- ✅ User sample (UserSeeder) - sudah ada
- ✅ Mahasiswa sample (MahasiswaSeeder) - sudah dibuat
- ✅ Prodi, Tahun, Mata Kuliah - bisa ditambahkan

### 2. Jangan Commit Database File
File di `.gitignore`:
```
/database/database.sqlite
/database/*.sqlite
/database/*.db
```

### 3. Dokumentasikan di README
Tambahkan di README.md:
```markdown
## Setup Database
```bash
php artisan migrate:fresh --seed
```
Ini akan membuat database baru dan mengisi data sample.
```

### 4. Komunikasi dengan Tim
Setiap kali ada perubahan data penting:
- 📢 Beritahu di group: "Ada seeder baru, jalankan `php artisan db:seed`"
- 📝 Update dokumentasi kalau ada data dependency

---

## 🚀 Workflow Development Tim

```bash
# Morning routine - Sinkronisasi dengan tim
git pull                      # Pull code terbaru
php artisan migrate          # Jalankan migration baru
php artisan db:seed          # Load data sample terbaru
php artisan cache:clear      # Clear cache
php artisan view:clear       # Clear view cache

# Setelah input data baru (misal mahasiswa baru)
# 1. Update MahasiswaSeeder.php dengan data baru
# 2. Commit seeder file
git add database/seeders/MahasiswaSeeder.php
git commit -m "Update mahasiswa seeder dengan data baru"
git push

# Tim lain tinggal:
git pull
php artisan db:seed --class=MahasiswaSeeder
```

---

## ❓ FAQ

**Q: Kenapa tidak commit file database.sqlite saja?**
A: Karena:
- File binary, sulit di-track perubahan
- Conflict saat merge
- Ukuran file besar, memperlambat git
- Setiap developer punya data lokal yang berbeda

**Q: Seeder vs Migration + Data?**
A: 
- **Seeder**: Untuk data sample/testing, bisa di-run berulang
- **Migration**: Untuk struktur database, di-run sekali

**Q: Data production bagaimana?**
A: 
- Production punya database sendiri di server
- Jangan gunakan seeder untuk data production
- Gunakan Laravel Backup package untuk backup production

---

## 📚 Resources

- [Laravel Seeding Documentation](https://laravel.com/docs/11.x/seeding)
- [Database: Migrations](https://laravel.com/docs/11.x/migrations)

---

**Dibuat:** 2025-11-12  
**Update terakhir:** 2025-11-12
