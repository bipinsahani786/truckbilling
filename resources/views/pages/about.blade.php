@extends('layouts.landing')

@section('title', 'About Zytrixon - Mission and Vision')

@section('content')
    <!-- Header -->
    <section class="pt-32 pb-20 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center reveal">
            <h1 class="text-4xl lg:text-7xl font-[900] tracking-tight text-[#0F172A] mb-8 leading-[1.1]">Digitizing the pulse <br> of <span class="text-indigo-600">Indian Transport.</span></h1>
            <p class="text-slate-500 text-lg lg:text-xl font-medium max-w-2xl mx-auto">We are on a mission to bring technology to every fleet owner across India, making operations transparent and highly profitable.</p>
        </div>
    </section>

    <!-- Story -->
    <section class="section-padding bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-32">
                <div class="flex-1 reveal">
                    <h2 class="text-3xl font-black text-slate-900 mb-6">Our Story</h2>
                    <p class="text-slate-600 text-lg font-medium leading-[1.7] mb-6">Zytrixon started in the heart of Bihar, where we saw transport owners struggling with lost bills, driver management, and inaccurate ledgers. We realized that simple technology could solve massive headaches for small fleet owners.</p>
                    <p class="text-slate-600 text-lg font-medium leading-[1.7]">Today, we've grown into a modern platform that serves businesses across Patna, Delhi, and Mumbai, providing enterprise-grade fleet intelligence to everyone.</p>
                </div>
                <div class="flex-1 relative reveal" style="transition-delay: 200ms;">
                    <div class="bg-indigo-50 w-full h-[400px] rounded-[3rem] overflow-hidden shadow-2xl shadow-indigo-100">
                        <img src="{{ asset('zytrixon_hero_3d_truck_1773676669765.png') }}" class="w-full h-full object-cover" alt="Zytrixon Truck">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Support Brand India -->
    <section class="section-padding bg-white overflow-hidden relative">
        <div class="max-w-4xl mx-auto px-6 text-center reveal">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 font-black text-xl">🇮🇳</div>
            <h2 class="text-3xl font-[900] text-slate-900 mb-6 tracking-tight">Proudly Made in India</h2>
            <p class="text-slate-500 text-lg font-medium">Built by Indian engineers for the unique challenges of the Indian logistics ecosystem. We understand local taxes, route complexities, and the ground reality of transport.</p>
        </div>
    </section>
@endsection
