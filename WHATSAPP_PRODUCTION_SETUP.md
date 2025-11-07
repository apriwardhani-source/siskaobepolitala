# 📱 WhatsApp Integration - Production Setup

## 🚀 Setup di Server/Hosting (VPS)

### Prerequisites
- Node.js installed on server
- SSH access to server
- PM2 process manager

---

## Step 1: Install PM2 (di Server)

```bash
# SSH ke server
ssh user@your-server.com

# Install PM2 globally
npm install -g pm2

# Verify installation
pm2 --version
```

---

## Step 2: Start WhatsApp Service

```bash
# Navigate to project directory
cd /path/to/siskaobepolitala

# Start service dengan PM2
pm2 start ecosystem.config.js

# Check status
pm2 status

# View logs
pm2 logs whatsapp-service
```

---

## Step 3: Auto-Start on Server Reboot

```bash
# Generate startup script
pm2 startup

# Copy paste command yang muncul (contoh):
# sudo env PATH=$PATH:/usr/bin pm2 startup systemd -u username --hp /home/username

# Save PM2 process list
pm2 save
```

---

## Step 4: Scan QR Code (First Time Only)

1. **Check logs untuk QR code:**
```bash
pm2 logs whatsapp-service --lines 100
```

2. **Atau akses via browser:**
- Login as admin
- Buka: https://your-domain.com/admin/whatsapp/connect
- Scan QR code dengan WhatsApp di HP
- **QR scan hanya perlu 1x**, session tersimpan!

---

## Management Commands

### Via Artisan (Preferred)

```bash
# Start service
php artisan whatsapp:service start

# Stop service
php artisan whatsapp:service stop

# Restart service
php artisan whatsapp:service restart

# Check status
php artisan whatsapp:service status
```

### Via PM2 (Alternative)

```bash
# List all processes
pm2 list

# Restart service
pm2 restart whatsapp-service

# Stop service
pm2 stop whatsapp-service

# Delete process
pm2 delete whatsapp-service

# View real-time logs
pm2 logs whatsapp-service --lines 50
```

---

## 🔧 Troubleshooting

### Service Tidak Start

```bash
# Check PM2 logs
pm2 logs whatsapp-service --err

# Check Node.js version
node --version  # Harus v16+

# Reinstall dependencies
npm install
```

### Session Disconnect

```bash
# Restart service
php artisan whatsapp:service restart

# Delete old session
rm -rf whatsapp-auth/

# Restart dan scan QR ulang
pm2 restart whatsapp-service
pm2 logs whatsapp-service  # Tunggu QR muncul
```

### QR Code Tidak Muncul

```bash
# Check if service running
pm2 status

# Check logs
pm2 logs whatsapp-service --lines 100

# Restart service
pm2 restart whatsapp-service
```

---

## 📊 Monitoring

```bash
# Monitor CPU/Memory usage
pm2 monit

# View detailed info
pm2 show whatsapp-service

# View logs location
pm2 info whatsapp-service
```

---

## 🔐 Security Notes

1. **Jangan expose port 3001** ke public (internal only)
2. **WhatsApp session sensitive** - backup folder `whatsapp-auth/`
3. **Set proper file permissions:**
```bash
chmod 700 whatsapp-auth/
chmod 600 ecosystem.config.js
```

---

## 🎯 Production Checklist

- [ ] PM2 installed
- [ ] Service auto-start configured (`pm2 startup`)
- [ ] QR code scanned dan connected
- [ ] Test kirim pesan berhasil
- [ ] Logs monitored (tidak ada error)
- [ ] Backup session folder
- [ ] .gitignore updated (exclude whatsapp-auth/)

---

## ⚡ Alternative: Pakai Fonnte (Recommended untuk Production)

**Pros:**
- ✅ Tidak perlu PM2/server management
- ✅ Tidak perlu scan QR berulang
- ✅ API stable & reliable
- ✅ Multi-device support
- ✅ Customer support

**Cons:**
- ❌ Berbayar (Rp 100.000 = 1000 pesan)

### Setup Fonnte:
1. Daftar di https://fonnte.com
2. Beli paket (Rp 100rb)
3. Copy API token
4. Update `.env`:
```env
FONNTE_TOKEN=your_token_here
WHATSAPP_ADMIN_NUMBER=6285754631899
```
5. Selesai! No PM2, no QR scan, no hassle.

---

## 📞 Support

Jika ada masalah, check:
1. PM2 logs: `pm2 logs whatsapp-service`
2. Laravel logs: `storage/logs/laravel.log`
3. System logs: `journalctl -u pm2-username -f`
