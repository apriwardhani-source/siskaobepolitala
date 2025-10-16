# Panduan Sharing Database untuk Tim

## 📦 Cara Share Data ke Teman (3 Metode)

### **Metode 1: Share File SQLite Database (PALING MUDAH)** ✅ Recommended

Karena project ini menggunakan SQLite, cara paling mudah adalah langsung share file database.

#### **Langkah untuk PENGIRIM (Dhani):**
1. Copy file database dari folder `database/database.sqlite`
2. Compress file tersebut (opsional, untuk mengecilkan ukuran)
3. Share via Google Drive / Whatsapp / Email ke teman

#### **Langkah untuk PENERIMA (Teman):**
1. Download file `database.sqlite` dari Dhani
2. Paste/Replace file tersebut ke folder `database/` di project mereka
3. Pastikan file `.env` mereka sama (terutama `DB_CONNECTION=sqlite`)
4. Done! Semua data sudah sinkron

**Keuntungan:**
- ✅ Super cepat, 1 file saja
- ✅ Tidak perlu run migration atau seeder
- ✅ Semua data termasuk ID tetap sama

**Catatan:**
- File database Anda saat ini: `database/database.sqlite` (233 KB)
- Lokasi lengkap: `C:\Users\dhani\Desktop\perkuliahan semester 3\IT Project 1\project\siskaobepolitala\database\database.sqlite`

---

### **Metode 2: Export ke SQL File**

Jika ingin lebih portable atau menggunakan MySQL di production.

#### **Export Database (oleh Dhani):**
```bash
# Untuk SQLite
php artisan db:backup
```

Atau manual export SQLite ke SQL:
```bash
# Install SQLite tools dulu jika belum
# Download dari: https://www.sqlite.org/download.html

# Export ke SQL file
sqlite3 database/database.sqlite .dump > backup-database.sql
```

#### **Import Database (oleh Teman):**
```bash
# Fresh migration dulu
php artisan migrate:fresh

# Import SQL
sqlite3 database/database.sqlite < backup-database.sql
```

---

### **Metode 3: Update Seeder dengan Data Real**

Jika ingin teman run `php artisan db:seed` tapi dengan data terbaru Anda.

**Saya akan buatkan Artisan command untuk auto-generate seeder dari database existing!**

Setelah command dibuat, caranya:
```bash
# Generate seeder dari database existing
php artisan generate:seeders

# Teman tinggal run seperti biasa
php artisan migrate:fresh --seed
```

---

## 🔄 Workflow Kolaborasi Tim

### **Setup Awal (Sekali saja):**
1. **Dhani** share file `database.sqlite` ke semua teman
2. Semua teman paste file tersebut ke folder `database/`
3. Done!

### **Setiap Ada Update Data:**

**Cara A - Share File Database (Recommended):**
- Dhani share file `database.sqlite` terbaru
- Teman replace file mereka

**Cara B - Share via Git (Hati-hati):**
```bash
# Dhani commit database
git add database/database.sqlite
git commit -m "Update database with latest data"
git push

# Teman pull
git pull origin main
```

⚠️ **WARNING**: Jangan commit database ke Git jika ada data sensitif!

---

## 🛡️ Best Practice

### **DO ✅**
- Backup database sebelum melakukan perubahan besar
- Komunikasikan ke tim sebelum share database baru
- Test di environment teman sebelum commit code

### **DON'T ❌**
- Jangan share database yang berisi password real
- Jangan overwrite database teman tanpa backup
- Jangan commit database.sqlite jika ada data production/sensitif

---

## 🔧 Troubleshooting

### **"Database is locked"**
```bash
# Matikan Laravel server
# Tutup semua koneksi database
# Baru copy file database
```

### **"SQLSTATE[HY000]: General error: 8 attempt to write a readonly database"**
```bash
# Berikan permission write ke file database
chmod 664 database/database.sqlite        # Linux/Mac
# Atau klik kanan > Properties > hilangkan Read-only  (Windows)
```

### **Data tidak muncul setelah copy database**
```bash
# Clear cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Restart server
php artisan serve
```

---

## 📋 Checklist Share Database

- [ ] Backup database Anda sendiri dulu
- [ ] Copy file `database/database.sqlite`
- [ ] Share via Google Drive/Whatsapp
- [ ] Teman download dan paste ke folder `database/`
- [ ] Teman check `.env` pastikan `DB_CONNECTION=sqlite`
- [ ] Teman run `php artisan config:clear`
- [ ] Teman run `php artisan serve` dan test
- [ ] Konfirmasi data sudah sinkron

---

## 📞 Kontak

Jika ada masalah saat sharing database, hubungi tim development.

**Happy Coding! 🚀**
