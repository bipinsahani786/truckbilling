@extends('layouts.landing')

@section('title', 'JMD TRUCK MANAGEMENT - Next-Gen Fleet Management')

@section('content')

<!-- HERO SECTION -->
<section class="relative min-h-[90vh] flex items-center pt-32 pb-24 lg:pt-48 lg:pb-32 overflow-hidden">
  <!-- Background Image with Overlay -->
  <div class="absolute inset-0 z-0">
    <!-- Using a high-quality Unsplash image as a placeholder for the truck at sunset -->
    <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?q=80&w=2075&auto=format&fit=crop" class="w-full h-full object-cover object-center" alt="Modern Truck at Sunset">
    <div class="absolute inset-0 bg-gradient-to-r from-[#0A0C14]/90 via-[#0A0C14]/50 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0C14] via-transparent to-[#0A0C14]/40"></div>
  </div>

  <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
    
    <!-- Hero Copy -->
    <div class="max-w-3xl reveal group">
      <h2 class="text-sm font-semibold tracking-widest text-dribbble-light/80 uppercase mb-4 transition-all duration-500 group-hover:text-indigo-400 group-hover:translate-x-2">
        Fleet Intelligence
      </h2>
      
      <h1 id="hero-title" class="text-5xl lg:text-6xl font-bold text-white leading-[1.1] mb-6 cursor-default">
        Smart Logistics.<br>
        Now 100% Free.
      </h1>
      
      <p class="text-xl text-dribbble-light/80 mb-10 max-w-xl leading-relaxed transition-all duration-500 group-hover:text-white group-hover:translate-x-1 cursor-default">
        Automate dispatch and maximize your profit.
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-start gap-4">
        <button class="w-full sm:w-auto bg-indigo-600 text-white px-8 py-3.5 rounded-lg text-base font-medium hover:bg-indigo-500 transition-all duration-300 shadow-lg shadow-indigo-600/30">
          Start Free Now
        </button>
        <button class="w-full sm:w-auto bg-transparent border border-white/40 text-white px-8 py-3.5 rounded-lg text-base font-medium hover:bg-white/10 transition-all duration-300">
          Explore Features
        </button>
      </div>
    </div>

  </div>
</section>

<!-- STATS BAR -->
<section class="relative z-20 -mt-10 mb-12">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 py-10 px-8 rounded-[2.5rem] glass-card shadow-2xl reveal delay-100 bg-dribbble-base/80">
      <div class="text-center lg:border-r border-dribbble-line/50 last:border-0">
        <p class="text-4xl font-[900] text-indigo-400 mb-2">10k+</p>
        <p class="text-xs font-bold text-dribbble-muted uppercase tracking-widest">Active Trucks</p>
      </div>
      <div class="text-center lg:border-r border-dribbble-line/50 last:border-0">
        <p class="text-4xl font-[900] text-indigo-400 mb-2">₹50Cr+</p>
        <p class="text-xs font-bold text-dribbble-muted uppercase tracking-widest">Processed Monthly</p>
      </div>
      <div class="text-center lg:border-r border-dribbble-line/50 last:border-0">
        <p class="text-4xl font-[900] text-indigo-400 mb-2">99.9%</p>
        <p class="text-xs font-bold text-dribbble-muted uppercase tracking-widest">Data Accuracy</p>
      </div>
      <div class="text-center last:border-0">
        <p class="text-4xl font-[900] text-indigo-400 mb-2">24/7</p>
        <p class="text-xs font-bold text-dribbble-muted uppercase tracking-widest">Indian Support</p>
      </div>
    </div>
  </div>
</section>

<!-- CORE FEATURES SECTION -->
<section id="features" class="py-24 relative overflow-hidden bg-dribbble-base border-t border-dribbble-line/20">
  <div class="max-w-7xl mx-auto px-6 relative z-10">
    
    <div class="text-center max-w-3xl mx-auto mb-20 reveal">
      <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Enterprise Features</h2>
      <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
        Everything you need to <br> manage 1 or 1,000 trucks.
      </h3>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      
      <!-- Feature 1: Driver Wallets -->
      <div class="group glass-card p-10 rounded-[2.5rem] hover:border-indigo-500/50 hover:bg-dribbble-card/40 transition-all duration-500 reveal">
        <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 group-hover:scale-110">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h4 class="text-xl font-extrabold text-dribbble-light mb-4">Driver Wallets</h4>
        <p class="text-dribbble-muted font-medium leading-relaxed">Give drivers a digital wallet for fuels, tolls, and maintenance. Track balances & expenses instantly.</p>
      </div>

      <!-- Feature 2: Profit Center -->
      <div class="group glass-card p-10 rounded-[2.5rem] hover:border-rose-500/50 hover:bg-dribbble-card/40 transition-all duration-500 reveal delay-100">
        <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center mb-8 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500 group-hover:scale-110">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2a4 4 0 00-4-4H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <h4 class="text-xl font-extrabold text-dribbble-light mb-4">Profit Center</h4>
        <p class="text-dribbble-muted font-medium leading-relaxed">Deep analytics for every trip. Compare routes, drivers, and vehicles to find your true profit margins.</p>
      </div>

      <!-- Feature 3: Multi-Party Billing -->
      <div class="group glass-card p-10 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-dribbble-card/40 transition-all duration-500 reveal delay-200">
        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-8 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500 group-hover:scale-110">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h4 class="text-xl font-extrabold text-dribbble-light mb-4">Multi-Party Billing</h4>
        <p class="text-dribbble-muted font-medium leading-relaxed">Complex Bilty handling made easy. Manage multiple parties with automated ledger entries per trip.</p>
      </div>

    </div>
  </div>
</section>

<!-- DASHBOARD PREVIEW SECTION -->
<section class="py-32 lg:py-48 relative overflow-hidden bg-[#0A0C14]">
  <div class="max-w-7xl mx-auto px-6 text-center reveal">
    <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Command Center</h2>
    <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight mb-16">
      Complete visibility over your entire operations.
    </h3>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        @keyframes scan {
            0% { left: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { left: 100%; opacity: 0; }
        }
        .animate-scan {
            animation: scan 3s linear infinite;
        }
    </style>
    
    <div class="group relative w-full rounded-[2.5rem] overflow-hidden glass-card border border-white/10 shadow-[0_20px_60px_-15px_rgba(79,70,229,0.3)] bg-[#0A0C14]/80 aspect-video flex transition-transform duration-700 hover:scale-[1.02] cursor-pointer">
        <!-- Animated Glowing Background Blob -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/30 rounded-full blur-[100px] animate-blob"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-rose-500/20 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>

        <!-- Sidebar Mockup -->
        <div class="w-1/4 h-full border-r border-white/5 bg-white/5 backdrop-blur-md p-6 flex flex-col gap-6 relative z-10 hidden md:flex">
            <!-- Logo area -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center animate-pulse">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-white font-black tracking-widest uppercase text-sm">JMD TRUCK MANAGEMENT</span>
            </div>
            
            <!-- Menu Items -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-white/10 text-white font-medium text-xs">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </div>
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg text-dribbble-muted hover:text-white hover:bg-white/5 transition-colors font-medium text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Live Dispatch
                </div>
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg text-dribbble-muted hover:text-white hover:bg-white/5 transition-colors font-medium text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Billing & Invoices
                </div>
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg text-dribbble-muted hover:text-white hover:bg-white/5 transition-colors font-medium text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Driver Wallets
                </div>
            </div>
            
            <div class="mt-auto p-4 bg-gradient-to-t from-indigo-500/20 to-transparent rounded-xl border border-indigo-500/20">
                <p class="text-[10px] text-indigo-300 font-bold uppercase tracking-wider mb-1">System Status</p>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <p class="text-xs font-medium text-white">All Systems Operational</p>
                </div>
            </div>
        </div>

        <!-- Main Content Mockup -->
        <div class="w-full md:w-3/4 h-full p-6 md:p-8 flex flex-col gap-6 relative z-10 text-left">
            <!-- Top Nav Mockup -->
            <div class="flex justify-between items-center w-full">
                <div>
                    <h4 class="text-white font-bold text-lg">Fleet Overview</h4>
                    <p class="text-xs text-dribbble-muted font-medium">Welcome back! Here's your fleet's live status.</p>
                </div>
                <div class="flex gap-4 items-center">
                    <div class="h-8 w-8 bg-white/10 rounded-full flex items-center justify-center text-dribbble-light">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 bg-white/10 rounded-full py-1 pl-1 pr-3">
                        <div class="h-6 w-6 bg-indigo-500 rounded-full flex items-center justify-center text-[10px] text-white font-bold">Admin</div>
                        <span class="text-xs text-white font-medium">Rajesh K.</span>
                    </div>
                </div>
            </div>
            
            <!-- Stats Row Mockup -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                <div class="h-24 md:h-28 bg-white/5 rounded-2xl border border-white/5 p-4 flex flex-col justify-end group-hover:bg-white/10 transition-colors duration-500 relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs text-dribbble-muted font-bold uppercase tracking-wider mb-1">Total Revenue</p>
                    <p class="text-2xl font-black text-white">₹14,52,000</p>
                    <p class="text-[10px] text-emerald-400 font-medium mt-1">+12.5% from last month</p>
                </div>
                <div class="h-24 md:h-28 bg-white/5 rounded-2xl border border-white/5 p-4 flex flex-col justify-end group-hover:bg-white/10 transition-colors duration-500 relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-rose-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <p class="text-xs text-dribbble-muted font-bold uppercase tracking-wider mb-1">Active Trips</p>
                    <p class="text-2xl font-black text-white">124</p>
                    <p class="text-[10px] text-rose-400 font-medium mt-1">8 delayed currently</p>
                </div>
                <div class="hidden md:flex h-28 bg-white/5 rounded-2xl border border-white/5 p-4 flex-col justify-end group-hover:bg-white/10 transition-colors duration-500 relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs text-dribbble-muted font-bold uppercase tracking-wider mb-1">Pending Invoices</p>
                    <p class="text-2xl font-black text-white">45</p>
                    <p class="text-[10px] text-emerald-400 font-medium mt-1">Ready for settlement</p>
                </div>
            </div>

            <!-- Chart Area Mockup -->
            <div class="flex-1 w-full bg-white/5 rounded-2xl border border-white/5 relative overflow-hidden group-hover:border-indigo-500/30 transition-all duration-700 p-6 flex flex-col">
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <p class="text-sm text-white font-bold">Revenue Analytics (Live)</p>
                    <div class="px-2 py-1 bg-white/10 rounded text-[10px] text-dribbble-light font-medium">This Week</div>
                </div>
                
                <!-- Simulated Chart Bars -->
                <div class="flex-1 flex items-end justify-between gap-2 relative z-10">
                    <div class="w-full bg-indigo-500/20 rounded-t-sm h-[30%] relative group-hover:bg-indigo-500/40 transition-colors"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-500"></div></div>
                    <div class="w-full bg-indigo-500/20 rounded-t-sm h-[50%] relative group-hover:bg-indigo-500/40 transition-colors"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-500"></div></div>
                    <div class="w-full bg-indigo-500/20 rounded-t-sm h-[40%] relative group-hover:bg-indigo-500/40 transition-colors"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-500"></div></div>
                    <div class="w-full bg-indigo-500/20 rounded-t-sm h-[70%] relative group-hover:bg-indigo-500/40 transition-colors"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-500"></div></div>
                    <div class="w-full bg-indigo-500/20 rounded-t-sm h-[60%] relative group-hover:bg-indigo-500/40 transition-colors"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-500"></div></div>
                    <div class="w-full bg-indigo-500/20 rounded-t-sm h-[90%] relative group-hover:bg-indigo-500/40 transition-colors"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-500"></div></div>
                    <div class="w-full bg-indigo-500/40 rounded-t-sm h-[80%] relative group-hover:bg-indigo-500/60 transition-colors shadow-[0_0_15px_rgba(99,102,241,0.5)]"><div class="absolute top-0 inset-x-0 h-1 bg-indigo-400 shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div></div>
                </div>

                <!-- Animated sweeping scanning line -->
                <div class="absolute top-0 bottom-0 w-[2px] bg-indigo-400 shadow-[0_0_20px_rgba(129,140,248,1)] animate-scan z-20"></div>
            </div>
        </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS SECTION -->
<section class="py-32 lg:py-48 relative bg-dribbble-base border-t border-dribbble-line/20">
  <div class="max-w-7xl mx-auto px-6 relative z-10">
    <div class="text-center max-w-3xl mx-auto mb-20 reveal">
      <h2 class="text-xs font-black text-rose-400 tracking-[0.2em] uppercase mb-4">Workflow</h2>
      <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
        Streamlined from load to ledger.
      </h3>
    </div>

    <div class="grid md:grid-cols-3 gap-16 relative">
      <!-- Connection line for desktop -->
      <div class="hidden md:block absolute top-12 left-[16%] right-[16%] h-[2px] bg-gradient-to-r from-indigo-500/50 via-rose-500/50 to-emerald-500/50 -z-10"></div>
      
      <div class="text-center reveal">
        <div class="w-24 h-24 mx-auto bg-dribbble-base rounded-3xl border border-indigo-500/30 flex items-center justify-center text-3xl font-black text-indigo-400 mb-8 shadow-2xl shadow-indigo-500/10">1</div>
        <h4 class="text-2xl font-extrabold text-dribbble-light mb-4">Create Trip</h4>
        <p class="text-dribbble-muted font-medium text-lg leading-relaxed">Enter LR details, assign a truck and driver, and instantly issue an initial advance directly to the driver's wallet.</p>
      </div>

      <div class="text-center reveal delay-100">
        <div class="w-24 h-24 mx-auto bg-dribbble-base rounded-3xl border border-rose-500/30 flex items-center justify-center text-3xl font-black text-rose-400 mb-8 shadow-2xl shadow-rose-500/10">2</div>
        <h4 class="text-2xl font-extrabold text-dribbble-light mb-4">Track & Manage</h4>
        <p class="text-dribbble-muted font-medium text-lg leading-relaxed">Monitor expenses on the go. Drivers can upload toll and fuel receipts directly via our mobile application.</p>
      </div>

      <div class="text-center reveal delay-200">
        <div class="w-24 h-24 mx-auto bg-dribbble-base rounded-3xl border border-emerald-500/30 flex items-center justify-center text-3xl font-black text-emerald-400 mb-8 shadow-2xl shadow-emerald-500/10">3</div>
        <h4 class="text-2xl font-extrabold text-dribbble-light mb-4">Settle & Bill</h4>
        <p class="text-dribbble-muted font-medium text-lg leading-relaxed">Automatically generate detailed profit reports and multi-party invoices the moment the POD is verified.</p>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="py-32 lg:py-48 relative overflow-hidden bg-[#0A0C14] border-t border-dribbble-line/20">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20 reveal">
            <h2 class="text-xs font-black text-emerald-400 tracking-[0.2em] uppercase mb-4">Testimonials</h2>
            <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
                Trusted by Top Transporters
            </h3>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="glass-card p-10 lg:p-12 rounded-[2.5rem] reveal hover:border-white/10 transition-colors">
                <div class="flex items-center gap-1.5 text-yellow-400 mb-8">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
                <p class="text-xl text-dribbble-light font-medium italic mb-8 leading-relaxed">"Since switching to JMD TRUCK MANAGEMENT, our dispatch time dropped by 40%. The driver wallet feature alone is worth its weight in gold. No more calling drivers for cash requests at 2 AM."</p>
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-bold">RK</div>
                    <div>
                        <p class="font-extrabold text-white text-lg">Rajesh Kumar</p>
                        <p class="text-sm text-dribbble-muted font-medium">Owner, RK Logistics</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-10 lg:p-12 rounded-[2.5rem] reveal delay-100 hover:border-white/10 transition-colors">
                <div class="flex items-center gap-1.5 text-yellow-400 mb-8">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
                <p class="text-xl text-dribbble-light font-medium italic mb-8 leading-relaxed">"The multi-party billing module saved us. We deal with complex trips involving multiple brokers, and this system generates accurate invoices automatically upon delivery."</p>
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-full bg-rose-500/20 border border-rose-500/30 flex items-center justify-center text-rose-400 font-bold">AS</div>
                    <div>
                        <p class="font-extrabold text-white text-lg">Amit Singh</p>
                        <p class="text-sm text-dribbble-muted font-medium">Director, Singh Roadways</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ANIMATED CTA SECTION -->
<section class="py-32 relative overflow-hidden bg-[#05060A] border-y border-dribbble-line/30">
  <!-- Subtle Grid Background -->
  <div class="absolute inset-0 opacity-20 bg-[radial-gradient(rgba(144,150,165,0.3)_1.5px,transparent_1.5px)] [background-size:32px_32px]"></div>
  
  <!-- Edge Gradients for smooth fade -->
  <div class="absolute top-0 inset-x-0 h-40 bg-gradient-to-b from-dribbble-base to-transparent"></div>
  <div class="absolute bottom-0 inset-x-0 h-40 bg-gradient-to-t from-dribbble-base to-transparent"></div>

  <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
    <h2 class="text-4xl lg:text-6xl font-[900] text-dribbble-light tracking-tight mb-8">
      Ready to transform your <br> <span class="text-indigo-400">transport business?</span>
    </h2>
    <p class="text-dribbble-muted text-lg lg:text-xl mb-12 max-w-2xl mx-auto font-medium">
      Join thousands of modern fleet owners who use JMD TRUCK MANAGEMENT to power their daily operations.
    </p>
    
    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
      <button class="w-full sm:w-auto px-12 py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)] hover:shadow-[0_0_50px_rgba(79,70,229,0.5)] hover:-translate-y-1">
        Start Now - It's Free
      </button>
      <button class="w-full sm:w-auto px-12 py-5 bg-white/5 border border-white/10 text-dribbble-light rounded-2xl font-black text-lg hover:bg-white/10 transition-all hover:-translate-y-1">
        Talk to Sales
      </button>
    </div>
  </div>
</section>


@endsection