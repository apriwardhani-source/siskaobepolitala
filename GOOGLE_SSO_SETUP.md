# Panduan Setup Google SSO (Single Sign-On)

## 🎯 Fitur yang Ditambahkan
- Login dengan Google Account
- **Pemilihan role oleh user** untuk akun baru
- User baru dengan **status pending** (memerlukan approval admin)
- Link Google account ke user existing
- Role-based redirect setelah login

## 📋 Langkah-langkah Setup

### 1. Run Migration Database
Jalankan migration untuk menambahkan kolom `google_id` dan `avatar` ke tabel `users`:

```bash
php artisan migrate
```

### 2. Dapatkan Google OAuth Credentials

#### A. Buka Google Cloud Console
1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Login dengan akun Google Anda

#### B. Buat Project Baru (jika belum ada)
1. Klik dropdown project di atas
2. Klik "New Project"
3. Beri nama project (contoh: "SISKAO POLITALA")
4. Klik "Create"

#### C. Enable Google+ API
1. Di dashboard, klik "APIs & Services" > "Library"
2. Cari "Google+ API"
3. Klik dan enable API tersebut

#### D. Buat OAuth 2.0 Credentials
1. Klik "APIs & Services" > "Credentials"
2. Klik "Create Credentials" > "OAuth client ID"
3. Jika diminta, configure OAuth consent screen terlebih dahulu:
   - Pilih "External" (untuk testing)
   - Isi Application name: "SISKAO POLITALA"
   - Isi User support email
   - Isi Developer contact email
   - Klik "Save and Continue"
   - Tambahkan test users (email yang boleh login)
   
4. Kembali ke Credentials > Create OAuth client ID:
   - Application type: **Web application**
   - Name: "SISKAO Web Client"
   - **Authorized JavaScript origins**:
     - `http://localhost:8000`
     - `http://127.0.0.1:8000`
     - (Tambahkan domain production jika sudah deploy)
   
   - **Authorized redirect URIs**:
     - `http://localhost:8000/auth/google/callback`
     - `http://127.0.0.1:8000/auth/google/callback`
     - (Tambahkan domain production jika sudah deploy)
   
5. Klik "Create"
6. **SIMPAN** Client ID dan Client Secret yang ditampilkan

### 3. Update File .env

Tambahkan credentials Google OAuth ke file `.env`:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

⚠️ **PENTING**: Ganti `your-client-id-here` dan `your-client-secret-here` dengan credentials yang Anda dapatkan dari Google Cloud Console.

### 4. Clear Cache (Opsional tapi direkomendasikan)

```bash
php artisan config:clear
php artisan cache:clear
```

### 5. Test Login dengan Google

1. Jalankan server: `php artisan serve`
2. Buka `http://127.0.0.1:8000/login`
3. Klik tombol **"Masuk dengan Google"**
4. Login dengan akun Google Anda
5. Akan diredirect kembali ke aplikasi

## 🔒 Keamanan & Catatan Penting

### User Baru dari Google
- User baru yang login via Google akan diarahkan ke **halaman pemilihan role**
- User memilih role sendiri dari 5 pilihan:
  - `admin` - Administrator sistem
  - `wadir1` - Wakil Direktur 1
  - `kaprodi` - Kepala Program Studi
  - `tim` - Tim Penyusun Kurikulum
  - `dosen` - Dosen Pengampu
- User bisa mengisi **NIP** dan **No. HP** (opsional)
- Akun dibuat dengan:
  - **Status**: `pending` (butuh approval admin)
  - **Password**: Random (tidak bisa login dengan email/password biasa)
  
### User Existing
- Jika email sudah terdaftar, Google account akan di-link ke user tersebut
- User bisa login dengan email/password ATAU Google SSO

### Approval User
- User dengan status `pending` tidak bisa login
- Admin harus approve user melalui menu "Pending Users"
- Setelah approved, user bisa login normal

## 🎨 UI/UX

Tombol Google SSO sudah terintegrasi dengan desain login page yang ada:
- ✅ Glass morphism effect
- ✅ Smooth animations
- ✅ Responsive design
- ✅ Google brand colors

## 🔧 Troubleshooting

### Error: "Access blocked: This app's request is invalid"
- Pastikan Authorized redirect URIs sudah benar di Google Console
- Cek URL di browser sama dengan yang di-configure

### Error: "invalid_client"
- Client ID atau Client Secret salah
- Cek ulang credentials di `.env`

### Error: "redirect_uri_mismatch"
- URL callback tidak match dengan yang di-configure
- Tambahkan URL yang sesuai di Google Console

### User baru tidak bisa login
- Cek status user di database (harus `approved`)
- Admin perlu approve user melalui dashboard

## 📱 Production Deployment

Untuk production, jangan lupa:
1. Update Authorized redirect URIs di Google Console dengan domain production
2. Update `GOOGLE_REDIRECT_URI` di `.env` production
3. Pastikan HTTPS enabled untuk keamanan
4. Review OAuth consent screen (ubah ke "Internal" jika hanya untuk organisasi)

## 🔄 Alur Login Google SSO

```
User klik "Masuk dengan Google"
    ↓
Redirect ke Google Login
    ↓
User login di Google & approve permissions
    ↓
Google redirect ke /auth/google/callback
    ↓
Sistem cek apakah user sudah ada:
    ├─ Sudah ada (by google_id) → Cek status & login
    ├─ Sudah ada (by email) → Link Google account & cek status
    └─ Belum ada → Simpan data ke session → Redirect ke pemilihan role
    ↓
[UNTUK USER BARU]
Halaman Pemilihan Role:
    ├─ User pilih role (admin/wadir1/kaprodi/tim/dosen)
    ├─ User isi NIP & No. HP (opsional)
    ├─ Submit form
    └─ Create user baru dengan status: pending
    ↓
Redirect ke login dengan pesan:
"Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan admin"
    ↓
Admin approve user di dashboard
    ↓
User bisa login kembali dengan Google SSO
    ↓
Cek status user:
    ├─ Status: approved → Redirect ke dashboard sesuai role
    └─ Status: pending → Redirect ke login dengan error message
```

## 📞 Support

Jika ada masalah atau pertanyaan, silakan hubungi tim pengembang.
