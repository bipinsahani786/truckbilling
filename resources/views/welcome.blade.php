<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zytrixon Tech - Indian Truck Billing & Fleet Management</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes rotateIn { from { opacity: 0; transform: rotate(-5deg); } to { opacity: 1; transform: rotate(0); } }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
        .animate-slide-left { animation: slideInLeft 0.8s ease-out forwards; opacity: 0; }
        .animate-slide-right { animation: slideInRight 0.8s ease-out forwards; opacity: 0; }
        .animate-rotate-in { animation: rotateIn 0.8s ease-out forwards; opacity: 0; }
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-600 { animation-delay: 600ms; }
        .hover-scale { transition: transform 0.3s ease-in-out; }
        .hover-scale:hover { transform: scale(1.05); }
        .hover-rotate { transition: transform 0.3s ease-in-out; }
        .hover-rotate:hover { transform: rotate(2deg); }
    </style>
</head>
<body class="antialiased font-sans bg-[#FFFAF0] text-slate-800">

    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <div class="flex-shrink-0 flex items-center">
                <span class="text-3xl font-black tracking-tighter text-emerald-700">Zytrixon<span class="text-amber-500">Tech</span></span>
            </div>

            <div class="hidden md:flex items-center space-x-6">
                <a href="#features" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition" wire:navigate>Features</a>
                <a href="#solutions" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition" wire:navigate>Mobile App</a>
                <a href="#pricing" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition" wire:navigate>Pricing</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition" wire:navigate>Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition" wire:navigate>Log in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-2.5 bg-amber-500 rounded-full font-black text-xs text-slate-900 uppercase tracking-widest hover:bg-amber-400 hover:shadow-lg transition transform hover:-translate-y-0.5" wire:navigate>Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="relative overflow-hidden bg-[#FFFAF0]">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-amber-200 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-emerald-200 rounded-full blur-3xl opacity-50"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1 text-center md:text-left animate-slide-left">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-600 text-sm font-bold mb-6">
                    <span class="flex w-2 h-2 rounded-full bg-rose-600 mr-2 animate-ping"></span> Live Kharchi Tracking
                </div>
                <h1 class="text-5xl md:text-7xl tracking-tighter font-black text-slate-900 leading-tight">
                    Desi Transport, <br> <span class="text-emerald-600">Digital Hisab.</span>
                </h1>
                <p class="mt-6 text-xl text-slate-700 max-w-2xl mx-auto md:mx-0 font-medium">
                    India ka sabse smart Truck Billing aur Logistics Software. Driver advance, toll, diesel, aur net profit ka pura hisab ab aapki ungliyon par.
                </p>
                <div class="mt-12 flex flex-col sm:flex-row justify-center md:justify-start gap-5">
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-amber-500 rounded-full font-black text-lg text-slate-900 hover:bg-amber-400 hover:shadow-xl hover-scale transition" wire:navigate>
                        Start Your Free Trial
                    </a>
                    <a href="#demo" class="px-10 py-4 bg-white border-2 border-slate-200 rounded-full font-bold text-lg text-slate-800 hover:border-emerald-600 hover:text-emerald-600 transition">
                        Watch Demo
                    </a>
                </div>
            </div>
            <div class="flex-1 flex justify-center items-center animate-slide-right delay-200">
                <div class="relative w-full max-w-lg">
                    <img src="https://img.daisyui.com/images/stock/photo-1559703248-dcaaec9fab78.webp" alt="Professional Interface Mockup" class="w-full h-auto rounded-3xl shadow-2xl border-4 border-white animate-rotate-in delay-600" />
                    <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-2xl shadow-xl animate-bounce">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xl">₹</div>
                            <div>
                                <p class="text-xs text-slate-500 font-bold uppercase">Trip Profit</p>
                                <p class="text-lg font-black text-slate-900">+₹45,200</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="features" class="bg-white py-24 md:py-32 border-t border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in">
            <span class="text-sm font-black text-rose-600 uppercase tracking-widest">Fleet Optimization</span>
            <h2 class="mt-4 text-5xl font-black text-slate-900 tracking-tighter max-w-2xl mx-auto">Har Truck Ki Puri Kundli</h2>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-[#FFFAF0] p-8 rounded-3xl border border-amber-100 hover:shadow-xl hover:border-amber-300 transition duration-300 transform animate-fade-in hover:scale-105">
                <div class="w-16 h-16 inline-flex items-center justify-center rounded-2xl bg-amber-200 text-amber-700 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Driver Kharchi</h3>
                <p class="text-slate-600 font-medium">Advance aur raste ke kharche ka 100% accurate settlement.</p>
            </div>
            <div class="bg-[#FFFAF0] p-8 rounded-3xl border border-amber-100 hover:shadow-xl hover:border-emerald-300 transition duration-300 transform animate-fade-in animation-delay-200 hover:scale-105">
                <div class="w-16 h-16 inline-flex items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">POD & Bilty</h3>
                <p class="text-slate-600 font-medium">Driver directly app se bill aur bilty ki photo upload karega.</p>
            </div>
            <div class="bg-[#FFFAF0] p-8 rounded-3xl border border-amber-100 hover:shadow-xl hover:border-rose-300 transition duration-300 transform animate-fade-in animation-delay-400 hover:scale-105">
                <div class="w-16 h-16 inline-flex items-center justify-center rounded-2xl bg-rose-100 text-rose-600 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Fastag & Fuel</h3>
                <p class="text-slate-600 font-medium">Owner aur driver ke expenses ko alag-alag track karein.</p>
            </div>
            <div class="bg-[#FFFAF0] p-8 rounded-3xl border border-amber-100 hover:shadow-xl hover:border-emerald-300 transition duration-300 transform animate-fade-in animation-delay-600 hover:scale-105">
                <div class="w-16 h-16 inline-flex items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Profit Analytics</h3>
                <p class="text-slate-600 font-medium">Kaunsa truck kitna kama raha hai, ek click me PDF report.</p>
            </div>
        </div>
    </section>

    <section id="solutions" class="bg-emerald-800 py-24 md:py-32 flex flex-col gap-24 overflow-hidden relative">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#F59E0B 2px, transparent 2px); background-size: 30px 30px;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-16 items-center">
            <div class="animate-slide-left hover-rotate">
                <img src="https://img.daisyui.com/images/stock/photo-1559703248-dcaaec9fab78.webp" alt="Driver App" class="w-full h-auto rounded-3xl shadow-2xl border-4 border-emerald-600" />
            </div>
            <div class="animate-slide-right delay-200">
                <span class="text-sm font-black text-amber-400 uppercase tracking-widest">Driver Mobile App</span>
                <h2 class="mt-4 text-5xl font-black text-white leading-tight">Driver Ka Kaam Asaan, <br> Malik Ki Tension Khatam.</h2>
                <p class="mt-6 text-xl text-emerald-100 font-medium">Driver directly app me apne toll, diesel, aur police expenses record karega. Aapko live dashboard par dikhega ki wallet me kitna balance bacha hai.</p>
                <a href="{{ route('register') }}" class="mt-10 inline-flex items-center gap-2.5 px-8 py-3 bg-amber-500 rounded-full font-black text-slate-900 hover:bg-amber-400 hover:shadow-lg transition" wire:navigate>
                    See How It Works
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <section id="pricing" class="bg-[#FFFAF0] py-24 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in">
            <span class="text-sm font-black text-rose-600 uppercase tracking-widest">Pricing</span>
            <h2 class="mt-4 text-5xl font-black text-slate-900 tracking-tighter max-w-2xl mx-auto">Sahi Daam, Pura Kaam</h2>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            
            <div class="bg-white p-10 rounded-3xl shadow-lg border border-amber-100 transition duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in hover:scale-105">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Single Truck</h3>
                <p class="mt-2 text-slate-600 font-medium">Chote transport owners ke liye.</p>
                <div class="mt-8 flex items-baseline">
                    <span class="text-5xl font-black text-emerald-700 tracking-tight">₹499</span>
                    <span class="ml-1 text-base font-bold text-slate-500">/ mo</span>
                </div>
                <ul class="mt-10 space-y-4 text-sm font-bold text-slate-700">
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> 1 Truck Allowed</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Driver Wallet</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Standard Reports</li>
                </ul>
                <a href="{{ route('register') }}" class="mt-10 block text-center px-8 py-3 bg-slate-100 rounded-full font-black text-slate-900 hover:bg-slate-200 transition" wire:navigate>Select Plan</a>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-2xl border-4 border-amber-500 relative transition duration-300 hover:-translate-y-2 animate-fade-in animation-delay-200 hover:scale-105">
                <div class="absolute -top-5 right-10 px-5 py-2 bg-rose-600 rounded-full text-xs font-black text-white uppercase tracking-widest shadow-md">Bestseller</div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Fleet Owner</h3>
                <p class="mt-2 text-slate-600 font-medium">Bade transport business ke liye.</p>
                <div class="mt-8 flex items-baseline">
                    <span class="text-5xl font-black text-emerald-700 tracking-tight">₹1499</span>
                    <span class="ml-1 text-base font-bold text-slate-500">/ mo</span>
                </div>
                <ul class="mt-10 space-y-4 text-sm font-bold text-slate-700">
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Up to 15 Trucks</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Advanced Analytics</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Driver Mobile App</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Automated Invoicing</li>
                </ul>
                <a href="{{ route('register') }}" class="mt-10 block text-center px-8 py-3 bg-amber-500 rounded-full font-black text-slate-900 hover:bg-amber-400 hover:shadow-lg transition" wire:navigate>Select Plan</a>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-lg border border-amber-100 transition duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in animation-delay-400 hover:scale-105">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Enterprise</h3>
                <p class="mt-2 text-slate-600 font-medium">15+ trucks aur custom needs ke liye.</p>
                <div class="mt-8 flex items-baseline">
                    <span class="text-4xl font-black text-emerald-700 tracking-tight">Custom</span>
                </div>
                <ul class="mt-10 space-y-4 text-sm font-bold text-slate-700">
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Unlimited Trucks</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Dedicated Support</li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Custom Expenses</li>
                </ul>
                <a href="#contact" class="mt-10 block text-center px-8 py-3 bg-slate-100 rounded-full font-black text-slate-900 hover:bg-slate-200 transition">Contact Us</a>
            </div>
        </div>
    </section>

    <section class="bg-amber-500 py-24 md:py-32 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-rose-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-200"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in">
            <h2 class="text-5xl font-black text-slate-900 tracking-tighter max-w-2xl mx-auto">Aaj Hi Apna Business Digital Karein!</h2>
            <p class="mt-6 text-xl text-slate-800 font-bold max-w-3xl mx-auto">Zytrixon Tech ke sath apna pura fleet manage karna shuru karein, wo bhi ekdum asaan tarike se.</p>
            <a href="{{ route('register') }}" class="mt-12 inline-flex items-center gap-2.5 px-12 py-5 bg-slate-900 rounded-full font-black text-lg text-white hover:bg-slate-800 hover:shadow-2xl transition transform hover:-translate-y-1" wire:navigate>
                Create Free Account
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    </section>

    <footer id="contact" class="bg-slate-900 pt-20 pb-12 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-12 text-center sm:text-left">
            <div class="col-span-2 md:col-span-1">
                <span class="text-3xl font-black tracking-tighter text-white">Zytrixon<span class="text-amber-500">Tech</span></span>
                <p class="mt-4 text-sm font-medium text-slate-400 max-w-sm mx-auto sm:mx-0">Proudly built in Patna, India <br> for the global transport industry.</p>
            </div>
            <div>
                <h4 class="font-bold text-white mb-5 uppercase tracking-widest text-sm">Product</h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a href="#features" class="hover:text-amber-400 transition">Features</a></li>
                    <li><a href="#pricing" class="hover:text-amber-400 transition">Pricing Plans</a></li>
                    <li><a href="#" class="hover:text-amber-400 transition">Driver App</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-5 uppercase tracking-widest text-sm">Company</h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a href="#" class="hover:text-amber-400 transition">About Us</a></li>
                    <li><a href="#" class="hover:text-amber-400 transition">Contact Support</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-5 uppercase tracking-widest text-sm">Legal</h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a href="#" class="hover:text-amber-400 transition">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-amber-400 transition">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-10 border-t border-slate-800 text-center flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm font-medium">&copy; {{ date('Y') }} Zytrixon Tech. All rights reserved.</p>
            <p class="text-slate-500 text-sm font-medium flex items-center gap-1">Made with <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg> in India</p>
        </div>
    </footer>

</body>
</html>