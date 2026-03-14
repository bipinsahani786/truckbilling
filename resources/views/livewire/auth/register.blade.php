<div class="flex min-h-screen bg-white">
    
    <div class="hidden lg:flex w-1/2 bg-[#050505] relative overflow-hidden items-center justify-center border-r border-slate-800">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[100px]"></div>
        
        <div class="relative z-10 px-16 text-left max-w-lg">
            <div class="mb-12">
                <a href="/" wire:navigate class="flex items-center gap-2.5 group inline-flex">
                    <div class="w-8 h-8 bg-white rounded-md flex items-center justify-center group-hover:scale-105 transition-transform">
                        <svg class="w-4 h-4 text-[#0A0A0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white">Zytrixon.</span>
                </a>
            </div>
            
            <h3 class="text-4xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                Build your fleet's<br>digital foundation.
            </h3>
            <p class="text-slate-400 text-lg font-medium leading-relaxed mb-12">
                Join top transport owners who use Zytrixon Tech to track expenses, manage drivers, and scale their logistics.
            </p>
            
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-white/[0.05] border border-white/10 flex items-center justify-center flex-shrink-0 mt-1">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-sm">Smart Expense Routing</h4>
                        <p class="text-slate-500 text-xs font-medium mt-1">Auto-calculate driver Kharchi and Owner profits.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-white/[0.05] border border-white/10 flex items-center justify-center flex-shrink-0 mt-1">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-sm">Bank-grade Security</h4>
                        <p class="text-slate-500 text-xs font-medium mt-1">100% isolated data for your transport company.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center w-full lg:w-1/2 px-6 py-12 lg:px-24 xl:px-32 relative z-10 overflow-y-auto">
        
        <div class="mb-10 lg:hidden">
            <a href="/" wire:navigate class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-[#0A0A0A] rounded-md flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-[#0A0A0A]">Zytrixon.</span>
            </a>
        </div>

        <div>
            <h2 class="text-3xl font-extrabold text-[#0A0A0A] tracking-tight">Create your account</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium">Start managing your fleet professionally today.</p>
        </div>

        <form wire:submit="register" class="mt-10 space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                    <div class="mt-2">
                        <input wire:model="name" id="name" type="text" required autofocus
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="Rahul Singh" />
                    </div>
                    @error('name') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="company_name" class="block text-sm font-semibold text-slate-700">Transport Name <span class="text-slate-400 font-medium">(Optional)</span></label>
                    <div class="mt-2">
                        <input wire:model="company_name" id="company_name" type="text"
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="Zytrixon Logistics" />
                    </div>
                    @error('company_name') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="mobile_number" class="block text-sm font-semibold text-slate-700">Mobile Number</label>
                    <div class="mt-2">
                        <input wire:model="mobile_number" id="mobile_number" type="tel" required
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="9876543210" />
                    </div>
                    @error('mobile_number') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                    <div class="mt-2">
                        <input wire:model="email" id="email" type="email" required
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="admin@example.com" />
                    </div>
                    @error('email') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                    <div class="mt-2">
                        <input wire:model="password" id="password" type="password" required
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="••••••••" />
                    </div>
                    @error('password') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                    <div class="mt-2">
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="••••••••" />
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" wire:loading.attr="disabled" 
                    class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#0A0A0A] hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Create Account</span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Creating account...
                    </span>
                </button>
            </div>
        </form>

        <p class="mt-10 text-sm font-medium text-slate-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-[#0A0A0A] hover:underline decoration-2 underline-offset-4 transition-all" wire:navigate>Log in</a>
        </p>
    </div>
</div>