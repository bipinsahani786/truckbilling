<div class="pb-16 bg-[#f8fafc] min-h-screen">
    <div class="max-w-4xl mx-auto animate-in fade-in duration-500">
        
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black text-xl uppercase shadow-lg">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Account Settings</h2>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-0.5">Manage your personal data & security</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Personal Details
                </h3>

                @if(session()->has('profile_success'))
                    <div class="mb-4 px-3 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-100">
                        {{ session('profile_success') }}
                    </div>
                @endif

                <form wire:submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Full Name</label>
                        <input type="text" wire:model="name" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold capitalize outline-none focus:border-indigo-500">
                        @error('name') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Mobile Number</label>
                        <input type="text" wire:model="mobile_number" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none focus:border-indigo-500">
                        @error('mobile_number') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Email Address</label>
                        <input type="email" wire:model="email" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none focus:border-indigo-500">
                        @error('email') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="w-full py-3.5 bg-slate-900 hover:bg-black text-white rounded-xl text-xs font-extrabold uppercase tracking-widest shadow-lg transition-all">
                            <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                            <span wire:loading wire:target="updateProfile">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Security Settings
                </h3>

                @if(session()->has('password_success'))
                    <div class="mb-4 px-3 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-100">
                        {{ session('password_success') }}
                    </div>
                @endif

                <form wire:submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Current Password</label>
                        <input type="password" wire:model="current_password" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none focus:border-rose-400" placeholder="••••••••">
                        @error('current_password') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase">New Password</label>
                        <input type="password" wire:model="new_password" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none focus:border-rose-400" placeholder="Minimum 6 characters">
                        @error('new_password') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Confirm New Password</label>
                        <input type="password" wire:model="new_password_confirmation" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none focus:border-rose-400" placeholder="Must match new password">
                    </div>

                    <div class="pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="w-full py-3.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl text-xs font-extrabold uppercase tracking-widest shadow-lg transition-all">
                            <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                            <span wire:loading wire:target="updatePassword">Updating...</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>