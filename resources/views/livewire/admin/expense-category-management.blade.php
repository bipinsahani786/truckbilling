<div x-data="{ showMobileForm: false }" class="pb-10"> 
    
    <div class="space-y-4 lg:space-y-6 animate-in fade-in duration-500">
        
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center justify-between">
            <div>
                <h2 class="text-xl lg:text-lg font-black text-slate-900 tracking-tight">Expense Categories</h2>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Manage Trip Expense Types</p>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <p class="text-[11px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                        @if(auth()->user()->hasRole('super-admin')) 👑 Root Control @else Standard Mode @endif
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

                @if (session()->has('error'))
                    <div class="px-4 py-3 lg:py-2.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                <button @click="setTimeout(() => $refs.catInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" wire:click="resetForm" class="hidden lg:flex px-6 py-2.5 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold items-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 uppercase tracking-widest active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    NEW CATEGORY
                </button>
            </div>

            <button @click="showMobileForm = !showMobileForm; if(!showMobileForm) $wire.resetForm()" class="lg:hidden w-full py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold flex items-center justify-center gap-2 shadow-xl shadow-slate-200 active:scale-95 transition-all uppercase tracking-widest">
                <svg x-show="!showMobileForm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <svg x-show="showMobileForm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span x-text="showMobileForm ? 'CLOSE FORM' : 'NEW CATEGORY'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div :class="showMobileForm ? 'block' : 'hidden'" class="lg:!block lg:col-span-1 lg:sticky lg:top-20">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-lg lg:shadow-sm shadow-slate-200/50 transition-all {{ $isEditMode ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }}">
                    
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest mb-4">
                        @if(auth()->user()->hasRole('super-admin'))
                            {{ $isEditMode ? 'Edit Global Category' : 'Add Global System Category' }}
                        @else
                            {{ $isEditMode ? 'Edit My Category' : 'Add Custom Expense' }}
                        @endif
                    </h3>

                    <form wire:submit.prevent="saveCategory" class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Category Name <span class="text-rose-500">*</span></label>
                            <input x-ref="catInput" type="text" wire:model="name" placeholder="E.g. Diesel, Toll, Police..." required class="w-full mt-1 px-4 py-3 lg:py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all uppercase">
                            @error('name') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row gap-2">
                            <button type="submit" @click="showMobileForm = false" wire:loading.attr="disabled" class="flex-1 py-3.5 lg:py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold hover:bg-slate-800 transition-all shadow-lg uppercase tracking-widest disabled:opacity-70 flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="saveCategory">
                                    {{ $isEditMode ? 'UPDATE' : 'SAVE CATEGORY' }}
                                </span>
                                <span wire:loading wire:target="saveCategory">Processing...</span>
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
                
                <div class="relative w-full sm:w-1/2">
                    <svg class="absolute left-3.5 top-3.5 lg:top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search categories..." class="w-full pl-10 pr-4 py-3 lg:py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold outline-none shadow-sm focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @forelse ($categories as $cat)
                        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 shadow-sm flex flex-col justify-between group hover:border-indigo-200 transition-all relative">
                            
                            <div class="flex justify-between items-start mb-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-extrabold text-[10px] {{ $cat->is_system_default ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'bg-slate-50 text-slate-400' }}">
                                    @if($cat->is_system_default)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    @endif
                                </div>
                                
                                @if($cat->is_system_default)
                                    <span class="px-2 py-0.5 rounded-md text-[8px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase tracking-wider">System</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[8px] font-extrabold bg-slate-50 text-slate-400 border border-slate-200 uppercase tracking-wider">Personal</span>
                                @endif
                            </div>

                            <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight leading-tight">{{ $cat->name }}</h4>

                            <div class="mt-4 pt-3 border-t border-slate-50 flex items-center gap-2">
                                {{-- Access Control Logic --}}
                                @if(auth()->user()->hasRole('super-admin') || !$cat->is_system_default)
                                    <button @click="showMobileForm = true; window.scrollTo({top: 0, behavior: 'smooth'})" wire:click="editCategory({{ $cat->id }})" class="flex-1 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg transition-colors text-[9px] font-extrabold uppercase tracking-widest active:scale-95">Edit</button>
                                    <button wire:click="deleteCategory({{ $cat->id }})" wire:confirm="Delete this category?" class="flex-1 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition-colors text-[9px] font-extrabold uppercase tracking-widest active:scale-95">Delete</button>
                                @else
                                    <div class="w-full flex items-center justify-center gap-1.5 py-1.5 bg-slate-50 rounded-lg opacity-60">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Locked Category</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 md:col-span-3 bg-white p-8 rounded-2xl border border-slate-200/60 shadow-sm text-center">
                            <h4 class="text-base font-black text-slate-900">No Categories Found</h4>
                            <p class="text-xs font-bold text-slate-400 mt-1">Add expense types to start tracking trip costs.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>