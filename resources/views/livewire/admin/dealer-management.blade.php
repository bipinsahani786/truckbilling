<div x-data="{ showMobileForm: false }" class="pb-10"> 
    
    <div class="space-y-4 lg:space-y-6 animate-in fade-in duration-500">
        
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center justify-between">
            <div>
                <h2 class="text-xl lg:text-lg font-black text-slate-900 tracking-tight">Dealer & Party Registry</h2>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Client Khata & Ledger</p>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <p class="text-[11px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                        Total Parties: {{ $dealers->total() }}
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if (session()->has('success'))
                    <div class="px-4 py-3 lg:py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <button @click="setTimeout(() => $refs.dealerInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" wire:click="resetForm" class="hidden lg:flex px-6 py-2.5 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold items-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 uppercase tracking-widest active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    ADD NEW PARTY
                </button>
            </div>

            <button @click="showMobileForm = !showMobileForm; if(!showMobileForm) $wire.resetForm()" class="lg:hidden w-full py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold flex items-center justify-center gap-2 shadow-xl shadow-slate-200 active:scale-95 transition-all uppercase tracking-widest">
                <svg x-show="!showMobileForm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <svg x-show="showMobileForm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span x-text="showMobileForm ? 'CLOSE FORM' : 'ADD NEW PARTY'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div :class="showMobileForm ? 'block' : 'hidden'" class="lg:!block lg:col-span-1 lg:sticky lg:top-20">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-lg lg:shadow-sm shadow-slate-200/50 transition-all {{ $isEditMode ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }}">
                    
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest mb-4">
                        {{ $isEditMode ? 'Edit Party Details' : 'Register New Dealer' }}
                    </h3>

                    <form wire:submit.prevent="saveDealer" class="space-y-4">
                        
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Company Name <span class="text-rose-500">*</span></label>
                            <input x-ref="dealerInput" type="text" wire:model="company_name" placeholder="E.g. Reliance Logistics" required class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all uppercase">
                            @error('company_name') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">GSTIN</label>
                                <input type="text" wire:model="gstin" placeholder="27AA..." class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none uppercase">
                                @error('gstin') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">PAN Number</label>
                                <input type="text" wire:model="pan_number" placeholder="ABCDE1234F" class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none uppercase">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Primary Phone <span class="text-rose-500">*</span></label>
                                <input type="text" wire:model="phone_number" placeholder="9876543210" required class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none">
                                @error('phone_number') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Email ID</label>
                                <input type="email" wire:model="email" placeholder="billing@party.com" class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none">
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Billing Address</label>
                                <input type="text" wire:model="billing_address" placeholder="Street, Area..." class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">City</label>
                                    <input type="text" wire:model="city" placeholder="E.g. Patna" class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Pincode</label>
                                    <input type="text" wire:model="pincode" placeholder="800001" class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row gap-2">
                            <button type="submit" @click="showMobileForm = false" wire:loading.attr="disabled" class="flex-1 py-3.5 lg:py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold hover:bg-slate-800 transition-all shadow-lg uppercase tracking-widest disabled:opacity-70 flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="saveDealer">
                                    {{ $isEditMode ? 'UPDATE DEALER' : 'SAVE DEALER' }}
                                </span>
                                <span wire:loading wire:target="saveDealer">Processing...</span>
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

            <div class="lg:col-span-2 space-y-4">
                
                <div class="relative">
                    <svg class="absolute left-3.5 top-3.5 lg:top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by Company, Contact, GST or City..." class="w-full pl-10 pr-4 py-3 lg:py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold outline-none shadow-sm focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($dealers as $dealer)
                        <div class="bg-white p-4 lg:p-5 rounded-2xl border border-slate-200/60 shadow-sm hover:border-indigo-200 transition-all flex flex-col justify-between group">
                            
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black text-sm uppercase group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                            {{ substr($dealer->company_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-base lg:text-[15px] font-black text-slate-900 uppercase tracking-tight leading-none">{{ $dealer->company_name }}</h4>
                                            <p class="text-[10px] text-slate-400 font-bold mt-1 tracking-wider uppercase">
                                                👤 {{ $dealer->contact_person_name ?? 'No Contact' }}
                                            </p>
                                        </div>
                                    </div>
                                    <button @click="showMobileForm = true; setTimeout(() => $refs.dealerInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" 
                                            wire:click="editDealer({{ $dealer->id }})" 
                                            class="p-2 bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>

                                <div class="space-y-2 mb-4 bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Phone</span>
                                        <span class="text-[11px] font-bold text-slate-800">{{ $dealer->phone_number }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">GST</span>
                                        <span class="text-[10px] font-bold text-indigo-600 uppercase">{{ $dealer->gstin ?? 'Unregistered' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Location</span>
                                        <span class="text-[11px] font-bold text-slate-800 uppercase">{{ $dealer->city ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-50 flex items-center justify-between">
                                <a href="#" class="text-[10px] font-extrabold text-indigo-600 hover:underline uppercase tracking-widest">View Ledger</a>
                                <span class="text-[10px] font-bold text-slate-400 italic">ID: #DLR-{{ 1000 + $dealer->id }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 bg-white p-12 rounded-2xl border border-slate-200/60 shadow-sm text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h4 class="text-base font-black text-slate-900">No Dealers Registered</h4>
                            <p class="text-xs font-bold text-slate-400 mt-1">Start by adding your first party to manage their trips.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $dealers->links() }}
                </div>

            </div>
        </div>
    </div>
</div>