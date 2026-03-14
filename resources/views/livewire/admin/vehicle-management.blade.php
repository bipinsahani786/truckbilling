<div x-data="{ showMobileForm: false, activeTab: 'basic' }" class="pb-10"> 
    
    <div class="space-y-4 lg:space-y-6 animate-in fade-in duration-500">
        
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center justify-between">
            <div>
                <h2 class="text-xl lg:text-lg font-black text-slate-900 tracking-tight">Fleet & Asset Management</h2>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Total Fleet: {{ $totalCount }}</p>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                        {{ $activeCount }} Active On-Road
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if (session()->has('success'))
                    <div class="px-4 py-3 lg:py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-[11px] font-bold flex items-center gap-2 shadow-sm animate-in zoom-in-95 duration-300">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <button @click="setTimeout(() => $refs.truckInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" wire:click="resetForm" class="hidden lg:flex px-6 py-2.5 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold items-center gap-2 hover:bg-slate-800 transition-all shadow-lg uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    ADD NEW TRUCK
                </button>
            </div>

            <button @click="showMobileForm = !showMobileForm; if(!showMobileForm) $wire.resetForm()" class="lg:hidden w-full py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold flex items-center justify-center gap-2 shadow-lg uppercase tracking-widest">
                <span x-text="showMobileForm ? 'CLOSE FORM' : 'ADD NEW TRUCK'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div :class="showMobileForm ? 'block' : 'hidden'" class="lg:!block lg:col-span-1 lg:sticky lg:top-20 z-10">
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-lg lg:shadow-sm overflow-hidden {{ $isEditMode ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }}">
                    
                    <div class="flex border-b border-slate-100 bg-slate-50/50 p-1">
                        <button type="button" @click="activeTab = 'basic'" :class="activeTab === 'basic' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:bg-slate-100'" class="flex-1 py-2 rounded-xl text-[10px] font-extrabold uppercase tracking-widest transition-all">Info</button>
                        <button type="button" @click="activeTab = 'dates'" :class="activeTab === 'dates' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:bg-slate-100'" class="flex-1 py-2 rounded-xl text-[10px] font-extrabold uppercase tracking-widest transition-all">Dates</button>
                        <button type="button" @click="activeTab = 'docs'" :class="activeTab === 'docs' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:bg-slate-100'" class="flex-1 py-2 rounded-xl text-[10px] font-extrabold uppercase tracking-widest transition-all">Docs</button>
                    </div>

                    <form wire:submit.prevent="saveVehicle" class="p-5 space-y-4">
                        
                        <div x-show="activeTab === 'basic'" class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Truck No. <span class="text-rose-500">*</span></label>
                                <input x-ref="truckInput" type="text" wire:model="truck_number" placeholder="HR-55-AS-9022" required class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold uppercase focus:ring-2 focus:ring-indigo-500/20 outline-none">
                                @error('truck_number') <span class="text-[9px] text-rose-500 font-bold block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Type <span class="text-rose-500">*</span></label>
                                    <select wire:model="truck_type" required class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                        <option value="">Select</option>
                                        <option value="6-Wheeler">6-Wheeler</option>
                                        <option value="10-Wheeler">10-Wheeler</option>
                                        <option value="12-Wheeler">12-Wheeler</option>
                                        <option value="14-Wheeler">14-Wheeler</option>
                                        <option value="Container">Container</option>
                                        <option value="Trailer">Trailer</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Capacity (Tons)</label>
                                    <input type="number" step="0.1" wire:model="capacity_tons" placeholder="24.5" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">RC Number</label>
                                <input type="text" wire:model="rc_number" placeholder="RC123..." class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold uppercase outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Engine No.</label>
                                    <input type="text" wire:model="engine_number" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold uppercase outline-none">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Chassis No.</label>
                                    <input type="text" wire:model="chassis_number" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold uppercase outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Status</label>
                                <select wire:model="status" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                                    <option value="active">🟢 Active / Available</option>
                                    <option value="maintenance">🟠 In Maintenance</option>
                                    <option value="inactive">🔴 Inactive / Sold</option>
                                </select>
                            </div>
                        </div>

                        <div x-show="activeTab === 'dates'" style="display: none;" class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Insurance Expiry</label>
                                <input type="date" wire:model="insurance_expiry_date" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Fitness Expiry</label>
                                <input type="date" wire:model="fitness_expiry_date" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">National Permit Expiry</label>
                                <input type="date" wire:model="national_permit_expiry_date" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Pollution (PUC) Expiry</label>
                                <input type="date" wire:model="pollution_expiry_date" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-bold outline-none">
                            </div>
                        </div>

                        <div x-show="activeTab === 'docs'" style="display: none;" class="space-y-4">
                            @php
                                $docs = [
                                    ['model' => 'rc_document', 'existing' => $existing_rc_document, 'label' => 'RC Document'],
                                    ['model' => 'insurance_document', 'existing' => $existing_insurance_document, 'label' => 'Insurance'],
                                    ['model' => 'fitness_document', 'existing' => $existing_fitness_document, 'label' => 'Fitness Cert'],
                                    ['model' => 'truck_photo', 'existing' => $existing_truck_photo, 'label' => 'Truck Photo'],
                                ];
                            @endphp
                            
                            @foreach($docs as $doc)
                                @php
                                    $field = $doc['model'];
                                    $existingPath = $doc['existing'];
                                    $label = $doc['label'];
                                @endphp

                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">{{ $label }}</label>
                                    
                                    @if($this->$field)
                                        <div class="mt-1 relative w-full">
                                            <div class="flex items-center gap-2 px-4 py-3 w-full justify-center border-2 border-emerald-400 bg-emerald-50 rounded-xl">
                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                <p class="text-[10px] text-emerald-700 font-extrabold uppercase tracking-widest truncate">
                                                    {{ method_exists($this->$field, 'getClientOriginalName') ? $this->$field->getClientOriginalName() : 'NEW FILE SELECTED' }}
                                                </p>
                                            </div>
                                            </div>

                                    @elseif($existingPath)
                                        <div class="mt-1 flex items-center justify-between p-3 border border-slate-200 rounded-xl bg-slate-50">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-extrabold text-slate-900 uppercase">Document Saved</p>
                                                    <a href="{{ Storage::url($existingPath) }}" target="_blank" class="text-[9px] font-bold text-indigo-600 hover:text-indigo-800 hover:underline uppercase tracking-widest">
                                                        Click to View
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div class="relative">
                                                <input type="file" id="{{ $field }}" wire:model="{{ $field }}" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                                <label for="{{ $field }}" class="px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-[9px] font-extrabold uppercase tracking-widest cursor-pointer shadow-sm transition-colors">
                                                    Replace
                                                </label>
                                                <div wire:loading wire:target="{{ $field }}" class="absolute inset-0 bg-white/80 rounded-lg flex items-center justify-center">
                                                    <svg class="animate-spin h-3 w-3 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <div class="mt-1 relative w-full">
                                            <input type="file" id="{{ $field }}" wire:model="{{ $field }}" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                            
                                            <label for="{{ $field }}" class="flex flex-col items-center justify-center w-full h-12 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all duration-300">
                                                <div class="flex items-center gap-2 px-4 w-full justify-center">
                                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest"><span class="text-indigo-600">Upload</span> {{ $label }}</p>
                                                </div>
                                            </label>

                                            <div wire:loading wire:target="{{ $field }}" class="absolute inset-0 bg-white/90 backdrop-blur-sm rounded-xl flex items-center justify-center border-2 border-indigo-200 z-10">
                                                <svg class="animate-spin h-4 w-4 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-widest">Uploading...</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex gap-2">
                            <button type="submit" wire:loading.attr="disabled" wire:target="saveVehicle, rc_document, insurance_document, fitness_document, truck_photo" class="flex-1 py-3 bg-[#0A0A0A] text-white rounded-xl text-xs font-extrabold hover:bg-slate-800 transition-all uppercase tracking-widest disabled:opacity-70 flex items-center justify-center">
                                <span wire:loading.remove wire:target="saveVehicle">{{ $isEditMode ? 'UPDATE TRUCK' : 'SAVE TRUCK' }}</span>
                                <span wire:loading wire:target="saveVehicle">SAVING...</span>
                            </button>
                            
                            @if($isEditMode)
                                <button type="button" wire:click="resetForm" class="py-3 px-4 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-extrabold hover:bg-slate-200 transition-all uppercase">CANCEL</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search Vehicle No, RC..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold outline-none shadow-sm focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <select wire:model.live="statusFilter" class="w-full sm:w-auto px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold outline-none shadow-sm">
                        <option value="">All Status</option>
                        <option value="active">🟢 Active</option>
                        <option value="maintenance">🟠 Maintenance</option>
                        <option value="inactive">🔴 Inactive</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($vehicles as $vehicle)
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-sm hover:border-indigo-200 transition-all relative group">
                            
                            @php
                                $alerts = [];
                                $today = \Carbon\Carbon::now();
                                if($vehicle->insurance_expiry_date && \Carbon\Carbon::parse($vehicle->insurance_expiry_date)->diffInDays($today) < 30) $alerts[] = 'Insurance';
                                if($vehicle->fitness_expiry_date && \Carbon\Carbon::parse($vehicle->fitness_expiry_date)->diffInDays($today) < 30) $alerts[] = 'Fitness';
                            @endphp

                            @if(count($alerts) > 0)
                                <div class="absolute -top-2 -right-2 bg-rose-500 text-white text-[8px] font-black px-2 py-1 rounded-md shadow-sm uppercase tracking-widest animate-pulse">
                                    {{ implode(', ', $alerts) }} EXPIRING
                                </div>
                            @endif

                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ $vehicle->truck_number }}</h4>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">
                                        {{ $vehicle->truck_type ?? 'N/A' }} 
                                        @if($vehicle->capacity_tons) • {{ $vehicle->capacity_tons }} Ton @endif
                                    </p>
                                </div>
                                
                                @if($vehicle->status === 'active')
                                    <span class="px-2 py-1 rounded-md text-[9px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase">Active</span>
                                @elseif($vehicle->status === 'maintenance')
                                    <span class="px-2 py-1 rounded-md text-[9px] font-extrabold bg-amber-50 text-amber-600 border border-amber-100 uppercase">Maint.</span>
                                @else
                                    <span class="px-2 py-1 rounded-md text-[9px] font-extrabold bg-rose-50 text-rose-600 border border-rose-100 uppercase">Inactive</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-4 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">RC Number</p>
                                    <p class="text-[10px] font-bold text-slate-800 uppercase truncate">{{ $vehicle->rc_number ?? '---' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Ins. Expiry</p>
                                    <p class="text-[10px] font-bold {{ (count($alerts)>0 && in_array('Insurance', $alerts)) ? 'text-rose-600' : 'text-slate-800' }}">
                                        {{ $vehicle->insurance_expiry_date ? \Carbon\Carbon::parse($vehicle->insurance_expiry_date)->format('d M, Y') : '---' }}
                                    </p>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-50 flex gap-2">
                                <button wire:click="editVehicle({{ $vehicle->id }})" @click="showMobileForm = true; activeTab='basic'; setTimeout(() => $refs.truckInput.focus(), 100); window.scrollTo({top: 0, behavior: 'smooth'})" class="flex-1 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-100/50 rounded-xl transition-colors text-[9px] font-extrabold uppercase tracking-widest flex justify-center items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit Details
                                </button>
                                @if($vehicle->rc_document_path)
                                    <a href="{{ Storage::url($vehicle->rc_document_path) }}" target="_blank" class="py-2 px-3 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl transition-colors text-[9px] font-extrabold uppercase tracking-widest flex justify-center items-center" title="View RC">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 bg-white p-8 rounded-2xl border border-slate-200/60 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            </div>
                            <h4 class="text-sm font-black text-slate-900 uppercase">No Fleet Added Yet</h4>
                            <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">Register your first truck to get started.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $vehicles->links() }}</div>
            </div>
        </div>
    </div>
</div>