# 📱 WhatsApp Notification - Panduan Lengkap

## 🎯 Fitur Notifikasi Input Nilai Mahasiswa

Sistem akan **otomatis mengirim notifikasi WhatsApp ke admin** setiap kali dosen menginput nilai mahasiswa.

---

## 📋 Informasi yang Dikirim

### Single Input Nilai
Ketika dosen input satu nilai:
```
📊 NILAI MAHASISWA BARU

👨‍🏫 Dosen: Nama Dosen
📚 Mata Kuliah: Nama MK
📖 Kode MK: XXXX

👤 Mahasiswa: Nama Mahasiswa
🆔 NIM: 123456789
📝 Teknik Penilaian: UTS/UAS/Quiz/etc
✅ Nilai: 85
📅 Tahun: 2024

⏰ Waktu Input: 13 Nov 2025 14:30

---
Notifikasi otomatis dari Sistem OBE Politala
```

### Bulk Input Nilai
Ketika dosen input multiple nilai sekaligus:
```
📊 INPUT NILAI MAHASISWA (BULK)

👨‍🏫 Dosen: Nama Dosen
📚 Mata Kuliah: Nama MK
📖 Kode MK: XXXX

👤 Mahasiswa: Nama Mahasiswa
🆔 NIM: 123456789
📝 Jumlah Nilai: 3 nilai
📅 Tahun: 2024

Detail Nilai:
1. UTS = 85
2. UAS = 90
3. Quiz 1 = 88

⏰ Waktu Input: 13 Nov 2025 14:30

---
Notifikasi otomatis dari Sistem OBE Politala
```

---

## ⚙️ Konfigurasi (.env)

### Required Settings
```env
# WhatsApp API Configuration (Evolution API)
EVOLUTION_API_URL=http://localhost:8080
EVOLUTION_API_KEY=dhaniganteng
EVOLUTION_INSTANCE=politala-bot

# Nomor Admin yang akan menerima notifikasi
WHATSAPP_ADMIN_NUMBER=6285754631899

# Enable/Disable notifikasi (optional)
WHATSAPP_ENABLED=true
```

### Development Mode
Untuk development lokal (tidak mengirim WA):
```env
WHATSAPP_ENABLED=false
```

---

## 🚀 Cara Kerja

### 1. Dosen Input Nilai
- Dosen masuk ke halaman Penilaian Mahasiswa
- Pilih mahasiswa dan mata kuliah
- Input nilai (single atau bulk)
- Klik Submit

### 2. Sistem Proses
- Nilai disimpan ke database
- Sistem otomatis collect data (dosen, mahasiswa, mk, nilai)
- WhatsAppService dipanggil
- Format pesan dibuat

### 3. Kirim Notifikasi
- Pesan dikirim via Evolution API
- Admin menerima notifikasi di WhatsApp
- Jika gagal: error di-log, proses input tetap sukses

---

## 🔧 Technical Implementation

### Files Modified
1. **app/Services/WhatsAppService.php**
   - `sendNilaiNotification()` - Single input
   - `sendBulkNilaiNotification()` - Multiple input

2. **app/Http/Controllers/PenilaianDosenController.php**
   - `store()` - Tambah notifikasi single
   - `storeMultiple()` - Tambah notifikasi bulk

### Code Flow
```php
// PenilaianDosenController.php

public function store(Request $request)
{
    // 1. Validate
    $request->validate([...]);
    
    // 2. Save nilai
    $nilai = NilaiMahasiswa::create([...]);
    
    // 3. Send WhatsApp notification
    try {
        $whatsappService = new WhatsAppService();
        $whatsappService->sendNilaiNotification([
            'dosen_name' => Auth::user()->name,
            'mata_kuliah' => $nilai->mataKuliah->nama_mk,
            // ... other data
        ]);
    } catch (\Exception $e) {
        \Log::error('WhatsApp failed: ' . $e->getMessage());
        // Process continues even if notification fails
    }
    
    return redirect()->back()->with('success', 'Nilai tersimpan & notifikasi terkirim');
}
```

---

## 🛡️ Error Handling

### Notification Failure
Jika WhatsApp API gagal:
- ✅ Nilai tetap tersimpan ke database
- ✅ User tetap mendapat success message
- ⚠️ Error di-log untuk debugging
- ⚠️ Admin perlu cek manual di sistem

### Common Issues

**1. WhatsApp tidak terkirim**
```bash
# Check .env
WHATSAPP_ENABLED=true  # Pastikan true
WHATSAPP_ADMIN_NUMBER=628xxxx  # Format correct (628...)

# Check Evolution API running
curl http://localhost:8080/instance/status/politala-bot
```

**2. Instance not connected**
```bash
# Restart Evolution API
docker restart evolution-api

# Re-scan QR code di admin panel
```

**3. Number format salah**
```bash
# SALAH
WHATSAPP_ADMIN_NUMBER=085754631899
WHATSAPP_ADMIN_NUMBER=+6285754631899

# BENAR
WHATSAPP_ADMIN_NUMBER=6285754631899
```

---

## 📊 Monitoring & Logs

### Check Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log | grep WhatsApp

# Filter error saja
tail -f storage/logs/laravel.log | grep "WhatsApp.*failed"
```

### Log Format
```
[2025-11-13 14:30:00] local.INFO: WhatsApp Message Sent (Evolution API) 
{
    "to": "6285754631899",
    "response": {
        "key": {...},
        "message": {...}
    }
}
```

---

## 🔐 Security Notes

1. **API Key**: Jangan commit `.env` ke git
2. **Admin Number**: Hanya untuk admin terpercaya
3. **Rate Limiting**: Evolution API gratis punya limit
4. **PII Data**: Notifikasi berisi data mahasiswa (GDPR aware)

---

## 🧪 Testing

### Manual Test
1. Login sebagai dosen
2. Masuk ke menu Penilaian Mahasiswa
3. Input nilai untuk satu mahasiswa
4. Check WhatsApp admin
5. Verifikasi format pesan

### Disable saat testing
```env
WHATSAPP_ENABLED=false
```

### Mock untuk unit test
```php
// tests/Feature/PenilaianTest.php
use Mockery;

$mockWhatsApp = Mockery::mock(WhatsAppService::class);
$mockWhatsApp->shouldReceive('sendNilaiNotification')->once();
```

---

## 📈 Future Enhancements

### Possible Improvements
- [ ] Notifikasi ke dosen saat nilai disetujui
- [ ] Notifikasi ke mahasiswa (optional)
- [ ] Notifikasi untuk approval workflow
- [ ] Summary harian (digest)
- [ ] Multi-admin support
- [ ] Telegram bot integration
- [ ] Email fallback jika WA gagal

---

## 🆘 Troubleshooting

### Issue: "WhatsApp notification failed"
**Solution:**
1. Check Evolution API status
2. Verify admin number format
3. Check API key valid
4. Review logs for detail error

### Issue: "Message sent but admin tidak terima"
**Solution:**
1. Pastikan admin number correct
2. Check WhatsApp connected di Evolution
3. Test kirim pesan manual dulu
4. Cek spam/blocked messages

### Issue: "Too many requests"
**Solution:**
1. Evolution API punya rate limit
2. Implementasi queue system
3. Atau upgrade ke paid plan

---

## 📞 Support

Jika ada masalah dengan integrasi WhatsApp:

1. Check dokumentasi Evolution API: https://doc.evolution-api.com
2. Review logs Laravel di `storage/logs/`
3. Contact system admin
4. Disable sementara: `WHATSAPP_ENABLED=false`

---

**Last Updated:** 13 November 2025
**Version:** 1.0.0
**Author:** SISKABOE Team - Politala
