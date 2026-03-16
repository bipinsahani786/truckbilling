<div class="flex min-h-screen bg-white">
    
    <div class="flex flex-col justify-center w-full lg:w-1/2 px-6 py-12 lg:px-24 xl:px-32 relative z-10">
        
        <div class="mb-12">
            <a href="/" wire:navigate class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-[#0A0A0A] rounded-md flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-[#0A0A0A]">Zytrixon.</span>
            </a>
        </div>

        <div>
            <h2 class="text-3xl font-extrabold text-[#0A0A0A] tracking-tight">Log in to your account</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium">Enter your credentials to access the fleet dashboard.</p>
        </div>

        <form wire:submit="login" class="mt-10 space-y-6">
            
            <div>
                <label for="login_id" class="block text-sm font-semibold text-slate-700">Email Address or Mobile No.</label>
                <div class="mt-2">
                    <input wire:model="login_id" id="login_id" type="text" required autofocus
                        class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                        placeholder="admin@zytrixon.com or 9876543210" />
                </div>
                @error('login_id') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-slate-500 hover:text-[#0A0A0A] transition-colors" wire:navigate>Forgot password?</a>
                </div>
                <div>
                    <input wire:model="password" id="password" type="password" required
                        class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                        placeholder="••••••••" />
                </div>
                @error('password') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center pt-1">
                <input wire:model="remember" id="remember" type="checkbox" 
                    class="h-4 w-4 text-[#0A0A0A] focus:ring-[#0A0A0A] border-slate-300 rounded cursor-pointer transition-colors">
                <label for="remember" class="ml-2.5 block text-sm font-medium text-slate-600 cursor-pointer">
                    Remember for 30 days
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" wire:loading.attr="disabled" 
                    class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#0A0A0A] hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Continue to Dashboard</span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Authenticating...
                    </span>
                </button>
            </div>
        </form>

        <p class="mt-10 text-sm font-medium text-slate-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-[#0A0A0A] hover:underline decoration-2 underline-offset-4 transition-all" wire:navigate>Sign up</a>
        </p>
    </div>

    <div class="hidden lg:flex w-1/2 bg-[#050505] relative overflow-hidden items-center justify-center border-l border-slate-800">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[100px]"></div>
        
        <div class="relative z-10 px-16 text-left max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs font-bold tracking-wide uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Zytrixon Tech
            </div>
            
            <h3 class="text-4xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                Redefining logistics.<br>One trip at a time.
            </h3>
            <p class="text-slate-400 text-lg font-medium leading-relaxed">
                Experience the next generation of transport management. Fast, scalable, and beautifully designed.
            </p>
            
            <div class="mt-12 grid grid-cols-2 gap-4">
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/[0.05] backdrop-blur-md">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Trips</p>
                    <p class="text-white text-2xl font-extrabold">12,400+</p>
                </div>
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/[0.05] backdrop-blur-md">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">System Uptime</p>
                    <p class="text-white text-2xl font-extrabold">99.99%</p>
                </div>
            </div>
        </div>
    </div>
</div>