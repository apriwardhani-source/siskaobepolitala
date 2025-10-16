# 🔄 Git Database Auto-Sync Setup

## Cara Kerja Auto-Sync Database via Git

Ketika kamu **`git push`**, database ikut ter-commit.  
Ketika teman **`git pull`**, database auto ter-update dan cache di-refresh otomatis.

---

## 🚀 Setup Awal (Lakukan SEKALI saja)

### **1. Setup di Komputer Dhani (Pemilik Data)**

```bash
# Pastikan database.sqlite tidak di-ignore
# (Sudah di-check, aman!)

# Commit database ke Git
git add database/database.sqlite
git commit -m "Add database with current data"
git push origin main
```

### **2. Setup di Komputer Teman (Semua Anggota Tim)**

```bash
# Clone atau pull repository
git pull origin main

# Install Git hooks untuk auto-refresh
# Double-click file ini atau run di terminal:
setup-git-hooks.bat

# DONE! Sekarang setiap git pull, database akan auto-sinkron
```

---

## 📋 Workflow Sehari-hari

### **Ketika Dhani Update Data:**

```bash
# 1. Edit data via aplikasi (tambah user, prodi, mata kuliah, dll)
# 2. Commit database
git add database/database.sqlite
git commit -m "Update database: tambah data prodi baru"
git push origin main

# Done! Teman tinggal pull
```

### **Ketika Teman Ingin Data Terbaru:**

```bash
# Pull dari Git
git pull origin main

# OTOMATIS:
# ✅ Database ter-download
# ✅ Cache Laravel ter-clear (via git hook)
# ✅ Data langsung terlihat di aplikasi

# Refresh browser, data sudah update!
```

---

## 🔧 Git Hook yang Terinstall

File: `.git/hooks/post-merge.bat`

**Fungsi:**
- Otomatis jalan setelah `git pull` atau `git merge`
- Clear cache Laravel (`config:clear`, `cache:clear`, `view:clear`)
- Memastikan database yang baru ter-detect oleh aplikasi

**Cara kerja:**
```
git pull 
  ↓
database.sqlite ter-update
  ↓
Git Hook: post-merge.bat ter-trigger
  ↓
php artisan cache:clear (otomatis)
  ↓
✅ Data langsung sinkron!
```

---

## ⚠️ Hal yang Perlu Diperhatikan

### **JANGAN:**
❌ Edit data di 2 komputer berbeda secara bersamaan (akan conflict!)  
❌ Commit database yang isinya data sensitif/password production  
❌ Lupa pull sebelum push

### **LAKUKAN:**
✅ Komunikasi dengan tim sebelum edit data besar  
✅ Selalu `git pull` dulu sebelum `git push`  
✅ Backup database sebelum merge yang kompleks

---

## 🛠️ Troubleshooting

### **"Database tidak update setelah git pull"**

```bash
# Manual clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Restart Laravel server
# Ctrl+C (stop server)
php artisan serve
```

### **"Git conflict di database.sqlite"**

```bash
# Pilih salah satu:

# Option 1: Ambil versi dari Git (REMOTE)
git checkout --theirs database/database.sqlite
git add database/database.sqlite

# Option 2: Pakai versi lokal kamu (LOCAL)
git checkout --ours database/database.sqlite
git add database/database.sqlite

# Option 3: Koordinasi dengan tim, pilih salah satu secara manual
# Lalu commit
git commit -m "Resolve database conflict"
```

### **"Git hook tidak jalan"**

```bash
# Re-install git hooks
setup-git-hooks.bat

# Atau manual copy
copy .git\hooks\post-merge.bat .git\hooks\post-merge
```

---

## 🎯 Checklist untuk Tim

**Setup Awal (Owner/Dhani):**
- [x] Database.sqlite tidak di-ignore
- [ ] Commit database ke Git
- [ ] Push ke remote repository
- [ ] Beritahu tim untuk pull

**Setup Awal (Teman):**
- [ ] Git pull dari repository
- [ ] Run `setup-git-hooks.bat`
- [ ] Test: jalankan aplikasi, data sudah ada
- [ ] Konfirmasi ke tim: "Data sudah sinkron!"

**Setiap Ada Update Data:**
- [ ] Edit data di aplikasi
- [ ] Git add + commit database.sqlite
- [ ] Git push
- [ ] Beritahu tim via chat: "Database updated, silakan pull!"
- [ ] Teman git pull (otomatis sinkron)

---

## 📊 Struktur File Penting

```
project/
├── database/
│   └── database.sqlite          ← File ini yang di-commit ke Git
├── .git/
│   └── hooks/
│       ├── post-merge           ← Auto-generated dari .bat
│       └── post-merge.bat       ← Script untuk Windows
├── setup-git-hooks.bat          ← Installer untuk git hooks
├── GIT_DATABASE_SYNC.md         ← Dokumentasi ini
└── PANDUAN_SHARING_DATABASE.md  ← Panduan alternatif (manual share)
```

---

## 💡 Tips Kolaborasi

1. **Komunikasi adalah Kunci**
   - Beritahu tim sebelum push database besar
   - Gunakan commit message yang jelas
   
2. **Commit Message yang Baik**
   ```bash
   git commit -m "Update database: tambah 5 mata kuliah semester 3"
   git commit -m "Update database: tambah user dosen baru"
   git commit -m "Update database: perbaikan data CPL prodi X"
   ```

3. **Pull Sebelum Edit Data**
   ```bash
   # Always do this first!
   git pull origin main
   
   # Baru edit data
   # Baru commit & push
   ```

4. **Backup Berkala**
   ```bash
   # Backup database sebelum perubahan besar
   copy database\database.sqlite database\backup-YYYY-MM-DD.sqlite
   ```

---

## 🎓 Untuk Presentasi/Demo

Jika perlu demo ke dosen:

```bash
# Komputer 1 (Dhani):
git add database/database.sqlite
git commit -m "Demo: tambah data mahasiswa"
git push

# Komputer 2 (Teman):
git pull   # <- Otomatis data update!
php artisan serve
# Buka browser, data sudah sinkron! ✨
```

---

## 📞 Butuh Bantuan?

Jika ada masalah:
1. Check apakah git hooks sudah terinstall: `dir .git\hooks\post-merge`
2. Manual clear cache: `php artisan config:clear`
3. Restart Laravel server
4. Hubungi tim development

**Happy Collaborating! 🚀**

---

**Dibuat oleh:** Factory AI  
**Terakhir update:** {{ date('Y-m-d') }}  
**Version:** 1.0
