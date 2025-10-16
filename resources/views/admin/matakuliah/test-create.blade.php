<!DOCTYPE html>
<html>
<head>
    <title>Test Create Mata Kuliah</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .checkbox-item { margin: 10px 0; }
        input[type="text"], input[type="number"], select { 
            width: 300px; 
            padding: 5px; 
            margin: 5px 0; 
        }
        .btn { 
            padding: 10px 20px; 
            margin: 10px 5px; 
            cursor: pointer; 
        }
    </style>
</head>
<body>
    <h1>TEST FORM - Tambah Mata Kuliah</h1>
    
    @if ($errors->any())
        <div style="background: #fee; border: 1px solid red; padding: 10px; margin: 10px 0;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.matakuliah.store') }}" method="POST">
        @csrf
        
        <h3>Pilih CPL (boleh 1 atau lebih):</h3>
        <div style="border: 1px solid #ccc; padding: 10px; max-height: 300px; overflow-y: auto;">
            @foreach ($capaianProfilLulusans as $cpl)
                <div class="checkbox-item">
                    <label>
                        <input type="checkbox" name="id_cpls[]" value="{{ $cpl->id_cpl }}">
                        {{ $cpl->kode_cpl }} - {{ $cpl->deskripsi_cpl }}
                    </label>
                </div>
            @endforeach
        </div>
        <br>

        <label>Kode MK:</label><br>
        <input type="text" name="kode_mk"><br>

        <label>Nama MK:</label><br>
        <input type="text" name="nama_mk"><br>

        <label>Jenis MK:</label><br>
        <input type="text" name="jenis_mk"><br>

        <label>SKS:</label><br>
        <input type="number" name="sks_mk"><br>

        <label>Semester:</label><br>
        <select name="semester_mk">
            <option value="">Pilih</option>
            @for ($i = 1; $i <= 8; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select><br>

        <label>Kompetensi:</label><br>
        <select name="kompetensi_mk">
            <option value="">Pilih</option>
            <option value="pendukung">Pendukung</option>
            <option value="utama">Utama</option>
        </select><br><br>

        <button type="submit" class="btn" style="background: #4CAF50; color: white;">SIMPAN</button>
        <a href="{{ route('admin.matakuliah.index') }}" class="btn" style="background: #999; color: white; text-decoration: none; display: inline-block;">BATAL</a>
    </form>

    <script>
        console.log('TEST PAGE LOADED - NO ALPINE, NO VALIDATION');
    </script>
</body>
</html>
