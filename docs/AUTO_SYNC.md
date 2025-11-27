# 🚀 AUTO SYNC DATA - FULLY AUTOMATED!

## ✨ Fitur Auto-Sync Aktif!

Dengan Git Hooks, data akan **otomatis sync** tanpa perlu command manual!

---

## 🔄 Cara Kerja

### **Saat PUSH (Kamu):**
```
1. git push
   ↓
2. 🤖 Git hook otomatis jalankan: php artisan db:export
   ↓
3. Data mahasiswa/nilai/MK di-export ke JSON
   ↓
4. Push ke remote
```

### **Saat PULL (Tim):**
```
1. git pull
   ↓
2. Code ter-update
   ↓
3. 🤖 Git hook otomatis jalankan: php artisan db:import
   ↓
4. Data mahasiswa/nilai/MK otomatis ter-import
   ↓
5. ✅ Database langsung sama dengan punyamu!
```

---

## 📋 Setup (Sekali Aja!)

**Setiap anggota tim jalankan:**
```bash
# Windows
setup-auto-sync.bat

# Atau manual:
cd .git/hooks
copy pre-push.bat pre-push
copy post-merge.bat post-merge
```

---

## 🎯 Workflow Baru

### **KAMU (Input Data Baru):**

**SEBELUM:**
```bash
# Input data di website
php artisan db:export          ← MANUAL
git add ...
git commit ...
git push
```

**SEKARANG (AUTO):**
```bash
# Input data di website
git add storage/app/database-exports/*.json
git commit -m "Update data mahasiswa"
git push  ← OTOMATIS EXPORT! 🎉
```

---

### **TIM (Terima Update):**

**SEBELUM:**
```bash
git pull
php artisan db:import   ← MANUAL
```

**SEKARANG (AUTO):**
```bash
git pull   ← OTOMATIS IMPORT! 🎉
# Done! Data sudah sync!
```

---

## 📊 File yang Di-Sync

File JSON di `storage/app/database-exports/`:
- ✅ `mahasiswas.json` (10 mahasiswa)
- ✅ `nilai_mahasiswa.json` (18 nilai)
- ✅ `mata_kuliahs.json` (60 mata kuliah)
- ✅ `tahun.json` (1 tahun akademik)
- ✅ `prodis.json` (1 program studi)

---

## ⚙️ Manual Commands (Kalau Perlu)

```bash
# Export manual (kalau hook gagal)
php artisan db:export

# Import manual (kalau hook gagal)
php artisan db:import

# Import fresh (hapus data lama dulu)
php artisan db:import --fresh

# Export table tertentu aja
php artisan db:export --tables=mahasiswas --tables=nilai_mahasiswa
```

---

## 🐛 Troubleshooting

**Q: Hook tidak jalan?**
```bash
# Check permission
icacls .git/hooks/pre-push.bat
icacls .git/hooks/post-merge.bat

# Re-run setup
setup-auto-sync.bat
```

**Q: Lupa commit JSON setelah export?**
```bash
git add storage/app/database-exports/*.json
git commit --amend --no-edit
git push --force-with-lease
```

**Q: Data tidak ter-import setelah pull?**
```bash
# Manual import
php artisan db:import
```

**Q: Konflik di file JSON?**
```bash
# Ambil versi remote
git checkout --theirs storage/app/database-exports/*.json
php artisan db:import
```

---

## ✅ Keuntungan

| Sebelum | Sesudah |
|---------|---------|
| Manual export | ✅ Auto export saat push |
| Manual import | ✅ Auto import saat pull |
| Lupa sync | ✅ Tidak mungkin lupa |
| Command manual | ✅ Zero command! |

---

## 🎉 SEKARANG TIM KALIAN FULLY AUTOMATED!

**Workflow:**
```
Kamu: Input data → Commit → Push 🚀
       ↓
   Auto Export! 📤
       ↓
   Push ke GitHub
       ↓
Tim:  Pull 📥
       ↓
   Auto Import! 📥
       ↓
   Data Sync! ✅
```

**NO MORE MANUAL COMMANDS! JUST PUSH & PULL!** 🎊
