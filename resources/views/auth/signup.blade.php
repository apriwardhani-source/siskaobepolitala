<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SignUp</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="bg-gradient-to-br  from-blue-300 to-gray-100">

  <div class="min-h-screen flex items-center justify-center py-6 px-4">
    <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row">
      
     
      <div class="md:w-1/2 w-full h-64 md:h-auto bg-cover bg-center relative" style="background-image: url('/image/Politala.jpeg');">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
      </div>
      
      
      <div class="md:w-1/2 w-full py-8 px-6 sm:px-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign-Up</h2>
        <p class="mb-4 text-gray-600">Buat akunmu sekarang.</p>
        @if (session('success'))
            <div id="alert"
                class="bg-green-500 text-white px-4 py-2 rounded-md mb-6 text-center relative max-w-4xl mx-auto">
                <span class="font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif
        <form action="{{ route('signup.store') }}" method="POST">
          @csrf
          <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-user text-gray-400"></i>
            </div>
            <input type="text" name="name" placeholder="Nama Lengkap" class="border border-gray-300 py-2 px-3 w-full rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] pl-10" value="{{ old('name') }}" required>
          </div>

          <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-id-card text-gray-400"></i>
            </div>
            <input type="text" name="nip" placeholder="NIP" class="border border-gray-300 py-2 px-3 w-full rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] pl-10" value="{{ old('nip') }}" required>
          </div>

          <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-phone text-gray-400"></i>
            </div>
            <input type="text" name="nohp" placeholder="Nomor HP" class="border border-gray-300 py-2 px-3 w-full rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] pl-10" value="{{ old('nohp') }}" required>
          </div>
          
          <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-envelope text-gray-400"></i>
            </div>
            <input type="text" name="email" placeholder="Email" class="border border-gray-300 py-2 px-3 w-full rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] pl-10" value="{{ old('email') }}" required>
          </div>
          
          <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-lock text-gray-400"></i>
            </div>
            <input type="password" name="password" placeholder="Masukkan Password" class="border border-gray-300 py-2 px-3 w-full rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] pl-10" required>
          </div>

          <div class="mb-4">
            <label class="block mb-1 text-[#87acd6]">Program Studi</label>
            <select name="kode_prodi" class="w-full border border-gray-300 py-2 px-3 rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] " required>
              <option value="">-- Pilih Prodi --</option>
              @foreach($prodis as $prodi)
                <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-4">
            <label class="block mb-1 text-[#87acd6]">Peran</label>
            <select name="role" class="w-full border border-gray-300 py-2 px-3 rounded focus:outline-none focus:ring-2 focus:ring-[#3094c6] " required>
              <option value="">-- Pilih Peran --</option>
              <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
              <option value="tim" {{ old('role') == 'tim' ? 'selected' : '' }}>Admin Prodi</option>
              <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
            </select>
          </div>

          {{-- <div>
          <!-- CHECK -->
          <div class="mb-4 flex items-start gap-2">
            <input type="checkbox" id="agreeCheckbox" class="mt-1" required disabled>
            <p class="text-sm text-gray-600">
              Saya menerima 
              <button type="button" onclick="openModal()" class="text-[#3094c6] font-semibold underline">Ketentuan Penggunaan</button> & 
              <button type="button" onclick="openModal()" class="text-[#3094c6] font-semibold underline">Kebijakan Privasi</button>.
            </p>
          </div>

          <!-- Modal -->
          <div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-xl max-w-xl w-full shadow-lg relative">
              <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-600 hover:text-black">&times;</button>
              <h3 class="text-xl font-bold mb-4 text-gray-800">Ketentuan Penggunaan & Kebijakan Privasi</h3>
              <div class="overflow-y-auto max-h-64 text-sm text-gray-700">
                <p class="mb-2 font-semibold">Ketentuan Penggunaan:</p>
                <p class="mb-4">
                  Dengan mendaftar, Anda menyetujui bahwa informasi yang Anda berikan adalah benar dan Anda akan mematuhi aturan penggunaan sistem ini.
                </p>
                <p class="mb-2 font-semibold">Kebijakan Privasi:</p>
                <p>
                  Data pribadi Anda akan digunakan hanya untuk keperluan sistem dan tidak akan dibagikan kepada pihak ketiga tanpa izin Anda.
                </p>
              </div>
              <div class="mt-6 text-right">
                <button onclick="agreeTerms()" class="bg-[#3094c6] hover:bg-[rgb(29,99,134)] text-white px-4 py-2 rounded-lg">Saya Setuju</button>
              </div>
            </div>
          </div>
          
          <script>
            function openModal() {
              document.getElementById('termsModal').classList.remove('hidden');
            }
          
            function closeModal() {
              document.getElementById('termsModal').classList.add('hidden');
            }
          
            function agreeTerms() {
              const checkbox = document.getElementById('agreeCheckbox');
              checkbox.checked = true;
              checkbox.disabled = false;
              closeModal();
            }
          </script>
          </div> --}}


          <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <button type="submit" class="bg-[#3094c6] hover:bg-[rgb(29,99,134)]  text-white font-semibold py-2 px-7 rounded-lg transition duration-300 w-full sm:w-auto">
              Daftar
            </button>
            <a href="{{ route('login') }}" class="text-sm text-[#3094c6] hover:underline text-center sm:text-left">Sudah punya akun?</a>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
