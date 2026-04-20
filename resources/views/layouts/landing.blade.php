<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Zytrixon')) - Professional Fleet Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Tailwind Configuration for Dark Theme -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            },
            colors: {
              dribbble: {
                base: '#0A0C14',
                card: '#303A4C',
                line: '#565A6C',
                muted: '#9096A5',
                light: '#EBEBEB',
              }
            }
          }
        }
      }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0A0C14;
            color: #EBEBEB;
            overflow-x: hidden;
        }

        /* Glassmorphism Utilities */
        .glass-panel {
            background: rgba(10, 12, 20, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(86, 90, 108, 0.3);
        }

        .glass-card {
            background: rgba(48, 58, 76, 0.25);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(86, 90, 108, 0.4);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(48, 58, 76, 0.4);
            border-color: rgba(144, 150, 165, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px -12px rgba(0,0,0,0.5);
        }

        /* Ambient Glows */
        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(10, 12, 20, 0) 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        /* Floating Animations */
        @keyframes float-soft {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes float-medium {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float-soft {
            animation: float-soft 5s ease-in-out infinite;
        }
        .animate-float-medium {
            animation: float-medium 6s ease-in-out infinite;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .perspective-lg {
            perspective: 1000px;
        }
        
        .preserve-3d {
            transform-style: preserve-3d;
        }

        /* Smooth Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal.active, .reveal.reveal-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        /* Moving Road Live Animation */
        .moving-road-container {
            position: relative;
            overflow: hidden;
        }
        .moving-road-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: repeating-linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0px, rgba(99, 102, 241, 0.15) 40px, transparent 40px, transparent 80px);
            background-size: 80px 100%;
            animation: moveRoad 1s linear infinite;
            opacity: 0.6;
        }
        @keyframes moveRoad {
            0% { background-position: 0 0; }
            100% { background-position: -80px 0; }
        }
        
        /* Summer Day Backgrounds */
        .summer-day-footer {
            position: relative;
            overflow: hidden;
            background: radial-gradient(ellipse at bottom, #fde047 0%, #ea580c 40%, #9a3412 100%);
        }
        
        /* Night Scene Backgrounds */
        .night-scene-footer {
            position: relative;
            overflow: hidden;
            background: radial-gradient(ellipse at bottom, #1b2735 0%, #05060A 100%);
        }
        .footer-stars {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(1px 1px at 20px 30px, #eee, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 40px 70px, #fff, rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 50px 160px, #ddd, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 90px 40px, #fff, rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 130px 80px, #fff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 160px 120px, #ddd, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 200px 200px;
            animation: twinkle 4s infinite alternate;
            opacity: 0.5;
            z-index: 0;
            pointer-events: none;
        }
        @keyframes twinkle {
            0% { opacity: 0.3; transform: scale(1); }
            100% { opacity: 0.8; transform: scale(1.02); }
        }

        /* Winding Road Doodle */
        .footer-road-doodle {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 200%;
            height: 150px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 120' preserveAspectRatio='none'%3E%3Cpath d='M0 60 Q 100 0, 200 60 T 400 60' fill='none' stroke='rgba(99,102,241,0.1)' stroke-width='10'/%3E%3Cpath d='M0 60 Q 100 0, 200 60 T 400 60' fill='none' stroke='rgba(255,255,255,0.2)' stroke-width='3' stroke-dasharray='15,15'/%3E%3C/svg%3E");
            background-repeat: repeat-x;
            background-size: 400px 120px;
            animation: moveFooterRoad 5s linear infinite;
            z-index: 0;
            pointer-events: none;
        }
        @keyframes moveFooterRoad {
            0% { transform: translateX(0); }
            100% { transform: translateX(-400px); }
        }
        
        /* Moon Doodle */
        .footer-moon {
            position: absolute;
            top: 15%;
            right: 15%;
            width: 80px;
            height: 80px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 10 A40 40 0 1 0 90 50 A30 30 0 0 1 50 10 Z' fill='rgba(255, 255, 255, 0.6)'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0.8;
            z-index: 0;
            pointer-events: none;
            animation: moonFloat 8s ease-in-out infinite alternate;
        }
        @keyframes moonFloat {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-15px) rotate(5deg); }
        }
        .summer-day-footer {
            position: relative;
            overflow: hidden;
            background: radial-gradient(ellipse at bottom, #fde047 0%, #ea580c 40%, #9a3412 100%);
        }
        .footer-sun {
            position: absolute;
            top: 15%;
            right: 15%;
            width: 100px;
            height: 100px;
            background-color: #fef08a;
            border-radius: 50%;
            box-shadow: 0 0 60px 30px rgba(254, 240, 138, 0.6);
            opacity: 0.9;
            z-index: 0;
            pointer-events: none;
            animation: sunPulse 6s ease-in-out infinite alternate;
        }
        @keyframes sunPulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.05); opacity: 1; }
        }

        /* Straight Plain Road */
        .footer-road-straight {
            position: absolute;
            bottom: 25px;
            left: 0;
            width: 200%;
            height: 6px;
            background-image: linear-gradient(90deg, transparent 20%, rgba(255,255,255,0.7) 20%, rgba(255,255,255,0.7) 80%, transparent 80%);
            background-size: 80px 6px;
            animation: moveFooterRoadStraight 1s linear infinite;
            z-index: 0;
            pointer-events: none;
        }
        @keyframes moveFooterRoadStraight {
            0% { transform: translateX(0); }
            100% { transform: translateX(-80px); }
        }

        /* Truck Doodle */
        .footer-truck {
            position: absolute;
            bottom: 30px;
            left: 20%;
            width: 120px;
            height: 60px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 60'%3E%3Cpath d='M10 20 L80 20 L80 50 L10 50 Z' fill='none' stroke='rgba(255,255,255,0.9)' stroke-width='3' stroke-linejoin='round'/%3E%3Cpath d='M80 30 L100 30 L110 40 L110 50 L80 50' fill='none' stroke='rgba(255,255,255,0.9)' stroke-width='3' stroke-linejoin='round'/%3E%3Cpath d='M85 32 L98 32 L105 40 L85 40 Z' fill='none' stroke='rgba(255,255,255,0.9)' stroke-width='2'/%3E%3Ccircle cx='30' cy='50' r='6' fill='none' stroke='rgba(255,255,255,0.9)' stroke-width='3'/%3E%3Ccircle cx='90' cy='50' r='6' fill='none' stroke='rgba(255,255,255,0.9)' stroke-width='3'/%3E%3Cpath d='M5 30 L-10 30 M5 40 L-5 40' fill='none' stroke='rgba(255,255,255,0.6)' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            animation: truckBounce 0.4s infinite alternate;
            z-index: 1;
            pointer-events: none;
        }
        @keyframes truckBounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-3px); }
        }

        .header-moon {
            position: absolute;
            top: -20px;
            right: 10%;
            width: 80px;
            height: 80px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 10 A40 40 0 1 0 90 50 A30 30 0 0 1 50 10 Z' fill='rgba(255, 255, 255, 0.6)'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0;
            transition: all 0.8s ease;
            transform: scale(0.5) rotate(-20deg);
            z-index: 0;
            pointer-events: none;
            animation: moonFloat 8s ease-in-out infinite alternate;
        }
        
        .is-night .header-moon {
            opacity: 0.6;
            transform: scale(1) rotate(0deg);
        }
        
        .is-night .footer-sun {
            opacity: 0 !important;
            transform: scale(0.5) translateY(-20px);
        }

        .footer-sun {
            transition: all 0.8s ease;
        }

        /* Global Letter Pop Styles */
        .letter {
            display: inline-block;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            white-space: pre;
        }
        .letter:hover {
            transform: translateY(-8px) scale(1.4) rotate(8deg);
            color: #818cf8 !important;
            text-shadow: 0 10px 20px rgba(129, 140, 248, 0.5);
            z-index: 50;
            position: relative;
        }

        /* AI Nav Effect */
        .ai-nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .ai-nav-link::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #818cf8, transparent);
            transition: all 0.4s ease;
            transform: translateX(-50%);
            box-shadow: 0 0 12px rgba(129, 140, 248, 0.8);
            opacity: 0;
        }
        .ai-nav-link:hover::after {
            width: 100%;
            opacity: 1;
        }
        .ai-nav-link:hover {
            color: #818cf8 !important;
            text-shadow: 0 0 10px rgba(129, 140, 248, 0.5);
            transform: translateY(-1px);
        }

        /* AI Background Effect */
        .header-ai-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            z-index: 0;
        }

        nav:hover .header-ai-bg {
            opacity: 0.3;
        }

        /* AI Scan Animation */
        .header-ai-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, rgba(129, 140, 248, 0.1), transparent);
            height: 200%;
            top: -100%;
            animation: aiScan 4s linear infinite;
        }

        @keyframes aiScan {
            0% { transform: translateY(-50%); }
            100% { transform: translateY(50%); }
        }
    </style>
</head>
<body class="antialiased selection:bg-indigo-500/30 selection:text-white relative">
    
    <!-- Navbar -->
    <nav x-data="{ mobileMenu: false, scrolled: false, isNight: false }" 
         x-init="
            window.addEventListener('scroll', () => {
                const el = document.elementFromPoint(window.innerWidth / 2, 100);
                if (el) {
                    const style = window.getComputedStyle(el);
                    const color = style.backgroundColor;
                    const rgb = color.match(/\d+/g);
                    if (rgb) {
                        const brightness = (rgb[0] * 299 + rgb[1] * 587 + rgb[2] * 114) / 1000;
                        isNight = brightness < 128;
                    }
                }
            })
         "
         @scroll.window="
             scrolled = (window.pageYOffset > 20);
         "
         :class="{ 
             'bg-white/10 backdrop-blur-3xl border-white/20 shadow-2xl': scrolled, 
             'bg-white/5 backdrop-blur-xl border-white/10': !scrolled,
             'is-night': isNight
         }"
         class="fixed top-4 left-4 right-4 z-[100] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] border rounded-xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.3)] moving-road-container group">
        
        <!-- AI Hidden Background -->
        <div class="header-ai-bg"></div>
        
        <!-- Header Summer Background Elements -->
        <div class="footer-sun" style="top: -20px; right: 10%; width: 80px; height: 80px; opacity: 0.5;"></div>
        <div class="header-moon"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="flex items-center justify-between h-20 md:h-24 transition-none">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                        <!-- Modern Geometric Icon -->
                        <div class="relative w-10 h-10 flex items-center justify-center">
                            <div class="absolute inset-0 bg-indigo-600 rounded-xl rotate-6 group-hover:rotate-12 transition-all duration-500 shadow-lg shadow-indigo-600/20"></div>
                            <div class="absolute inset-0 bg-[#0A0C14]/80 backdrop-blur-sm rounded-xl border border-white/10 transition-transform duration-500"></div>
                            <svg class="relative z-10 w-6 h-6 text-white group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <!-- Branded Typography -->
                        <span class="font-[900] tracking-tighter text-white uppercase text-2xl md:text-3xl transition-all duration-500 group-hover:text-indigo-400">
                            ZYTRIXON
                        </span>
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-10">
                    <a href="{{ route('welcome') }}" class="text-[15px] font-black uppercase tracking-widest text-dribbble-light ai-nav-link">Home</a>
                    <a href="{{ Route::has('features') ? route('features') : '#features' }}" class="text-[15px] font-black uppercase tracking-widest text-dribbble-light ai-nav-link">Features</a>
                    <a href="{{ Route::has('solutions') ? route('solutions') : '#solutions' }}" class="text-[15px] font-black uppercase tracking-widest text-dribbble-light ai-nav-link">Solutions</a>
                    <a href="#fleet" class="text-[15px] font-black uppercase tracking-widest text-dribbble-light ai-nav-link">Fleet</a>
                    <a href="{{ Route::has('contact') ? route('contact') : '#contact' }}" class="text-[15px] font-black uppercase tracking-widest text-dribbble-light ai-nav-link">Support</a>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-indigo-600 rounded-lg text-[13px] font-black uppercase tracking-widest text-white hover:bg-indigo-500 transition-all duration-300 shadow-md shadow-indigo-600/20">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-white/10 border border-white/20 rounded-lg text-[13px] font-black uppercase tracking-widest text-white hover:bg-white/20 transition-all duration-300">Sign In</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 rounded-lg text-[13px] font-black uppercase tracking-widest text-white hover:bg-indigo-500 transition-all duration-300 shadow-md shadow-indigo-600/30">Start Free</a>
                    @endauth
                </div>

                <!-- Mobile Toggle -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg text-dribbble-light hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" x-show="!mobileMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg class="w-6 h-6" x-show="mobileMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-cloak
             class="absolute top-full left-0 right-0 bg-dribbble-base border-b border-dribbble-line/30 shadow-2xl md:hidden p-8 space-y-6">
            <a @click="mobileMenu = false" href="{{ route('features') ?? '#features' }}" class="block text-xl font-bold text-dribbble-light">Features</a>
            <a @click="mobileMenu = false" href="{{ route('solutions') ?? '#' }}" class="block text-xl font-bold text-dribbble-light">Solutions</a>
            <a @click="mobileMenu = false" href="{{ route('about') ?? '#' }}" class="block text-xl font-bold text-dribbble-light">About</a>
            <a @click="mobileMenu = false" href="{{ route('contact') ?? '#' }}" class="block text-xl font-bold text-dribbble-light">Support</a>
            <hr class="border-dribbble-line/30">
            @auth
                <a href="{{ route('dashboard') }}" class="block text-xl font-bold text-indigo-400">Dashboard</a>
            @else
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('login') }}" class="flex items-center justify-center py-4 border border-dribbble-line rounded-2xl font-bold text-dribbble-light hover:bg-dribbble-card/30">Log in</a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center py-4 bg-indigo-600 rounded-2xl text-white font-bold hover:bg-indigo-500 shadow-[0_0_20px_rgba(79,70,229,0.3)]">Sign Up</a>
                </div>
            @endauth
        </div>
    </nav>

    <main class="relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="night-scene-footer pt-16 pb-8 relative z-10 border-t border-white/10">
        <!-- Night Scene Background Elements -->
        <div class="footer-stars"></div>
        <div class="footer-moon"></div>
        <div class="footer-road-doodle"></div>
        <div class="footer-truck"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-12 mb-16">
                
                <div class="md:col-span-1">
                    <a href="#" class="text-2xl font-black text-dribbble-light flex items-center gap-2 mb-4 tracking-tight">
                    <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    Zytrixon
                    </a>
                    <p class="text-dribbble-muted text-sm font-medium leading-relaxed">
                    Premium logistics and billing software designed for the modern transport network.
                    </p>
                </div>

                <div>
                    <h4 class="text-dribbble-light font-bold mb-4 uppercase tracking-wider text-xs">Platform</h4>
                    <ul class="space-y-3">
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Features</a></li>
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Pricing</a></li>
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Integrations</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-dribbble-light font-bold mb-4 uppercase tracking-wider text-xs">Company</h4>
                    <ul class="space-y-3">
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">About Us</a></li>
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Careers</a></li>
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Legal Info</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-dribbble-light font-bold mb-4 uppercase tracking-wider text-xs">Support</h4>
                    <ul class="space-y-3">
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Help Center</a></li>
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Terms of Use</a></li>
                    <li><a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors text-sm font-medium">Security</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-dribbble-light font-bold mb-4 uppercase tracking-wider text-xs">Connect</h4>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center gap-2 text-dribbble-muted text-xs font-medium">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"></path></svg>
                            +91 98765 43210
                        </li>
                        <li class="flex items-center gap-2 text-dribbble-muted text-xs font-medium">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"></path></svg>
                            +91 88888 77777
                        </li>
                        <li class="flex items-center gap-2 text-dribbble-muted text-xs font-medium">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            support@zytrixon.com
                        </li>
                    </ul>
                    <div class="flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-dribbble-muted hover:text-white hover:bg-indigo-600 transition-all border border-white/5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-dribbble-muted hover:text-white hover:bg-indigo-600 transition-all border border-white/5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-2.201c0-1.137.496-1.799 1.795-1.799h2.205v-4.403c-.382-.046-1.693-.197-3.218-.197-3.186 0-5.382 1.944-5.382 5.538v3.063z"></path></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-dribbble-muted hover:text-white hover:bg-emerald-600 transition-all border border-white/5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.589.943 3.133 1.415 4.742 1.416 5.469 0 9.92-4.45 9.924-9.922.002-2.652-1.029-5.145-2.903-7.02-1.873-1.874-4.366-2.904-7.019-2.906-5.471 0-9.92 4.45-9.924 9.922 0 1.799.487 3.506 1.409 4.953l-.922 3.357 3.468-.91-.075-.09zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-dribbble-muted hover:text-white hover:bg-sky-500 transition-all border border-white/5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path></svg>
                        </a>
                    </div>
                </div>

            </div>

            <div class="border-t border-dribbble-line/20 pt-8 text-center md:flex md:justify-between md:items-center">
                <p class="text-dribbble-muted text-sm font-medium mb-4 md:mb-0">
                    &copy; {{ date('Y') }} Zytrixon Inc. All rights reserved.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                    </a>
                    <a href="#" class="text-dribbble-muted hover:text-dribbble-light transition-colors">
                        <span class="sr-only">GitHub</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Letterize Global Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectors = 'h1, h2, h3, h4, h5, h6, p, a:not(:has(svg)), button:not(:has(svg)), .text-xl, .text-lg';
            const elements = document.querySelectorAll(selectors);

            elements.forEach(el => {
                // Skip if it's already letterized or inside an ignored container
                if (el.closest('.moving-road-container') || el.closest('svg') || el.querySelector('.letter')) return;

                // Handle text nodes
                const processNode = (node) => {
                    if (node.nodeType === 3) { // Text node
                        const text = node.textContent;
                        if (!text.trim()) return;

                        const fragment = document.createDocumentFragment();
                        text.split('').forEach(char => {
                            const span = document.createElement('span');
                            span.textContent = char;
                            if (char.trim()) {
                                span.className = 'letter';
                            }
                            fragment.appendChild(span);
                        });
                        node.parentNode.replaceChild(fragment, node);
                    } else if (node.nodeType === 1) { // Element node
                        if (node.tagName === 'BR') return;
                        Array.from(node.childNodes).forEach(processNode);
                    }
                };

                Array.from(el.childNodes).forEach(processNode);
            });

            // Reveal on Scroll Logic
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible', 'active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
