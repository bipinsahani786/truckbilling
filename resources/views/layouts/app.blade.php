<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zytrixon Pro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            letter-spacing: -0.01em;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="antialiased text-slate-900 overflow-x-hidden" x-data="{ profile: false }">

    <div class="flex min-h-screen">

        <aside class="hidden lg:flex flex-col w-[240px] bg-white border-r border-slate-200/60 sticky top-0 h-screen z-50">
            <div class="h-14 flex items-center px-6 border-b border-slate-50">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-slate-900 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-[800] tracking-tighter text-slate-900 uppercase">Zytrixon</span>
                </a>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto no-scrollbar">

                {{-- Owner Sidebar: Full fleet management menu --}}
                @role('owner')
                    <p class="px-3 text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2">Management</p>

                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.trips') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('admin.trips') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                            </path>
                        </svg>
                        Trips & Dispatch
                    </a>

                    <a href="{{ route('admin.dealers') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('admin.dealers') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Dealers & Parties
                    </a>

                    <a href="{{ route('admin.vehicles') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('admin.vehicles') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Fleet Management
                    </a>

                    <p class="px-3 text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 mt-6">Financials</p>

                    <a href="{{ route('admin.drivers') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('admin.drivers') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Driver Wallets
                    </a>

                    <a href="{{ route('admin.expense.categories') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('admin.expense.categories') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                        Expense Settings
                    </a>
                @endrole

                {{-- Super-Admin Sidebar: Only user management and expense categories --}}
                @role('super-admin')
                    <p class="px-3 text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2">Administration</p>

                    <a href="{{ route('admin.users') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('admin.users') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        User Management
                    </a>

                    <a href="{{ route('superadmin.expense.categories') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('superadmin.expense.categories') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                        Expense Settings
                    </a>
                @endrole

                @role('driver')
                    <p class="px-3 text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2">Driver App</p>

                    <a href="{{ route('driver.trips') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('driver.trips') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        My Trips
                    </a>

                    <a href="{{ route('driver.documents') }}" wire:navigate
                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-bold text-[13px] transition-all 
                        {{ request()->routeIs('driver.documents') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h3"></path>
                        </svg>
                        My Documents
                    </a>
                @endrole

            </nav>

            <div class="p-3 mt-auto border-t border-slate-50">
                <div class="bg-slate-50/80 rounded-xl p-2 border border-slate-100">
                    <div class="flex items-center gap-2 mb-2">
                        <div
                            class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-[10px] uppercase">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-[11px] font-bold text-slate-900 truncate capitalize">
                                {{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">
                                {{ auth()->user()?->roles->first()?->name ?? 'Staff' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0">

            <header class="h-14 px-4 lg:px-8 flex items-center justify-between sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200/50">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest hidden sm:block">Zytrixon Panel</span>
                    <span class="h-4 w-[1px] bg-slate-200 hidden sm:block"></span>

                    <h2 class="text-sm font-bold text-slate-900">
                        @if (request()->routeIs('dashboard')) Dashboard
                        @elseif(request()->routeIs('admin.trips') || request()->routeIs('driver.trips')) Trip Management
                        @elseif(request()->routeIs('admin.vehicles')) Fleet Management
                        @elseif(request()->routeIs('admin.dealers')) Party Registry
                        @elseif(request()->routeIs('admin.drivers')) Driver Registry
                        @elseif(request()->routeIs('admin.expense.categories') || request()->routeIs('superadmin.expense.categories')) Expense Settings
                        @elseif(request()->routeIs('admin.users')) User Management
                        @elseif(request()->routeIs('profile')) Profile Settings
                        @elseif(request()->routeIs('driver.documents')) My Documents
                        @else Control Panel
                        @endif
                    </h2>
                </div>

                <div class="flex items-center gap-3 lg:gap-4">

                    @role('driver')
                        @php
                            $walletBalance = \App\Models\Wallet::where('driver_id', auth()->id())->value('balance') ?? 0;
                        @endphp
                        <div class="flex items-center gap-1.5 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg shadow-sm">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-[8px] font-extrabold text-emerald-600 uppercase tracking-widest leading-none">Wallet Bal.</span>
                                <span class="text-xs font-black text-emerald-700 leading-tight">₹{{ number_format($walletBalance) }}</span>
                            </div>
                        </div>
                    @endrole

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 p-1 bg-white border border-slate-200 rounded-xl hover:border-slate-300 transition-all">
                            <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-[10px] uppercase">
                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 p-1.5 z-50 font-bold text-xs text-slate-600">
                            <a href="{{ route('profile') }}" wire:navigate class="block px-4 py-2 hover:bg-slate-50 rounded-xl transition-all font-bold text-slate-700">
                                Profile Settings
                            </a>
                            <hr class="my-1 border-slate-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-600 rounded-xl transition-all">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </header>

            <div class="p-5 lg:p-6 pb-24 overflow-x-hidden">
                {{ $slot }}
            </div>
        </main>
    </div>

    <nav class="lg:hidden fixed bottom-4 left-4 right-4 h-14 bg-slate-900 shadow-2xl rounded-2xl flex items-center justify-around px-2 z-50">

        {{-- Owner Mobile Nav --}}
        @role('owner')
            <a href="{{ route('dashboard') }}" wire:navigate
                class="p-2 transition-colors {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </a>

            <a href="{{ route('admin.vehicles') }}" wire:navigate
                class="p-2 transition-colors {{ request()->routeIs('admin.vehicles') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </a>

            <a href="{{ route('admin.trips') }}" wire:navigate
                class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg transition-transform active:scale-95 {{ request()->routeIs('admin.trips') ? 'ring-2 ring-indigo-300 ring-offset-2 ring-offset-slate-900' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </a>

            <a href="{{ route('admin.dealers') }}" wire:navigate
                class="p-2 transition-colors {{ request()->routeIs('admin.dealers') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </a>

            <a href="{{ route('admin.drivers') }}" wire:navigate
                class="p-2 transition-colors {{ request()->routeIs('admin.drivers') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </a>
        @endrole

        {{-- Super-Admin Mobile Nav --}}
        @role('super-admin')

            <a href="{{ route('admin.users') }}" wire:navigate
                class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg transition-transform active:scale-95 {{ request()->routeIs('admin.users') ? 'ring-2 ring-indigo-300 ring-offset-2 ring-offset-slate-900' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </a>

            <a href="{{ route('superadmin.expense.categories') }}" wire:navigate
                class="p-2 transition-colors {{ request()->routeIs('superadmin.expense.categories') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </a>
        @endrole

        @role('driver')
            <a href="{{ route('dashboard') }}" wire:navigate
                class="p-2 transition-colors {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </a>

            <a href="{{ route('driver.trips') }}" wire:navigate
                class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg transition-transform active:scale-95 {{ request()->routeIs('driver.trips') ? 'ring-2 ring-emerald-300 ring-offset-2 ring-offset-slate-900' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
            </a>

            <a href="{{ route('driver.documents') }}" wire:navigate class="p-2 transition-colors {{ request()->routeIs('driver.documents') ? 'text-emerald-400' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </a>
        @endrole

    </nav>

</body>

</html>