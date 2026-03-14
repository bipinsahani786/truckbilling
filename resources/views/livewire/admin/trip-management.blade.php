<div class="pb-16 bg-slate-50 min-h-screen">
    
    @if($currentView === 'list')
    <div class="animate-in fade-in duration-500 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-black text-slate-900 uppercase">Trip Radar</h2>
            <button wire:click="showCreate" class="px-5 py-2.5 bg-slate-900 text-white rounded-lg text-xs font-extrabold shadow-md active:scale-95 transition-all">
                + NEW TRIP
            </button>
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
                            <th class="px-4 py-3 text-xs font-extrabold text-slate-500 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($trips as $trip)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-black text-slate-900 uppercase">T-{{ $trip->id }} | {{ $trip->from_location }} ➔ {{ $trip->to_location }}</p>
                                    <p class="text-xs text-slate-500 mt-1 truncate max-w-[200px]">{{ $trip->dealer->company_name ?? 'Direct Party' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-bold text-slate-900 uppercase">{{ $trip->vehicle->truck_number ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 mt-1 capitalize">Driver: {{ $trip->driver->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded-md text-xs font-bold uppercase {{ $trip->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ str_replace('_', ' ', $trip->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="showManage({{ $trip->id }})" class="px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold shadow-sm transition-colors">
                                        Manage
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-6 text-center text-sm text-slate-500 font-bold uppercase">No Trips Found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">{{ $trips->links() }}</div>
        </div>
    </div>
    @endif

    @if($currentView === 'create')
    <div class="max-w-3xl mx-auto animate-in fade-in duration-500">
        <div class="flex items-center gap-4 mb-6">
            <button wire:click="showList" class="p-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </button>
            <h2 class="text-xl font-black text-slate-900 uppercase">Create New Trip</h2>
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

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 border-t border-slate-100 pt-6">
                <div class="col-span-2">
                    <label class="text-xs font-bold text-slate-500 uppercase">Material (Optional)</label>
                    <input type="text" wire:model="material_description" placeholder="e.g. Steel Pipes" class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold uppercase outline-none">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Weight (Tons)</label>
                    <input type="number" step="0.1" wire:model="weight_tons" placeholder="0.0" class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold outline-none">
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="w-full py-4 bg-[#0A0A0A] hover:bg-slate-800 text-white rounded-xl text-sm font-black uppercase tracking-widest shadow-lg transition-all">
                Dispatch Trip
            </button>
        </form>
    </div>
    @endif

    @if($currentView === 'manage' && $tripDetails)
    <div class="max-w-5xl mx-auto space-y-6 animate-in fade-in duration-300">
        
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button wire:click="showList" class="p-2 bg-slate-100 rounded-lg hover:bg-slate-200"><svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg></button>
                <div>
                    <h2 class="text-lg font-black uppercase">T-{{ $tripDetails->id }} | {{ $tripDetails->vehicle->truck_number }}</h2>
                    <p class="text-xs text-slate-500 font-bold">{{ $tripDetails->from_location }} ➔ {{ $tripDetails->to_location }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <select wire:model="trip_status" wire:change="updateTripStatus" class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold outline-none uppercase">
                    <option value="scheduled">Scheduled</option>
                    <option value="loaded">Loaded</option>
                    <option value="in_transit">In Transit</option>
                    <option value="unloaded">Unloaded</option>
                    <option value="completed">Completed</option>
                </select>
                @if($tripDetails->status !== 'completed')
                    <button wire:click="endTrip" class="px-4 py-2.5 bg-rose-500 text-white rounded-lg text-sm font-black uppercase shadow-sm">End Trip</button>
                @endif
            </div>
        </div>

        @if(session()->has('console_success')) 
            <div class="p-3 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-lg border border-emerald-100 text-center">{{ session('console_success') }}</div> 
        @endif

        <div class="grid grid-cols-3 gap-0 bg-slate-900 rounded-xl shadow-lg text-white overflow-hidden divide-x divide-slate-700">
            <div class="p-4 text-center">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Total Aamad</p>
                <p class="text-2xl font-black text-emerald-400 mt-1">₹{{ number_format($totalRevenue) }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Total Kharcha</p>
                <p class="text-2xl font-black text-rose-400 mt-1">₹{{ number_format($totalExpense) }}</p>
            </div>
            <div class="p-4 text-center bg-slate-800">
                <p class="text-xs text-slate-300 font-bold uppercase tracking-widest">Net Profit</p>
                <p class="text-2xl font-black {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-rose-500' }} mt-1">₹{{ number_format($netProfit) }}</p>
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
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($driverExp as $ex)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $ex->category->name ?? 'Other' }}</span>
                                <span class="text-base font-black text-rose-600">₹{{ number_format($ex->amount) }}</span>
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
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($ownerExp as $ex)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $ex->category->name ?? 'Other' }}</span>
                                <span class="text-base font-black text-rose-600">₹{{ number_format($ex->amount) }}</span>
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
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($driverRec as $rc)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $rc->remarks ?: 'Cash Aamad' }}</span>
                                <span class="text-base font-black text-emerald-600">₹{{ number_format($rc->amount) }}</span>
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
                
                <div class="p-3 flex-1 overflow-y-auto max-h-64 space-y-2 bg-slate-50/50">
                    @forelse($ownerRec as $rc)
                        <div class="bg-white p-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-800 uppercase">{{ $rc->remarks ?: 'Bank Aamad' }}</span>
                                <span class="text-base font-black text-emerald-600">₹{{ number_format($rc->amount) }}</span>
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

    </div>
    @endif

    @if($showTxModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 animate-in fade-in">
        <div class="bg-white w-full max-w-sm rounded-2xl overflow-hidden shadow-2xl animate-in zoom-in-95">
            <div class="p-4 border-b border-slate-100 flex justify-between items-center {{ $tx_type == 'expense' ? 'bg-rose-50' : 'bg-emerald-50' }}">
                <h3 class="text-sm font-black uppercase {{ $tx_type == 'expense' ? 'text-rose-700' : 'text-emerald-700' }}">
                    Add {{ $tx_type }} ({{ $tx_payment_mode == 'wallet' ? 'Driver' : 'Owner' }})
                </h3>
                <button wire:click="$set('showTxModal', false)" class="text-slate-400 hover:text-slate-900 font-bold">X</button>
            </div>
            
            <form wire:submit.prevent="saveTransaction" class="p-5 space-y-5">
                
                @if($tx_type == 'expense')
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Category *</label>
                    <div class="flex gap-2 mt-1">
                        <select wire:model="tx_category_id" required class="flex-1 p-3 border border-slate-200 rounded-lg text-sm font-bold outline-none">
                            <option value="">Select</option>
                            @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                        </select>
                        <button type="button" wire:click="$set('showCatModal', true)" class="px-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg border border-indigo-100 transition-colors">+ New</button>
                    </div>
                </div>
                @endif

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Amount (₹) *</label>
                    <input type="number" wire:model="tx_amount" required class="w-full mt-1 p-3 border border-slate-200 rounded-lg text-xl font-black outline-none {{ $tx_type == 'expense' ? 'text-rose-600' : 'text-emerald-600' }}">
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Remarks (Optional)</label>
                    <input type="text" wire:model="tx_remarks" placeholder="Add note..." class="w-full mt-1 p-3 border border-slate-200 rounded-lg text-sm outline-none">
                </div>

                <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-black text-white rounded-xl text-sm font-black uppercase tracking-widest shadow-lg transition-all">
                    Save Entry
                </button>
            </form>
        </div>
    </div>
    @endif

    @if($showCatModal)
    <div class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-900/60 p-4">
        <div class="bg-white p-5 rounded-2xl w-full max-w-xs shadow-2xl">
            <h3 class="text-sm font-black uppercase mb-4 text-slate-900">New Category</h3>
            <input type="text" wire:model="new_cat_name" placeholder="e.g. Police Entry, Toll" class="w-full p-3 border border-slate-200 rounded-lg text-sm font-bold mb-4 outline-none uppercase focus:border-indigo-500">
            <div class="flex gap-3">
                <button wire:click="$set('showCatModal', false)" class="w-1/2 p-3 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg uppercase">Cancel</button>
                <button wire:click="saveNewCategory" class="w-1/2 p-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg uppercase transition-all">Save</button>
            </div>
        </div>
    </div>
    @endif

</div>