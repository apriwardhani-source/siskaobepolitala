# 🧹 Cleanup & Organization Scripts

## 📋 Overview

3 script otomatis untuk membersihkan dan merapihkan project SISKAOBE:

| Script | Fungsi | Priority |
|--------|--------|----------|
| **cleanup.bat** | Hapus file testing/debug/backup | 🟢 Safe |
| **organize.bat** | Pindahkan file ke folder yang sesuai | 🟢 Safe |
| **fix-gitignore.bat** | Fix security issues & update .gitignore | 🔴 **CRITICAL** |

---

## 🚀 Quick Start

### **Urutan Eksekusi (Recommended):**

```bash
# 1. Cleanup dulu (hapus file tidak penting)
cleanup.bat

# 2. Organize (rapihkan struktur folder)
organize.bat

# 3. Fix gitignore (PENTING untuk security!)
fix-gitignore.bat

# 4. Commit perubahan
git add .
git commit -m "chore: cleanup project structure and fix security issues"
git push
```

---

## 📝 Detail Masing-Masing Script

### 1️⃣ **cleanup.bat** - Hapus File Tidak Penting

**Yang Akan Dihapus:**
- ✅ `read-bobot.php` - Testing file Excel
- ✅ `read-excel-temp.php` - Testing file Excel
- ✅ `debug-session.php` - Debug session
- ✅ `test-wa-simple.ps1` - Testing WhatsApp
- ✅ `test-whatsapp.ps1` - Testing WhatsApp
- ✅ `screenshot-all-pages.js` - Testing screenshot
- ✅ `laravel.local.bak` - Backup binary (~180KB)
- ✅ `${DB_DATABASE}` - Old database (~147KB)
- ✅ `s` - Unknown file
- ⚠️ `Teknik Pengambilan keputusan.xlsx` - **Opsional** (ditanya)

**Space Dibebaskan:** ~350-550KB

**Safe to Run:** ✅ Yes, semua file adalah testing/backup

---

### 2️⃣ **organize.bat** - Rapihkan Struktur Folder

**Folder Baru:**
```
docs/       → Semua dokumentasi (MD, TXT files)
scripts/    → Semua automation scripts (BAT files)
```

**File yang Dipindah:**

**📁 docs/**
- `AUTO_SYNC.md`
- `CHANGELOG_AUTO_SYNC.md`
- `DATA_SYNC_GUIDE.md`
- `WHATSAPP_NOTIFICATION_GUIDE.md`
- `SETUP_TIM.md`
- `PESAN_UNTUK_TIM.txt`
- `UPDATE_TIM.txt`

**🔧 scripts/**
- `export-data.bat`
- `import-data.bat`
- `sync-data.bat`
- `setup-auto-sync.bat`
- `setup-git-hooks.bat`
- `start-dev.bat`
- `QUICK_SETUP_TIM.bat`

**Bonus:**
- Rename `.env.development.example` → `.env.example`

**Safe to Run:** ✅ Yes, hanya move file (tidak delete)

---

### 3️⃣ **fix-gitignore.bat** - Fix Security Issues ⚠️

**CRITICAL SECURITY FIXES:**

🔴 **Akan Diperbaiki:**
1. ✅ `.env` removed dari Git (contains API keys!)
2. ✅ `.wwebjs_cache/` removed (WhatsApp cache)
3. ✅ `whatsapp-auth/` removed (WhatsApp auth data)
4. ✅ `database.sqlite` removed (database file)
5. ✅ Update `.gitignore` dengan patterns baru

**Actions:**
1. Backup `.gitignore` → `.gitignore.backup`
2. Append security patterns ke `.gitignore`
3. `git rm --cached` untuk file sensitif (tetap ada di local!)

**⚠️ URGENT ACTION REQUIRED AFTER:**

```
GOOGLE CLIENT SECRET EXPOSED!

Action:
1. Buka: https://console.cloud.google.com/
2. Credentials → OAuth 2.0 Client IDs
3. REGENERATE secret lama (revoke!)
4. Update .env dengan secret baru
5. JANGAN commit .env lagi!
```

**Safe to Run:** ✅ Yes, files tetap di local (hanya remove dari Git tracking)

---

## 📊 Before & After

### **Before (Messy):**
```
siskaobepolitala/
├── read-bobot.php ❌
├── debug-session.php ❌
├── AUTO_SYNC.md 📄
├── SETUP_TIM.md 📄
├── export-data.bat 🔧
├── start-dev.bat 🔧
├── .env (tracked in Git!) 🔴
├── database.sqlite (tracked!) 🔴
└── ...
```

### **After (Clean):**
```
siskaobepolitala/
├── docs/
│   ├── AUTO_SYNC.md
│   ├── SETUP_TIM.md
│   └── ...
├── scripts/
│   ├── export-data.bat
│   ├── start-dev.bat
│   └── ...
├── .env (NOT tracked!) ✅
├── .env.example ✅
├── .gitignore (updated!) ✅
└── ...
```

---

## 🎯 Checklist Setelah Run

**Setelah cleanup.bat:**
- [ ] Check file testing/debug sudah terhapus
- [ ] Pastikan tidak ada file penting yang kehapus

**Setelah organize.bat:**
- [ ] Folder `docs/` terisi dengan MD/TXT files
- [ ] Folder `scripts/` terisi dengan BAT files
- [ ] File `.env.example` sudah ada

**Setelah fix-gitignore.bat:**
- [ ] `.gitignore` updated
- [ ] `.gitignore.backup` tersimpan (untuk rollback)
- [ ] Run `git status` - .env, .wwebjs_cache, dll tidak muncul
- [ ] **REGENERATE Google Client Secret!** 🔴
- [ ] Commit dan push perubahan

---

## 🔄 Rollback (Jika Ada Masalah)

### **Undo organize.bat:**
```bash
# Pindah balik dari docs/ ke root
move docs\*.md .
move docs\*.txt .

# Pindah balik dari scripts/ ke root
move scripts\*.bat .

# Hapus folder kosong
rmdir docs
rmdir scripts
```

### **Undo fix-gitignore.bat:**
```bash
# Restore .gitignore lama
copy .gitignore.backup .gitignore

# Add back files ke Git
git add .env
git add database/database.sqlite
git commit -m "revert: restore gitignore"
```

### **Undo cleanup.bat:**
```bash
# Tidak bisa undo (files sudah dihapus permanen)
# Restore dari Git history jika perlu:
git checkout HEAD~1 -- read-bobot.php
git checkout HEAD~1 -- debug-session.php
# dst...
```

---

## ⚠️ Important Notes

1. **Backup Dulu:** Script sudah aman, tapi backup project sebelum run lebih baik
2. **Git Status:** Setelah organize & fix-gitignore, banyak file "deleted" di git - **NORMAL!**
3. **Team Sync:** Setelah push, kasih tahu tim bahwa struktur folder berubah
4. **Google Secret:** JANGAN lupa regenerate setelah fix-gitignore!
5. **Scripts Reference:** Jika ada script/docs yang reference path lama, update manual

---

## 🆘 Troubleshooting

**Q: Script error "file not found"?**
A: Normal jika file sudah dihapus sebelumnya. Script akan skip otomatis.

**Q: Git rm error "did not match any files"?**
A: Normal jika file tidak di-track Git. Diabaikan saja.

**Q: Setelah organize, link broken?**
A: Update reference di README atau docs lain ke path baru (`docs/` atau `scripts/`)

**Q: Mau undo cleanup?**
A: File testing bisa dibuat ulang atau restore dari Git history

**Q: .env masih muncul di git status?**
A: Run `git rm --cached .env` manual, lalu commit

---

## 📞 Support

Jika ada masalah setelah run scripts:

1. Check `.gitignore.backup` untuk rollback
2. Check Git history: `git log --oneline`
3. Restore specific file: `git checkout HEAD~1 -- <filename>`
4. Contact team lead

---

**Last Updated:** 27 November 2025  
**Created by:** Droid AI - Factory  
**Version:** 1.0.0
