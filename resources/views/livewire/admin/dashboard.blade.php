@if($isDriver)
    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .stagger-1 { animation-delay: 100ms; }
        .stagger-2 { animation-delay: 200ms; }
        .stagger-3 { animation-delay: 300ms; }
    </style>
    <!-- Professional Driver Dashboard -->
    <div class="max-w-6xl mx-auto px-4 space-y-12 animate-slide-up pb-20">
        
        <!-- Premium Hero Section -->
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-[3rem] blur opacity-10 group-hover:opacity-20 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative bg-slate-900 rounded-[2.5rem] p-6 md:p-10 shadow-2xl overflow-hidden border border-slate-800/50">
                <!-- Dynamic Mesh Background -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[120px] animate-pulse"></div>
                
                <div class="relative z-10 flex flex-col items-center text-center">
                    <!-- Abstract Background Icon -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.03] pointer-events-none">
                        <svg class="w-64 h-64 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>

                    <div class="space-y-4 max-w-2xl mx-auto relative z-10">
                        <div class="inline-flex items-center gap-3 px-3 py-1.5 bg-indigo-500/10 rounded-xl border border-indigo-500/20 backdrop-blur-md">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-ping"></div>
                            <span class="text-[8px] font-black text-indigo-300 uppercase tracking-[0.4em]">Logistics Command</span>
                        </div>
                        
                        <div class="space-y-1">
                            <h1 class="text-3xl md:text-5xl font-black text-white leading-tight uppercase tracking-tighter">
                                Welcome, 
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-indigo-400 to-emerald-400">
                                    {{ explode(' ', auth()->user()->name)[0] }}
                                </span>
                            </h1>
                            <p class="text-slate-400 font-medium text-sm max-w-lg mx-auto">
                                Driving the future of <span class="text-white font-bold">JMD TRUCK MANAGEMENT</span> with precision and safety.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                            <div class="bg-white/5 backdrop-blur-xl border border-white/10 px-5 py-2.5 rounded-xl group/stat hover:bg-white/10 transition-all cursor-default">
                                <p class="text-[8px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-0.5 opacity-70">Fleet Status</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-xl font-black text-white tracking-tighter">{{ count($liveTrips) }}</span>
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Active</span>
                                </div>
                            </div>
                            @php
                                $balance = \App\Models\Wallet::where('driver_id', auth()->id())->value('balance') ?? 0;
                            @endphp
                            <div class="bg-white/5 backdrop-blur-xl border border-white/10 px-5 py-2.5 rounded-xl group/stat hover:bg-white/10 transition-all cursor-default">
                                <p class="text-[8px] font-black {{ $balance >= 0 ? 'text-emerald-400' : 'text-rose-400' }} uppercase tracking-[0.2em] mb-0.5 opacity-70">Wallet Credits</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-xl font-black text-white tracking-tighter">₹{{ number_format($balance) }}</span>
                                    <div class="w-1.5 h-1.5 rounded-full {{ $balance >= 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Assignment Board -->
        <div class="space-y-10">
            <div class="flex flex-col items-center text-center space-y-2">
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Assignment Board</h2>
                <div class="w-12 h-1 bg-indigo-600 rounded-full"></div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] pt-2">Real-time logistics monitoring</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($liveTrips as $trip)
                    <div class="group relative bg-white rounded-[1.5rem] p-5 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden animate-slide-up opacity-0 fill-mode-both" style="animation-delay: {{ ($loop->index + 1) * 150 }}ms">
                        <div class="relative z-10 space-y-4">
                            <!-- Compact Header -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-slate-900 rounded flex items-center justify-center">
                                        <span class="text-[8px] font-black text-white">T</span>
                                    </div>
                                    <span class="text-[11px] font-black text-slate-900">#{{ $trip->trip_number }}</span>
                                </div>
                                <span @class([
                                    'px-2 py-0.5 rounded text-[7px] font-black uppercase tracking-wider',
                                    'bg-indigo-50 text-indigo-600' => $trip->status === 'in_transit',
                                    'bg-amber-50 text-amber-600' => $trip->status === 'scheduled',
                                    'bg-emerald-50 text-emerald-600' => $trip->status === 'completed',
                                ])>
                                    {{ str_replace('_', ' ', $trip->status) }}
                                </span>
                            </div>

                            <!-- Horizontal Route -->
                            <div class="flex items-center justify-between gap-3 py-1">
                                <div class="flex-1">
                                    <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest mb-0.5">From</p>
                                    <p class="text-[13px] font-black text-slate-900 uppercase truncate">{{ $trip->from_location }}</p>
                                </div>
                                <div class="flex flex-col items-center px-2">
                                    <div class="w-8 h-px bg-slate-200 relative">
                                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-indigo-500 rounded-full border-2 border-white"></div>
                                    </div>
                                </div>
                                <div class="flex-1 text-right">
                                    <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest mb-0.5">To</p>
                                    <p class="text-[13px] font-black text-slate-900 uppercase truncate">{{ $trip->to_location }}</p>
                                </div>
                            </div>

                            <!-- Streamlined Specs Row -->
                            <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-100 gap-4">
                                <div class="shrink-0">
                                    <p class="text-[7px] font-black text-slate-400 uppercase mb-0.5">Vehicle</p>
                                    <p class="text-[9px] font-extrabold text-indigo-600 uppercase">{{ $trip->vehicle->truck_number ?? 'N/A' }}</p>
                                </div>
                                <div class="flex-1 border-x border-slate-200 px-3 text-center">
                                    <p class="text-[7px] font-black text-slate-400 uppercase mb-0.5">Load</p>
                                    <p class="text-[9px] font-bold text-slate-800 uppercase">{{ $trip->material_description ?: 'General' }} | {{ $trip->weight_tons ?? 0 }}T</p>
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="text-[7px] font-black text-slate-400 uppercase mb-0.5">POD</p>
                                    <p class="text-[9px] font-bold {{ $trip->pod_status === 'verified' ? 'text-emerald-500' : 'text-amber-500' }} uppercase">{{ $trip->pod_status }}</p>
                                </div>
                            </div>

                            <a href="{{ route('driver.trips') }}" wire:navigate class="flex items-center justify-center w-full py-2 bg-slate-900 text-white rounded-lg text-[9px] font-black uppercase tracking-[0.15em] hover:bg-indigo-600 transition-all shadow-md active:scale-[0.98]">
                                Update Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-white border-2 border-dashed border-slate-200 rounded-[3rem] text-center space-y-6">
                        <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto shadow-inner">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-xl font-black text-slate-900 uppercase">Standby Mode</h3>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">No active assignments on your board.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if(count($liveTrips) > 0)
            <div class="flex justify-center pt-8">
                <a href="{{ route('driver.trips') }}" wire:navigate class="group flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-[2rem] text-[11px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-2xl shadow-slate-900/20 active:scale-95">
                    Explore All Assignments
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            @endif
        </div>
    </div>
@else
<div class="space-y-6 animate-slide-up pb-16">
    
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
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
@endif


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