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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Swiper & Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Swiper homepage  -->
    <script>
        $(document).ready(function() {
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
            owl.on('initialized.owl.carousel', function(event) {
                setTimeout(function() {
                    $('.owl-dot').each(function(index) {
                        $(this).find('span').text(index + 1); // Menambahkan angka pada dots
                    });
                }, 100);
            });

            // Menambahkan klik event pada tombol (1, 2, 3) untuk berpindah slide
            $('.owl-dot').on('click', function() {
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
        :root {
            --brand-1: #1e3c72;
            --brand-2: #2a5298;
            --brand-3: #4a90e2;
            --brand-ring: rgba(30, 60, 114, 0.35);
        }

        html {
            scroll-behavior: smooth;
            /* Better scroll performance */
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }

        body {
            /* Prevent scroll issues */
            position: relative;
            overflow-x: hidden;
        }

        /* Enhanced Motion & Animations */
        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(12px);
                opacity: 0
            }

            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(30px);
                opacity: 0
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        @keyframes pulseSoft {
            0% {
                box-shadow: 0 0 0 0 rgba(48, 148, 198, 0.25)
            }

            70% {
                box-shadow: 0 0 0 12px rgba(48, 148, 198, 0)
            }

            100% {
                box-shadow: 0 0 0 0 rgba(48, 148, 198, 0)
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px)
            }

            50% {
                transform: translateY(-10px)
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0
            }

            100% {
                background-position: 1000px 0
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0
            }

            to {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }
        }

        .animate-fadeIn {
            animation: fadeIn .6s ease-out both
        }

        .animate-slideUp {
            animation: slideUp .6s ease-out both
        }

        .animate-slideInLeft {
            animation: slideInLeft .8s ease-out both
        }

        .animate-slideInRight {
            animation: slideInRight .8s ease-out both
        }

        .animate-scaleIn {
            animation: scaleIn .6s ease-out both
        }

        .animate-float {
            animation: float 3s ease-in-out infinite
        }

        .btn-soft-pulse:hover {
            animation: pulseSoft 1.2s ease-out
        }

        .transition-smooth {
            transition: all .2s ease
        }

        .transition-all-300 {
            transition: all .3s cubic-bezier(0.4, 0, 0.2, 1)
        }

        .transition-all-500 {
            transition: all .5s cubic-bezier(0.4, 0, 0.2, 1)
        }

        /* Enhanced Glass morphism & Cards */
        .glass {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.30);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            box-shadow: 0 10px 26px rgba(2, 6, 23, 0.16), 0 1px 0 rgba(255, 255, 255, 0.18) inset, 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }

        .glass::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(120% 60% at 0% 0%, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0) 60%);
            pointer-events: none;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            transform-style: preserve-3d;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-glass:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.4s ease;
        }

        .card-3d:hover {
            transform: perspective(1000px) rotateX(2deg) rotateY(-2deg) translateY(-5px);
        }

        .divider-gradient {
            height: 4px;
            background: linear-gradient(90deg, var(--brand-1), var(--brand-2), var(--brand-3));
            border-radius: 9999px;
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand-1), var(--brand-2));
            color: #fff;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--brand-2), var(--brand-3));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .btn-brand:hover::before {
            opacity: 1;
        }

        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(11, 106, 169, 0.3);
        }

        .btn-brand-outline {
            border: 2px solid var(--brand-1);
            color: var(--brand-1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-brand-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--brand-1);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .btn-brand-outline:hover::before {
            width: 100%;
        }

        .btn-brand-outline:hover {
            color: white;
            border-color: var(--brand-1);
        }

        /* Gradient Backgrounds */
        .gradient-bg-animated {
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #4a90e2, #1e40af);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        /* Floating Shapes - Optimized */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            will-change: transform;
            transform: translateZ(0);
        }

        .floating-shapes .shape {
            position: absolute;
            opacity: 0.08;
            animation: float 8s ease-in-out infinite;
            will-change: transform;
        }

        /* Hover Lift Effect */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Shimmer Effect */
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        /* Scroll Header Effect */
        .header-scrolled {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Smooth Scroll Optimization */
        #mainHeader {
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        /* Prevent layout shift during scroll */
        .fixed-header-spacing {
            padding-top: 64px;
            /* Height of header */
        }

        /* Neon Glow Effect */
        .neon-glow {
            box-shadow: 0 0 20px rgba(47, 179, 218, 0.5), 0 0 40px rgba(11, 106, 169, 0.3);
        }

        /* UI/UX Laws Implementation */

        /* Fitts's Law - Larger clickable areas */
        .btn-large {
            min-height: 48px;
            min-width: 120px;
            padding: 14px 32px;
        }

        /* Law of Proximity - Visual grouping */
        .group-proximity {
            padding: 24px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.02);
        }

        /* Visual Hierarchy - Typography scale */
        .text-hero {
            font-size: clamp(2.5rem, 5vw, 4rem);
            line-height: 1.2;
        }

        .text-section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.3;
        }

        .text-card-title {
            font-size: clamp(1.25rem, 2.5vw, 1.5rem);
            line-height: 1.4;
        }

        .text-body-large {
            font-size: clamp(1rem, 2vw, 1.125rem);
            line-height: 1.7;
        }

        /* Whitespace - Breathing room */
        .spacing-section {
            padding: clamp(3rem, 8vw, 6rem) 0;
        }

        .spacing-element {
            margin-bottom: clamp(1.5rem, 3vw, 2.5rem);
        }

        /* Von Restorff Effect - Make CTA stand out */
        .cta-primary {
            position: relative;
            font-weight: 600;
            font-size: 1.125rem;
            padding: 16px 40px;
            box-shadow: 0 4px 14px 0 rgba(11, 106, 169, 0.39);
        }

        .cta-primary::after {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            bottom: -2px;
            left: -2px;
            background: linear-gradient(45deg, var(--brand-1), var(--brand-2), var(--brand-3));
            border-radius: inherit;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
            animation: gradientShift 3s ease infinite;
            background-size: 200% 200%;
        }

        .cta-primary:hover::after {
            opacity: 1;
        }

        /* Progressive Disclosure - Expandable content */
        .disclosure-hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .disclosure-shown {
            max-height: 1000px;
        }

        /* Focus States - Accessibility */
        .focus-ring:focus {
            outline: 3px solid var(--brand-3);
            outline-offset: 2px;
        }

        /* Loading States - Feedback */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Doherty Threshold - Keep response under 400ms */
        /* Removed will-change from all elements for better performance */

        /* Peak-End Rule - Memorable first & last impressions */
        .memorable-start,
        .memorable-end {
            position: relative;
            z-index: 10;
        }

        /*
    ═══════════════════════════════════════════
    📊 UI/UX LAWS IMPLEMENTED
    ═══════════════════════════════════════════
    
    ✅ Fitts's Law
       - Larger clickable areas (min 48px)
       - Prominent CTAs with btn-large class
       - Easy-to-reach navigation items
    
    ✅ Hick's Law
       - Limited navigation items (5 main items)
       - Simplified decision-making
       - Clear visual hierarchy
    
    ✅ Miller's Law
       - Information chunked in 7±2 items
       - Card content limited per view
       - Organized misi in manageable list
    
    ✅ Jakob's Law
       - Familiar patterns (header, hero, cards, footer)
       - Expected navigation behavior
       - Standard interaction patterns
    
    ✅ Law of Proximity
       - Related elements grouped together
       - Proper spacing between sections
       - Visual grouping with group-proximity class
    
    ✅ Law of Similarity
       - Consistent card designs
       - Uniform button styles
       - Repeating visual patterns
    
    ✅ Law of Common Region
       - Cards with clear boundaries
       - Sections with defined areas
       - Color coding for different regions
    
    ✅ Law of Prägnanz (Simplicity)
       - Clean, simple layouts
       - Clear visual hierarchy
       - Minimal cognitive load
    
    ✅ Von Restorff Effect
       - CTA buttons stand out with cta-primary
       - Login button more prominent
       - Animated gradient borders on primary actions
    
    ✅ Progressive Disclosure
       - Content revealed as needed
       - Expandable sections with disclosure classes
       - Lazy loading patterns
    
    ✅ Aesthetic-Usability Effect
       - Beautiful gradient animations
       - Smooth transitions
       - Modern glass morphism
    
    ✅ Doherty Threshold
       - Fast transitions (<400ms)
       - Immediate visual feedback
       - Optimized animations
    
    ✅ Peak-End Rule
       - Strong hero section start
       - Memorable footer with CTA
       - Highlights at key points
    
    ✅ Serial Position Effect
       - Important items at start/end of lists
       - Primary CTA in prime positions
       - Key info at top and bottom
    
    ✅ Accessibility (WCAG)
       - Focus states with focus-ring
       - ARIA labels on interactive elements
       - Semantic HTML structure
       - Keyboard navigation support
    
    ═══════════════════════════════════════════
    */

        @media (prefers-reduced-motion: reduce) {

            .animate-fadeIn,
            .animate-slideUp,
            .animate-slideInLeft,
            .animate-slideInRight,
            .animate-scaleIn,
            .animate-float,
            .btn-soft-pulse:hover {
                animation: none
            }

            .transition-smooth,
            .transition-all-300,
            .transition-all-500 {
                transition: none
            }
        }

        /* Floating WhatsApp Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: float 3s ease-in-out infinite;
        }

        .whatsapp-float:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.6);
        }

        .whatsapp-float::before {
            content: '';
            position: absolute;
            top: -4px;
            right: -4px;
            bottom: -4px;
            left: -4px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            border-radius: 50%;
            z-index: -1;
            opacity: 0;
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.9);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        @media (max-width: 640px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                font-size: 26px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 pt-16">

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6282159640262?text=Halo%20Politala%2C%20saya%20ingin%20bertanya%20tentang%20Kurikulum%20OBE"
        target="_blank" class="whatsapp-float" aria-label="Chat via WhatsApp" title="Chat dengan kami via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Header -->
    <header id="mainHeader"
        class="bg-white shadow-md px-4 sm:px-6 md:px-16 lg:px-32 fixed top-0 left-0 right-0 z-[100] transition-all-500"
        x-data="{ open: false }" style="position: fixed !important;">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="index.html" class="flex items-center space-x-2">
                    <img src="/image/Logo.png" alt="Logo" class="h-9 object-contain">
                    <span class="text-xl font-semibold text-gray-800 leading-none">Politala OBE</span>
                </a>

                <!-- Desktop Menu - Hick's Law: Limited navigation items (7±2) -->
                <nav class="hidden md:flex space-x-8 items-center" role="navigation" aria-label="Main Navigation">
                    <a href="#beranda"
                        class="relative text-gray-700 font-medium hover:text-[#1e3c72] transition duration-300 py-2 px-3 focus-ring
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-[#1e3c72] before:transition-all before:duration-300 hover:before:w-full">
                        Beranda
                    </a>
                    <a href="#visimisi"
                        class="relative text-gray-700 font-medium hover:text-[#1e3c72] transition duration-300 py-2 px-3 focus-ring
          before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
          before:bg-[#1e3c72] before:transition-all before:duration-300 hover:before:w-full">
                        Visi & Misi
                    </a>
                    <a href="#prodi"
                        class="relative text-gray-700 font-medium hover:text-[#1e3c72] transition duration-300 py-2 px-3 focus-ring
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-[#1e3c72] before:transition-all before:duration-300 hover:before:w-full">
                        Program Studi
                    </a>
                    <a href="#team"
                        class="relative text-gray-700 font-medium hover:text-[#1e3c72] transition duration-300 py-2 px-3 focus-ring
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-[#1e3c72] before:transition-all before:duration-300 hover:before:w-full">
                        Team
                    </a>
                    <a href="#contact"
                        class="relative text-gray-700 font-medium hover:text-[#1e3c72] transition duration-300 py-2 px-3 focus-ring
            before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-0 before:h-[2px]
            before:bg-[#1e3c72] before:transition-all before:duration-300 hover:before:w-full">
                        Contact Us
                    </a>
                    <!-- Von Restorff Effect: Login CTA stands out -->
                    <a href="{{ route('login') }}"
                        class="btn-brand-outline cta-primary font-semibold px-6 py-2.5 rounded-xl transition-smooth flex items-center gap-2 focus-ring"
                        aria-label="Login ke sistem">
                        <i class="bi bi-person text-lg"></i>
                        <span>Login</span>
                    </a>
                </nav>

                <!-- Toggle Button (Mobile Only) - Fitts's Law: Larger tap target -->
                <button class="md:hidden text-gray-700 p-2 focus:outline-none focus-ring" @click="open = !open"
                    aria-label="Toggle mobile menu" aria-expanded="false" :aria-expanded="open.toString()">
                    <template x-if="!open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </template>
                    <template x-if="open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </template>
                </button>
            </div>

            <!-- Mobile Menu - Hick's Law & Fitts's Law: Simple with larger targets -->
            <div class="md:hidden" x-show="open" @click.away="open = false" x-transition role="navigation"
                aria-label="Mobile Navigation">
                <nav class="flex flex-col bg-[#6988db] text-white p-4 mt-2 rounded-3xl space-y-2 shadow-lg">
                    <!-- Fitts's Law: Min 44px height for mobile tap targets -->
                    <a href="#beranda"
                        class="flex items-center justify-center gap-2 min-h-[44px] p-4 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5] transition-colors focus-ring">
                        <span>Beranda</span>
                    </a>
                    <a href="#visimisi"
                        class="flex items-center justify-center gap-2 min-h-[44px] p-4 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5] transition-colors focus-ring">
                        <span>Visi & Misi</span>
                    </a>
                    <a href="#prodi"
                        class="flex items-center justify-center gap-2 min-h-[44px] p-4 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5] transition-colors focus-ring">
                        <span>Program Studi</span>
                    </a>
                    <a href="#team"
                        class="flex items-center justify-center gap-2 min-h-[44px] p-4 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5] transition-colors focus-ring">
                        <span>Team</span>
                    </a>
                    <a href="#contact"
                        class="flex items-center justify-center gap-2 min-h-[44px] p-4 hover:bg-[#586da7] rounded-2xl border-b border-[#5067a5] transition-colors focus-ring">
                        <span>Contact Us</span>
                    </a>
                    <!-- Von Restorff Effect: Login stands out even on mobile -->
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center gap-2 min-h-[44px] p-4 bg-white/10 hover:bg-white/20 rounded-2xl font-semibold transition-colors focus-ring">
                        <i class="bi bi-person text-white opacity-70"></i>
                        <span class="ml-1">Login</span>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Page Home -->
    <section
        class="w-full h-screen md:h-[650px] bg-cover bg-center flex items-center justify-center text-white relative overflow-hidden"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/image/Politala.jpeg');"
        id="top">
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape w-24 h-24 bg-white rounded-full" style="top: 10%; left: 10%; animation-delay: 0s;">
            </div>
            <div class="shape w-16 h-16 rounded-full"
                style="top: 70%; left: 80%; animation-delay: 1s; background: rgba(74, 144, 226, 0.3);"></div>
            <div class="shape w-32 h-32 rounded-full"
                style="top: 40%; right: 10%; animation-delay: 2s; background: rgba(42, 82, 152, 0.3);"></div>
            <div class="shape w-20 h-20 rounded-full"
                style="bottom: 20%; left: 70%; animation-delay: 1.5s; background: rgba(30, 60, 114, 0.3);"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20 relative z-10">
            <div class="owl-carousel owl-banner">
                <!-- Slide 1 - Visual Hierarchy & Law of Prägnanz -->
                <div class="text-center md:text-left spacing-element">
                    <h6 class="text-lg md:text-xl font-semibold text-white/90 tracking-wide mb-3">KURIKULUM OBE</h6>
                    <h2 class="text-hero font-bold leading-tight mt-2">
                        <span class="text-[#f3f3f3]">Politeknik</span>
                        <em class="text-[#4a90e2]">Negeri</em>
                        <span class="text-[#f3f3f3]">Tanah Laut</span>
                    </h2>
                    <p class="text-body-large text-white/90 mb-8 mt-4 max-w-2xl">
                        Selamat Datang di Website Kurikulum Berbasis Outcome-Based Education (OBE)
                    </p>
                    <!-- Fitts's Law: Larger touch targets (48px min) - Law of Proximity: Group actions -->
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-4 mt-8">
                        <a href="{{ route('login') }}"
                            class="btn-brand btn-large cta-primary font-bold rounded-full shadow-lg transition-smooth hover:scale-105 btn-soft-pulse focus-ring"
                            aria-label="Mulai menggunakan sistem">
                            Mulai Sekarang
                        </a>
                        <button id="openPopup" type="button"
                            class="bg-green-600 text-white btn-large font-semibold rounded-full shadow-lg hover:bg-green-700 transition-smooth hover:scale-105 btn-soft-pulse focus-ring flex items-center gap-2">
                            <i class="fab fa-whatsapp text-xl"></i><span>Hubungi Kami</span>
                        </button>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="text-center md:text-left spacing-element">
                    <h6 class="text-lg md:text-xl font-semibold text-white/90 tracking-wide mb-3">VISI & MISI</h6>
                    <h2 class="text-section-title font-bold text-white mt-2">
                        Mewujudkan Lulusan Unggul <em class="text-[#4a90e2]">Berbasis</em> Outcome-Based Education
                    </h2>
                    <p class="text-body-large text-white/90 mb-8 mt-4 max-w-2xl">
                        Visi kami adalah mencetak lulusan yang siap kerja, kompeten, dan adaptif terhadap perkembangan
                        industri.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-4 mt-8">
                        <a href="#visimisi"
                            class="btn-brand btn-large cta-primary font-bold rounded-full shadow-lg transition-smooth hover:scale-105 btn-soft-pulse focus-ring">
                            Lihat Visi & Misi
                        </a>
                        <a href="https://wa.me/6282151889076?text=Halo%20Politala%2C%20saya%20ingin%20mengetahui%20lebih%20lanjut%20tentang%20Visi%20dan%20Misi"
                            target="_blank"
                            class="bg-green-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-110">
                            <i class="fab fa-whatsapp mr-2"></i>Kontak Kami
                        </a>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="text-center md:text-left spacing-element">
                    <h6 class="text-lg md:text-xl font-semibold text-white/90 tracking-wide mb-3">PROFIL PROGRAM STUDI
                    </h6>
                    <h2 class="text-section-title font-bold text-white mt-2">
                        Program Studi Unggulan <em class="text-[#4a90e2]">Siap</em> Meningkatkan Mutu Pendidikan
                    </h2>
                    <p class="text-body-large text-white/90 mb-8 mt-4 max-w-2xl">
                        Kenali lebih jauh program studi di Politala yang mendukung sistem pembelajaran OBE.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-4 mt-8">
                        <a href="#prodi"
                            class="btn-brand btn-large cta-primary font-bold rounded-full shadow-lg transition-smooth hover:scale-105 btn-soft-pulse focus-ring">
                            Jelajahi Program Studi
                        </a>
                        <a href="https://wa.me/6282151889076?text=Halo%20Politala%2C%20saya%20ingin%20informasi%20tentang%20Program%20Studi"
                            target="_blank"
                            class="bg-green-600 text-white font-semibold py-2 px-8 rounded-full shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-110">
                            <i class="fab fa-whatsapp mr-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>


            <!-- Navigasi Slide -->
            <div class="flex justify-center md:justify-start gap-2 mt-3">
                <button
                    class="owl-dot w-10 h-10 border-2 border-white text-white rounded-full flex justify-center items-center font-bold text-base hover:text-[#4a90e2] transition-all duration-300">1</button>
                <button
                    class="owl-dot w-10 h-10 border-2 border-white text-white rounded-full flex justify-center items-center font-bold text-base hover:text-[#4a90e2] transition-all duration-300">2</button>
                <button
                    class="owl-dot w-10 h-10 border-2 border-white text-white rounded-full flex justify-center items-center font-bold text-base hover:text-[#4a90e2] transition-all duration-300">3</button>
            </div>

        </div>
    </section>

    <!-- Beranda -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            mirror: true
        });
    </script>
    <!-- Beranda - Law of Proximity & Whitespace -->
    <div id="beranda" class="homepage spacing-section">
        <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12 lg:gap-16">
                <div data-aos="fade-right" data-aos-once="false" data-aos-duration="1000">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-10 animate-slideInLeft">
                        Profil Kurikulum OBE <span class="text-[#4a90e2] relative inline-block">Politala
                            <span
                                class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#1e3c72] to-[#4a90e2] transform origin-left"></span>
                        </span>
                    </h1>
                    <!-- Law of Proximity: Group related content with proper spacing -->
                    <p class="text-justify text-body-large text-gray-700 leading-relaxed spacing-element">
                        Politeknik Negeri Tanah Laut (Politala) merupakan perguruan tinggi vokasi yang berlokasi di
                        Kabupaten Tanah Laut, Provinsi Kalimantan Selatan. Politala berfokus pada pendidikan terapan
                        dengan tujuan mencetak lulusan yang kompeten, inovatif, dan siap kerja di berbagai bidang
                        industri.

                        Kampus ini memiliki berbagai program studi unggulan di bidang teknologi, pertanian, dan bisnis
                        digital, yang dirancang untuk mendukung perkembangan industri dan pembangunan daerah. Politala
                        juga aktif menjalin kerja sama dengan dunia industri serta lembaga pendidikan lain, baik di
                        dalam maupun luar negeri, guna meningkatkan kualitas pendidikan dan relevansi kompetensi lulusan
                        dengan kebutuhan pasar kerja.
                    </p>
                    <!-- Fitts's Law: Larger clickable target -->
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center btn-brand btn-large cta-primary mt-6 rounded-full shadow transition-smooth btn-soft-pulse group focus-ring"
                        aria-label="Pelajari lebih lanjut tentang website">
                        <span>Pelajari Lebih Lanjut</span>
                        <i class="ri-arrow-right-line ms-2 group-hover:translate-x-1 transition-transform text-xl"></i>
                    </a>
                </div>
                <div className="flex justify-end" data-aos="fade-left" data-aos-once="false"
                    data-aos-duration="1000">
                    <img src="/image/profil.png" alt="Hero Image" className="w-full max-w-md h-auto ml-auto" />
                </div>
            </div>
        </div>
    </div>


    {{-- visi misi --}}
    <div id="visimisi" class="gradient-bg-animated py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full opacity-10 -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full opacity-10 translate-x-1/2 translate-y-1/2">
        </div>

        <div class="max-w-5xl mx-auto relative z-10">
            <div class="text-center mb-12 animate-slideUp">
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl mb-4">Visi & Misi</h1>
                <div class="divider-gradient w-24 mx-auto mt-4"></div>
                <p class="text-white/90 mt-4 text-lg">Komitmen kami untuk masa depan pendidikan vokasi</p>
            </div>

            @if ($visis)
                <!-- Miller's Law: Chunk information for better processing -->
                <div class="bg-white rounded-xl shadow-2xl p-10 mb-12 hover-lift animate-scaleIn group-proximity"
                    data-aos="fade-up" data-aos-duration="800" role="article" aria-labelledby="visi-title">
                    <div class="flex items-center justify-center mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-[#1e3c72] to-[#2a5298] rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                    </div>
                    <h2 id="visi-title" class="text-section-title font-bold text-gray-900 text-center mb-6">Visi
                        Politala</h2>
                    <p class="text-body-large text-gray-700 leading-relaxed text-center max-w-4xl mx-auto">
                        {{ $visis->visi }}
                    </p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-2xl p-8 mb-10 text-center">
                    <p class="text-gray-500">Data visi belum tersedia.</p>
                </div>
            @endif

            <!-- Miller's Law: Organize misi in manageable chunks -->
            <div class="bg-white rounded-xl shadow-2xl p-10 hover-lift animate-scaleIn group-proximity"
                data-aos="fade-up" data-aos-duration="800" data-aos-delay="200" role="article"
                aria-labelledby="misi-title">
                <div class="flex items-center justify-center mb-6">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-[#2a5298] to-[#4a90e2] rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                </div>
                <h2 id="misi-title" class="text-section-title font-bold text-gray-900 text-center mb-8">Misi Politala
                </h2>
                @if ($misis->count() > 0)
                    <ol class="list-decimal list-outside space-y-5 text-body-large text-gray-700">
                        @foreach ($misis as $misi)
                            <!-- Von Restorff Effect: Make each item distinct with hover -->
                            <li
                                class="ml-8 leading-relaxed text-justify relative pl-3 hover:text-[#1e3c72] transition-colors hover:translate-x-1 duration-200">
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

    <!-- Program Studi - Law of Prägnanz: Clear structure -->
    <div id="prodi" class="scroll-mt-24">
        <section class="spacing-section bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
                <div class="text-center mb-12 animate-slideUp">
                    <div
                        class="inline-block p-3 bg-gradient-to-br from-[#1e3c72] to-[#2a5298] rounded-full mb-4 animate-float">
                        <i class="fas fa-graduation-cap text-white text-3xl"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-[#1e3c72] mb-3">Program Studi</h1>
                    <div class="divider-gradient w-24 mx-auto mb-4"></div>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan program studi yang sesuai dengan minat
                        dan passion Anda untuk masa depan yang cerah</p>
                </div>




                <!-- Swiper Card Slider -->
                <div class="relative swiper mySwiper pb-20" id="prodi-container">
                    <div class="swiper-wrapper ">
                        @foreach ($prodis as $prodi)
                            <div class="swiper-slide">
                                <!-- Miller's Law: Limit info per card (7±2 items) -->
                                <div class="program-card card-glass card-3d rounded-2xl shadow-lg overflow-hidden cursor-pointer border border-gray-100 group"
                                    role="article" tabindex="0">

                                    <!-- Law of Proximity: Group related header info -->
                                    <div
                                        class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] p-6 text-white group-proximity">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                                <i class="fas fa-graduation-cap text-2xl"></i>
                                            </div>
                                            <span
                                                class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $prodi->jenjang_pendidikan }}
                                            </span>
                                        </div>
                                        <h3 class="text-card-title font-bold mb-2">{{ $prodi->nama_prodi }}</h3>
                                        <p class="text-white/90 text-sm">{{ $prodi->gelar_lulusan }}</p>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6">
                                        <div class="flex items-center mb-4">
                                            <div
                                                class="bg-gradient-to-r from-[#2a5298] to-[#4a90e2] text-white px-4 py-2 rounded-full text-sm font-semibold">
                                                <i class="fas fa-award mr-2"></i>
                                                Akreditasi {{ $prodi->peringkat_akreditasi }}
                                            </div>
                                        </div>

                                        <div class="space-y-3 mb-6">
                                            <div class="flex items-center text-gray-600">
                                                <div class="bg-[#1e3c72]/10 p-2 rounded-lg mr-3">
                                                    <i class="fas fa-calendar-alt text-[#1e3c72]"></i>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-gray-500">Berdiri</span>
                                                    <p class="font-medium">
                                                        {{ date('d M Y', strtotime($prodi->tgl_berdiri_prodi)) }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center text-gray-600">
                                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                                    <i class="fas fa-phone text-[#2a5298]"></i>
                                                </div>
                                                <div>
                                                    <span class="text-sm text-gray-500">Kontak</span>
                                                    <p class="font-medium">{{ $prodi->telepon_prodi ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fitts's Law: Larger CTA button -->
                                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                            <a class="btn-brand text-white px-8 py-3 rounded-xl font-semibold transition-smooth transform hover:scale-105 btn-soft-pulse w-full text-center focus-ring"
                                                href="{{ $prodi->website_prodi ?? '#' }}" target="_blank"
                                                aria-label="Lihat detail {{ $prodi->nama_prodi }}">
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
                    <div class="swiper-button-prev !text-[#1e3c72]"></div>
                    <div class="swiper-button-next !text-[#1e3c72]"></div>

                    <!-- Pagination Bulat -->
                    <div class="swiper-pagination pt-8 mt-14 flex justify-center"></div>
                </div>
            </div>
        </section>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- Script Slider + Filter -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
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
                        640: {
                            slidesPerView: 2
                        },
                        1024: {
                            slidesPerView: 3
                        },
                        1280: {
                            slidesPerView: 4
                        },
                    }
                });
            });
        </script>

        <!-- Style Geser -->
        <style>
            .swiper-button-prev::after,
            .swiper-button-next::after {
                font-size: 20px !important;
                color: var(--brand-1) !important;
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
                background: var(--brand-1);
            }
        </style>
    </div>

    <!-- Team Kurikulum - Law of Similarity: Consistent card design -->
    <section id="team" class="spacing-section">
        <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20">
            <!-- Header -->
            <div class="text-center mb-12 animate-slideUp">
                <div
                    class="inline-block p-3 bg-gradient-to-br from-[#1e3c72] to-[#2a5298] rounded-full mb-4 animate-float">
                    <i class="fas fa-users text-white text-3xl"></i>
                </div>
                <h2 class="text-4xl font-bold text-[#1e3c72] mb-3">Team Kurikulum</h2>
                <div class="divider-gradient w-24 mx-auto mb-4"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Tim profesional yang berdedikasi dalam pengembangan
                    kurikulum berbasis OBE</p>
            </div>

            <!-- Swiper Wrapper -->
            <div class="swiper teamSwiper relative pb-10 animate-fadeIn">
                <div class="swiper-wrapper">
                    @foreach ($tim_users as $user)
                        <div class="swiper-slide">
                            <!-- Law of Common Region: Group team member info -->
                            <div class="card-glass card-3d rounded-xl overflow-hidden shadow-md w-full px-2 group-proximity hover:shadow-xl transition-shadow"
                                role="article" tabindex="0">
                                <div class="w-full h-1 bg-gradient-to-r from-[#1e3c72] to-[#4a90e2]"></div>
                                <div class="p-4">
                                    <span
                                        class="text-xs bg-green-600 text-white px-3 py-1 rounded-full shadow-sm font-medium">TEAM
                                        KURIKULUM</span>
                                    <h3 class="font-bold text-card-title text-gray-800 mt-3 mb-1">{{ $user->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-1"><i
                                            class="fas fa-university text-[#1e3c72] mr-1"></i>
                                        {{ $user->prodi?->nama_prodi ?? '-' }}</p>
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">#MerdekaBelajar</span>
                                            <span
                                                class="inline-block bg-[#4a90e2]/10 text-[#1e3c72] text-xs px-2 py-1 rounded">#KampusMerdeka</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Arrow Buttons -->
                <div class="swiper-button-prev !text-[#1e3c72]"></div>
                <div class="swiper-button-next !text-[#1e3c72]"></div>

                <!-- Pagination -->
                <div class="swiper-pagination pt-4 flex justify-center"></div>
            </div>

        </div>
    </section>

    <style>
        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 20px !important;
            color: var(--brand-1) !important;
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
            background: var(--brand-1);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
                    640: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    },
                    1280: {
                        slidesPerView: 4
                    },
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
                        <a href="https://politala.ac.id/"><img src="/image/Logo.png" class="h-24"
                                alt="Onix Digital TemplateMo" class="w-32 h-auto"></a>
                        <a href="mailto:info@company.com" class="block mb-2 mt-5 text-sm">info@politala.ac.id</a>
                    </div>

                    <div>
                        <ul class="flex space-x-4">
                            <li><a href="https://www.facebook.com/politala.ac.id"
                                    class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li><a href="https://twitter.com/humaspolitala"
                                    class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.instagram.com/politala_official/"
                                    class="text-gray-400 hover:text-white text-xl"><i
                                        class="fab fa-instagram"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UC5CfzvUTqEUPXhwwSLvP53Q"
                                    class="text-gray-400 hover:text-white text-xl"><i class="fab fa-youtube"></i></a>
                            </li>
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
                    <p class="text-gray-400 mb-4">Dapatkan informasi, Tim kami siap menjawab pertanyaan Anda via email.
                    </p>
                    <div action="#" method="get" class="flex items-center space-x-2">
                        <!-- Popup ) -->
                        <div id="popupOverlay" class=" hidden">
                            <div
                                class="fixed inset-0 bg-black bg-opacity-70 justify-center z-50 flex items-center backdrop-blur-sm">
                                <div
                                    class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-8 w-full max-w-md shadow-2xl transform transition-all animate-fadeIn">
                                    <div class="flex justify-between items-center mb-6">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                                <i class="fab fa-whatsapp text-green-600"></i> Hubungi Kami
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">Pesan akan dikirim via WhatsApp</p>
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
                                                <input type="text" id="name" name="name" required
                                                    class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3c72] 
                            focus:border-transparent transition bg-white/80 text-gray-800 placeholder-gray-400 peer"
                                                    placeholder="Nama Lengkap">
                                                <i class="fas fa-user absolute left-3 top-4 text-gray-400"></i>
                                                <label for="popupName"
                                                    class="absolute left-11 top-3 text-sm text-gray-500 transition-all 
                                      peer-focus:-top-3 peer-focus:text-xs peer-focus:text-[#1e3c72]
                                      peer-valid:-top-3 peer-valid:text-xs">
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Field Email -->
                                        <div class="relative mb-3">
                                            <div class="relative">
                                                <input type="email" id="email" name="email" required
                                                    class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3c72] 
                            focus:border-transparent transition bg-white/80 text-gray-800 placeholder-gray-400 peer"
                                                    placeholder="Alamat Email">
                                                <i class="fas fa-envelope absolute left-3 top-4 text-gray-400"></i>
                                                <label for="popupEmail"
                                                    class="absolute left-11 top-3 text-sm text-gray-500 transition-all 
                                      peer-focus:-top-3 peer-focus:text-xs peer-focus:text-[#1e3c72]
                                      peer-valid:-top-3 peer-valid:text-xs">
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Field Pesan -->
                                        <div class="relative mb-3">
                                            <div class="relative">
                                                <textarea id="message" name="message" rows="5" required
                                                    class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3c72] 
                                focus:border-transparent transition bg-white/80 text-gray-800 placeholder-gray-400 peer resize-none"
                                                    placeholder="Tulis pesan Anda..."></textarea>
                                                <i class="fas fa-comment-dots absolute left-3 top-4 text-gray-400"></i>
                                                <label for="popupMessage"
                                                    class="absolute left-11 top-3 text-sm text-gray-500 transition-all 
                                      peer-focus:-top-3 peer-focus:text-xs peer-focus:text-[#1e3c72]
                                      peer-valid:-top-3 peer-valid:text-xs">
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Tombol Submit -->
                                        <!-- Fitts's Law: Full-width submit button -->
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 btn-large cta-primary text-white rounded-xl transition-smooth transform hover:scale-[1.02] shadow-lg font-bold flex items-center justify-center gap-2 btn-soft-pulse focus-ring"
                                            aria-label="Kirim pesan via WhatsApp">
                                            <i class="fab fa-whatsapp text-xl"></i>
                                            <span class="relative">
                                                Kirim ke WhatsApp
                                                <span
                                                    class="absolute -bottom-1 left-0 w-full h-0.5 bg-white/50 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                                            </span>
                                        </button>
                                    </form>

                                    <div class="mt-6 text-center text-xs text-gray-400">
                                        <p><i class="fas fa-lock mr-1"></i>Pesan akan dikirim langsung ke WhatsApp
                                            Admin Politala</p>
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


                    <!-- Fitts's Law: Larger CTA button in footer -->


                    <button id="footerPopup" type="button"
                        class="mt-3 bg-white border-2 border-[#1e3c72] text-[#1e3c72] btn-large rounded-xl transition-smooth transform hover:scale-105 shadow-lg flex items-center btn-soft-pulse focus-ring hover:bg-[#1e3c72] hover:text-white"
                        aria-label="Hubungi kami via email">
                        <i class="fas fa-envelope mr-2 flex items-center"></i> Hubungi via WhatsApp
                    </button>


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Tangani popup hero section
                            const heroPopupBtn = document.getElementById('openPopup');
                            const footerPopupBtn = document.getElementById('footerPopup');
                            const popupOverlay = document.getElementById('popupOverlay');
                            const closePopup = document.getElementById('closePopup');
                            const emailForm = document.getElementById('emailForm');

                            // Nomor WhatsApp Admin (format internasional tanpa +)
                            const adminWhatsApp = '6285754631899';

                            function openPopup() {
                                popupOverlay.classList.remove('hidden');
                                document.body.style.overflow = 'hidden';
                            }

                            function closePopupFunc() {
                                popupOverlay.classList.add('hidden');
                                document.body.style.overflow = '';
                                emailForm.reset();
                            }

                            // Event listener untuk membuka popup
                            if (heroPopupBtn) heroPopupBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                openPopup();
                            });
                            if (footerPopupBtn) footerPopupBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                openPopup();
                            });
                            if (closePopup) closePopup.addEventListener('click', closePopupFunc);

                            popupOverlay.addEventListener('click', function(e) {
                                if (e.target === popupOverlay) {
                                    closePopupFunc();
                                }
                            });

                            // Submit form ke Laravel Backend - Auto kirim WhatsApp
                            if (emailForm) {
                                emailForm.addEventListener("submit", async function(event) {
                                    event.preventDefault();

                                    // Ambil data dari form
                                    const name = document.getElementById('name').value;
                                    const email = document.getElementById('email').value;
                                    const message = document.getElementById('message').value;

                                    // Disable button saat loading
                                    const submitBtn = emailForm.querySelector('button[type="submit"]');
                                    const originalBtnText = submitBtn.innerHTML;
                                    submitBtn.disabled = true;
                                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';

                                    try {
                                        // Kirim ke Laravel backend (akan auto kirim WhatsApp)
                                        const response = await fetch('{{ route('contact.store') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                name: name,
                                                email: email,
                                                message: message
                                            })
                                        });

                                        const data = await response.json();

                                        if (data.success) {
                                            // Sukses
                                            let successMsg = '✅ ' + data.message;
                                            if (data.email_sent) {
                                                successMsg += '\n\n✅ Notifikasi email berhasil dikirim ke admin!';
                                            } else {
                                                successMsg +=
                                                    '\n\n⚠️ Pesan tersimpan, tapi notifikasi email gagal. Admin akan melihat di dashboard.';
                                            }
                                            alert(successMsg);
                                            closePopupFunc();
                                        } else {
                                            // Error validasi
                                            let errorMsg = data.message || 'Terjadi kesalahan';
                                            if (data.errors) {
                                                errorMsg += '\n' + Object.values(data.errors).flat().join('\n');
                                            }
                                            alert('❌ ' + errorMsg);
                                        }
                                    } catch (error) {
                                        console.error('Error:', error);
                                        alert('❌ Terjadi kesalahan jaringan. Silakan coba lagi.');
                                    } finally {
                                        // Re-enable button
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = originalBtnText;
                                    }
                                });
                            }
                        });
                    </script>

                </div>

            </div>

            <!-- Enhanced JavaScript -->
            <script>
                // Throttle function for better performance
                function throttle(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Header Scroll Effect - Optimized
                const handleScroll = throttle(function() {
                    const header = document.getElementById('mainHeader');
                    if (window.scrollY > 50) {
                        header.classList.add('header-scrolled');
                    } else {
                        header.classList.remove('header-scrolled');
                    }
                }, 100);

                window.addEventListener('scroll', handleScroll, {
                    passive: true
                });

                // Smooth Scroll for Navigation Links - Enhanced
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        if (href === '#' || href === '#top') {
                            e.preventDefault();
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            return;
                        }

                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            const headerOffset = 90; // Account for fixed header
                            const elementPosition = target.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                            // Smooth scroll with requestAnimationFrame for better performance
                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });

                            // Close mobile menu if open
                            const mobileMenu = document.querySelector('[x-data]');
                            if (mobileMenu && mobileMenu.__x) {
                                mobileMenu.__x.$data.open = false;
                            }
                        }
                    });
                });

                // Scroll Reveal Animation
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -100px 0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fadeIn');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                // Observe all cards and sections
                document.addEventListener('DOMContentLoaded', function() {
                    const elementsToAnimate = document.querySelectorAll('.program-card, .card-glass');
                    elementsToAnimate.forEach(el => observer.observe(el));
                });

                // Removed Parallax Effect - Was causing scroll jank

                // Add stagger animation to cards
                document.addEventListener('DOMContentLoaded', function() {
                    const cards = document.querySelectorAll('.program-card');
                    cards.forEach((card, index) => {
                        card.style.animationDelay = `${index * 0.1}s`;
                    });
                });
            </script>

            <hr class="mt-10 border-gray-400">
            <!-- Copyright Section -->
            <div class="text-center text-sm text-gray-400 mt-8">
                <p>Copyright &copy; 2025 Kelompok 2 PBL., All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>
