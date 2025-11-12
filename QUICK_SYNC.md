# ⚡ Quick Sync Guide

## Untuk Tim yang Baru Pull Code

**Option 1: Jalankan Script (Paling Mudah)**
```bash
# Windows
sync-data.bat

# Mac/Linux
chmod +x sync-data.sh
./sync-data.sh
```

**Option 2: Manual Commands**
```bash
git pull
php artisan migrate
php artisan db:seed
php artisan cache:clear
```

---

## Untuk Developer yang Input Data Baru

**Step 1: Update Seeder**
Edit file: `database/seeders/MahasiswaSeeder.php`

Tambahkan data baru:
```php
[
    'nim' => '2301301999',
    'nama_mahasiswa' => 'Nama Mahasiswa Baru',
    'kode_prodi' => 'TI',
    'id_tahun_kurikulum' => 1,
    'status' => 'aktif',
    'created_at' => now(),
    'updated_at' => now(),
],
```

**Step 2: Commit & Push**
```bash
git add database/seeders/MahasiswaSeeder.php
git commit -m "Add mahasiswa baru ke seeder"
git push
```

**Step 3: Beritahu Tim**
Kirim pesan: "Pull code & jalankan `php artisan db:seed`"

---

## Reset Database (Fresh Start)

**⚠️ WARNING: Ini akan hapus SEMUA data!**
```bash
php artisan migrate:fresh --seed
```

---

Dokumentasi lengkap: Baca `DATA_SYNC_GUIDE.md`
