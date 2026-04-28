<x-layouts::guest>
<div class="flex min-h-screen bg-white">
    
    <div class="flex flex-col justify-center w-full lg:w-1/2 px-6 py-12 lg:px-24 xl:px-32 relative z-10">
        
        <div class="mb-12">
            <a href="/" wire:navigate class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-[#0A0A0A] rounded-md flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-[#0A0A0A]">JMD TRUCK MANAGEMENT.</span>
            </a>
        </div>

        <div>
            <h2 class="text-3xl font-extrabold text-[#0A0A0A] tracking-tight">Forgot password?</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium">No worries, we'll send you reset instructions.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100/80 text-emerald-700 text-sm font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-10 space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                <div class="mt-2 text-left">
                    <input name="email" id="email" type="email" required autofocus
                        class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                        placeholder="admin@jmdtrucks.com" value="{{ old('email') }}" />
                </div>
                @error('email') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" 
                    class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#0A0A0A] hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 transition-all">
                    Reset Password
                </button>
            </div>
        </form>

        <div class="mt-10 space-x-1 rtl:space-x-reverse text-center lg:text-left text-sm font-medium text-slate-500">
            <span>Or, return to</span>
            <a href="{{ route('login') }}" class="font-bold text-[#0A0A0A] hover:underline decoration-2 underline-offset-4 transition-all" wire:navigate>log in</a>
        </div>
    </div>

    <div class="hidden lg:flex w-1/2 bg-[#050505] relative overflow-hidden items-center justify-center border-l border-slate-800">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[100px]"></div>
        
        <div class="relative z-10 px-16 text-left max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs font-bold tracking-wide uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Account Recovery
            </div>
            
            <h3 class="text-4xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                Secure your fleet.<br>Reset with ease.
            </h3>
            <p class="text-slate-400 text-lg font-medium leading-relaxed">
                Logistics moves fast. We make sure your account access stays ahead of the curve.
            </p>
            
            <div class="mt-12 space-y-4">
                <div class="flex items-center gap-3 text-slate-400 font-medium">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Multi-factor Protection</span>
                </div>
                <div class="flex items-center gap-3 text-slate-400 font-medium">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Instant Token Verification</span>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts::guest>

