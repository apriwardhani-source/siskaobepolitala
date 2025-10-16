<!DOCTYPE html>
<html>
<head>
    <title>TEST Create Mata Kuliah - TIM</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .checkbox-item { margin: 10px 0; padding: 5px; }
        .checkbox-item:hover { background: #f0f0f0; }
        input[type="text"], input[type="number"], select { 
            width: 100%; 
            padding: 8px; 
            margin: 5px 0; 
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn { 
            padding: 10px 20px; 
            margin: 10px 5px 10px 0; 
            cursor: pointer;
            border: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .error { background: #fee; border: 1px solid #f00; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .cpl-box { border: 2px solid #2563eb; padding: 15px; max-height: 300px; overflow-y: auto; border-radius: 4px; background: #f8f9fa; }
        h1 { color: #2563eb; }
        .info { background: #e3f2fd; padding: 10px; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 TEST FORM - Tambah Mata Kuliah (TIM)</h1>
        
        <div class="info">
            <strong>INFO:</strong> Ini adalah form test TANPA Alpine.js, TANPA validasi browser, TANPA layout kompleks.
            <br>Tujuan: Cek apakah checkbox bisa dipilih bebas (tidak harus semua).
        </div>

        @if ($errors->any())
            <div class="error">
                <strong>Error:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tim.matakuliah.store') }}" method="POST">
            @csrf
            
            <h3>✅ Pilih CPL (boleh 1, 2, 3, atau lebih - BEBAS!):</h3>
            <div class="cpl-box">
                @forelse ($capaianProfilLulusans as $cpl)
                    <div class="checkbox-item">
                        <label style="cursor: pointer; display: block;">
                            <input type="checkbox" name="id_cpls[]" value="{{ $cpl->id_cpl }}" style="width: auto; margin-right: 8px;">
                            <strong>{{ $cpl->kode_cpl }}</strong> - {{ $cpl->deskripsi_cpl }}
                        </label>
                    </div>
                @empty
                    <p style="color: #999;">Tidak ada CPL tersedia</p>
                @endforelse
            </div>
            <p style="color: #666; font-size: 12px; margin-top: 5px;">💡 Centang BEBAS berapa saja, tidak harus semua!</p>
            <br>

            <label><strong>Kode MK:</strong></label><br>
            <input type="text" name="kode_mk" value="{{ old('kode_mk') }}" placeholder="Contoh: MK001"><br>

            <label><strong>Nama MK:</strong></label><br>
            <input type="text" name="nama_mk" value="{{ old('nama_mk') }}" placeholder="Contoh: Pemrograman Web"><br>

            <label><strong>Jenis MK:</strong></label><br>
            <input type="text" name="jenis_mk" value="{{ old('jenis_mk') }}" placeholder="Contoh: Wajib / Pilihan"><br>

            <label><strong>SKS:</strong></label><br>
            <input type="number" name="sks_mk" value="{{ old('sks_mk') }}" placeholder="Contoh: 3"><br>

            <label><strong>Semester:</strong></label><br>
            <select name="semester_mk">
                <option value="">-- Pilih Semester --</option>
                @for ($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}" {{ old('semester_mk') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select><br>

            <label><strong>Kompetensi:</strong></label><br>
            <select name="kompetensi_mk">
                <option value="">-- Pilih Kompetensi --</option>
                <option value="pendukung" {{ old('kompetensi_mk') == 'pendukung' ? 'selected' : '' }}>Pendukung</option>
                <option value="utama" {{ old('kompetensi_mk') == 'utama' ? 'selected' : '' }}>Utama</option>
            </select><br><br>

            <button type="submit" class="btn" style="background: #10b981; color: white;">💾 SIMPAN</button>
            <a href="{{ route('tim.matakuliah.index') }}" class="btn" style="background: #6b7280; color: white; text-decoration: none; display: inline-block;">❌ BATAL</a>
        </form>

        <hr style="margin: 30px 0;">
        <p style="color: #999; font-size: 12px;">
            <strong>Debug Info:</strong><br>
            - No Alpine.js ✅<br>
            - No Browser Validation ✅<br>
            - No JavaScript Interference ✅<br>
            - Pure HTML Form ✅
        </p>
    </div>

    <script>
        console.log('🧪 TEST PAGE LOADED - NO ALPINE, NO VALIDATION, NO BS!');
        console.log('Total CPL available:', {{ $capaianProfilLulusans->count() }});
    </script>
</body>
</html>
