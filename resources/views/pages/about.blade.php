@extends('layouts.landing')

@section('title', 'About Zytrixon - Mission and Vision')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative min-h-[70vh] flex items-center pt-32 pb-20 overflow-hidden bg-dribbble-base">
        <!-- Ambient Glows -->
        <div class="absolute top-1/4 -right-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-1/4 -left-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full text-center">
            <div class="reveal group">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4 transition-all duration-500 group-hover:tracking-[0.4em]">
                    Our Identity
                </h2>
                <h1 class="text-5xl lg:text-7xl font-[900] text-white leading-tight mb-8 tracking-tighter">
                    Digitizing the Pulse of <br> <span class="text-indigo-500">Indian Transport.</span>
                </h1>
                <p class="text-xl text-dribbble-muted max-w-2xl mx-auto leading-relaxed mb-10">
                    We are on a mission to bring technology to every fleet owner across India, making operations transparent, efficient, and highly profitable.
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- STORY SECTION -->
    <section class="py-24 relative bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="flex-1 reveal">
                    <h2 class="text-xs font-black text-rose-400 tracking-[0.2em] uppercase mb-4">Our Roots</h2>
                    <h3 class="text-3xl lg:text-5xl font-[900] text-white mb-8 tracking-tight">From Bihar to the Nation.</h3>
                    <p class="text-dribbble-muted text-lg font-medium leading-relaxed mb-8">
                        Zytrixon started in the heart of Bihar, where we saw transport owners struggling with lost bills, driver management, and inaccurate ledgers. We realized that simple technology could solve massive headaches for small fleet owners.
                    </p>
                    <p class="text-dribbble-muted text-lg font-medium leading-relaxed mb-10">
                        Today, we've grown into a modern platform that serves businesses across Patna, Delhi, and Mumbai, providing enterprise-grade fleet intelligence to everyone.
                    </p>
                    
                    <div class="flex items-center gap-6 p-6 glass-card rounded-3xl border border-white/5">
                        <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400 text-xl font-black italic">
                            IN
                        </div>
                        <div>
                            <h5 class="text-white font-black">Proudly Made in India</h5>
                            <p class="text-dribbble-muted text-xs font-medium uppercase tracking-widest">Built for local challenges</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="group relative">
                        <div class="absolute -inset-4 bg-indigo-500/10 blur-2xl rounded-[4rem] group-hover:bg-indigo-500/20 transition-all duration-700"></div>
                        <div class="relative rounded-[3.5rem] overflow-hidden border border-white/10 shadow-2xl transition-transform duration-700 group-hover:scale-[1.02]">
                            <img src="{{ asset('zytrixon_hero_3d_truck_1773676669765.png') }}" class="w-full h-full object-cover" alt="Zytrixon Vision">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES (TEMPLATES) -->
    <section class="py-32 relative bg-[#05060A] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Core Principles</h2>
                <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
                    Values that drive us forward.
                </h3>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Technical Foundation Card -->
                <div class="group glass-card rounded-[2.5rem] overflow-hidden border border-white/5 bg-white/5 reveal transition-all duration-500 hover:border-indigo-500/30">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ asset('technical_foundation_about_dark_1776662794439.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Technical Foundation">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base/90 to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h4 class="text-2xl font-black text-white">Innovation</h4>
                        </div>
                    </div>
                    <div class="p-8">
                        <p class="text-dribbble-muted text-sm font-medium leading-relaxed">
                            We leverage cutting-edge cloud architecture and AI to build tools that are not just fast, but intelligent enough to predict your business needs.
                        </p>
                    </div>
                </div>

                <!-- Nationwide Network Card -->
                <div class="group glass-card rounded-[2.5rem] overflow-hidden border border-white/5 bg-white/5 reveal delay-100 transition-all duration-500 hover:border-rose-500/30">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ asset('nationwide_logistics_network_dark_1776662812118.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Nationwide Network">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base/90 to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h4 class="text-2xl font-black text-white">Scale</h4>
                        </div>
                    </div>
                    <div class="p-8">
                        <p class="text-dribbble-muted text-sm font-medium leading-relaxed">
                            From local routes in Bihar to nationwide operations, our infrastructure is built to handle the sheer scale of the Indian logistics market.
                        </p>
                    </div>
                </div>

                <!-- Empowerment Card -->
                <div class="group glass-card rounded-[2.5rem] overflow-hidden border border-white/5 bg-white/5 reveal delay-200 transition-all duration-500 hover:border-emerald-500/30">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ asset('empowering_fleet_owners_impact_dark_1776662829785.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Empowerment">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base/90 to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <h4 class="text-2xl font-black text-white">Empowerment</h4>
                        </div>
                    </div>
                    <div class="p-8">
                        <p class="text-dribbble-muted text-sm font-medium leading-relaxed">
                            Our ultimate goal is to put power back into the hands of fleet owners, giving them the data they need to negotiate better and grow faster.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FINAL CTA (REUSED FROM WELCOME) -->
    <section class="py-32 relative overflow-hidden bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
            <h2 class="text-4xl lg:text-5xl font-[900] text-dribbble-light tracking-tight mb-8">
                Join the <span class="text-indigo-400">logistics revolution.</span>
            </h2>
            <p class="text-dribbble-muted text-lg lg:text-xl mb-12 max-w-2xl mx-auto font-medium leading-relaxed">
                Experience the power of Zytrixon and see why thousands of transporters trust us with their daily operations.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-12 py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)] hover:-translate-y-1">
                    Start Now - It's Free
                </a>
                <a href="{{ route('features') }}" class="w-full sm:w-auto px-12 py-5 bg-white/5 border border-white/10 text-dribbble-light rounded-2xl font-black text-lg hover:bg-white/10 transition-all hover:-translate-y-1">
                    See Features
                </a>
            </div>
        </div>
    </section>
@endsection
