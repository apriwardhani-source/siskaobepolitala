# 📝 Changelog - Auto Sync System

## [Update] 2025-11-12 - Tambah Tabel Dosen & User

### ✨ Yang Ditambahkan:

**Tabel baru yang di-export/import:**
1. ✅ **dosen_mata_kuliah** (9 records)
   - Relasi dosen dan mata kuliah yang diampu
   - Data penugasan dosen per semester
   
2. ✅ **users** (27 records)
   - Data semua user (Admin, Wadir, Kaprodi, Tim, Dosen)
   - Info login dan role

### 📊 Summary Export:

| Tabel | Records | Size | Keterangan |
|-------|---------|------|------------|
| mahasiswas | 10 | 2.8 KB | Data mahasiswa |
| nilai_mahasiswa | 18 | 6.3 KB | Nilai mahasiswa |
| mata_kuliahs | 60 | 18 KB | Mata kuliah |
| **dosen_mata_kuliah** | **9** | **1.7 KB** | **NEW! Penugasan dosen** |
| tahun | 1 | 162 B | Tahun akademik |
| prodis | 1 | 630 B | Program studi |
| **users** | **27** | **17 KB** | **NEW! Data user & dosen** |

### 🎯 Manfaat:

**Sekarang tim juga akan sync:**
- ✅ Data dosen (nama, email, role)
- ✅ Penugasan dosen ke mata kuliah
- ✅ Data user untuk login testing
- ✅ Relasi dosen-matakuliah per semester

### 📥 Cara Update (Untuk Tim):

```bash
# 1. Pull update terbaru
git pull

# 2. Import data baru
php artisan db:import

# 3. Verifikasi
# Seharusnya ada:
# - 27 users
# - 9 penugasan dosen
```

### ✅ Test Case:

**Verifikasi dosen Aidil:**
```sql
SELECT 
    u.name as dosen,
    COUNT(dmk.id) as total_mk
FROM dosen_mata_kuliah dmk
JOIN users u ON dmk.user_id = u.id
WHERE u.name LIKE '%Aidil%'
GROUP BY u.name;
```

**Expected:** Aidil mengampu 9 mata kuliah semester 1

---

## [Initial Release] 2025-11-12 - Auto Sync System

### Fitur:
- ✅ Export/Import commands
- ✅ Git hooks (pre-push & post-merge)
- ✅ Setup scripts untuk tim
- ✅ Auto-sync mahasiswa, nilai, mata kuliah, prodi, tahun

---

**Total Tables Synced:** 7 tables  
**Total Records:** ~126 records  
**Total Size:** ~46 KB
