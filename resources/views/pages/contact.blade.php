@extends('layouts.landing')

@section('title', 'Contact Zytrixon Support')

@section('content')
    <!-- Header -->
    <section class="pt-32 pb-20 bg-slate-50 text-center reveal">
        <h1 class="text-4xl lg:text-6xl font-[900] tracking-tight text-[#0F172A] mb-6">Get in <span class="text-indigo-600">Touch.</span></h1>
        <p class="text-slate-500 text-lg font-medium max-w-2xl mx-auto px-4 leading-[1.6]">Have a technical question or want to see a live demo? Our team is ready to help you digitize your fleet.</p>
    </section>

    <!-- Contact Grid -->
    <section class="section-padding bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-20">
            
            <!-- Info -->
            <div class="reveal">
                <h2 class="text-3xl font-black text-slate-900 mb-10 tracking-tight">Our Offices</h2>
                
                <div class="space-y-12">
                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 mb-2">Technical Hub - Patna</h4>
                            <p class="text-slate-500 font-medium">Boring Road, Patna, Bihar <br> PIN: 800001, India</p>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 mb-2">Email Support</h4>
                            <p class="text-slate-500 font-medium hover:text-indigo-600 transition">support@zytrixon.com <br> sales@zytrixon.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-slate-50 p-8 lg:p-12 rounded-[3rem] border border-slate-100 reveal" style="transition-delay: 200ms;">
                <form class="space-y-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Full Name</label>
                            <input type="text" placeholder="John Doe" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Phone Number</label>
                            <input type="tel" placeholder="+91 98765 43210" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold outline-none">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Message</label>
                        <textarea placeholder="How can we help you?" rows="5" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold outline-none resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-xl shadow-indigo-900/10">Send Inquiry</button>
                </form>
            </div>

        </div>
    </section>
@endsection
