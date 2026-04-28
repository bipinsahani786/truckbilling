<div class="pb-16 bg-slate-50 min-h-screen">
    
    @if($currentView === 'list')
    <div class="animate-in fade-in duration-500 max-w-7xl mx-auto px-4 lg:px-0">
        
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-6">
            <h2 class="text-xl font-black text-slate-900 uppercase">Trip Radar</h2>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto">
                
                <div class="flex items-center gap-2 bg-white border border-slate-200 p-1.5 rounded-xl shadow-sm w-full sm:w-auto">
                    <input type="date" wire:model.live="filter_from_date" class="bg-transparent text-xs font-bold text-slate-600 outline-none px-2 w-full sm:w-auto">
                    <span class="text-xs font-bold text-slate-400">To</span>
                    <input type="date" wire:model.live="filter_to_date" class="bg-transparent text-xs font-bold text-slate-600 outline-none px-2 w-full sm:w-auto">
                </div>

                <div class="relative w-full sm:w-80">
                    <svg class="absolute left-3 top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search Route, Truck, Driver, Party..." class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold outline-none shadow-sm focus:border-indigo-500 transition-all">
                </div>

                <div class="flex items-center gap-2 bg-white border border-slate-200 p-1 rounded-xl shadow-sm w-full sm:w-auto">
                    <select wire:model.live="statusFilter" class="bg-transparent text-xs font-bold text-slate-600 outline-none px-3 py-1.5 min-w-[120px]">
                        <option value="">All Status</option>
                        <option value="in_transit">🚚 In Transit</option>
                        <option value="completed">✅ Completed</option>
                        <option value="settled">💰 Settled</option>
                    </select>
                </div>
                
                <button wire:click="showCreate" class="w-full sm:w-auto px-5 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-extrabold shadow-md active:scale-95 transition-all whitespace-nowrap">
                    + NEW TRIP
                </button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mb-4 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-slate-100 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-xs font-extrabold text-slate-500 uppercase">Route</th>
                            <th class="px-4 py-3 text-xs font-extrabold text-slate-500 uppercase">Vehicle / Driver</th>
                            <th class="px-4 py-3 text-xs font-extrabold text-slate-500 uppercase text-center">Status</th>
                            @unless(auth()->user()->hasRole('driver'))
                            <th class="px-4 py-3 text-xs font-extrabold text-slate-500 uppercase text-right">Profit / Loss</th>
                            @endunless
                            <th class="px-4 py-3 text-xs font-extrabold text-slate-500 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($trips as $trip)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-black text-slate-900 uppercase">T-{{ $trip->trip_number }} | {{ $trip->from_location }} ➔ {{ $trip->to_location }}</p>
                                    <p class="text-xs text-slate-500 mt-1 truncate max-w-[200px]">{{ $trip->start_date ? \Carbon\Carbon::parse($trip->start_date)->format('d M Y') : 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-bold text-slate-900 uppercase">{{ $trip->vehicle->truck_number ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 mt-1 capitalize">Driver: {{ $trip->driver->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded-md text-[10px] font-bold uppercase {{ $trip->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ str_replace('_', ' ', $trip->status) }}
                                    </span>
                                </td>
                                @unless(auth()->user()->hasRole('driver'))
                                <td class="px-4 py-3 text-right">
                                    <p class="text-sm font-black {{ $trip->calculated_profit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        ₹{{ number_format($trip->calculated_profit) }}
                                    </p>
                                </td>
                                @endunless
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('trip.download', $trip->id) }}" target="_blank" title="Download Bill" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </a>

                                        <button wire:click="showEdit({{ $trip->id }})" title="Edit Trip" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <button wire:click="deleteTrip({{ $trip->id }})" wire:confirm="Are you sure you want to delete this trip and all its records? This cannot be undone." title="Delete Trip" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>

                                        <button wire:click="showManage({{ $trip->id }})" class="px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold shadow-sm transition-colors">
                                            Manage
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-6 text-center text-sm text-slate-500 font-bold uppercase">No Trips Found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">{{ $trips->links() }}</div>
        </div>
    </div>
    @endif

    @if($currentView === 'create')
    <div class="max-w-3xl mx-auto animate-in fade-in duration-500 px-4 lg:px-0">
        <div class="flex items-center gap-4 mb-6">
            <button wire:click="showList" class="p-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </button>
            <h2 class="text-xl font-black text-slate-900 uppercase">{{ $editingTripId ? 'Edit Trip' : 'Create New Trip' }}</h2>
        </div>

        <form wire:submit.prevent="saveTrip" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Select Truck *</label>
                    <select wire:model="vehicle_id" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none uppercase">
                        <option value="">-- Choose Truck --</option>
                        @foreach($vehicles as $v) <option value="{{ $v->id }}">{{ $v->truck_number }}</option> @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Select Driver *</label>
                    @if(Auth::user()->hasRole('driver'))
                        <div class="w-full mt-1 p-3 bg-slate-100 border border-slate-200 rounded-xl text-sm font-bold capitalize text-slate-600 cursor-not-allowed">
                            {{ Auth::user()->name }} (Auto-Assigned)
                        </div>
                    @else
                        <select wire:model="driver_id" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none capitalize">
                            <option value="">-- Choose Driver --</option>
                            @foreach($drivers as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Party / Dealer (Optional)</label>
                <select wire:model="dealer_id" class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none">
                    <option value="">Direct / Walk-in Party</option>
                    @foreach($dealers as $d) <option value="{{ $d->id }}">{{ $d->company_name }}</option> @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold text-indigo-600 uppercase">From Location *</label>
                    <input type="text" wire:model="from_location" required placeholder="Origin City" class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold uppercase outline-none">
                </div>
                <div>
                    <label class="text-xs font-bold text-emerald-600 uppercase">To Location *</label>
                    <input type="text" wire:model="to_location" required placeholder="Destination City" class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold uppercase outline-none">
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="w-full py-4 bg-[#0A0A0A] hover:bg-slate-800 text-white rounded-xl text-sm font-black uppercase tracking-widest shadow-lg transition-all">
                {{ $editingTripId ? 'Update Trip Details' : 'Dispatch Trip' }}
            </button>
        </form>
    </div>
    @endif

    @if($currentView === 'manage' && $tripDetails)
    <div class="max-w-5xl mx-auto space-y-6 animate-in fade-in duration-300 px-4 lg:px-0">
        
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button wire:click="showList" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200"><svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg></button>
                <div>
                    <h2 class="text-lg font-black uppercase leading-none">T-{{ $tripDetails->trip_number }} | {{ $tripDetails->vehicle->truck_number }}</h2>
                    <p class="text-xs text-slate-500 font-bold mt-1">{{ $tripDetails->from_location }} ➔ {{ $tripDetails->to_location }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="flex-1 sm:flex-none bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100 text-right">
                    <p class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-widest">Driver Wallet</p>
                    <p class="text-lg font-black text-indigo-900">₹{{ number_format($driverWalletBalance) }}</p>
                </div>
                <div class="flex-1 sm:flex-none bg-slate-50 px-4 py-2 rounded-lg border border-slate-200 text-right">
                    <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-widest">Driver Hisab</p>
                    <p class="text-lg font-black {{ $driverHisab >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $driverHisab > 0 ? '+' : '' }}₹{{ number_format($driverHisab) }}
                    </p>
                </div>
            </div>
        </div>

        @if(session()->has('console_success')) 
            <div class="p-3 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-lg border border-emerald-100 text-center">{{ session('console_success') }}</div> 
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-900 p-4 rounded-xl shadow-lg text-white">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select wire:model="trip_status" wire:change="updateTripStatus" class="p-2 bg-slate-800 border border-slate-700 text-white rounded text-sm font-bold outline-none uppercase">
                    <option value="scheduled">Scheduled</option>
                    <option value="in_transit">In Transit</option>
                    <option value="completed">Completed</option>
                </select>
                @if($tripDetails->status !== 'completed')
                    <button wire:click="endTrip" class="px-4 py-2 bg-rose-500 rounded text-sm font-bold uppercase">End Trip</button>
                @endif
            </div>

            <div class="flex gap-6 text-center w-full sm:w-auto justify-between">
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Total Aamad</p>
                    <p class="text-xl font-black text-emerald-400 mt-0.5">₹{{ number_format($totalRevenue) }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Total Kharcha</p>
                    <p class="text-xl font-black text-rose-400 mt-0.5">₹{{ number_format($totalExpense) }}</p>
                </div>
                @unless(auth()->user()->hasRole('driver'))
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest">Net Profit</p>
                    <p class="text-xl font-black {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-rose-500' }} mt-0.5">₹{{ number_format($netProfit) }}</p>
                </div>
                @endunless
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-xl border border-rose-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-rose-50 p-3 border-b border-rose-100 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-rose-800 uppercase">Driver Expense</h4>
                        <p class="text-xs text-rose-600 font-bold">Deduct from Wallet</p>
                    </div>
                    @if($tripDetails->status !== 'completed')
                        <button wire:click="openTxModal('expense', 'wallet')" class="px-3 py-1.5 bg-rose-600 text-white rounded text-xs font-black shadow-sm">+ ADD</button>
                    @endif
                </div>

                <div class="px-3 py-2 bg-rose-50/50 border-b border-rose-100">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="searchTxDriver" placeholder="Search expenses..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-rose-200 rounded-lg text-[10px] font-bold outline-none focus:border-rose-400">
                        <svg class="absolute left-2.5 top-2 w-3 h-3 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($driverExp as $ex)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm group">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $ex->category->name ?? 'Other' }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-base font-black text-rose-600">₹{{ number_format($ex->amount) }}</span>
                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="editTx({{ $ex->id }})" class="text-indigo-500 hover:text-indigo-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <button onclick="confirm('Delete entry? Wallet will refund.') || event.stopImmediatePropagation()" wire:click="deleteTx({{ $ex->id }})" class="text-rose-400 hover:text-rose-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </div>
                            </div>
                            @if($ex->remarks) <p class="text-xs text-slate-500 mt-1">{{ $ex->remarks }}</p> @endif
                            <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ $ex->created_at->format('d M, h:i A') }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic text-center py-4">No driver expenses.</p>
                    @endforelse
                </div>
                <div class="p-3 bg-white border-t border-slate-100 text-right">
                    <span class="text-xs font-bold text-slate-500 uppercase">Driver Sum: </span>
                    <span class="text-lg font-black text-rose-600">₹{{ number_format($sumDriverExp) }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-rose-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-rose-50 p-3 border-b border-rose-100 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-rose-800 uppercase">Owner Expense</h4>
                        <p class="text-xs text-rose-600 font-bold">Fastag / Online Bank</p>
                    </div>
                    @if($tripDetails->status !== 'completed')
                        <button wire:click="openTxModal('expense', 'owner_bank')" class="px-3 py-1.5 bg-rose-600 text-white rounded text-xs font-black shadow-sm">+ ADD</button>
                    @endif
                </div>

                <div class="px-3 py-2 bg-rose-50/50 border-b border-rose-100">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="searchTxOwner" placeholder="Search expenses..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-rose-200 rounded-lg text-[10px] font-bold outline-none focus:border-rose-400">
                        <svg class="absolute left-2.5 top-2 w-3 h-3 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($ownerExp as $ex)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm group">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $ex->category->name ?? 'Other' }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-base font-black text-rose-600">₹{{ number_format($ex->amount) }}</span>
                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="editTx({{ $ex->id }})" class="text-indigo-500 hover:text-indigo-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <button onclick="confirm('Delete entry?') || event.stopImmediatePropagation()" wire:click="deleteTx({{ $ex->id }})" class="text-rose-400 hover:text-rose-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </div>
                            </div>
                            @if($ex->remarks) <p class="text-xs text-slate-500 mt-1">{{ $ex->remarks }}</p> @endif
                            <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ $ex->created_at->format('d M, h:i A') }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic text-center py-4">No owner expenses.</p>
                    @endforelse
                </div>
                <div class="p-3 bg-white border-t border-slate-100 text-right">
                    <span class="text-xs font-bold text-slate-500 uppercase">Owner Sum: </span>
                    <span class="text-lg font-black text-rose-600">₹{{ number_format($sumOwnerExp) }}</span>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-xl border border-emerald-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-emerald-50 p-3 border-b border-emerald-100 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-emerald-800 uppercase">Driver Recovery</h4>
                        <p class="text-xs text-emerald-600 font-bold">Added to Wallet</p>
                    </div>
                    @if($tripDetails->status !== 'completed')
                        <button wire:click="openTxModal('recovery', 'wallet')" class="px-3 py-1.5 bg-emerald-600 text-white rounded text-xs font-black shadow-sm">+ ADD</button>
                    @endif
                </div>

                <div class="px-3 py-2 bg-emerald-50/50 border-b border-emerald-100">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="searchRecDriver" placeholder="Search recovery..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-emerald-200 rounded-lg text-[10px] font-bold outline-none focus:border-emerald-400">
                        <svg class="absolute left-2.5 top-2 w-3 h-3 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($driverRec as $rc)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm group">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $rc->remarks ?: 'Cash Aamad' }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-base font-black text-emerald-600">₹{{ number_format($rc->amount) }}</span>
                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="editTx({{ $rc->id }})" class="text-indigo-500 hover:text-indigo-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <button onclick="confirm('Delete entry? Wallet will deduct.') || event.stopImmediatePropagation()" wire:click="deleteTx({{ $rc->id }})" class="text-rose-400 hover:text-rose-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ $rc->created_at->format('d M, h:i A') }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic text-center py-4">No driver recovery.</p>
                    @endforelse
                </div>
                <div class="p-3 bg-white border-t border-slate-100 text-right">
                    <span class="text-xs font-bold text-slate-500 uppercase">Driver Sum: </span>
                    <span class="text-lg font-black text-emerald-600">₹{{ number_format($sumDriverRec) }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-emerald-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-emerald-50 p-3 border-b border-emerald-100 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-black text-emerald-800 uppercase">Owner Recovery</h4>
                        <p class="text-xs text-emerald-600 font-bold">Online Bank / Direct</p>
                    </div>
                    @if($tripDetails->status !== 'completed')
                        <button wire:click="openTxModal('recovery', 'owner_bank')" class="px-3 py-1.5 bg-emerald-600 text-white rounded text-xs font-black shadow-sm">+ ADD</button>
                    @endif
                </div>

                <div class="px-3 py-2 bg-emerald-50/50 border-b border-emerald-100">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="searchRecOwner" placeholder="Search recovery..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-emerald-200 rounded-lg text-[10px] font-bold outline-none focus:border-emerald-400">
                        <svg class="absolute left-2.5 top-2 w-3 h-3 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($ownerRec as $rc)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm group">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $rc->remarks ?: 'Bank Aamad' }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-base font-black text-emerald-600">₹{{ number_format($rc->amount) }}</span>
                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="editTx({{ $rc->id }})" class="text-indigo-500 hover:text-indigo-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <button onclick="confirm('Delete entry?') || event.stopImmediatePropagation()" wire:click="deleteTx({{ $rc->id }})" class="text-rose-400 hover:text-rose-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ $rc->created_at->format('d M, h:i A') }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic text-center py-4">No owner recovery.</p>
                    @endforelse
                </div>
                <div class="p-3 bg-white border-t border-slate-100 text-right">
                    <span class="text-xs font-bold text-slate-500 uppercase">Owner Sum: </span>
                    <span class="text-lg font-black text-emerald-600">₹{{ number_format($sumOwnerRec) }}</span>
                </div>
            </div>

        </div>

        <div class="mt-10 space-y-6">
            <div class="flex justify-between items-center px-2">
                <h3 class="text-xl font-black text-slate-900 uppercase">Party Billings</h3>
                <button wire:click="openBillingModal" class="px-5 py-2.5 bg-[#2a2b6e] text-white rounded-lg text-sm font-extrabold shadow-md">+ ADD PARTY</button>
            </div>

            @forelse($tripBillings as $bill)
                <div class="bg-[#2a2b6e] rounded-2xl shadow-xl p-6 md:p-8 text-white relative group border border-[#3d3e8a]">
                    
                    <div class="flex justify-between items-start mb-6 md:mb-8">
                        <h3 class="text-base md:text-lg font-black uppercase tracking-widest text-white">Party Billing & Dues</h3>
                        <div class="flex gap-2">
                            <button wire:click="editBilling({{ $bill->id }})" class="px-4 py-2 bg-[#4c4de6] hover:bg-[#3f40d1] text-white rounded-lg text-xs font-bold transition-colors">Edit Details</button>
                            <button wire:click="deleteBilling({{ $bill->id }})" onclick="confirm('Delete this party billing?') || event.stopImmediatePropagation()" class="px-3 py-2 bg-rose-500/20 text-rose-300 hover:bg-rose-500 hover:text-white rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-all">Delete</button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                        <div>
                            <p class="text-xs text-[#a0a1de] uppercase tracking-wider mb-1.5">Party Name</p>
                            <p class="text-lg md:text-xl font-bold text-white">{{ $bill->party_name ?: 'Direct' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#a0a1de] uppercase tracking-wider mb-1.5">Material</p>
                            <p class="text-lg md:text-xl font-bold text-white">{{ $bill->material_description ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#a0a1de] uppercase tracking-wider mb-1.5">Weight</p>
                            <p class="text-lg md:text-xl font-bold text-white">{{ $bill->weight_tons ?? 0 }} Tons</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#a0a1de] uppercase tracking-wider mb-1.5">Kul Bhaada</p>
                            <p class="text-2xl md:text-3xl font-black text-[#10b981]">₹{{ number_format($bill->freight_amount) }}</p>
                        </div>
                    </div>
                    
                    <hr class="border-[#3d3e8a] my-6 md:my-8">
                    
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs text-[#a0a1de] uppercase tracking-wider mb-1.5">Received From Party</p>
                            <p class="text-2xl md:text-3xl font-bold text-white">₹{{ number_format($bill->received_amount) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm md:text-base text-[#fca5a5] font-bold uppercase tracking-widest mb-1.5">Pending Dues</p>
                            <p class="text-4xl md:text-5xl font-black text-[#f87171]">₹{{ number_format($bill->freight_amount - $bill->received_amount) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-dashed border-slate-200 rounded-xl p-8 text-center text-slate-400">
                    <p class="text-sm font-bold uppercase tracking-widest">No Parties Added Yet</p>
                </div>
            @endforelse
            
            @if(count($tripBillings) > 0)
            <div class="flex justify-between items-end bg-slate-900 p-6 rounded-xl border border-slate-800 text-white shadow-sm">
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Total Party Collection</p>
                    <p class="text-2xl font-bold text-emerald-400">₹{{ number_format($totalPartyReceived) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 uppercase tracking-widest mb-1">Total Market Dues</p>
                    <p class="text-2xl font-black text-rose-400">₹{{ number_format($partyDues) }}</p>
                </div>
            </div>
            @endif

        </div>

    </div>
    @endif

    @if($showTxModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl overflow-hidden shadow-xl">
            <div class="p-5 border-b flex justify-between items-center {{ $tx_type == 'expense' ? 'bg-rose-50 border-rose-100' : 'bg-emerald-50 border-emerald-100' }}">
                <h3 class="text-base font-black uppercase {{ $tx_type == 'expense' ? 'text-rose-700' : 'text-emerald-700' }}">
                    {{ $editingTxId ? 'Edit' : 'Add' }} {{ $tx_type }}
                </h3>
                <button wire:click="$set('showTxModal', false)" class="font-bold text-xl">&times;</button>
            </div>
            <form wire:submit.prevent="saveTransaction" class="p-5 space-y-5">
                @if($tx_type == 'expense')
                <div>
                    <label class="text-sm font-bold text-slate-500 uppercase">Category *</label>
                    <div class="flex gap-2 mt-1">
                        <select wire:model="tx_category_id" required class="flex-1 p-3 border border-slate-200 rounded-lg text-sm font-bold outline-none">
                            <option value="">Select</option>@foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                        </select>
                        <button type="button" wire:click="$set('showCatModal', true)" class="px-4 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-lg">+ New</button>
                    </div>
                </div>
                @endif
                <div>
                    <label class="text-sm font-bold text-slate-500 uppercase">Amount (₹) *</label>
                    <input type="number" wire:model="tx_amount" required class="w-full mt-1 p-3 border border-slate-200 rounded-lg text-2xl font-black outline-none {{ $tx_type == 'expense' ? 'text-rose-600' : 'text-emerald-600' }}">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-500 uppercase">Remarks</label>
                    <input type="text" wire:model="tx_remarks" class="w-full mt-1 p-3 border border-slate-200 rounded-lg text-sm outline-none">
                </div>
                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-lg text-sm font-bold uppercase">{{ $editingTxId ? 'Update' : 'Save' }} Entry</button>
            </form>
        </div>
    </div>
    @endif

    @if($showCatModal)
    <div class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-900/60 p-4">
        <div class="bg-white p-6 rounded-xl w-full max-w-sm shadow-xl">
            <h3 class="text-base font-black uppercase mb-4">New Category</h3>
            <input type="text" wire:model="new_cat_name" placeholder="e.g. Toll" class="w-full p-3 border border-slate-200 rounded-lg text-sm font-bold mb-4 outline-none uppercase">
            <div class="flex gap-3">
                <button wire:click="$set('showCatModal', false)" class="w-1/2 py-3 bg-slate-100 font-bold rounded-lg text-sm">Cancel</button>
                <button wire:click="saveNewCategory" class="w-1/2 py-3 bg-indigo-600 text-white font-bold rounded-lg text-sm">Save</button>
            </div>
        </div>
    </div>
    @endif

    @if($showPartyModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/70 p-4">
        <div class="bg-[#2a2b6e] w-full max-w-md rounded-2xl overflow-hidden shadow-2xl border border-[#3d3e8a]">
            <div class="p-5 border-b border-[#3d3e8a] flex justify-between items-center">
                <h3 class="text-base font-black text-white uppercase">{{ $editingBillingId ? 'Edit' : 'Add' }} Details</h3>
                <button wire:click="$set('showPartyModal', false)" class="font-bold text-xl text-white">&times;</button>
            </div>
            <form wire:submit.prevent="saveBilling" class="p-5 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-[#a0a1de] uppercase">Party Name</label>
                        <input type="text" wire:model="b_party_name" placeholder="Direct" class="w-full mt-1 p-2.5 bg-[#1e1f4d] border border-[#3d3e8a] text-white rounded-lg text-sm font-bold outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#a0a1de] uppercase">Material</label>
                        <input type="text" wire:model="b_material" placeholder="e.g. Iron" class="w-full mt-1 p-2.5 bg-[#1e1f4d] border border-[#3d3e8a] text-white rounded-lg text-sm font-bold outline-none">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-[#a0a1de] uppercase">Weight (Tons)</label>
                    <input type="number" step="0.1" wire:model="b_weight" class="w-full mt-1 p-2.5 bg-[#1e1f4d] border border-[#3d3e8a] text-white rounded-lg text-sm font-bold outline-none">
                </div>
                <div class="bg-[#1e1f4d] p-3 rounded-lg border border-[#3d3e8a]">
                    <label class="text-xs font-bold text-[#a0a1de] uppercase">Total Bhaada (₹) *</label>
                    <input type="number" wire:model="b_freight" required class="w-full mt-1 p-2 bg-transparent text-[#10b981] text-2xl font-black outline-none">
                </div>
                <div class="bg-[#1e1f4d] p-3 rounded-lg border border-[#3d3e8a]">
                    <label class="text-xs font-bold text-[#a0a1de] uppercase">Received from Party (₹)</label>
                    <input type="number" wire:model="b_received" class="w-full mt-1 p-2 bg-transparent text-white text-xl font-bold outline-none">
                </div>
                <button type="submit" class="w-full py-4 bg-[#4c4de6] hover:bg-[#3f40d1] text-white rounded-lg text-sm font-bold uppercase tracking-widest mt-2 transition-colors">Save Party Entry</button>
            </form>
        </div>
    </div>
    @endif

</div>