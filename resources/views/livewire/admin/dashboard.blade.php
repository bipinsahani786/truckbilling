<div class="space-y-6 animate-in fade-in duration-500 pb-16">
    
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-5">
        <div>
            <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">
                {{ $isDriver ? 'Driver Dashboard' : 'Command Center' }}
            </h2>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Performance & Analytics</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase mr-2">From</span>
                <input type="date" wire:model.live="date_from" class="bg-transparent text-xs font-bold text-slate-700 outline-none">
            </div>
            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase mr-2">To</span>
                <input type="date" wire:model.live="date_to" class="bg-transparent text-xs font-bold text-slate-700 outline-none">
            </div>
            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                <select wire:model.live="status_filter" class="bg-transparent text-xs font-bold text-slate-700 outline-none uppercase">
                    <option value="">All Statuses</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="in_transit">In Transit</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <button wire:click="resetFilters" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold uppercase transition-colors">
                Reset
            </button>
        </div>
    </div>

    <!-- Trip Range Selection Section -->
    <div class="bg-slate-900 p-6 rounded-3xl shadow-2xl flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 relative overflow-hidden border border-slate-800">
        <!-- Background Glows -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-indigo-600/10 rounded-full blur-[100px]"></div>
        <div class="absolute -left-20 -top-20 w-64 h-64 bg-emerald-600/5 rounded-full blur-[100px]"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center border border-indigo-500/30 shadow-inner">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <h3 class="text-xl font-black text-white uppercase tracking-tight leading-none mb-2">Trip Range Analysis</h3>
                @if($trip_from && $trip_to)
                    <p class="text-xs text-emerald-400 font-black uppercase tracking-widest animate-pulse">
                        Analyzing trips {{ $trip_from }} to {{ $trip_to }}
                    </p>
                @else
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] opacity-80">Select trip sequence for batch calculation</p>
                @endif
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4 w-full xl:w-auto relative z-10">
            <div class="flex items-center gap-3 bg-slate-800/50 p-1.5 rounded-2xl border border-slate-700/50">
                <div class="flex items-center bg-slate-900 rounded-xl px-4 py-3 border border-slate-700 focus-within:border-indigo-500 transition-all">
                    <span class="text-[10px] font-black text-slate-500 uppercase mr-4 whitespace-nowrap">From Trip</span>
                    <input type="number" wire:model="trip_from" placeholder="e.g. 1" class="bg-transparent text-base font-black text-white w-20 outline-none placeholder:text-slate-700">
                </div>
                <div class="flex items-center bg-slate-900 rounded-xl px-4 py-3 border border-slate-700 focus-within:border-indigo-500 transition-all">
                    <span class="text-[10px] font-black text-slate-500 uppercase mr-4 whitespace-nowrap">To Trip</span>
                    <input type="number" wire:model="trip_to" placeholder="e.g. 10" class="bg-transparent text-base font-black text-white w-20 outline-none placeholder:text-slate-700">
                </div>
                <button wire:click="$refresh" class="group flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-xl font-black uppercase text-xs tracking-widest transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                    <span wire:loading.remove wire:target="$refresh">Run Analysis</span>
                    <span wire:loading wire:target="$refresh" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Analyzing...
                    </span>
                    <svg wire:loading.remove wire:target="$refresh" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

            @if($trip_from && $trip_to)
            <div class="flex-1 bg-indigo-500/10 border border-indigo-500/20 rounded-2xl p-4 flex flex-col justify-center">
                <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">
                    @if($actualTripCount < (abs($trip_to - $trip_from) + 1))
                        <span class="text-amber-400">Notice: Only {{ $actualTripCount }} trips found in this range</span>
                    @else
                        Batch Performance
                    @endif
                </p>
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-xs font-bold text-white">Your {{ $actualTripCount }} trips gives you </span>
                        <span class="text-base font-black text-emerald-400">₹{{ number_format($netProfit) }} profit</span>
                    </div>
                    <div class="flex items-baseline gap-2 opacity-80">
                        <span class="text-[10px] font-bold text-slate-300">and </span>
                        <span class="text-xs font-black text-rose-400">₹{{ number_format($totalExpenses) }} is the loss (expenses)</span>
                    </div>
                </div>
            </div>
            
            <button wire:click="resetFilters" class="p-4 bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white rounded-2xl transition-all border border-rose-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <div class="bg-white p-5 rounded-2xl border-b-4 border-indigo-500 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Total Revenue</p>
                <h3 class="text-2xl font-black text-slate-900">₹{{ number_format($totalRevenue) }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border-b-4 border-rose-500 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Total Expenses</p>
                <h3 class="text-2xl font-black text-slate-900">₹{{ number_format($totalExpenses) }}</h3>
            </div>
        </div>

        @unless($isDriver)
        <div class="bg-slate-900 p-5 rounded-2xl shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Net Profitability</p>
                <h3 class="text-2xl font-black {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    ₹{{ number_format($netProfit) }}
                </h3>
            </div>
        </div>
        @endunless

        @if($isOwner)
        <div class="bg-white p-5 rounded-2xl border-b-4 border-amber-500 shadow-sm">
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">On-Road Fleet</p>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-black text-slate-900">{{ $onRoadVehicles }} <span class="text-sm text-slate-400">/ {{ $totalVehicles }}</span></h3>
                <span class="text-xs font-black text-amber-600">{{ $fleetPercentage }}%</span>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
                <div class="bg-amber-500 h-full" style="width: {{ $fleetPercentage }}%"></div>
            </div>
        </div>
        @else
        <div class="bg-emerald-500 p-5 rounded-2xl shadow-xl text-white">
            <p class="text-[10px] font-extrabold text-emerald-100 uppercase tracking-widest mb-1">Driver Performance</p>
            <h3 class="text-xl font-black">Active Trips: {{ count($liveTrips) }}</h3>
            <p class="text-xs font-bold text-emerald-100 mt-2">Keep up the safe driving!</p>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">15-Day Logistics Trend</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-500"></span><span class="text-[10px] font-bold text-slate-500 uppercase">Freight</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-400"></span><span class="text-[10px] font-bold text-slate-500 uppercase">Recovery</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-rose-400"></span><span class="text-[10px] font-bold text-slate-500 uppercase">Expense</span></div>
                </div>
            </div>
            
            <div wire:ignore class="relative h-64 w-full">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row gap-4 sm:items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                        </span>
                        Live Trip Feed
                    </h4>
                    <span class="h-4 w-[1px] bg-slate-200 hidden sm:block"></span>
                    <a href="{{ route('admin.trips') }}" wire:navigate class="text-[10px] font-bold text-indigo-600 hover:underline uppercase tracking-widest">View All</a>
                </div>
                
                <div class="relative flex-1 sm:max-w-[240px]">
                    <svg class="absolute left-3 top-2.5 w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search Live Feed..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-bold outline-none focus:ring-4 focus:ring-indigo-500/5 transition-all">
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto p-3 space-y-2 max-h-64 no-scrollbar">
                @forelse($liveTrips as $trip)
                    <div class="bg-white border border-slate-100 p-3 rounded-xl hover:border-indigo-200 hover:shadow-md transition-all cursor-pointer group">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded uppercase">T-{{ $trip->trip_number }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase">{{ str_replace('_', ' ', $trip->status) }}</span>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-xs font-black text-slate-800 uppercase">{{ $trip->from_location }} <span class="text-indigo-400 px-1">→</span> {{ $trip->to_location }}</p>
                                <p class="text-[10px] font-bold text-slate-500 mt-0.5">{{ $trip->vehicle->truck_number ?? 'N/A' }} | Dr: {{ explode(' ', $trip->driver->name ?? '')[0] }}</p>
                            </div>
                            @unless(auth()->user()->hasRole('driver'))
                            <div class="text-right">
                                <p class="text-[9px] text-slate-400 font-bold uppercase">Net Bal</p>
                                <p class="text-sm font-black {{ $trip->current_profit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">₹{{ number_format($trip->current_profit) }}</p>
                            </div>
                            @endunless
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center p-6 opacity-50">
                        <svg class="w-10 h-10 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">No Active Trips</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        let chartInstance = null;

        const renderChart = () => {
            const ctx = document.getElementById('analyticsChart');
            if(!ctx) return;

            if(chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Freight (Bhaada)',
                            data: @json($chartFreight),
                            borderColor: '#6366f1', // Indigo
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Recovery (Aamad)',
                            data: @json($chartRecovery),
                            borderColor: '#34d399', // Emerald
                            borderWidth: 3,
                            borderDash: [5, 5],
                            fill: false,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Expenses (Kharcha)',
                            data: @json($chartExpense),
                            borderColor: '#fb7185', // Rose
                            borderWidth: 3,
                            borderDash: [3, 3],
                            fill: false,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 9, family: 'sans-serif', weight: 'bold' } } },
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f1f5f9' }, 
                            ticks: { 
                                font: { size: 9, weight: 'bold' },
                                // ✅ BUG FIXED: Y-Axis now properly handles '0'
                                callback: function(value) { 
                                    if (value === 0) return 'RS 0';
                                    return value >= 1000 ? 'RS ' + (value / 1000) + 'k' : 'RS ' + value; 
                                }
                            } 
                        }
                    },
                    interaction: { mode: 'index', intersect: false }
                }
            });
        };

        // Render on initial load
        renderChart();

        // Re-render when Livewire updates the filters
        Livewire.hook('morph.updated', ({ el, component }) => {
            renderChart();
        });
    });
</script>