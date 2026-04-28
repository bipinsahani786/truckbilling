@extends('layouts.landing')

@section('title', 'Contact JMD TRUCK MANAGEMENT Support')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative min-h-[60vh] flex items-center pt-32 pb-20 overflow-hidden bg-dribbble-base">
        <!-- Ambient Glows -->
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-rose-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full text-center">
            <div class="reveal group">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4 transition-all duration-500 group-hover:tracking-[0.4em]">
                    Connect with Us
                </h2>
                <h1 class="text-5xl lg:text-7xl font-[900] text-white leading-tight mb-8 tracking-tighter">
                    Get in <span class="text-indigo-500">Touch.</span>
                </h1>
                <p class="text-xl text-dribbble-muted max-w-2xl mx-auto leading-relaxed mb-10">
                    Have a technical question or want to see a live demo? Our team is ready to help you digitize your fleet and optimize your operations.
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT GRID -->
    <section class="py-24 relative bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-20 items-start">
                
                <!-- Contact Information -->
                <div class="reveal">
                    <h2 class="text-3xl font-black text-white mb-12 tracking-tight">Our Presence</h2>
                    
                    <div class="space-y-10">
                        <!-- Office Location -->
                        <div class="group flex gap-8 p-8 rounded-3xl glass-card border border-white/5 hover:border-indigo-500/30 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-black text-white mb-2">Technical Hub - Patna</h4>
                                <p class="text-dribbble-muted font-medium leading-relaxed italic">Boring Road, Patna, Bihar <br> PIN: 800001, India</p>
                            </div>
                        </div>

                        <!-- Email Support -->
                        <div class="group flex gap-8 p-8 rounded-3xl glass-card border border-white/5 hover:border-rose-500/30 transition-all">
                            <div class="w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-black text-white mb-2">Electronic Support</h4>
                                <p class="text-dribbble-muted font-medium leading-relaxed">
                                    <a href="mailto:support@jmdtrucks.com" class="hover:text-indigo-400 transition-colors">support@jmdtrucks.com</a> <br> 
                                    <a href="mailto:sales@jmdtrucks.com" class="hover:text-indigo-400 transition-colors">sales@jmdtrucks.com</a>
                                </p>
                            </div>
                        </div>

                        <!-- Social Channels -->
                        <div class="flex gap-4 pl-4">
                            <a href="#" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-indigo-600 transition-all">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
                            </a>
                            <a href="#" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-sky-500 transition-all">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path></svg>
                            </a>
                            <a href="#" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-emerald-600 transition-all">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.589.943 3.133 1.415 4.742 1.416 5.469 0 9.92-4.45 9.924-9.922.002-2.652-1.029-5.145-2.903-7.02-1.873-1.874-4.366-2.904-7.019-2.906-5.471 0-9.92 4.45-9.924 9.922 0 1.799.487 3.506 1.409 4.953l-.922 3.357 3.468-.91-.075-.09zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inquiry Form -->
                <div class="relative group reveal" style="transition-delay: 200ms;">
                    <div class="absolute -inset-4 bg-indigo-500/10 blur-3xl rounded-[4rem] group-hover:bg-indigo-500/20 transition-all duration-700"></div>
                    <div class="relative p-10 lg:p-14 glass-card rounded-[3.5rem] border border-white/10 backdrop-blur-3xl shadow-2xl">
                        <form class="space-y-8">
                            <div class="grid sm:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] pl-1">Full Name</label>
                                    <input type="text" placeholder="John Doe" class="w-full px-6 py-5 bg-white/5 border border-white/10 rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold outline-none text-white placeholder:text-dribbble-muted/50">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] pl-1">Phone Number</label>
                                    <input type="tel" placeholder="+91 98765 43210" class="w-full px-6 py-5 bg-white/5 border border-white/10 rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold outline-none text-white placeholder:text-dribbble-muted/50">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] pl-1">Message</label>
                                <textarea placeholder="How can we help your fleet today?" rows="5" class="w-full px-6 py-5 bg-white/5 border border-white/10 rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold outline-none text-white placeholder:text-dribbble-muted/50 resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full py-6 bg-indigo-600 text-white rounded-2xl font-black text-xl hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)] hover:shadow-[0_0_60px_rgba(79,70,229,0.5)] hover:-translate-y-1">
                                Send Inquiry
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- EXTRA SUPPORT TEMPLATES (IMAGE CARDS) -->
    <section class="py-32 relative bg-[#05060A] overflow-hidden border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <h2 class="text-xs font-black text-indigo-400 tracking-[0.2em] uppercase mb-4">Support Ecosystem</h2>
                <h3 class="text-4xl lg:text-5xl font-[900] leading-tight text-dribbble-light tracking-tight">
                    Beyond simple assistance.
                </h3>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Priority Support Card -->
                <div class="group glass-card rounded-[2.5rem] overflow-hidden border border-white/5 bg-white/5 reveal transition-all duration-500 hover:border-indigo-500/30">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('priority_support_24_7_dark_1776662535499.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Priority Support">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base/80 to-transparent"></div>
                    </div>
                    <div class="p-8">
                        <h4 class="text-xl font-black text-white mb-3">24/7 Priority Desk</h4>
                        <p class="text-dribbble-muted text-sm font-medium leading-relaxed mb-6">
                            Elite support for enterprise clients. Direct access to a dedicated account manager who understands your fleet's unique challenges.
                        </p>
                        <div class="flex items-center gap-2 text-indigo-400 text-xs font-black uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                            Live Now
                        </div>
                    </div>
                </div>

                <!-- Implementation Hub Card -->
                <div class="group glass-card rounded-[2.5rem] overflow-hidden border border-white/5 bg-white/5 reveal delay-100 transition-all duration-500 hover:border-rose-500/30">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('tech_implementation_hub_dark_1776662555240.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Implementation Hub">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base/80 to-transparent"></div>
                    </div>
                    <div class="p-8">
                        <h4 class="text-xl font-black text-white mb-3">Implementation Hub</h4>
                        <p class="text-dribbble-muted text-sm font-medium leading-relaxed mb-6">
                            Hands-on technical assistance for digitizing your paper records. We help you migrate your entire ledger system to JMD TRUCK MANAGEMENT in days, not months.
                        </p>
                        <div class="flex items-center gap-2 text-rose-400 text-xs font-black uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Setup Support
                        </div>
                    </div>
                </div>

                <!-- Community Card -->
                <div class="group glass-card rounded-[2.5rem] overflow-hidden border border-white/5 bg-white/5 reveal delay-200 transition-all duration-500 hover:border-emerald-500/30">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('logistics_community_networking_dark_1776662572151.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Logistics Community">
                        <div class="absolute inset-0 bg-gradient-to-t from-dribbble-base/80 to-transparent"></div>
                    </div>
                    <div class="p-8">
                        <h4 class="text-xl font-black text-white mb-3">Owner Community</h4>
                        <p class="text-dribbble-muted text-sm font-medium leading-relaxed mb-6">
                            Join a network of 5,000+ modern transporters. Share insights, find reliable partners, and stay updated on the latest logistics trends in India.
                        </p>
                        <div class="flex items-center gap-2 text-emerald-400 text-xs font-black uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Connect Now
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FINAL CALL FOR HELP -->
    <section class="py-32 relative overflow-hidden bg-dribbble-base border-t border-dribbble-line/20">
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
            <h2 class="text-4xl lg:text-5xl font-[900] text-dribbble-light tracking-tight mb-8">
                Ready to transform your <br> <span class="text-indigo-400">transport business?</span>
            </h2>
            <p class="text-dribbble-muted text-lg lg:text-xl mb-12 max-w-2xl mx-auto font-medium">
                Our support team is standing by to help you take the first step towards total automation.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <button class="w-full sm:w-auto px-12 py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg hover:bg-indigo-500 transition-all shadow-[0_0_40px_rgba(79,70,229,0.3)] hover:-translate-y-1">
                    Get Started Free
                </button>
                <button class="w-full sm:w-auto px-12 py-5 bg-white/5 border border-white/10 text-dribbble-light rounded-2xl font-black text-lg hover:bg-white/10 transition-all hover:-translate-y-1">
                    Talk to Sales
                </button>
            </div>
        </div>
    </section>
@endsection
