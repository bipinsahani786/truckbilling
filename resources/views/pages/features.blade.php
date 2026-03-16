@extends('layouts.landing')

@section('title', 'System Features - Zytrixon Intelligence')

@section('content')
    <!-- Header -->
    <section class="pt-32 pb-20 bg-slate-50 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23000000\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center relative z-10 reveal">
            <h1 class="text-4xl lg:text-6xl font-[900] tracking-tight text-[#0F172A] mb-6">Built for the <span class="text-indigo-600">Road Ahead.</span></h1>
            <p class="text-slate-500 text-lg lg:text-xl font-medium max-w-2xl mx-auto">Explore the deep feature set that makes Zytrixon the preferred choice for forward-thinking transport companies in India.</p>
        </div>
    </section>

    <!-- Feature Grid -->
    <section class="section-padding bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                
                <!-- Financial Management -->
                <div class="reveal">
                    <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-xl shadow-indigo-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#0F172A] mb-4 tracking-tight">Financial Mastery</h3>
                    <p class="text-slate-500 font-medium leading-relaxed mb-6">Automate your entire trip ledger. Track advances, fuel expenses, toll charges, and net margins with 100% accuracy from any device.</p>
                    <ul class="space-y-3 text-sm font-bold text-slate-700">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div> Instant Trip Settlement</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div> Driver Wallet History</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div> Party-Wise Ledgers</li>
                    </ul>
                </div>

                <!-- Operations -->
                <div class="reveal" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 bg-rose-500 rounded-2xl flex items-center justify-center text-white mb-8 shadow-xl shadow-rose-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#0F172A] mb-4 tracking-tight">Smooth Operations</h3>
                    <p class="text-slate-500 font-medium leading-relaxed mb-6">Manage your fleet like a pro. Document tracking, trip scheduling, and real-time dispatch updates for your whole team.</p>
                    <ul class="space-y-3 text-sm font-bold text-slate-700">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div> Digital Bilty & POD</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div> Vehicle Document Alerts</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div> Multi-User Permissions</li>
                    </ul>
                </div>

                <!-- Driver App -->
                <div class="reveal" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-8 shadow-xl shadow-emerald-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#0F172A] mb-4 tracking-tight">The Driver App</h3>
                    <p class="text-slate-500 font-medium leading-relaxed mb-6">Empower your drivers with a dedicated mobile interface. They report expenses, you approve in seconds.</p>
                    <ul class="space-y-3 text-sm font-bold text-slate-700">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Expense Photo Uploads</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Real-time Notifications</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Simplified UI in Hindi</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Detailed Feature Highlight -->
    <section class="section-padding bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="flex-1 reveal">
                    <h2 class="text-4xl font-black text-[#0F172A] mb-8 leading-tight">Advanced Reporting for Data-Driven Decisions.</h2>
                    <p class="text-slate-600 font-medium text-lg leading-relaxed mb-8">Stop guessing which trucks or routes are profitable. Our deep analytics engine processes every rupee to give you the truth.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-black text-[#0F172A]">Consolidated P&L Statements</h5>
                                <p class="text-slate-500 text-sm font-medium">Monthly and yearly profit and loss reports tailored for Indian transporters.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                            </div>
                            <div>
                                <h5 class="font-black text-[#0F172A]">Customizable Dashboards</h5>
                                <p class="text-slate-500 text-sm font-medium">Pin the metrics that matter most to your specific business model.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-white p-4 rounded-[3rem] shadow-2xl border border-slate-200 reveal" style="transition-delay: 200ms;">
                    <img src="{{ asset('zytrixon_logistics_dashboard_3d_1773676710969.png') }}" class="w-full h-auto rounded-[2.5rem]" alt="Reporting dashboard">
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="section-padding bg-indigo-600 text-center">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 reveal">
            <h2 class="text-4xl lg:text-5xl font-[900] text-white mb-8">Experience all these features for yourself.</h2>
            <a href="{{ route('register') }}" class="inline-block px-12 py-5 bg-white text-indigo-600 rounded-2xl font-black text-lg hover:shadow-2xl transition-all hover:-translate-y-1">Start Free Test Drive</a>
        </div>
    </section>
@endsection
