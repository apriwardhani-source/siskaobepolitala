# 📋 SETUP UNTUK TIM - WAJIB DIBACA!

## ⚠️ PENTING: Setiap Anggota Tim HARUS Install Hooks!

Git hooks **TIDAK** ikut di-push ke remote. Setiap developer harus install sendiri di komputer masing-masing!

---

## 🚀 Setup (5 Menit Aja!)

### **Step 1: Pull Code Terbaru**
```bash
git pull
```

### **Step 2: Install Auto-Sync Hooks**

**Windows PowerShell:**
```powershell
.\setup-auto-sync.bat
```

**Windows CMD:**
```cmd
setup-auto-sync.bat
```

**Kalau muncul error "not recognized":** Pakai `.\` di depan:
```powershell
.\setup-auto-sync.bat
```

### **Step 3: Import Data yang Sudah Ada**
```bash
php artisan db:import
```

### **Step 4: Test Hook**
```bash
# Test dengan perintah ini (tidak akan push beneran)
git push --dry-run
```

Kalau muncul "🔄 Auto-exporting database..." → **BERHASIL!** ✅

---

## ✅ Verifikasi Setup Berhasil

**Check 1: File Hook Exists**
```bash
# Windows PowerShell
Test-Path .git\hooks\pre-push
Test-Path .git\hooks\post-merge
```

Harus return: `True` dan `True`

**Check 2: Test Import**
```bash
php artisan db:import
```

Output harus:
```
✅ mahasiswas: 10 records imported
✅ nilai_mahasiswa: 18 records imported
✅ mata_kuliahs: 60 records imported
```

---

## 🔄 Workflow Setelah Setup

### **Setiap Pull (Otomatis!):**
```bash
git pull
# 🤖 Hook otomatis import data!
# Database langsung update!
```

### **Setiap Push (Otomatis!):**
```bash
git push
# 🤖 Hook otomatis export data!
# Data terbaru ikut ke-push!
```

---

## 🐛 Troubleshooting

### **Problem 1: Hook Tidak Jalan Saat Pull**
```bash
# Manual import
php artisan db:import

# Re-install hooks
.\setup-auto-sync.bat
```

### **Problem 2: Error "cannot spawn .git/hooks/pre-push"**
```bash
# Re-install hooks
.\setup-auto-sync.bat
```

### **Problem 3: Data Masih Tidak Sama**
```bash
# Import fresh (hapus data lama dulu)
php artisan db:import --fresh
```

### **Problem 4: "setup-auto-sync.bat not recognized"**
```powershell
# Pakai .\ di depan
.\setup-auto-sync.bat
```

---

## 📞 Bantuan

**Kalau masih error, kirim screenshot error ke group!**

Command untuk debug:
```bash
# Check hooks
ls .git/hooks/

# Test export
php artisan db:export

# Test import
php artisan db:import

# Check file JSON
ls storage/app/database-exports/
```

---

## ⏰ Waktu Setup

| Step | Waktu |
|------|-------|
| Pull code | 30 detik |
| Install hooks | 5 detik |
| Import data | 10 detik |
| Test | 10 detik |
| **Total** | **< 1 menit** |

---

## 🎉 Setelah Setup

✅ Tidak perlu ingat command manual  
✅ Data otomatis sync setiap pull  
✅ Data otomatis export setiap push  
✅ **ZERO EFFORT!**

---

**Setup sekarang juga!** Jangan sampai data tim tidak sync! 🚀
