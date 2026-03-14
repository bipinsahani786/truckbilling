<div class="space-y-6 animate-in fade-in duration-500 max-w-3xl mx-auto">

    <div class="bg-slate-900 p-6 rounded-3xl shadow-xl text-white relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full"></div>
        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
            <div class="w-20 h-20 bg-slate-800 border-2 border-indigo-500 rounded-2xl flex items-center justify-center overflow-hidden shadow-lg shrink-0">
                @if($driver->profile_photo_path)
                    <img src="{{ Storage::url($driver->profile_photo_path) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-3xl font-black text-indigo-500">{{ $driver->initials() }}</span>
                @endif
            </div>
            <div class="flex-1 mt-2 sm:mt-0">
                <p class="text-[10px] font-extrabold text-indigo-400 uppercase tracking-widest mb-1">Registered Driver</p>
                <h2 class="text-2xl font-black uppercase tracking-tight">{{ $driver->name }}</h2>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-3">
                    <span class="bg-indigo-500/20 text-indigo-300 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $driver->mobile_number ?? 'N/A' }}
                    </span>
                    @if($driver->blood_group)
                    <span class="bg-rose-500/20 text-rose-300 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2.5a.5.5 0 00-.5.5v1.25a.5.5 0 001 0V3a.5.5 0 00-.5-.5zM10 6a.5.5 0 00-.5.5v1.25a.5.5 0 001 0V6.5A.5.5 0 0010 6zM10 10a.5.5 0 00-.5.5v1.25a.5.5 0 001 0v-1.25A.5.5 0 0010 10zM10 14a.5.5 0 00-.5.5v1.25a.5.5 0 001 0v-1.25A.5.5 0 0010 14zM10 17a.5.5 0 00-.5.5v1.25a.5.5 0 001 0v-1.25A.5.5 0 0010 17z"></path></svg>
                        {{ $driver->blood_group }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-2">Personal Identity Vault</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Driving License</p>
                        <p class="text-sm font-black text-slate-900 uppercase mt-0.5">{{ $driver->license_number ?: 'NOT UPDATED' }}</p>
                    </div>
                </div>
                <div class="mt-auto">
                    @if($driver->license_document_path)
                        <a href="{{ Storage::url($driver->license_document_path) }}" target="_blank" class="block w-full py-3 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-700 text-center rounded-xl text-xs font-black uppercase tracking-widest transition-colors shadow-sm">View Document</a>
                    @else
                        <button disabled class="w-full py-3 bg-slate-100 text-slate-400 text-center rounded-xl text-xs font-black uppercase tracking-widest cursor-not-allowed">Not Uploaded</button>
                    @endif
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h3"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Aadhar Card</p>
                        <p class="text-sm font-black text-slate-900 uppercase mt-0.5">{{ $driver->aadhar_number ?: 'NOT UPDATED' }}</p>
                    </div>
                </div>
                <div class="mt-auto">
                    @if($driver->aadhar_document_path)
                        <a href="{{ Storage::url($driver->aadhar_document_path) }}" target="_blank" class="block w-full py-3 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-700 text-center rounded-xl text-xs font-black uppercase tracking-widest transition-colors shadow-sm">View Document</a>
                    @else
                        <button disabled class="w-full py-3 bg-slate-100 text-slate-400 text-center rounded-xl text-xs font-black uppercase tracking-widest cursor-not-allowed">Not Uploaded</button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="pt-2">
        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-2">Active Vehicle Documents</h3>
        
        @if($vehicle)
        <div class="bg-slate-900 p-5 rounded-t-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Currently Driving</p>
                <h2 class="text-2xl font-black uppercase tracking-tight text-white mt-0.5">{{ $vehicle->truck_number }}</h2>
            </div>
            <div>
                <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> On Active Trip
                </span>
            </div>
        </div>

        <div class="bg-white rounded-b-2xl border border-slate-200 border-t-0 p-5 shadow-sm space-y-4">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl flex flex-col h-full">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">RC Number</p>
                    <p class="text-base font-black text-slate-900 uppercase mb-4 mt-1">{{ $vehicle->rc_number ?: 'N/A' }}</p>
                    
                    <div class="mt-auto">
                        @if($vehicle->rc_document_path)
                            <a href="{{ Storage::url($vehicle->rc_document_path) }}" target="_blank" class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white rounded-lg text-[11px] font-black uppercase tracking-widest transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> 
                                View RC
                            </a>
                        @else
                            <span class="block w-full py-2.5 bg-slate-100 text-slate-400 text-center rounded-lg text-[11px] font-bold uppercase tracking-widest">No File</span>
                        @endif
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl flex flex-col h-full">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Insurance Expiry</p>
                    @php $insExpired = $vehicle->insurance_expiry_date && \Carbon\Carbon::parse($vehicle->insurance_expiry_date)->isPast(); @endphp
                    <p class="text-base font-black {{ $insExpired ? 'text-rose-600' : 'text-slate-900' }} uppercase mb-4 mt-1">
                        {{ $vehicle->insurance_expiry_date ? \Carbon\Carbon::parse($vehicle->insurance_expiry_date)->format('d M Y') : 'N/A' }}
                        @if($insExpired) <span class="text-[10px] bg-rose-100 text-rose-600 px-2 py-0.5 rounded ml-2 align-middle">Expired</span> @endif
                    </p>
                    
                    <div class="mt-auto">
                        @if($vehicle->insurance_document_path)
                            <a href="{{ Storage::url($vehicle->insurance_document_path) }}" target="_blank" class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white rounded-lg text-[11px] font-black uppercase tracking-widest transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> 
                                View Insurance
                            </a>
                        @else
                            <span class="block w-full py-2.5 bg-slate-100 text-slate-400 text-center rounded-lg text-[11px] font-bold uppercase tracking-widest">No File</span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl flex flex-col h-full">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Fitness Valid Till</p>
                    @php $fitExpired = $vehicle->fitness_expiry_date && \Carbon\Carbon::parse($vehicle->fitness_expiry_date)->isPast(); @endphp
                    <p class="text-base font-black {{ $fitExpired ? 'text-rose-600' : 'text-slate-900' }} uppercase mb-4 mt-1">
                        {{ $vehicle->fitness_expiry_date ? \Carbon\Carbon::parse($vehicle->fitness_expiry_date)->format('d M Y') : 'N/A' }}
                        @if($fitExpired) <span class="text-[10px] bg-rose-100 text-rose-600 px-2 py-0.5 rounded ml-2 align-middle">Expired</span> @endif
                    </p>
                    
                    <div class="mt-auto">
                        @if($vehicle->fitness_document_path)
                            <a href="{{ Storage::url($vehicle->fitness_document_path) }}" target="_blank" class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white rounded-lg text-[11px] font-black uppercase tracking-widest transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> 
                                View Fitness
                            </a>
                        @else
                            <span class="block w-full py-2.5 bg-slate-100 text-slate-400 text-center rounded-lg text-[11px] font-bold uppercase tracking-widest">No File</span>
                        @endif
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pollution Valid Till</p>
                    @php $polExpired = $vehicle->pollution_expiry_date && \Carbon\Carbon::parse($vehicle->pollution_expiry_date)->isPast(); @endphp
                    <p class="text-base font-black {{ $polExpired ? 'text-rose-600' : 'text-slate-900' }} uppercase mt-1">
                        {{ $vehicle->pollution_expiry_date ? \Carbon\Carbon::parse($vehicle->pollution_expiry_date)->format('d M Y') : 'N/A' }}
                        @if($polExpired) <span class="text-[10px] bg-rose-100 text-rose-600 px-2 py-0.5 rounded ml-2 align-middle">Expired</span> @endif
                    </p>
                </div>

            </div>

            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">National Permit Expiry</p>
                @php $npExpired = $vehicle->national_permit_expiry_date && \Carbon\Carbon::parse($vehicle->national_permit_expiry_date)->isPast(); @endphp
                <p class="text-base font-black {{ $npExpired ? 'text-rose-600' : 'text-slate-900' }} uppercase mt-1">
                    {{ $vehicle->national_permit_expiry_date ? \Carbon\Carbon::parse($vehicle->national_permit_expiry_date)->format('d M Y') : 'N/A' }}
                    @if($npExpired) <span class="text-[10px] bg-rose-100 text-rose-600 px-2 py-0.5 rounded ml-2 align-middle">Expired</span> @endif
                </p>
            </div>

        </div>
        @else
        <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-10 text-center">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <h3 class="text-base font-black text-slate-900 uppercase">No Active Vehicle Assigned</h3>
            <p class="text-xs font-bold text-slate-500 mt-2 max-w-sm mx-auto">Gaadi ki RC, Insurance aur Fitness dekhne ke liye aapko pehle koi Trip assign honi zaroori hai.</p>
        </div>
        @endif
    </div>

</div>