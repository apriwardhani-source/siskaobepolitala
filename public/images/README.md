# Logo Politala

## Instruksi

Silakan upload file logo Politala dengan nama: **`logo-politala.png`**

### Spesifikasi Logo:
- **Format:** PNG (dengan background transparan)
- **Nama file:** `logo-politala.png`
- **Ukuran:** Tinggi 48px (width auto/proporsional)
- **Lokasi:** `public/images/logo-politala.png`

### Cara Upload:
1. Simpan file logo dengan nama `logo-politala.png`
2. Copy file ke folder ini: `public/images/`
3. Refresh browser

### Alternatif Format:
Jika tidak ada PNG, bisa pakai:
- `logo-politala.jpg`
- `logo-politala.svg` (lebih bagus, scalable)

Jangan lupa update di layout jika ganti format:
```blade
<!-- Ubah dari .png ke .svg atau .jpg -->
<img src="{{ asset('images/logo-politala.svg') }}" alt="Logo Politala" class="h-12 w-auto">
```

---

**Note:** Logo akan muncul di header setiap halaman untuk semua role (Admin, Wadir1, Kaprodi, Tim, Dosen).
