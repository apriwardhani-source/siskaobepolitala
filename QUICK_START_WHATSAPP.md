# 🚀 Quick Start - WhatsApp Gratis (5 Menit!)

## ✅ Setup Tercepat (Pakai Docker)

### 1. Install Docker Desktop
- Download: https://www.docker.com/products/docker-desktop
- Install & restart komputer

### 2. Jalankan Evolution API

```bash
cd "C:\Users\dhani\Desktop\perkuliahan semester 3\IT Project 1\project\siskaobepolitala"

docker-compose -f docker-compose-whatsapp.yml up -d
```

**Tunggu 1-2 menit** sampai download selesai.

### 3. Cek Status

```bash
docker ps
```

Harus ada container `evolution_api` dengan status **Up**.

### 4. Edit .env

Buka file `.env` dan ganti:

```env
EVOLUTION_API_KEY=rahasia123  # Ganti dengan password Anda
```

### 5. Connect WhatsApp

**Windows PowerShell:**
```powershell
$headers = @{
    "apikey" = "dhaniganteng"
    "Content-Type" = "application/json"
}

$body = @{
    instanceName = "politala-bot"
    qrcode = $true
    integration = "WHATSAPP-BAILEYS"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8080/instance/create" -Method Post -Headers $headers -Body $body
```

**Windows CMD / Git Bash:**
```bash
curl -X POST http://localhost:8080/instance/create ^
  -H "apikey: rahasia123" ^
  -H "Content-Type: application/json" ^
  -d "{\"instanceName\": \"politala-bot\", \"qrcode\": true, \"integration\": \"WHATSAPP-BAILEYS\"}"
```

**Response akan ada QR Code!**

### 6. Scan QR Code

Copy base64 dari response, paste ke: https://base64.guru/converter/decode/image

Atau buka browser: http://localhost:8080/instance/connect/politala-bot

**Scan dengan WhatsApp:**
1. Buka WhatsApp di HP
2. Tap **⋮** (3 titik) → **Linked Devices**
3. Tap **Link a Device**
4. Scan QR code

✅ **CONNECTED!**

### 7. Test Kirim Pesan

```bash
curl -X POST http://localhost:8080/message/sendText/politala-bot ^
  -H "apikey: rahasia123" ^
  -H "Content-Type: application/json" ^
  -d "{\"number\": \"6282159640262\", \"text\": \"Test dari Evolution API!\"}"
```

Cek WhatsApp Anda - **pesan masuk!** 🎉

### 8. Test Form Website

```bash
cd "C:\Users\dhani\Desktop\perkuliahan semester 3\IT Project 1\project\siskaobepolitala"

php artisan config:clear
php artisan serve
```

Buka http://localhost:8000, klik "Hubungi Kami", submit form.

✅ **Admin dapat notifikasi WhatsApp otomatis!**

---

## 🎯 Cara Kerja

```
Website Form → Laravel → Evolution API → WhatsApp Admin
```

Semua otomatis, user tidak perlu buka WhatsApp!

---

## 📝 Ringkasan Config

**File `.env`:**
```env
EVOLUTION_API_URL=http://localhost:8080
EVOLUTION_API_KEY=rahasia123
EVOLUTION_INSTANCE=politala-bot
WHATSAPP_ADMIN_NUMBER=6282159640262
```

**File `docker-compose-whatsapp.yml`:**
- Evolution API running di port 8080
- SQLite database (simple)
- Auto-restart jika crash

---

## 🔥 Tips Production

### Pakai VPS (Agar Selalu Online)

**VPS Murah Indonesia:**
- **Biznet Gio:** Rp 15.000/bulan (1GB RAM)
- **Niagahoster VPS:** Rp 39.000/bulan
- **Contabo:** $4/bulan (internasional)

**Setup di VPS:**
```bash
# Install Docker
curl -fsSL https://get.docker.com | sh

# Clone project
git clone <your-repo>
cd project

# Run Evolution API
docker-compose -f docker-compose-whatsapp.yml up -d

# Ganti .env dengan IP VPS
EVOLUTION_API_URL=http://your-vps-ip:8080
```

### Auto-Restart jika Server Reboot

```bash
# Docker sudah auto-restart (restart: always)
docker ps  # Cek status
```

---

## 🆘 Troubleshooting Cepat

**1. Docker tidak jalan?**
```bash
docker-compose -f docker-compose-whatsapp.yml logs
```

**2. QR Code tidak muncul?**
```bash
# Generate ulang
curl -X POST http://localhost:8080/instance/restart/politala-bot -H "apikey: rahasia123"
```

**3. Pesan tidak terkirim?**
```bash
# Cek log Laravel
tail -f storage/logs/laravel.log | grep WhatsApp

# Cek status WhatsApp
curl http://localhost:8080/instance/connectionState/politala-bot -H "apikey: rahasia123"
```

---

## ✅ Checklist (5 Menit!)

- [ ] Install Docker Desktop (2 min)
- [ ] Run `docker-compose up -d` (1 min)
- [ ] Create instance via curl (30 sec)
- [ ] Scan QR code dengan WhatsApp (30 sec)
- [ ] Update `.env` Laravel (10 sec)
- [ ] Test form website (30 sec)
- [ ] ✅ SELESAI!

**Total waktu: ~5 menit** ⚡

---

**🎉 Selamat! WhatsApp terintegrasi GRATIS SELAMANYA!**

Dokumentasi lengkap: baca `WHATSAPP_FREE_SETUP.md`
