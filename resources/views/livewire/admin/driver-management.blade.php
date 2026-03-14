<div x-data="{ showMobileForm: false }" class="pb-10"> 
    
    <div class="space-y-4 lg:space-y-6 animate-in fade-in duration-500">
        
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center justify-between">
            <div>
                <h2 class="text-xl lg:text-lg font-black text-slate-900 tracking-tight">Driver & Wallet Registry</h2>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Manage Staff & KYC</p>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                        Total Cash: ₹{{ number_format($totalBalance, 2) }}
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if (session()->has('success'))
                    <div class="px-4 py-3 lg:py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm animate-in zoom-in-95 duration-300">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <button @click="setTimeout(() => $refs.driverInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" wire:click="resetForm" class="hidden lg:flex px-6 py-2.5 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold items-center gap-2 hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 uppercase tracking-widest active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    ADD NEW DRIVER
                </button>
            </div>

            <button @click="showMobileForm = !showMobileForm; if(!showMobileForm) $wire.resetForm()" class="lg:hidden w-full py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold flex items-center justify-center gap-2 shadow-xl shadow-slate-200 active:scale-95 transition-all uppercase tracking-widest">
                <svg x-show="!showMobileForm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <svg x-show="showMobileForm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span x-text="showMobileForm ? 'CLOSE FORM' : 'ADD NEW DRIVER'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div :class="showMobileForm ? 'block' : 'hidden'" class="lg:!block lg:col-span-1 lg:sticky lg:top-20 z-10">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-lg lg:shadow-sm shadow-slate-200/50 transition-all {{ $isEditMode ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }}">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest">
                            {{ $isEditMode ? 'Edit Profile' : 'Register Profile & Wallet' }}
                        </h3>
                    </div>

                    <form wire:submit.prevent="saveDriver" class="space-y-4">
                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Full Name <span class="text-rose-500">*</span></label>
                                <input x-ref="driverInput" type="text" wire:model="name" placeholder="E.g. Rajesh Kumar" required class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                @error('name') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Mobile No. <span class="text-rose-500">*</span></label>
                                    <input type="text" wire:model="mobile_number" placeholder="9876543210" required class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none">
                                    @error('mobile_number') <span class="text-[10px] text-rose-500 font-bold block leading-tight">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">App Password</label>
                                    <input type="password" wire:model="password" placeholder="{{ $isEditMode ? 'Leave blank' : 'Min 6 char' }}" {{ !$isEditMode ? 'required' : '' }} class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none">
                                    @error('password') <span class="text-[10px] text-rose-500 font-bold block leading-tight">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Aadhar No.</label>
                                    <input type="text" wire:model="aadhar_number" placeholder="XXXX XXXX" class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">License No.</label>
                                    <input type="text" wire:model="license_number" placeholder="DL-14..." class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none uppercase">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="col-span-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Blood</label>
                                    <select wire:model="blood_group" class="w-full mt-1 px-3 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                        <option value="">Select</option>
                                        <option value="A+">A+</option><option value="B+">B+</option><option value="O+">O+</option>
                                        <option value="AB+">AB+</option><option value="A-">A-</option><option value="B-">B-</option><option value="O-">O-</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Address</label>
                                    <input type="text" wire:model="address" placeholder="E.g. Patna, Bihar" class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row gap-2">
                            <button type="submit" @click="showMobileForm = false" wire:loading.attr="disabled" class="flex-1 py-3.5 lg:py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold hover:bg-slate-800 transition-all shadow-lg uppercase tracking-widest disabled:opacity-70 flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="saveDriver">
                                    {{ $isEditMode ? 'UPDATE DRIVER' : 'SAVE & CREATE WALLET' }}
                                </span>
                                <span wire:loading wire:target="saveDriver">Wait...</span>
                            </button>

                            @if($isEditMode)
                                <button type="button" @click="showMobileForm = false" wire:click="resetForm" class="py-3.5 lg:py-3 px-4 bg-slate-100 text-slate-600 rounded-xl text-xs font-extrabold hover:bg-slate-200 transition-all uppercase tracking-widest text-center">
                                    CANCEL
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4 relative z-0">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-3.5 lg:top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by Name, Mobile, License..." class="w-full pl-10 pr-4 py-3 lg:py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold outline-none shadow-sm focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    </div>
                    <select wire:model.live="statusFilter" class="w-full sm:w-auto px-4 py-3 lg:py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold outline-none shadow-sm min-w-[140px]">
                        <option value="">All Wallets</option>
                        <option value="active">🟢 Active</option>
                        <option value="frozen">🔴 Frozen</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($wallets as $wallet)
                        <div class="bg-white p-4 lg:p-5 rounded-2xl border border-slate-200/60 shadow-sm hover:border-indigo-200 transition-all flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-extrabold text-sm uppercase shadow-md shadow-slate-200">
                                        {{ substr($wallet->driver->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-base lg:text-lg font-black text-slate-900 capitalize tracking-tight leading-none">{{ $wallet->driver->name }}</h4>
                                        <p class="text-[10px] text-slate-500 font-bold mt-1 tracking-wider">📞 {{ $wallet->driver->mobile_number }}</p>
                                    </div>
                                </div>
                                @if($wallet->status === 'active')
                                    <span class="px-2.5 py-1 rounded-md text-[9px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase">Active</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md text-[9px] font-extrabold bg-rose-50 text-rose-600 border border-rose-100 uppercase">Frozen</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-2 mb-4 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <div>
                                    <p class="text-[8px] font-extrabold text-slate-400 uppercase tracking-widest">License</p>
                                    <p class="text-[10px] font-bold text-slate-800 uppercase">{{ $wallet->driver->license_number ?? 'Not Added' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[8px] font-extrabold text-slate-400 uppercase tracking-widest">Aadhar</p>
                                    <p class="text-[10px] font-bold text-slate-800">{{ $wallet->driver->aadhar_number ? 'Added' : 'Missing' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-4 px-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Wallet Bal:</span>
                                <span class="text-xl font-black tracking-tighter {{ $wallet->balance > 0 ? 'text-emerald-600' : ($wallet->balance < 0 ? 'text-rose-600' : 'text-slate-700') }}">
                                    ₹{{ number_format($wallet->balance, 2) }}
                                </span>
                            </div>

                            <div class="pt-3 border-t border-slate-50 grid grid-cols-3 gap-1.5">
                                <button @click="showMobileForm = true; setTimeout(() => $refs.driverInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" wire:click="editDriver({{ $wallet->driver->id }})" class="py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl transition-colors text-[9px] font-extrabold uppercase tracking-widest flex justify-center">
                                    EDIT KYC
                                </button>
                                <button wire:click="viewTransactions({{ $wallet->id }}, '{{ addslashes($wallet->driver->name) }}')" class="py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-100/50 rounded-xl transition-colors text-[9px] font-extrabold uppercase tracking-widest flex items-center justify-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    LEDGER
                                </button>
                                <button wire:click="openAddMoneyModal({{ $wallet->id }}, '{{ addslashes($wallet->driver->name) }}')" class="py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white shadow-md shadow-emerald-200 rounded-xl transition-colors text-[9px] font-extrabold uppercase tracking-widest flex items-center justify-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    CASH
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 bg-white p-8 rounded-2xl border border-slate-200/60 shadow-sm text-center">
                            <h4 class="text-base font-black text-slate-900">No Drivers Found</h4>
                            <p class="text-xs font-bold text-slate-400 mt-1">Try changing search criteria or onboard a new driver.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-6">{{ $wallets->links() }}</div>
            </div>
        </div>
    </div>

    @if($showAddMoneyModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 animate-in fade-in duration-200">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden animate-in zoom-in-95 duration-200">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-widest">Add Advance</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">Driver: <span class="text-indigo-600">{{ $selectedDriverName }}</span></p>
                </div>
                <button wire:click="closeModals" class="p-2 bg-white rounded-full hover:bg-rose-50 hover:text-rose-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="addFunds" class="p-6 space-y-5">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Amount (₹)</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-extrabold">₹</span>
                        </div>
                        <input type="number" wire:model="add_amount" placeholder="5000" required step="0.01" class="w-full pl-8 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-lg font-black text-slate-900 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                    </div>
                    @error('add_amount') <span class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Remarks / Reference</label>
                    <input type="text" wire:model="add_remarks" placeholder="E.g. Advance for Trip #45" required class="w-full mt-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                    @error('add_remarks') <span class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled" class="w-full py-3.5 bg-emerald-500 text-white rounded-xl text-xs font-extrabold hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200 uppercase tracking-widest flex items-center justify-center gap-2 disabled:opacity-70">
                    <span wire:loading.remove wire:target="addFunds">CREDIT TO WALLET</span>
                    <span wire:loading wire:target="addFunds">PROCESSING...</span>
                </button>
            </form>
        </div>
    </div>
    @endif

    @if($showTxDrawer)
    <div class="fixed inset-0 z-[100] flex justify-end bg-slate-900/20 backdrop-blur-sm animate-in fade-in duration-300">
        <div class="w-full max-w-md bg-white h-full shadow-2xl flex flex-col animate-in slide-in-from-right duration-300 border-l border-slate-100">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-widest">Wallet Ledger</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">Account: <span class="text-indigo-600">{{ $selectedDriverName }}</span></p>
                </div>
                <button wire:click="closeModals" class="p-2 bg-white rounded-full hover:bg-rose-50 hover:text-rose-600 transition-colors shadow-sm border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-slate-50/30">
                @forelse($transactionHistory as $tx)
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:border-slate-200 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $tx->type === 'credit' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                @if($tx->type === 'credit')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h13M3 8h9m-9 4h9m5-4v12m-0 0l-4-4m4 4l4-4"></path></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900 leading-tight">{{ $tx->description }}</p>
                                <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mt-1">
                                    {{ \Carbon\Carbon::parse($tx->created_at)->format('d M, Y • h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm font-black tracking-tighter {{ $tx->type === 'credit' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-40 text-center">
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">No Transactions Yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

</div>