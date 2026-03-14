<div class="space-y-5 animate-in fade-in duration-500">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 shadow-sm group hover:border-indigo-200 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Revenue</p>
                    <h3 class="text-lg font-bold text-slate-900 leading-none mt-0.5">₹4,82,000</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 shadow-sm group hover:border-emerald-200 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Fleet Status</p>
                    <div class="flex items-center justify-between mt-0.5">
                        <h3 class="text-lg font-bold text-slate-900">18/24</h3>
                        <span class="text-[9px] font-bold text-emerald-600">75%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 shadow-sm group hover:border-amber-200 transition-all">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pending Dues</p>
                    <h3 class="text-lg font-bold text-slate-900 mt-0.5">₹64,250</h3>
                </div>
            </div>
        </div>

        <button class="bg-slate-900 hover:bg-black text-white p-4 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2 group">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">New Trip</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
            <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest">Live Trip Feed</h4>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-[10px] font-bold bg-white border border-slate-200 rounded-lg hover:bg-slate-50">Filter</button>
                <button class="px-3 py-1 text-[10px] font-bold bg-white border border-slate-200 rounded-lg hover:bg-slate-50">Export</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Truck Info</th>
                        <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Route</th>
                        <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Profit</th>
                        <th class="px-4 py-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-slate-900 rounded-lg flex items-center justify-center text-[8px] font-bold text-white italic">Z-1</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 uppercase leading-none">HR-55-AS-9022</p>
                                    <p class="text-[9px] text-slate-400 mt-1 font-medium italic">Trip #2045</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-[10px] font-bold text-slate-700">INDORE <span class="text-indigo-400 mx-1">→</span> MUMBAI</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-md text-[8px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase tracking-wider">In Transit</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <p class="text-xs font-bold text-slate-900 tracking-tighter">₹14,500</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="p-1.5 hover:bg-slate-100 rounded-md transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>