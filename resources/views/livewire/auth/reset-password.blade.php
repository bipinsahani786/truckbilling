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
            <h2 class="text-3xl font-extrabold text-[#0A0A0A] tracking-tight">Set new password</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium">Please enter your new security credentials below.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="mt-10 space-y-6">
            @csrf
            
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                <div class="mt-2 text-left">
                    <input name="email" id="email" type="email" required
                        class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                        placeholder="admin@jmdtrucks.com" value="{{ request('email') }}" readonly />
                </div>
                @error('email') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700">New Password</label>
                    <div class="mt-2">
                        <input name="password" id="password" type="password" required autofocus
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="••••••••" />
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                    <div class="mt-2">
                        <input name="password_confirmation" id="password_confirmation" type="password" required
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-100 focus:border-slate-400 focus:bg-white transition-all text-sm font-medium shadow-[0_2px_10px_rgb(0,0,0,0.02)]" 
                            placeholder="••••••••" />
                    </div>
                </div>
            </div>
            @error('password') <p class="mt-1.5 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror

            <div class="pt-4">
                <button type="submit" 
                    class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#0A0A0A] hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 transition-all">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <div class="hidden lg:flex w-1/2 bg-[#050505] relative overflow-hidden items-center justify-center border-l border-slate-800">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[100px]"></div>
        
        <div class="relative z-10 px-16 text-left max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-white/80 text-xs font-bold tracking-wide uppercase mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Password Reset
            </div>
            
            <h3 class="text-4xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                Ready to roll.<br>Back in the seat.
            </h3>
            <p class="text-slate-400 text-lg font-medium leading-relaxed">
                Your new password grants you full access to the JMD TRUCK MANAGEMENT fleet management ecosystem. Let's get moving.
            </p>
            
            <div class="mt-12 grid grid-cols-2 gap-4">
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/[0.05] backdrop-blur-md">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Encrypted</p>
                    <p class="text-white text-xl font-extrabold">SHA-256</p>
                </div>
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/[0.05] backdrop-blur-md">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Status</p>
                    <p class="text-white text-xl font-extrabold">Secure</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts::guest>

