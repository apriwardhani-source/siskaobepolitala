# 📧 Setup Email Notification (100% GRATIS!)

## ✅ Keuntungan Email Notification

✅ **100% GRATIS SELAMANYA** - Pakai Gmail gratis  
✅ **UNLIMITED** - Tidak ada batasan pesan  
✅ **MUDAH SETUP** - 5 menit selesai  
✅ **RELIABLE** - Email pasti sampai  
✅ **PROFESSIONAL** - Email template cantik  

---

## 🚀 Setup Gmail (5 Menit)

### Step 1: Aktifkan 2-Step Verification Gmail

1. Buka: https://myaccount.google.com/security
2. Scroll ke **"2-Step Verification"**
3. Klik **"Get Started"** / **"Turn On"**
4. Ikuti instruksi (verifikasi dengan HP)
5. ✅ **2-Step Verification aktif!**

### Step 2: Generate App Password

1. Masih di halaman Security
2. Cari **"App passwords"** (atau buka: https://myaccount.google.com/apppasswords)
3. Klik **"App passwords"**
4. **Select app:** Pilih **"Mail"**
5. **Select device:** Pilih **"Other (Custom name)"**
6. Ketik nama: **"Laravel Politala"**
7. Klik **"Generate"**

**Akan muncul 16 karakter password seperti:** `abcd efgh ijkl mnop`

✅ **COPY password ini!** (tanpa spasi)

### Step 3: Update File `.env` Laravel

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="Politala OBE"

# Email admin yang menerima notifikasi
ADMIN_EMAIL=admin_email@gmail.com
```

**Ganti:**
- `your_email@gmail.com` → Email Gmail Anda
- `abcdefghijklmnop` → App Password dari Step 2 (16 karakter, tanpa spasi!)
- `admin_email@gmail.com` → Email admin yang terima notifikasi

### Step 4: Clear Cache & Test

```powershell
cd "C:\Users\dhani\Desktop\perkuliahan semester 3\IT Project 1\project\siskaobepolitala"

php artisan config:clear
php artisan serve
```

### Step 5: Test Form

1. Buka: http://localhost:8000
2. Klik **"Hubungi Kami"**
3. Isi form:
   - Nama: Test User
   - Email: test@example.com
   - Pesan: Test email notification
4. Klik **"Kirim Pesan"**

✅ **Cek email admin - notifikasi masuk!**

---

## 📧 Email yang Diterima Admin

Email cantik dengan format:

```
🔔 PESAN BARU DARI WEBSITE
Politala OBE System

👤 Nama: John Doe
📧 Email: john@example.com
📅 Waktu: 05 Januari 2025, 10:30 WIB

💬 Pesan:
Saya ingin bertanya tentang program studi...

✅ Pesan ini otomatis tersimpan di database
```

---

## 🆘 Troubleshooting

### Problem: "Invalid credentials"

**Penyebab:** App Password salah atau 2-Step Verification belum aktif

**Solusi:**
1. Pastikan 2-Step Verification AKTIF
2. Generate ulang App Password
3. Copy App Password **tanpa spasi**
4. Update `.env` dengan password baru
5. Run: `php artisan config:clear`

### Problem: "Connection refused"

**Penyebab:** Port 587 blocked atau internet issue

**Solusi:**
```env
# Coba port 465 dengan ssl
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

### Problem: Email masuk ke Spam

**Solusi:**
1. Buka email di folder Spam
2. Klik **"Not Spam"** / **"Report not spam"**
3. Next email akan masuk Inbox

### Problem: "MAIL_FROM_ADDRESS not verified"

**Solusi:** Pastikan `MAIL_FROM_ADDRESS` sama dengan `MAIL_USERNAME`:

```env
MAIL_USERNAME=your_email@gmail.com
MAIL_FROM_ADDRESS="your_email@gmail.com"  # Harus sama!
```

---

## 🧪 Test Email Manual

Test kirim email via Tinker:

```powershell
php artisan tinker
```

Lalu jalankan:

```php
Mail::raw('Test email dari Laravel Politala', function($message) {
    $message->to('your_admin_email@gmail.com')
            ->subject('Test Email');
});

// Cek output
// Jika berhasil: "null"
// Jika error: akan ada error message
```

Cek inbox admin!

---

## 📊 Monitoring Email

### Cek Log Laravel

```powershell
# Real-time monitoring
tail -f storage/logs/laravel.log

# Atau cari email log
Get-Content storage/logs/laravel.log | Select-String "Email"
```

### Log yang dicatat:
- ✅ **Success:** `Email notification sent successfully`
- ❌ **Failed:** `Email notification failed`
- 📝 **Detail:** Contact ID, admin email, error message

---

## 💡 Tips & Best Practices

### 1. Gunakan Email Khusus

Buat email Gmail khusus untuk aplikasi:
- `app.politala@gmail.com`
- `noreply.politala@gmail.com`

Jangan pakai email pribadi!

### 2. Monitor Quota Gmail

Gmail gratis limit: **500 email/hari**

Cukup untuk aplikasi normal. Jika lebih, upgrade ke:
- Google Workspace (bayar)
- Atau pakai SMTP service (Mailgun, SendGrid)

### 3. Template Email

Email template sudah dibuat di:
`resources/views/emails/contact-notification.blade.php`

Bisa di-customize sesuai kebutuhan!

### 4. Queue Email (Optional)

Untuk performa lebih baik, pakai queue:

```php
// Di ContactController.php
Mail::to(env('ADMIN_EMAIL'))
    ->queue(new ContactNotification($contactData));
```

Jangan lupa run queue worker:
```powershell
php artisan queue:work
```

---

## ✅ Checklist Setup

- [ ] Aktifkan 2-Step Verification Gmail
- [ ] Generate App Password
- [ ] Update `.env` dengan App Password
- [ ] Update ADMIN_EMAIL
- [ ] Run `php artisan config:clear`
- [ ] Test form di website
- [ ] Cek inbox admin
- [ ] ✅ SELESAI!

---

## 🎉 Selamat!

Email notification berhasil! 

**Keuntungan:**
✅ 100% Gratis selamanya  
✅ Unlimited messages  
✅ Email template profesional  
✅ Auto save ke database  
✅ Monitoring lengkap via log  

**Next:** Bisa tambah fitur auto-reply ke user juga!

---

**Last Updated:** 05 Januari 2025  
**Status:** ✅ Production Ready
