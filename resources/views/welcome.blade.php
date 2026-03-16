@extends('layouts.landing')

@section('title', 'Zytrixon - Next-Gen Fleet Management')

@section('content')
    <!-- Hero Section -->
    <header class="relative min-h-[95vh] flex items-center overflow-hidden pt-32 lg:pt-40">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-[500px] h-[500px] bg-slate-900/5 rounded-full blur-[100px]"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
                
                <!-- Left Content -->
                <div class="flex-1 text-center lg:text-left reveal">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-bold tracking-widest uppercase mb-8">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                        Introducing Zytrixon v2.0
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-[900] tracking-tight leading-[1.05] mb-8 text-gradient">
                        Precision Fleet <br> <span class="text-indigo-600 underline decoration-indigo-200 decoration-8 underline-offset-4">Intelligence.</span>
                    </h1>
                    
                    <p class="text-slate-600 text-lg lg:text-xl font-medium leading-relaxed max-w-xl mb-12">
                        India's most sophisticated logistics platform. Now <span class="text-indigo-600 font-bold">100% Free for Everyone.</span> Automate dispatch, track expenses, and maximize profit with ease.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 hover:-translate-y-1">
                            Start Free Now
                        </a>
                        <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 text-slate-700 rounded-2xl font-bold hover:border-slate-400 transition-all hover:-translate-y-1">
                            Explore Features
                        </a>
                    </div>

                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-6 grayscale opacity-60">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Trusted By</span>
                        <div class="flex gap-8 items-center font-black text-slate-800 text-xl tracking-tighter">
                            <span>TRANSIT.</span>
                            <span>LOGIX.</span>
                            <span>FLEETCO.</span>
                        </div>
                    </div>
                </div>

                <!-- Right 3D Mockup -->
                <div class="flex-1 relative perspective-lg reveal hidden lg:block" style="transition-delay: 200ms;">
                    <div class="relative preserve-3d group transition-transform duration-700 hover:rotate-y-12 hover:-rotate-x-6">
                        <!-- Main Card -->
                        <div class="relative bg-white p-4 rounded-[2.5rem] shadow-[0_50px_100px_rgba(15,23,42,0.12)] border border-white">
                            <img src="{{ asset('zytrixon_hero_3d_truck_1773676669765.png') }}" 
                                 class="w-full h-auto rounded-[1.8rem] shadow-sm transform transition-transform group-hover:translate-z-10" 
                                 alt="Modern Truck Interface">
                        </div>

                        <!-- Floating Badge 1 -->
                        <div class="absolute -top-12 -right-6 animate-float" style="animation-delay: 1s;">
                            <div class="bg-indigo-600 text-white p-5 rounded-3xl shadow-2xl shadow-indigo-200">
                                <p class="text-[10px] font-bold uppercase tracking-wider mb-1">Live Profit</p>
                                <p class="text-2xl font-[900]">₹84,200</p>
                            </div>
                        </div>

                        <!-- Floating Badge 2 -->
                        <div class="absolute -bottom-10 -left-10 animate-float">
                            <div class="bg-white p-6 rounded-3xl shadow-2xl shadow-slate-200 border border-slate-50 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900">Mileage Optimized</p>
                                    <p class="text-sm font-bold text-slate-500">+12% this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Stats Bar -->
    <section class="py-12 bg-white relative z-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 py-10 px-8 rounded-[2rem] bg-slate-50 border border-slate-100 reveal">
                <div class="text-center lg:border-r border-slate-200 last:border-0">
                    <p class="text-4xl font-[900] text-indigo-600 mb-1">10k+</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Trucks</p>
                </div>
                <div class="text-center lg:border-r border-slate-200 last:border-0">
                    <p class="text-4xl font-[900] text-indigo-600 mb-1">₹50Cr+</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Processed Monthly</p>
                </div>
                <div class="text-center lg:border-r border-slate-200 last:border-0">
                    <p class="text-4xl font-[900] text-indigo-600 mb-1">99.9%</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Data Accuracy</p>
                </div>
                <div class="text-center last:border-0">
                    <p class="text-4xl font-[900] text-indigo-600 mb-1">24/7</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Indian Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Features Section -->
    <section id="features" class="section-padding relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <h2 class="text-sm font-black text-indigo-600 tracking-[0.2em] uppercase mb-4">Enterprise Features</h2>
                <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-slate-900 tracking-tight">Everything you need to <br> manage 1 or 1,000 trucks.</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 hover:border-indigo-400 hover:shadow-2xl hover:shadow-indigo-50 transition-all duration-500 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-extrabold text-[#0F172A] mb-4">Driver Wallets</h4>
                    <p class="text-slate-500 font-medium leading-relaxed">Give drivers a digital wallet for fuels, tolls, and maintenance. Track balances & expenses instantly.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 hover:border-indigo-400 hover:shadow-2xl hover:shadow-indigo-50 transition-all duration-500 reveal" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2a4 4 0 00-4-4H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-extrabold text-[#0F172A] mb-4">Profit Center</h4>
                    <p class="text-slate-500 font-medium leading-relaxed">Deep analytics for every trip. Compare routes, drivers, and vehicles to find your true profit margins.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 hover:border-indigo-400 hover:shadow-2xl hover:shadow-indigo-50 transition-all duration-500 reveal" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-xl font-extrabold text-[#0F172A] mb-4">Multi-Party Billing</h4>
                    <p class="text-slate-500 font-medium leading-relaxed">Complex Bilty handling made easy. Manage multiple parties with automated ledger entries per trip.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Animated CTA Section -->
    <section class="section-padding bg-[#0F172A] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1.5px,transparent_1.5px)] [background-size:32px_32px]"></div>
        
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center relative z-10 reveal">
            <h2 class="text-4xl lg:text-6xl font-[900] text-white tracking-tight mb-8">
                Ready to transform your <br> <span class="text-indigo-400">transport business?</span>
            </h2>
            <p class="text-slate-400 text-lg lg:text-xl mb-12 max-w-2xl mx-auto">
                Join thousands of modern fleet owners who use Zytrixon to power their daily operations.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ route('register') }}" class="px-12 py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-2xl shadow-indigo-900/50 hover:-translate-y-1">
                    Start Now - It's Free
                </a>
                <a href="{{ route('contact') }}" class="px-12 py-5 bg-white/5 border border-white/10 text-white rounded-2xl font-black text-lg hover:bg-white/10 transition-all">
                    Talk to Sales
                </a>
            </div>
        </div>
    </section>
@endsection