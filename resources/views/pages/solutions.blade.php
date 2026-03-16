@extends('layouts.landing')

@section('title', 'Zytrixon Solutions - Tailored for Logistics')
@section('nav_dark', 'true')

@section('content')
    <!-- Header -->
    <section class="pt-32 pb-20 bg-[#0F172A] relative overflow-hidden text-white min-h-[60vh] flex items-center">
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none bg-[radial-gradient(#ffffff_1.5px,transparent_1.5px)] [background-size:24px_24px]"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Left Content -->
                <div class="flex-1 text-center lg:text-left reveal">
                    <h1 class="text-4xl lg:text-6xl font-[900] tracking-tight mb-6">Solutions for every <span class="text-indigo-400">Scale.</span></h1>
                    <p class="text-slate-400 text-lg lg:text-xl font-medium max-w-2xl mx-auto lg:mx-0">From single truck owners to pan-India logistics giants, we have the right automation for you.</p>
                </div>
                <!-- Right Visual -->
                <div class="flex-1 reveal hidden lg:block" style="transition-delay: 200ms;">
                    <div class="relative bg-white/5 border border-white/10 p-4 rounded-[2.5rem] backdrop-blur-xl shadow-2xl">
                        <img src="{{ asset('zytrixon_logistics_dashboard_3d_1773676710969.png') }}" class="w-full h-auto rounded-[1.8rem]" alt="Solutions Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scale Sections -->
    <section class="section-padding bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-32">
            
            <!-- Individual Owners -->
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="flex-1 reveal">
                    <span class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4 inline-block">Small Business</span>
                    <h2 class="text-3xl lg:text-4xl font-[900] text-[#0F172A] mb-6 tracking-tight">Individual Truck Owners</h2>
                    <p class="text-slate-600 font-medium text-lg leading-relaxed mb-8">Stop managing your business from a pocket diary. Zytrixon helps you transition to a digital system where every expense is recorded instantly.</p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <li class="flex items-center gap-3 font-bold text-slate-800">
                            <span class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </span>
                            Simple Expense Entry
                        </li>
                        <li class="flex items-center gap-3 font-bold text-slate-800">
                            <span class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </span>
                            WhatsApp Bill Sharing
                        </li>
                        <li class="flex items-center gap-3 font-bold text-slate-800">
                            <span class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </span>
                            Mobile-First Design
                        </li>
                        <li class="flex items-center gap-3 font-bold text-slate-800">
                            <span class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </span>
                            100% Free Forever
                        </li>
                    </ul>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="bg-indigo-50 w-full h-[400px] rounded-[3rem] overflow-hidden shadow-2xl shadow-indigo-100">
                        <img src="{{ asset('zytrixon_hero_3d_truck_1773676669765.png') }}" class="w-full h-full object-cover" alt="Individual owner">
                    </div>
                </div>
            </div>

            <!-- Fleet Managers -->
            <div class="flex flex-col lg:flex-row-reverse items-center gap-20">
                <div class="flex-1 reveal">
                    <span class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4 inline-block">Enterprise Growth</span>
                    <h2 class="text-3xl lg:text-4xl font-[900] text-[#0F172A] mb-6 tracking-tight">Medium & Large Fleets</h2>
                    <p class="text-slate-600 font-medium text-lg leading-relaxed mb-8">When you have 20+ trucks, visibility becomes a nightmare. Zytrixon centralizes your operations with advanced driver-wallet management and party-wise ledgers.</p>
                    <div class="space-y-4">
                        <div class="p-6 bg-slate-50 border border-slate-100 rounded-[1.5rem]">
                            <h5 class="font-black text-[#0F172A] mb-1">Corporate Party Billing</h5>
                            <p class="text-slate-500 text-sm font-medium">Auto-generate professional invoices for corporate clients with GST handling.</p>
                        </div>
                        <div class="p-6 bg-slate-50 border border-slate-100 rounded-[1.5rem]">
                            <h5 class="font-black text-[#0F172A] mb-1">Staff Management</h5>
                            <p class="text-slate-500 text-sm font-medium">Assign managers to specific branches or routes with controlled permissions.</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="bg-emerald-50 w-full h-[400px] rounded-[3rem] overflow-hidden shadow-2xl shadow-emerald-100">
                        <img src="{{ asset('zytrixon_driver_app_3d_1773676688693.png') }}" class="w-full h-full object-cover" alt="Large Fleet">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Industry CTA -->
    <section class="section-padding bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#indigo-500_2px,transparent_2px)] [background-size:24px_24px]"></div>
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center relative z-10 reveal">
            <h2 class="text-4xl font-[900] text-white tracking-tight mb-8">Not sure which plan fits? <br> Our experts are here to guide you.</h2>
            <div class="flex justify-center gap-6">
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold shadow-xl shadow-indigo-900/40 hover:-translate-y-1 transition-all">Schedule a Call</a>
            </div>
        </div>
    </section>
@endsection
