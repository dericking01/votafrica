<div class="space-y-6 rounded-3xl border border-slate-200/80 bg-gradient-to-br from-white via-slate-50 to-stone-50 p-4 shadow-sm sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-500">Manage submissions</p>
            <h1 class="text-2xl font-bold text-slate-900 mt-0.5">All Applications</h1>
        </div>

        <form wire:submit.prevent class="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:flex-nowrap sm:justify-end">
            <div class="relative w-full sm:w-auto">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search applications..."
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-sm text-slate-800 shadow-sm focus:border-slate-400 focus:outline-none sm:w-64"
                />
            </div>
            <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-slate-700">Search</button>
            @if($search !== '')
                <button type="button" wire:click="clearSearch" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                    Clear
                </button>
            @endif
            <button type="button"
                    wire:click="toggleFilters"
                    class="inline-flex items-center gap-2 rounded-xl border px-4 py-2.5 text-sm font-semibold transition-colors {{ $showFilters || $this->hasActiveFilters() ? 'border-slate-900 bg-slate-900 text-white hover:bg-slate-700' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 4.995 2.14 4.995 4.777v.216A4.91 4.91 0 0 1 15.5 11.4l-2.134 1.423a1.5 1.5 0 0 0-.666 1.247v2.68m0 0h-1.4m1.4 0h1.4" />
                </svg>
                Filter
            </button>
            <button type="button"
                    wire:click="exportFilteredApplications"
                    class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition-colors hover:bg-emerald-100">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V3m0 13.5-4.5-4.5M12 16.5l4.5-4.5M3.75 20.25h16.5" />
                </svg>
                Export
            </button>
        </form>
    </div>

    <div class="flex w-full items-center gap-2 rounded-2xl border border-slate-200 bg-white p-1.5 sm:w-fit">
        <button type="button"
                wire:click="setTab('active')"
                class="flex-1 rounded-xl px-4 py-2 text-sm font-semibold transition-colors sm:flex-none {{ $tab === 'active' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
            Active
        </button>
        <button type="button"
                wire:click="setTab('archived')"
                class="flex-1 rounded-xl px-4 py-2 text-sm font-semibold transition-colors sm:flex-none {{ $tab === 'archived' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
            Archived
        </button>
    </div>

    @if($showFilters)
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-6">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">Status</label>
                    <select wire:model.live="statusFilter" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <option value="all">Follow tab</option>
                        <option value="active">Active only</option>
                        <option value="archived">Archived only</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">Category</label>
                    <select wire:model.live="categoryFilter" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <option value="all">All categories</option>
                        <option value="Government">Government</option>
                        <option value="Private">Private</option>
                        <option value="Public">Public</option>
                        <option value="Small Entrepreneurs">Small Entrepreneurs</option>
                        <option value="NGO">NGO</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">Capital</label>
                    <select wire:model.live="capitalFilter" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <option value="all">All ranges</option>
                        <option value="100k - 1M">100k - 1M</option>
                        <option value="1M -10M">1M -10M</option>
                        <option value="10M-100M">10M - 100M</option>
                        <option value="100M-1B">100M - 1B</option>
                        <option value="1B and above">1B and above</option>
                        <option value="Prefer not to say">Prefer not to say</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">Date From</label>
                    <input type="date" wire:model.live="dateFrom" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300" />
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">Payment</label>
                    <select wire:model.live="paymentFilter" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <option value="all">All payments</option>
                        <option value="PAID">PAID</option>
                        <option value="UNPAID">UNPAID</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500">Date To</label>
                    <input type="date" wire:model.live="dateTo" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300" />
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end gap-2">
                <button type="button" wire:click="clearFilters" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100">
                    Reset filters
                </button>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-[860px] w-full">
            <thead>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Organization</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Location</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden md:table-cell">Activity</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden lg:table-cell">Phone</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden lg:table-cell">Capital</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Category</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Payment</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-5 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden sm:table-cell">Date</th>
                    @if($this->isArchivedView())
                        <th class="px-5 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                    @endif
                    <th class="px-5 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                        <td class="px-5 py-4">
                            <a href="{{ route('applications.show', $app) }}" wire:navigate class="text-sm font-semibold text-slate-900 transition-colors hover:text-slate-700">{{ $app->organization_name }}</a>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">{{ $app->business_location }}</td>
                        <td class="px-5 py-4 text-sm text-slate-500 hidden md:table-cell" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $app->business_activity }}</td>
                        <td class="px-5 py-4 text-sm text-slate-500 hidden lg:table-cell">{{ $app->phone_number }}</td>
                        <td class="px-5 py-4 hidden lg:table-cell">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-xs font-medium text-slate-700">{{ $app->capital_range }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $cc = ['Government' => 'background:#dbeafe;color:#1d4ed8', 'Private' => 'background:#ede9fe;color:#6d28d9', 'Public' => 'background:#dcfce7;color:#15803d', 'Small Entrepreneurs' => 'background:#fef9c3;color:#854d0e', 'NGO' => 'background:#fee2e2;color:#9f1239'];
                                $categoryLabel = $app->category === 'Small Entrepreneurs' ? 'SME' : $app->category;
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold" style="{{ $cc[$app->category] ?? 'background:#f1f5f9;color:#475569' }}">{{ $categoryLabel }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold {{ $app->payment_status === 'PAID' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-700' }}">
                                {{ $app->payment_status ?: 'UNPAID' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold {{ $app->trashed() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $app->trashed() ? 'Archived' : 'Active' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right text-xs text-slate-400 hidden sm:table-cell">{{ $app->created_at->format('M d, Y') }}</td>
                        @if($this->isArchivedView())
                            <td class="px-5 py-4 text-center">
                                <button type="button"
                                        wire:click="restoreApplication({{ $app->id }})"
                                        class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-200">
                                    Restore
                                </button>
                            </td>
                        @endif
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('applications.show', $app) }}" wire:navigate
                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900"
                               title="View details">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $this->isArchivedView() ? 11 : 10 }}" class="px-5 py-16 text-center">
                            <p class="text-slate-400 text-sm">No applications found{{ $search ? ' matching &ldquo;'.$search.'&rdquo;' : '' }}.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($applications->hasPages())
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Showing {{ $applications->firstItem() }}-{{ $applications->lastItem() }} of {{ $applications->total() }}</p>
            {{ $applications->links(data: ['scrollTo' => false]) }}
        </div>
    @endif
</div>
