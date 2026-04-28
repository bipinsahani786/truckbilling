@extends('layouts.landing')

@section('title', 'System Features - JMD TRUCK MANAGEMENT Intelligence')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative min-h-[70vh] flex items-center pt-32 pb-20 overflow-hidden bg-dribbble-base">
        <!-- Ambient Glows -->
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-rose-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full text-center">
            <div class="reveal group">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4 transition-all duration-500 group-hover:tracking-[0.4em]">
                    Enterprise Capabilities
                </h2>
                <h1 class="text-5xl lg:text-7xl font-[900] text-white leading-tight mb-8 tracking-tighter">
                    Built for the <br> <span class="text-indigo-500">Road Ahead.</span>
                </h1>
                <p class="text-xl text-dribbble-muted max-w-2xl mx-auto leading-relaxed mb-10">
                    Explore the deep feature set that makes JMD TRUCK MANAGEMENT the preferred choice for forward-thinking transport companies in India.
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE FEATURES GRID -->
    <section class="py-24 relative bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Financial Mastery -->
                <div class="group glass-card p-10 rounded-[2.5rem] hover:border-indigo-500/50 transition-all duration-500 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 group-hover:scale-110">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-dribbble-light mb-4 tracking-tight">Financial Mastery</h3>
                    <p class="text-dribbble-muted font-medium leading-relaxed mb-8">Automate your entire trip ledger. Track advances, fuel expenses, and net margins with 100% accuracy.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 text-[10px] italic">01</span>
                            Instant Trip Settlement
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 text-[10px] italic">02</span>
                            Driver Wallet History
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 text-[10px] italic">03</span>
                            Party-Wise Ledgers
                        </li>
                    </ul>
                </div>

                <!-- Smooth Operations -->
                <div class="group glass-card p-10 rounded-[2.5rem] hover:border-rose-500/50 transition-all duration-500 reveal delay-100">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center mb-8 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500 group-hover:scale-110">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-dribbble-light mb-4 tracking-tight">Smooth Operations</h3>
                    <p class="text-dribbble-muted font-medium leading-relaxed mb-8">Manage your fleet like a pro. Document tracking and real-time dispatch updates for your whole team.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-rose-500/20 flex items-center justify-center text-rose-400 text-[10px] italic">01</span>
                            Digital Bilty & POD
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-rose-500/20 flex items-center justify-center text-rose-400 text-[10px] italic">02</span>
                            Vehicle Document Alerts
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-rose-500/20 flex items-center justify-center text-rose-400 text-[10px] italic">03</span>
                            Multi-User Permissions
                        </li>
                    </ul>
                </div>

                <!-- Driver App -->
                <div class="group glass-card p-10 rounded-[2.5rem] hover:border-emerald-500/50 transition-all duration-500 reveal delay-200">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-8 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500 group-hover:scale-110">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-dribbble-light mb-4 tracking-tight">The Driver App</h3>
                    <p class="text-dribbble-muted font-medium leading-relaxed mb-8">Empower your drivers with a dedicated mobile interface. They report expenses, you approve in seconds.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-[10px] italic">01</span>
                            Expense Photo Uploads
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-[10px] italic">02</span>
                            Real-time Notifications
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-dribbble-light/80">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-[10px] italic">03</span>
                            Simplified UI in Hindi
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- PREMIUM IMAGE CARDS (TEMPLATES) -->
    <section class="py-32 relative bg-[#0A0C14] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Enterprise Templates</h2>
                <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
                    Advanced tools for <br> high-volume fleets.
                </h3>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                
                <!-- Large Template 1: Fleet Tracking -->
                <div class="group relative rounded-[3rem] overflow-hidden glass-card border border-white/5 bg-white/5 reveal">
                    <div class="aspect-[16/10] overflow-hidden">
                        <img src="{{ asset('fleet_tracking_map_dark_premium_1776661644338.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Fleet Tracking">
                    </div>
                    <div class="p-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h4 class="text-3xl font-black text-white mb-2">Live Fleet Intelligence</h4>
                                <p class="text-indigo-400 font-bold uppercase tracking-widest text-xs">Real-Time GPS & Telematics</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            </div>
                        </div>
                        <p class="text-dribbble-muted font-medium leading-relaxed mb-8">
                            Monitor every move with precision. Our integrated map template provides live breadcrumb trails, speed alerts, and geofencing for your entire fleet on a single unified screen.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-dribbble-light">Live Updates</span>
                            <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-dribbble-light">Geofencing</span>
                            <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-dribbble-light">Route History</span>
                        </div>
                    </div>
                </div>

                <!-- Large Template 2: Fuel Management -->
                <div class="group relative rounded-[3rem] overflow-hidden glass-card border border-white/5 bg-white/5 reveal delay-100">
                    <div class="aspect-[16/10] overflow-hidden">
                        <img src="{{ asset('fuel_analytics_dashboard_dark_1776661675987.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Fuel Analytics">
                    </div>
                    <div class="p-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h4 class="text-3xl font-black text-white mb-2">Fuel Efficiency AI</h4>
                                <p class="text-rose-400 font-bold uppercase tracking-widest text-xs">Cost Optimization & Analytics</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-rose-500/20 border border-rose-500/30 flex items-center justify-center text-rose-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <p class="text-dribbble-muted font-medium leading-relaxed mb-8">
                            Stop fuel leakage and optimize consumption. Our AI-driven template analyzes mileage patterns, identifies high-consumption routes, and tracks refueling costs in real-time.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-dribbble-light">Mileage Tracking</span>
                            <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-dribbble-light">Theft Detection</span>
                            <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-bold text-dribbble-light">Vendor Portals</span>
                        </div>
                    </div>
                </div>

                <!-- Large Template 3: Secure Vault -->
                <div class="group relative rounded-[3rem] overflow-hidden glass-card border border-white/5 bg-white/5 reveal lg:col-span-2">
                    <div class="grid md:grid-cols-2 gap-10 p-10 lg:p-16 items-center">
                        <div class="order-2 md:order-1">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <p class="text-emerald-400 font-bold uppercase tracking-widest text-sm">Security & Compliance</p>
                            </div>
                            <h4 class="text-4xl lg:text-5xl font-black text-white mb-6 leading-tight">Digital Document Vault</h4>
                            <p class="text-dribbble-muted text-lg font-medium leading-relaxed mb-8">
                                Keep your fleet compliant 24/7. Store permits, insurance, fitness certificates, and tax documents in an encrypted vault with automated expiry alerts sent directly to your phone.
                            </p>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                                    <p class="text-white font-bold mb-1">AES-256</p>
                                    <p class="text-xs text-dribbble-muted uppercase tracking-wider font-medium">Encryption</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                                    <p class="text-white font-bold mb-1">99.9%</p>
                                    <p class="text-xs text-dribbble-muted uppercase tracking-wider font-medium">Uptime</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-1 md:order-2 rounded-[2.5rem] overflow-hidden border border-white/10 shadow-2xl shadow-emerald-500/10">
                            <img src="{{ asset('document_vault_secure_dark_1776661659288.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="Document Vault">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- DASHBOARD PREVIEW SECTION (REUSED FROM WELCOME FOR CONSISTENCY) -->
    <section class="py-32 relative overflow-hidden bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-7xl mx-auto px-6 text-center reveal">
            <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Command Center</h2>
            <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight mb-16">
                Advanced Reporting for <br> Data-Driven Decisions.
            </h3>
            
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="flex-1 text-left">
                    <p class="text-dribbble-muted font-medium text-lg leading-relaxed mb-12">
                        Stop guessing which trucks or routes are profitable. Our deep analytics engine processes every rupee to give you the truth.
                    </p>
                    
                    <div class="space-y-8">
                        <div class="group flex items-start gap-6">
                            <div class="mt-1 w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-black text-dribbble-light text-lg mb-1">Consolidated P&L Statements</h5>
                                <p class="text-dribbble-muted text-sm font-medium leading-relaxed">Monthly and yearly profit and loss reports tailored for Indian transporters.</p>
                            </div>
                        </div>
                        <div class="group flex items-start gap-6">
                            <div class="mt-1 w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-black text-dribbble-light text-lg mb-1">Customizable Dashboards</h5>
                                <p class="text-dribbble-muted text-sm font-medium leading-relaxed">Pin the metrics that matter most to your specific business model.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 w-full rounded-[3rem] overflow-hidden glass-card border border-white/10 shadow-2xl bg-dribbble-base/40 p-4 transition-transform duration-700 hover:scale-[1.02]">
                    <img src="{{ asset('zytrixon_logistics_dashboard_3d_1773676710969.png') }}" class="w-full h-auto rounded-[2.5rem]" alt="Reporting dashboard">
                </div>
            </div>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="py-32 relative overflow-hidden bg-[#05060A] border-y border-dribbble-line/30">
        <!-- Subtle Grid Background -->
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(rgba(144,150,165,0.3)_1.5px,transparent_1.5px)] [background-size:32px_32px]"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
            <h2 class="text-4xl lg:text-6xl font-[900] text-dribbble-light tracking-tight mb-8">
                Experience all these <br> <span class="text-indigo-400">features for yourself.</span>
            </h2>
            <p class="text-dribbble-muted text-lg lg:text-xl mb-12 max-w-2xl mx-auto font-medium leading-relaxed">
                Join thousands of modern fleet owners who use JMD TRUCK MANAGEMENT to power their daily operations.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-12 py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)] hover:shadow-[0_0_50px_rgba(79,70,229,0.5)] hover:-translate-y-1">
                    Start Free Test Drive
                </a>
                <a href="{{ route('contact') }}" class="w-full sm:w-auto px-12 py-5 bg-white/5 border border-white/10 text-dribbble-light rounded-2xl font-black text-lg hover:bg-white/10 transition-all hover:-translate-y-1">
                    Talk to Sales
                </a>
            </div>
        </div>
    </section>
@endsection
