# 🔄 Cara Sync Data - SIMPLE!

## Untuk Kamu (Yang Input Data Baru)

**Setelah input mahasiswa/nilai di website:**

1. **Export data ke JSON:**
   ```bash
   php artisan db:export
   ```
   atau double-click: **`export-data.bat`**

2. **Commit & Push:**
   ```bash
   git add storage/app/database-exports/*.json
   git commit -m "Update data mahasiswa & nilai"
   git push
   ```

3. **Beritahu tim di group chat:**
   > "Sudah push data terbaru, pull & jalankan `php artisan db:import` ya!"

---

## Untuk Tim (Setelah Kamu Push)

1. **Pull code:**
   ```bash
   git pull
   ```

2. **Import data:**
   ```bash
   php artisan db:import
   ```
   atau double-click: **`import-data.bat`**

3. **Done!** Data mahasiswa, nilai, dll sudah sama dengan punyamu! ✨

---

## One-Click Scripts

### Windows:
- **`export-data.bat`** - Export data
- **`import-data.bat`** - Import data
- **`sync-data.bat`** - Pull + Import (all-in-one)

### Terminal:
```bash
# Export data (setelah input di website)
php artisan db:export

# Import data (setelah pull dari Git)
php artisan db:import

# Import fresh (hapus data lama dulu)
php artisan db:import --fresh
```

---

## Table yang Di-Export:
- ✅ mahasiswas (data mahasiswa)
- ✅ nilai_mahasiswa (nilai yang diinput dosen)
- ✅ mata_kuliahs (mata kuliah)
- ✅ tahun (tahun akademik)
- ✅ prodis (program studi)

---

## FAQ

**Q: File JSON di-commit ke Git?**
A: **YA!** File JSON kecil dan mudah di-track perubahannya.

**Q: Aman gak data gak corrupt?**
A: **Aman!** Command `db:import` pakai `updateOrInsert` jadi tidak duplikasi.

**Q: Kalo ada data lama mau dihapus dulu?**
A: Gunakan flag `--fresh`:
```bash
php artisan db:import --fresh
```

**Q: Export table tertentu aja?**
A: Bisa:
```bash
php artisan db:export --tables=mahasiswas --tables=nilai_mahasiswa
```

---

## Workflow Lengkap

```
KAMU (Developer A):
1. Input 5 mahasiswa baru via website ✏️
2. php artisan db:export 📤
3. git add storage/app/database-exports/*.json
4. git commit -m "Tambah 5 mahasiswa baru"
5. git push 🚀

TIM (Developer B):
1. git pull 📥
2. php artisan db:import 📥
3. Data mahasiswa langsung sama! ✅
```

---

**SIMPLE KAN? NO MORE MANUAL SEEDER!** 🎉
