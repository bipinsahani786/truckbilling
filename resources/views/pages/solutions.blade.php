@extends('layouts.landing')

@section('title', 'Zytrixon Solutions - Tailored for Logistics')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative min-h-[70vh] flex items-center pt-32 pb-20 overflow-hidden bg-dribbble-base">
        <!-- Ambient Glows -->
        <div class="absolute top-1/4 -right-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-1/4 -left-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full text-center lg:text-left">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Left Content -->
                <div class="flex-1 reveal">
                    <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Targeted Automation</h2>
                    <h1 class="text-5xl lg:text-7xl font-[900] text-white leading-[1.1] mb-8 tracking-tighter">
                        Solutions for <br> <span class="text-indigo-500">Every Scale.</span>
                    </h1>
                    <p class="text-xl text-dribbble-muted max-w-2xl leading-relaxed mb-10">
                        From single truck owners to pan-India logistics giants, we have the right automation for you. Tailored workflows that fit your business model.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-start gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-600 text-white px-10 py-4 rounded-2xl text-lg font-black hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)]">Find Your Solution</a>
                        <a href="{{ route('contact') }}" class="w-full sm:w-auto bg-white/5 border border-white/10 text-white px-10 py-4 rounded-2xl text-lg font-black hover:bg-white/10 transition-all">Talk to an Expert</a>
                    </div>
                </div>
                <!-- Right Visual (Dashboard Preview) -->
                <div class="flex-1 reveal hidden lg:block" style="transition-delay: 200ms;">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-indigo-500/20 blur-[60px] rounded-full group-hover:bg-indigo-500/30 transition-all duration-700"></div>
                        <div class="relative glass-card p-4 rounded-[3rem] border border-white/10 backdrop-blur-2xl shadow-2xl transition-transform duration-700 hover:scale-[1.02]">
                            <img src="{{ asset('zytrixon_logistics_dashboard_3d_1773676710969.png') }}" class="w-full h-auto rounded-[2.5rem]" alt="Solutions Dashboard">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SCALE SECTIONS (DETAILED SOLUTIONS) -->
    <section class="py-24 relative bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-7xl mx-auto px-6 relative z-10 space-y-40">
            
            <!-- Individual Owners Solution -->
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="flex-1 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-8">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4 inline-block">Small Business</h2>
                    <h3 class="text-3xl lg:text-5xl font-[900] text-white mb-6 tracking-tight">Individual Truck Owners</h3>
                    <p class="text-dribbble-muted font-medium text-lg leading-relaxed mb-10">Stop managing your business from a pocket diary. Zytrixon helps you transition to a digital system where every expense is recorded instantly on your phone.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        <div class="p-5 rounded-2xl glass-card border border-white/5 hover:border-indigo-500/30 transition-all">
                            <h5 class="text-white font-black mb-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                Mobile Diary
                            </h5>
                            <p class="text-dribbble-muted text-sm font-medium">Capture expenses at the pump or toll gate instantly.</p>
                        </div>
                        <div class="p-5 rounded-2xl glass-card border border-white/5 hover:border-indigo-500/30 transition-all">
                            <h5 class="text-white font-black mb-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                WhatsApp Share
                            </h5>
                            <p class="text-dribbble-muted text-sm font-medium">Send digital LRs and payment reminders via WhatsApp.</p>
                        </div>
                    </div>
                    <ul class="space-y-4 text-dribbble-light/80 font-bold">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                            100% Free Forever for Solo Owners
                        </li>
                    </ul>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="group relative">
                        <div class="absolute -inset-4 bg-indigo-500/10 blur-2xl rounded-[4rem] group-hover:bg-indigo-500/20 transition-all"></div>
                        <div class="relative rounded-[3rem] overflow-hidden border border-white/10 shadow-2xl">
                            <img src="{{ asset('solo_operator_mobile_solution_dark_1776662214953.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="Solo Owner Solution">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fleet Management Solution -->
            <div class="flex flex-col lg:flex-row-reverse items-center gap-20">
                <div class="flex-1 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center mb-8">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h2 class="text-xs font-black text-rose-400 tracking-[0.2em] uppercase mb-4 inline-block">Enterprise Growth</h2>
                    <h3 class="text-3xl lg:text-5xl font-[900] text-white mb-6 tracking-tight">Medium & Large Fleets</h3>
                    <p class="text-dribbble-muted font-medium text-lg leading-relaxed mb-10">When you have 20+ trucks, visibility becomes a nightmare. Zytrixon centralizes your operations with advanced driver-wallet management and multi-party ledgers.</p>
                    
                    <div class="space-y-6">
                        <div class="p-6 glass-card border border-white/5 rounded-3xl hover:border-rose-500/30 transition-all group">
                            <div class="flex items-center gap-4 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/10 flex items-center justify-center text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h5 class="text-white font-black">Corporate Party Billing</h5>
                            </div>
                            <p class="text-dribbble-muted text-sm font-medium pl-12">Auto-generate professional invoices for corporate clients with complex GST handling and credit terms tracking.</p>
                        </div>
                        <div class="p-6 glass-card border border-white/5 rounded-3xl hover:border-rose-500/30 transition-all group">
                            <div class="flex items-center gap-4 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/10 flex items-center justify-center text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <h5 class="text-white font-black">Staff Roles & Permissions</h5>
                            </div>
                            <p class="text-dribbble-muted text-sm font-medium pl-12">Assign branch managers, dispatchers, and accountants with custom access levels to protect your data.</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="group relative">
                        <div class="absolute -inset-4 bg-rose-500/10 blur-2xl rounded-[4rem] group-hover:bg-rose-500/20 transition-all"></div>
                        <div class="relative rounded-[3rem] overflow-hidden border border-white/10 shadow-2xl">
                            <img src="{{ asset('enterprise_fleet_management_solution_dark_1776662233480.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="Enterprise Fleet Solution">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3PL & Brokerage Solution -->
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="flex-1 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-8">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h2 class="text-xs font-black text-emerald-400 tracking-[0.2em] uppercase mb-4 inline-block">Intermediary Focus</h2>
                    <h3 class="text-3xl lg:text-5xl font-[900] text-white mb-6 tracking-tight">3PL & Brokerage</h3>
                    <p class="text-dribbble-muted font-medium text-lg leading-relaxed mb-10">Manage complex multi-party interactions without losing track of your commissions. Our broker-specific template handles supplier and customer ledgers simultaneously.</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 glass-card border border-white/5 rounded-3xl">
                            <p class="text-2xl font-black text-white mb-1">99%</p>
                            <p class="text-xs text-dribbble-muted uppercase tracking-wider font-bold">Accuracy in Settlement</p>
                        </div>
                        <div class="p-6 glass-card border border-white/5 rounded-3xl">
                            <p class="text-2xl font-black text-white mb-1">0%</p>
                            <p class="text-xs text-dribbble-muted uppercase tracking-wider font-bold">Missing PODs</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="group relative">
                        <div class="absolute -inset-4 bg-emerald-500/10 blur-2xl rounded-[4rem] group-hover:bg-emerald-500/20 transition-all"></div>
                        <div class="relative rounded-[3rem] overflow-hidden border border-white/10 shadow-2xl">
                            <img src="{{ asset('broker_3pl_logistics_solution_dark_1776662251727.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="Brokerage Solution">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- SPECIALIZED SOLUTIONS (EXTRA TEMPLATES) -->
    <section class="py-32 relative bg-[#05060A] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Specialized Industries</h2>
                <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
                    Customized for your <br> specific cargo.
                </h3>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                
                <!-- Extra Template 1: Cold Chain -->
                <div class="group glass-card rounded-[3rem] overflow-hidden border border-white/5 bg-white/5 reveal">
                    <div class="h-64 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base to-transparent z-10"></div>
                        <img src="{{ asset('cold_chain_logistics_solution_dark_1776662278303.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Cold Chain Solution">
                        <div class="absolute top-6 left-6 z-20">
                            <span class="px-4 py-2 bg-blue-500/20 border border-blue-500/30 rounded-xl text-[10px] font-black text-blue-400 uppercase tracking-widest backdrop-blur-md">Cold Chain</span>
                        </div>
                    </div>
                    <div class="p-10">
                        <h4 class="text-2xl font-black text-white mb-4">Temperature Sensitive</h4>
                        <p class="text-dribbble-muted font-medium leading-relaxed mb-8">
                            Integrated IoT sensor data for real-time temperature monitoring. Prevent spoilage with instant alerts for temperature fluctuations and compressor failures.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-indigo-400 font-bold hover:text-indigo-300 transition-colors">
                            Request Demo
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Extra Template 2: Express Delivery -->
                <div class="group glass-card rounded-[3rem] overflow-hidden border border-white/5 bg-white/5 reveal delay-100">
                    <div class="h-64 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base to-transparent z-10"></div>
                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Express Delivery">
                        <div class="absolute top-6 left-6 z-20">
                            <span class="px-4 py-2 bg-rose-500/20 border border-rose-500/30 rounded-xl text-[10px] font-black text-rose-400 uppercase tracking-widest backdrop-blur-md">Express</span>
                        </div>
                    </div>
                    <div class="p-10">
                        <h4 class="text-2xl font-black text-white mb-4">Last-Mile Optimization</h4>
                        <p class="text-dribbble-muted font-medium leading-relaxed mb-8">
                            High-frequency dispatch tools for local delivery fleets. Smart route sequencing to minimize turnaround time and maximize daily deliveries per vehicle.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-rose-400 font-bold hover:text-rose-300 transition-colors">
                            Request Demo
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="py-32 relative overflow-hidden bg-dribbble-base border-t border-dribbble-line/20">
        <!-- Subtle Moving Road for Solutions -->
        <div class="moving-road-container h-1 opacity-20 absolute top-0 inset-x-0">
            <div class="moving-road-bg"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
            <h2 class="text-4xl lg:text-5xl font-[900] text-dribbble-light tracking-tight mb-8">
                Ready to find the right <br> <span class="text-indigo-400">solution for you?</span>
            </h2>
            <p class="text-dribbble-muted text-lg lg:text-xl mb-12 max-w-2xl mx-auto font-medium">
                Our experts are here to help you choose the right path for your transport business growth.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('contact') }}" class="w-full sm:w-auto px-12 py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)] hover:-translate-y-1">
                    Schedule Free Consultation
                </a>
                <a href="{{ route('welcome') }}" class="w-full sm:w-auto px-12 py-5 bg-white/5 border border-white/10 text-dribbble-light rounded-2xl font-black text-lg hover:bg-white/10 transition-all">
                    Explore Platform
                </a>
            </div>
        </div>
    </section>
@endsection
