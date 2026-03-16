<div>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5">
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
            <p class="text-2xl font-black text-slate-900">{{ $stats['totalUsers'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5">
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Owners</p>
            <p class="text-2xl font-black text-indigo-600">{{ $stats['totalOwners'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5">
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Drivers</p>
            <p class="text-2xl font-black text-emerald-600">{{ $stats['totalDrivers'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5">
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Blocked</p>
            <p class="text-2xl font-black text-rose-600">{{ $stats['blockedUsers'] }}</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-2xl border border-slate-200/60 p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name, email, or mobile..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all" />
            </div>
            <select wire:model.live="roleFilter"
                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all">
                <option value="">All Roles</option>
                <option value="owner">Owners</option>
                <option value="driver">Drivers</option>
            </select>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">User</th>
                        <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest hidden md:table-cell">Contact</th>
                        <th class="text-left px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Role</th>
                        <th class="text-center px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="text-center px-5 py-3.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- User Name & ID -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $user->is_blocked ? 'bg-rose-100 text-rose-600' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center font-black text-xs uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-[13px]">{{ $user->name }}</p>
                                        <p class="text-[11px] font-medium text-slate-400">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact Info -->
                            <td class="px-5 py-4 hidden md:table-cell">
                                <p class="text-[13px] font-semibold text-slate-700">{{ $user->email ?? '—' }}</p>
                                <p class="text-[11px] font-medium text-slate-400">{{ $user->mobile_number ?? '—' }}</p>
                            </td>

                            <!-- Role Badge -->
                            <td class="px-5 py-4">
                                @php $role = $user->roles->first()?->name ?? 'user'; @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider
                                    {{ $role === 'owner' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                    {{ $role }}
                                </span>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-5 py-4 text-center">
                                @if($user->is_blocked)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 border border-rose-100 text-[10px] font-extrabold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Blocked
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-extrabold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Block / Unblock Toggle -->
                                    <button wire:click="toggleBlock({{ $user->id }})"
                                        wire:confirm="Are you sure you want to {{ $user->is_blocked ? 'unblock' : 'block' }} {{ $user->name }}?"
                                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-all
                                        {{ $user->is_blocked 
                                            ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200' 
                                            : 'bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200' }}">
                                        {{ $user->is_blocked ? 'Unblock' : 'Block' }}
                                    </button>

                                    <!-- Reset Password Button -->
                                    <button wire:click="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 transition-all">
                                        Reset Pass
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-sm font-bold text-slate-400">No users found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Password Reset Modal -->
    @if($showResetModal)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModals">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-slate-200/60 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Reset Password</h3>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">For: <span class="font-bold text-slate-600">{{ $resetUserName }}</span></p>
                    </div>
                    <button wire:click="closeModals" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit="resetUserPassword" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">New Password</label>
                        <input wire:model="newPassword" type="password" placeholder="Enter new password (min 6 chars)"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all" />
                        @error('newPassword') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Confirm Password</label>
                        <input wire:model="newPasswordConfirmation" type="password" placeholder="Confirm new password"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all" />
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeModals"
                            class="flex-1 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 py-2.5 rounded-xl text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 transition-all shadow-sm">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
