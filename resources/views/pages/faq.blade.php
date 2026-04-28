@extends('layouts.landing')

@section('title', 'JMD TRUCK MANAGEMENT Support FAQ')

@section('content')
    <!-- Header -->
    <section class="pt-32 pb-20 bg-white text-center reveal">
        <h1 class="text-4xl lg:text-6xl font-[900] tracking-tight text-[#0F172A] mb-6">Common <span class="text-indigo-600">Questions.</span></h1>
        <p class="text-slate-500 text-lg font-medium max-w-2xl mx-auto px-6 px-4">Find fast answers to frequently asked questions about JMD TRUCK MANAGEMENT logistics platform.</p>
    </section>

    <!-- FAQ Accordion -->
    <section class="pb-32 bg-white">
        <div class="max-w-3xl mx-auto px-6 lg:px-8" x-data="{ active: null }">
            
            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="border border-slate-100 rounded-[1.5rem] bg-slate-50/50 reveal">
                    <button @click="active !== 1 ? active = 1 : active = null" class="w-full p-6 text-left flex justify-between items-center group">
                        <span class="font-black text-slate-900 group-hover:text-indigo-600 transition">How does the driver wallet system work?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak class="px-6 pb-6 text-slate-500 font-medium leading-relaxed">
                        The driver wallet is a digital sub-account assigned to each driver. You can add "Advance" funds to it from the dashboard. Drivers then use their mobile app to report fuel, toll, or maintenance expenses against that balance.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="border border-slate-100 rounded-[1.5rem] bg-slate-50/50 reveal" style="transition-delay: 100ms;">
                    <button @click="active !== 2 ? active = 2 : active = null" class="w-full p-6 text-left flex justify-between items-center group">
                        <span class="font-black text-slate-900 group-hover:text-indigo-600 transition">Is my data safe and accessible?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak class="px-6 pb-6 text-slate-500 font-medium leading-relaxed">
                        Yes. We use industry-standard encryption and hourly backups. Your data is accessible 24/7 from any device with an internet connection.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="border border-slate-100 rounded-[1.5rem] bg-slate-50/50 reveal" style="transition-delay: 200ms;">
                    <button @click="active !== 3 ? active = 3 : active = null" class="w-full p-6 text-left flex justify-between items-center group">
                        <span class="font-black text-slate-900 group-hover:text-indigo-600 transition">Can I use JMD TRUCK MANAGEMENT for multi-party billing?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak class="px-6 pb-6 text-slate-500 font-medium leading-relaxed">
                        Absolutely. JMD TRUCK MANAGEMENT supports complex trip structures where multiple dealers or parties are involved in a single trip load. We auto-balance ledgers for each party involved.
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
