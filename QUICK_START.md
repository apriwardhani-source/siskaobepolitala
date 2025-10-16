# 🚀 Quick Start - Git Database Sync

## Untuk Dhani (Pertama Kali)

```bash
# 1. Commit database dan setup files
git add .
git commit -m "Setup Git database auto-sync + Add Wadir1 & Kaprodi views

- Enable database.sqlite tracking untuk team sync
- Add git hooks untuk auto-refresh setelah pull
- Add dashboard views untuk Wadir1 dan Kaprodi
- Add dokumentasi lengkap Git database workflow
"

# 2. Push ke repository
git push origin main

# Done! Beritahu teman untuk pull
```

## Untuk Teman (Pertama Kali)

```bash
# 1. Pull dari repository
git pull origin main

# 2. Install git hooks (double-click atau run)
setup-git-hooks.bat

# 3. Jalankan Laravel
php artisan serve

# 4. Buka browser
# http://localhost:8000

# Data sudah sinkron! ✅
```

---

## Update Data (Sehari-hari)

### Dhani Update Data:
```bash
# Edit data via aplikasi (tambah user, prodi, dll)
git add database/database.sqlite
git commit -m "Update: tambah data [isi perubahannya]"
git push

# Kasih tau teman di grup
```

### Teman Ambil Data Terbaru:
```bash
git pull

# OTOMATIS sinkron! Tidak perlu command lain
# Refresh browser saja
```

---

## Troubleshooting Cepat

### Database tidak update setelah pull?
```bash
php artisan config:clear
php artisan cache:clear
```

### Git conflict di database?
```bash
# Pakai versi terbaru dari Git
git checkout --theirs database/database.sqlite
git add database/database.sqlite
git commit
```

### Lupa push database?
```bash
git add database/database.sqlite
git commit -m "Update database"
git push
```

---

## Checklist

**Dhani (Pertama Kali):**
- [ ] Commit database.sqlite
- [ ] Push ke Git
- [ ] Beritahu teman

**Teman (Pertama Kali):**
- [ ] Git pull
- [ ] Run setup-git-hooks.bat
- [ ] Test aplikasi
- [ ] Konfirmasi data OK

**Daily Workflow:**
- [ ] Pull sebelum edit data
- [ ] Edit data via aplikasi
- [ ] Commit + push database
- [ ] Beritahu tim

---

**📖 Dokumentasi Lengkap:** Baca `GIT_DATABASE_SYNC.md`
