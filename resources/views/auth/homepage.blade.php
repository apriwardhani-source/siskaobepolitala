<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Politala | Kurikulum</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

  <!-- Pastikan ini ada sebelum script Anda -->
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Swiper & Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Swiper homepage  -->
  <script>
    $(document).ready(function () {
      const owl = $(".owl-banner");

      // Inisialisasi owl carousel
      owl.owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        items: 1,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true
      });

      // Mengatur angka pada dots
      owl.on('initialized.owl.carousel', function (event) {
        setTimeout(function () {
          $('.owl-dot').each(function (index) {
            $(this).find('span').text(index + 1);  // Menambahkan angka pada dots
          });
        }, 100);
      });

      // Menambahkan klik event pada tombol (1, 2, 3) untuk berpindah slide
      $('.owl-dot').on('click', function () {
        var index = $(this).index(); // Mendapatkan indeks tombol yang diklik
        owl.trigger('to.owl.carousel', [index]); // Berpindah ke slide yang sesuai dengan indeks
      });
    });
  </script>

  <!-- Swiper homepage 2 -->
  <script>
    const carousel = document.getElementById('carousel');
    const indicators = document.querySelectorAll('#indicators button');
    let currentSlide = 0;
    const totalSlides = indicators.length;

    function goToSlide(index) {
      currentSlide = index;
      carousel.style.transform = `translateX(-${index * 100}%)`;
      updateIndicators();
    }

    function updateIndicators() {
      indicators.forEach((btn, idx) => {
        btn.classList.remove('bg-orange-500', 'w-6');
        btn.classList.add('bg-gray-300', 'w-2');
        if (idx === currentSlide) {
          btn.classList.add('bg-orange-500', 'w-6');
          btn.classList.remove('bg-gray-300', 'w-2');
        }
      });
    }

    indicators.forEach((btn, index) => {
      btn.addEventListener('click', () => {
        goToSlide(index);
      });
    });

    setInterval(() => {
      currentSlide = (currentSlide + 1) % totalSlides;
      goToSlide(currentSlide);
    }, 5000); // Auto slide setiap 5 detik
  </script>

  <style>
    html {
  scroll-behavior: smooth;
}
  </style>
</head>

<body class="bg-gray-100 text-gray-800 ">

  <!-- Header -->
  <header class="bg-white shadow-md  px-4 sm:px-6 md:px-16 lg:px-32 " x-data="{ open: false }">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 ">
      <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="index.html" class="flex items-center space-x-2">
        <img  src="/image/Logo.png" alt="Logo" class="h-9 object-contain">
        <span class="text-xl font-semibold text-gray-800 leading-none">Politala OBE</span>
      </a>
    
        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6 items-center">
          <a href="#beranda" class="relative text-gray-700 font-medium hover:text-blue-600 transition duration-300
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-blue-600 before:transition-all before:duration-300 hover:before:w-full">
            Beranda
          </a>
          <a href="#visimisi" class="relative text-gray-700 font-medium hover:text-blue-600 transition duration-300
          before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
          before:bg-blue-600 before:transition-all before:duration-300 hover:before:w-full">
          Visi & Misi
          </a>
          <a href="#prodi" class="relative text-gray-700 font-medium hover:text-blue-600 transition duration-300
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-blue-600 before:transition-all before:duration-300 hover:before:w-full">
            Program Studi
          </a>
          <a href="#team" class="relative text-gray-700 font-medium hover:text-blue-600 transition duration-300
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-blue-600 before:transition-all before:duration-300 hover:before:w-full">
            Team
          </a>
          <a href="#contact" class="relative text-gray-700 font-medium hover:text-blue-600 transition duration-300
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-blue-600 before:transition-all before:duration-300 hover:before:w-full">
            Contact Us
          </a>
          <a href="{{ route('login') }}"
            class="text-[#3094c6] font-medium px-3 py-1 rounded-xl border-2 border-[#3094c6] hover:bg-[#3094c6] hover:text-white transition flex items-center">
            <i class="bi bi-person"></i>
            <span class="ml-2">Login</span>
          </a>
        </nav>

        <!-- Toggle Button (Mobile Only) -->
        <button class="md:hidden text-gray-700 focus:outline-none" @click="open = !open">
          <template x-if="!open">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </template>
          <template x-if="open">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </template>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div class="md:hidden" x-show="open" @click.away="open = false" x-transition>
        <nav class="flex flex-col bg-[#6988db] text-white p-4 mt-2 rounded-3xl space-y-2 shadow-lg">
          <a href="#beranda"
            class="flex items-center justify-center gap-2 p-3 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5]">
            <span>Beranda</span>
          </a>
          <a href="#visimisi"
            class="flex items-center justify-center gap-2 p-3 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5]">
            <span>Visi & Misi</span>
          </a>
          <a href="#prodi"
            class="flex items-center justify-center gap-2 p-3 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5]">
            <span>Program Studi</span>
          </a>
          <a href="#team"
            class="flex items-center justify-center gap-2 p-3 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5]">
            <span>Team</span>
          </a>
          <a href="#contact"
            class="flex items-center justify-center gap-2 p-3 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5]">
            <span>Contact Us</span>
          </a>
          <a href="{{ route('login') }}"
            class="flex items-center justify-center gap-2 p-3 hover:bg-[#586da7] rounded-2xl border-b border-[#313874]">
            <i class="bi bi-person text-white opacity-70"></i>
            <span class="ml-1">Login</span>
          </a>
        </nav>
      </div>
    </div>
  </header>

  <!-- Page Home -->
  <section class="w-full h-screen md:h-[650px] bg-cover bg-center flex items-center justify-center text-white"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/image/Politala.jpeg');"
    id="top">
    <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
      <div class="owl-carousel owl-banner">
        <!-- Slide 1 -->
        <div class="text-center md:text-left">
          <h6 class="text-xl md:text-2xl font-semibold text-white">KURIKULUM OBE</h6>
          <h2 class="text-3xl md:text-5xl font-bold leading-tight mt-2">
            <span class="text-[#f3f3f3]">Politeknik</span>
            <em class="text-sky-500">Negeri</em>
            <span class="text-[#f3f3f3]">Tanah Laut</span>
          </h2>
          <p class="text-base md:text-lg text-blue-100 mb-6 mt-3">
            Selamat Datang di Website Kurikulum Berbasis Outcome-Based Education (OBE)
          </p>
          <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-4 ml-2 mb-3">
            <a href="{{ route('login') }}"
              class="bg-blue-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-110">
              Mulai
            </a>
            <a id="openPopup" target="_blank"
              class="bg-green-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-110">
              <i class="fa fa-envelope mr-2"></i>Email
            </a>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="text-center md:text-left">
          <h6 class="text-xl md:text-2xl font-semibold text-white">VISI & MISI</h6>
          <h2 class="text-3xl md:text-4xl font-bold text-white mt-2">
            Mewujudkan Lulusan Unggul <em class="text-sky-500">Berbasis</em> Outcome-Based Education
          </h2>
          <p class="text-base md:text-lg text-blue-100 mb-6 mt-3">
            Visi kami adalah mencetak lulusan yang siap kerja, kompeten, dan adaptif terhadap perkembangan industri.
          </p>
          <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-4 ml-2 mb-3">
            <a href="#visimisi"
              class="bg-blue-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-110">
              Lihat Visi
            </a>
            <a href="kontak-politala.vcf" download
              class="bg-green-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-110">
              <i class="fa fa-phone mr-2"></i>Kontak Kami
            </a>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="text-center md:text-left">
          <h6 class="text-xl md:text-2xl font-semibold text-white">PROFIL PROGRAM STUDI</h6>
          <h2 class="text-3xl md:text-4xl font-bold text-white mt-2">
            Program Studi Unggulan <em class="text-sky-500">Siap</em> Meningkatkan Mutu Pendidikan
          </h2>
          <p class="text-base md:text-lg text-blue-100 mb-6 mt-3">
            Kenali lebih jauh program studi di Politala yang mendukung sistem pembelajaran OBE.
          </p>
          <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-4 ml-2 mb-3">
            <a href="#prodi"
              class="bg-blue-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-110">
              Lihat Program Studi
            </a>
            <a href="https://wa.me/05113305052"
              class="bg-green-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-110">
              <i class="fa fa-comment mr-2"></i>Hubungi Kami
            </a>
          </div>
        </div>
      </div>


      <!-- Navigasi Slide -->
      <div class="flex justify-center md:justify-start gap-2 mt-3">
        <button
          class="owl-dot w-10 h-10 border-2 border-white text-white rounded-full flex justify-center items-center font-bold text-base hover:text-blue-500 transition-all duration-300">1</button>
        <button
          class="owl-dot w-10 h-10 border-2 border-white text-white rounded-full flex justify-center items-center font-bold text-base hover:text-blue-500 transition-all duration-300">2</button>
        <button
          class="owl-dot w-10 h-10 border-2 border-white text-white rounded-full flex justify-center items-center font-bold text-base hover:text-blue-500 transition-all duration-300">3</button>
      </div>

    </div>
  </section>

  <!-- Beranda -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
    mirror: true
  </script>
  <div id="beranda" class="homepage pb-10">
    <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
      <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10 pt-12">
        <div data-aos="fade-right" data-aos-once="false" data-aos-duration="1000">
          <h1 class="text-4xl md:text-5xl font-semibold leading-tight mb-10">
            Profil Kurikulum OBE <span class="text-sky-500">Politala</span>
          </h1>
          <p class="text-justify text-base text-gray-700 leading-relaxed mb-6">
            Politeknik Negeri Tanah Laut (Politala) merupakan perguruan tinggi vokasi yang berlokasi di Kabupaten Tanah Laut, Provinsi Kalimantan Selatan. Politala berfokus pada pendidikan terapan dengan tujuan mencetak lulusan yang kompeten, inovatif, dan siap kerja di berbagai bidang industri.

Kampus ini memiliki berbagai program studi unggulan di bidang teknologi, pertanian, dan bisnis digital, yang dirancang untuk mendukung perkembangan industri dan pembangunan daerah. Politala juga aktif menjalin kerja sama dengan dunia industri serta lembaga pendidikan lain, baik di dalam maupun luar negeri, guna meningkatkan kualitas pendidikan dan relevansi kompetensi lulusan dengan kebutuhan pasar kerja.
          </p>
          <a href="{{ route('login') }}"
            class="inline-flex items-center bg-sky-500 hover:bg-sky-700 text-white mt-4 px-5 py-3 rounded-full shadow transition">
            Tentang Website <i class="ri-eye-line ms-2"></i>
          </a>
        </div>
        <div className="flex justify-end" data-aos="fade-left" data-aos-once="false" data-aos-duration="1000">
          <img src="/image/profil.png" alt="Hero Image" className="w-full max-w-md h-auto ml-auto" />
        </div>
      </div>
    </div>
  </div>

  
  {{-- visi misi --}}
  <div id="visimisi" class="bg-gradient-to-br from-blue-400 to-indigo-700 py-24   px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl">Visi & Misi</h1>
        <div class="w-24 h-1 bg-white mx-auto mt-4 rounded-full"></div>
      </div>
  
      @if($visis)
      <div class="bg-white rounded-xl shadow-2xl p-8 mb-10 transform hover:scale-105 transition duration-300 ease-in-out">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">Visi Politala</h2>
        <p class="text-lg text-gray-700 leading-relaxed text-center">
          {{ $visis->visi }}
        </p>
      </div>
      @else
      <div class="bg-white rounded-xl shadow-2xl p-8 mb-10 text-center">
        <p class="text-gray-500">Data visi belum tersedia.</p>
      </div>
      @endif
  
      <div class="bg-white rounded-xl shadow-2xl p-8 transform hover:scale-105 transition duration-300 ease-in-out">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">Misi Politala</h2>
        @if($misis->count() > 0)
        <ol class="list-decimal list-outside space-y-4 text-lg text-gray-700">
          @foreach ($misis as $misi)
            <li class="ml-6 leading-relaxed text-justify"> {{-- Added text-justify here --}}
                {{ $misi->misi }}
            </li>
          @endforeach
        </ol>
        @else
        <p class="text-center text-gray-500">Data misi belum tersedia.</p>
        @endif
      </div>
    </div>
  </div>
  
  <!-- Program STudi-->
  <div id="prodi" class="scroll-mt-24 mb-10 ">
    <section class="py-12 bg-gray-50 pt-20" >
      <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
        <h1 class="text-3xl text-center font-bold text-indigo-800 mb-2">Program Studi</h1>
        <p class="text-lg text-center text-gray-600 mb-8">Temukan program studi yang sesuai dengan minat Anda</p>




        <!-- Swiper Card Slider -->
        <div class="relative swiper mySwiper pb-20" id="prodi-container">
          <div class="swiper-wrapper ">
            @foreach ($prodis as $prodi)
            <div class="swiper-slide">
              <div class="program-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer border border-gray-100">

                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
                  <div class="flex items-center justify-between mb-3">
                    <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                      <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                      {{ $prodi->jenjang_pendidikan }}
                    </span>
                  </div>
                  <h3 class="text-[15px] font-bold mb-2">{{ $prodi->nama_prodi }}</h3>
                  <p class="text-blue-100 text-sm">{{ $prodi->gelar_lulusan }}</p>
                </div>

                <!-- Content -->
                <div  class="p-6">
                  <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                      <i class="fas fa-award mr-2"></i>
                      Akreditasi {{ $prodi->peringkat_akreditasi }}
                    </div>
                  </div>

                  <div class="space-y-3 mb-6">
                    <div class="flex items-center text-gray-600">
                      <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                      </div>
                      <div>
                        <span class="text-sm text-gray-500">Berdiri</span>
                        <p class="font-medium">{{ date('d M Y', strtotime($prodi->tgl_berdiri_prodi)) }}</p>
                      </div>
                    </div>

                    <div class="flex items-center text-gray-600">
                      <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-phone text-green-600"></i>
                      </div>
                      <div>
                        <span class="text-sm text-gray-500">Kontak</span>
                        <p class="font-medium">{{ $prodi->telepon_prodi ?? '-' }}</p>
                      </div>
                    </div>
                  </div>

                  <!-- Footer -->
                  <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <a class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-xl font-medium hover:from-blue-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105"
                      href="{{ $prodi->website_prodi ?? '#' }}" target="_blank">
                      <i class="fas fa-external-link-alt mr-2"></i>
                      Lihat Detail
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Tombol Geser Kanan-Kiri -->
          <div class="swiper-button-prev !text-indigo-600"></div>
          <div class="swiper-button-next !text-indigo-600"></div>

          <!-- Pagination Bulat -->
          <div class="swiper-pagination pt-8 mt-14 flex justify-center"></div>
        </div>
      </div>
    </section>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Script Slider + Filter -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const swiper = new Swiper(".mySwiper", {
          slidesPerView: 1,
          spaceBetween: 20,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
          breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
            1280: { slidesPerView: 4 },
          }
        });
      });
    </script>

    <!-- Style Geser -->
    <style>
      .swiper-button-prev::after,
      .swiper-button-next::after {
        font-size: 20px !important; /* atau 12px untuk lebih kecil lagi */
        color: #4f46e5 !important;  /* pastikan warnanya indigo */
      }

      .swiper-button-prev,
      .swiper-button-next {
        width: 28px;
        height: 28px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 9999px;
        top: 45%;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
      }

      .swiper-button-prev:hover,
      .swiper-button-next:hover {
        background: #4f46e5;
      }
    </style>
  </div>

  <!-- Team Kurikulum -->
  <section id="team" class="">
    <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-indigo-800 mb-4 sm:mb-0">Team Kurikulum</h2>
      </div>
    
      <!-- Swiper Wrapper -->
      <div class="swiper teamSwiper relative pb-10">
        <div class="swiper-wrapper">
          @foreach ($tim_users as $user)
            <div class="swiper-slide">
              <div class="bg-white rounded-xl overflow-hidden shadow-md w-full px-2 transition-transform duration-300 hover:scale-[1.03] hover:shadow-lg">
                <div class="w-full h-1 bg-gradient-to-r from-purple-400 to-pink-500"></div>
                <div class="p-4">
                  <span class="text-xs bg-green-600 text-white px-3 py-1 rounded-full shadow-sm">TEAM KURIKULUM</span>
                  <h3 class="font-bold text-lg text-gray-800 mt-2">{{ $user->name }}</h3>
                  <p class="text-sm text-gray-600">Program Studi: {{ $user->prodi?->nama_prodi ?? '-' }}</p>
                  <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap gap-2">
                      <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">#MerdekaBelajar</span>
                      <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">#KampusMerdeka</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Arrow Buttons -->
        <div class="swiper-button-prev !text-indigo-600"></div>
        <div class="swiper-button-next !text-indigo-600"></div>

        <!-- Pagination -->
        <div class="swiper-pagination pt-4 flex justify-center"></div>
      </div>

    </div>
  </section>

  <style>
    .swiper-button-prev::after,
    .swiper-button-next::after {
      font-size: 20px !important;
      color: #4f46e5 !important;
    }

    .swiper-button-prev,
    .swiper-button-next {
      width: 28px;
      height: 28px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 9999px;
      top: 45%;
      box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
    }

    .swiper-button-prev:hover,
    .swiper-button-next:hover {
      background: #4f46e5;
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      new Swiper(".teamSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        breakpoints: {
          640: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
          1280: { slidesPerView: 4 },
        }
      });
    });
  </script>



<!-- Footer -->
<footer id="contact" class="bg-gray-800 text-white py-12 mt-20">
    <div class="container mx-auto px-6">
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- About Section -->
        <div class="footer-item">
          <div class="logo mb-4">
            <a href="https://politala.ac.id/"><img src="/image/Logo.png" class="h-24" alt="Onix Digital TemplateMo" class="w-32 h-auto"></a>
            <a href="mailto:info@company.com" class="block mb-2 mt-5 text-sm">info@politala.ac.id</a>
          </div>

          <div>
            <ul class="flex space-x-4">
              <li><a href="https://www.facebook.com/politala.ac.id" class="text-gray-400 hover:text-white text-xl"><i
                    class="fab fa-facebook"></i></a></li>
              <li><a href="https://twitter.com/humaspolitala" class="text-gray-400 hover:text-white text-xl"><i
                    class="fab fa-twitter"></i></a></li>
              <li><a href="https://www.instagram.com/politala_official/"
                  class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a></li>
              <li><a href="https://www.youtube.com/channel/UC5CfzvUTqEUPXhwwSLvP53Q"
                  class="text-gray-400 hover:text-white text-xl"><i class="fab fa-youtube"></i></a></li>
            </ul>
          </div>
        </div>

        <!-- Services Section -->
        <div class="footer-item">
          <h4 class="font-semibold text-lg mb-6">Layanan</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white">Perpustakaan Digital</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Portal Mahasiswa</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Bimbingan Akademik</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Pusat Karier</a></li>
          </ul>
        </div>

        <!-- Community Section -->
        <div class="footer-item">
          <h4 class="font-semibold text-lg mb-6">Komunitas</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white">Organisasi Mahasiswa</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Alumni & Jejaring</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Forum Diskusi Akademik</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Kegiatan Kampus</a></li>
          </ul>
        </div>

        <!-- Email -->
<div class="footer-item">
          <h4 class="font-semibold text-lg mb-6">Tentang Informasi</h4>
          <p class="text-gray-400 mb-4">Dapatkan informasi, Tim kami siap menjawab pertanyaan Anda via email.</p>
          <div action="#" method="get" class="flex items-center space-x-2">
            <!-- Popup ) -->
            <div id="popupOverlay" class=" hidden">
              <div class="fixed inset-0 bg-black bg-opacity-70 justify-center z-50 flex items-center backdrop-blur-sm">
                <div
                  class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-8 w-full max-w-md shadow-2xl transform transition-all animate-fadeIn">
                  <div class="flex justify-between items-center mb-6">
                    <div>
                      <h3 class="text-2xl font-bold text-gray-800">Hubungi Kami</h3>
                      <p class="text-sm text-gray-500 mt-1">Kami akan segera merespon pesan Anda</p>
                    </div>
                    <button id="closePopup" type="button"
                      class="text-gray-400 hover:text-gray-600 transition-transform hover:rotate-90">
                      <i class="fas fa-times text-xl"></i>
                    </button>
                  </div>

                  <form id="emailForm" class="space-y-5">
                    <!-- Field Nama -->
                    <div class="relative mb-3">
                      <div class="relative">
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5460B5] 
                            focus:border-transparent transition bg-white/80 text-gray-800 placeholder-gray-400 peer"
                          placeholder="Nama Lengkap">
                        <i class="fas fa-user absolute left-3 top-4 text-gray-400"></i>
                        <label for="popupName" class="absolute left-11 top-3 text-sm text-gray-500 transition-all 
                                      peer-focus:-top-3 peer-focus:text-xs peer-focus:text-[#5460B5]
                                      peer-valid:-top-3 peer-valid:text-xs">
                        </label>
                      </div>
                    </div>

                    <!-- Field Email -->
                    <div class="relative mb-3">
                      <div class="relative">
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5460B5] 
                            focus:border-transparent transition bg-white/80 text-gray-800 placeholder-gray-400 peer"
                          placeholder="Alamat Email">
                        <i class="fas fa-envelope absolute left-3 top-4 text-gray-400"></i>
                        <label for="popupEmail" class="absolute left-11 top-3 text-sm text-gray-500 transition-all 
                                      peer-focus:-top-3 peer-focus:text-xs peer-focus:text-[#5460B5]
                                      peer-valid:-top-3 peer-valid:text-xs">
                        </label>
                      </div>
                    </div>

                    <!-- Field Pesan -->
                    <div class="relative mb-3">
                      <div class="relative">
                        <textarea id="message" name="message" rows="5" required
                          class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5460B5] 
                                focus:border-transparent transition bg-white/80 text-gray-800 placeholder-gray-400 peer resize-none"
                          placeholder="Tulis pesan Anda..."></textarea>
                        <i class="fas fa-comment-dots absolute left-3 top-4 text-gray-400"></i>
                        <label for="popupMessage" class="absolute left-11 top-3 text-sm text-gray-500 transition-all 
                                      peer-focus:-top-3 peer-focus:text-xs peer-focus:text-[#5460B5]
                                      peer-valid:-top-3 peer-valid:text-xs">
                        </label>
                      </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit"
                      class="w-full bg-gradient-to-r from-[#5460B5] to-[#3a44a1] text-white py-3.5 px-6 rounded-xl hover:opacity-90 transition-all transform hover:scale-[1.02] shadow-lg font-medium flex items-center justify-center gap-2">
                      <i class="fas fa-paper-plane"></i>
                      <span class="relative">
                        Kirim Pesan
                        <span
                          class="absolute -bottom-1 left-0 w-full h-0.5 bg-white/50 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                      </span>
                    </button>
                  </form>

                  <div class="mt-6 text-center text-xs text-gray-400">
                    <p>Kami tidak akan membagikan data Anda kepada pihak lain</p>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <style>
            @keyframes fadeIn {
              from {
                opacity: 0;
                transform: translateY(10px);
              }

              to {
                opacity: 1;
                transform: translateY(0);
              }
            }

            .animate-fadeIn {
              animation: fadeIn 0.3s ease-out forwards;
            }
          </style>

      
          <button id="footerPopup" type="button"
            class=" bg-[#5460B5] text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition transform hover:scale-[1.03] shadow-md flex items-center">
            <i class="fas fa-envelope mr-2 flex items-center"></i> Hubungi Kami
          </button>

         
          <script>
            
            emailjs.init("ifTKxlRZB0TeAe3c2"); // Gunakan public key yang sesuai dengan akun Anda

            document.addEventListener('DOMContentLoaded', function () {

            emailjs.init("ifTKxlRZB0TeAe3c2");

            // Tangani popup hero section
            const heroPopupBtn = document.getElementById('openPopup');
            const footerPopupBtn = document.getElementById('footerPopup');
            const popupOverlay = document.getElementById('popupOverlay');
            const closePopup = document.getElementById('closePopup');
            const emailForm = document.getElementById('emailForm');

            
            function openPopup() {
              popupOverlay.classList.remove('hidden');
              document.body.style.overflow = 'hidden';
            }

            
            function closePopupFunc() {
              popupOverlay.classList.add('hidden');
              document.body.style.overflow = '';
            }

          
            if (heroPopupBtn) heroPopupBtn.addEventListener('click', openPopup);
            if (footerPopupBtn) footerPopupBtn.addEventListener('click', openPopup);
            if (closePopup) closePopup.addEventListener('click', closePopupFunc);

            popupOverlay.addEventListener('click', function(e) {
              if (e.target === popupOverlay) {
                closePopupFunc();
              }
            });

            if (emailForm) {
              emailForm.addEventListener("submit", function(event) {
                event.preventDefault();
                emailjs.sendForm("service_juidzkf", "template_u1onvyd", this)
                  .then(
                    function(response) {
                      alert("Pesan berhasil dikirim!");
                      emailForm.reset();
                      closePopupFunc();
                    },
                    function(error) {
                      alert("Terjadi kesalahan: " + error.text);
                    }
                  );
              });
            }
          });
          
          </script>

        </div>

</div>

      <hr class="mt-10 border-gray-400">
      <!-- Copyright Section -->
      <div class="text-center text-sm text-gray-400 mt-8">
        <p>Copyright &copy; 2025 Fikri & Habibie., All Rights Reserved.</p>
      </div>
    </div>
</footer>

</body>

</html>