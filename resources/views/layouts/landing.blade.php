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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #0F172A;
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #0F172A 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        /* Perspective for 3D effects */
        .perspective-lg {
            perspective: 1000px;
        }
        
        .preserve-3d {
            transform-style: preserve-3d;
        }

        .section-padding {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        @media (min-width: 1024px) {
            .section-padding {
                padding-top: 8rem;
                padding-bottom: 8rem;
            }
        }
    </style>
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white">
    
    <!-- Navbar -->
    @php 
        $initialNavTheme = (request()->is('solutions*') || trim($__env->yieldContent('nav_dark')) === 'true') ? 'dark' : 'light';
    @endphp

    <nav x-data="{ 
            mobileMenu: false, 
            scrolled: (window.pageYOffset > 20), 
            navTheme: '{{ $initialNavTheme }}' 
         }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'bg-white/80 backdrop-blur-xl border-b border-slate-100 shadow-sm': scrolled, 'bg-transparent': !scrolled }"
         class="fixed top-0 left-0 right-0 z-[100] transition-all duration-[400ms]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 md:h-24">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 bg-[#0F172A] rounded-xl flex items-center justify-center group-hover:rotate-6 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-xl font-[800] tracking-tighter transition-colors duration-300"
                              :class="(scrolled || navTheme === 'light') ? 'text-[#0F172A]' : 'text-white'">
                            Zytrixon<span class="text-indigo-600">.</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-10">
                    <a href="{{ route('features') }}" 
                       class="text-sm font-bold transition-all duration-300 hover:text-indigo-600"
                       :class="(scrolled || navTheme === 'light') ? 'text-slate-600' : 'text-white/90'">Features</a>
                    <a href="{{ route('solutions') }}" 
                       class="text-sm font-bold transition-all duration-300 hover:text-indigo-600"
                       :class="(scrolled || navTheme === 'light') ? 'text-slate-600' : 'text-white/90'">Solutions</a>
                    <a href="{{ route('about') }}" 
                       class="text-sm font-bold transition-all duration-300 hover:text-indigo-600"
                       :class="(scrolled || navTheme === 'light') ? 'text-slate-600' : 'text-white/90'">About</a>
                    <a href="{{ route('contact') }}" 
                       class="text-sm font-bold transition-all duration-300 hover:text-indigo-600"
                       :class="(scrolled || navTheme === 'light') ? 'text-slate-600' : 'text-white/90'">Support</a>
                </div>

                <!-- Auth -->
                <div class="hidden md:flex items-center gap-5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-700 hover:text-indigo-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-sm font-bold transition-all duration-300"
                           :class="(scrolled || navTheme === 'light') ? 'text-slate-700 hover:text-[#0F172A]' : 'text-white/90 hover:text-white'">
                           Log in
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 rounded-xl text-xs font-bold text-white hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">Get Started Free</a>
                    @endauth
                </div>

                <!-- Mobile Toggle -->
                <button @click="mobileMenu = !mobileMenu" 
                        class="md:hidden p-2 rounded-lg transition-colors duration-300"
                        :class="(scrolled || navTheme === 'light') ? 'text-slate-600 hover:bg-slate-50' : 'text-white hover:bg-white/10'">
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
             class="absolute top-full left-0 right-0 bg-white border-b border-slate-100 shadow-2xl md:hidden p-8 space-y-6">
            <a @click="mobileMenu = false" href="{{ route('features') }}" class="block text-xl font-bold text-slate-700">Features</a>
            <a @click="mobileMenu = false" href="{{ route('solutions') }}" class="block text-xl font-bold text-slate-700">Solutions</a>
            <a @click="mobileMenu = false" href="{{ route('about') }}" class="block text-xl font-bold text-slate-700">About</a>
            <a @click="mobileMenu = false" href="{{ route('contact') }}" class="block text-xl font-bold text-slate-700">Support</a>
            <hr class="border-slate-100">
            @auth
                <a href="{{ route('dashboard') }}" class="block text-xl font-bold text-indigo-600">Dashboard</a>
            @else
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('login') }}" class="flex items-center justify-center py-4 border border-slate-200 rounded-2xl font-bold text-slate-700">Log in</a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center py-4 bg-indigo-600 rounded-2xl text-white font-bold">Sign Up</a>
                </div>
            @endauth
        </div>
    </nav>

    <main class="relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20 lg:text-left">
                <div class="col-span-1 lg:col-span-1">
                    <a href="#" class="flex items-center gap-2.5 mb-8 justify-center lg:justify-start">
                        <div class="w-10 h-10 bg-[#0F172A] rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-2xl font-[900] tracking-tighter text-[#0F172A]">Zytrixon<span class="text-indigo-600">.</span></span>
                    </a>
                    <p class="text-slate-500 text-base font-medium max-w-sm mb-8 mx-auto lg:mx-0 text-center lg:text-left">
                        Advanced transport management, built for India. Empowering fleet owners with real-time intelligence.
                    </p>
                    <div class="flex gap-4 justify-center lg:justify-start">
                        <a href="#" class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all text-slate-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="text-center lg:text-left">
                    <h4 class="font-bold text-[#0F172A] mb-8 uppercase tracking-widest text-[10px]">Product</h4>
                    <ul class="space-y-4 text-slate-500 text-sm font-bold">
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 transition">Fleet Features</a></li>
                        <li><a href="{{ route('solutions') }}" class="hover:text-indigo-600 transition">Enterprise Solutions</a></li>
                        <li><a href="#" class="text-emerald-600">Free Forever Plan</a></li>
                    </ul>
                </div>
                <div class="text-center lg:text-left">
                    <h4 class="font-bold text-[#0F172A] mb-8 uppercase tracking-widest text-[10px]">Company</h4>
                    <ul class="space-y-4 text-slate-500 text-sm font-bold">
                        <li><a href="{{ route('about') }}" class="hover:text-indigo-600 transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 transition">Contact Support</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-indigo-600 transition">Help Center</a></li>
                    </ul>
                </div>
                <div class="text-center lg:text-left">
                    <h4 class="font-bold text-[#0F172A] mb-8 uppercase tracking-widest text-[10px]">Legal</h4>
                    <ul class="space-y-4 text-slate-500 text-sm font-bold">
                        <li><a href="#" class="hover:text-indigo-600 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-slate-500 text-sm font-medium">&copy; {{ date('Y') }} Zytrixon Tech. All rights reserved.</p>
                <div class="flex items-center gap-2 group">
                    <span class="text-slate-500 text-sm font-medium">Made with</span>
                    <svg class="w-4 h-4 text-rose-500 group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    <span class="text-slate-500 text-sm font-medium">in India</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Reveal on Scroll Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>

    <style>
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</body>
</html>
