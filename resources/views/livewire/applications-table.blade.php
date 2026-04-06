<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-500">Manage submissions</p>
            <h1 class="text-2xl font-bold text-slate-900 mt-0.5">All Applications</h1>
        </div>

        <form wire:submit.prevent class="flex items-center gap-2">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search applications..."
                    class="pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 shadow-sm w-64 focus:outline-none focus:border-red-400"
                />
            </div>
            <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors" style="background:#ef4444;">Search</button>
            @if($search !== '')
                <button type="button" wire:click="clearSearch" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                    Clear
                </button>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Organization</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Location</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden md:table-cell">Activity</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden lg:table-cell">Phone</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden lg:table-cell">Capital</th>
                    <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Category</th>
                    <th class="px-5 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-widest hidden sm:table-cell">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                        <td class="px-5 py-4">
                            <a href="{{ route('applications.show', $app) }}" wire:navigate class="font-semibold text-slate-900 hover:text-red-500 transition-colors text-sm">{{ $app->organization_name }}</a>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">{{ $app->business_location }}</td>
                        <td class="px-5 py-4 text-sm text-slate-500 hidden md:table-cell" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $app->business_activity }}</td>
                        <td class="px-5 py-4 text-sm text-slate-500 hidden lg:table-cell">{{ $app->phone_number }}</td>
                        <td class="px-5 py-4 hidden lg:table-cell">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-xs font-medium text-slate-700">{{ $app->capital_range }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $cc = ['Government' => 'background:#dbeafe;color:#1d4ed8', 'Private' => 'background:#ede9fe;color:#6d28d9', 'Public' => 'background:#dcfce7;color:#15803d', 'Small Entrepreneurs' => 'background:#fef9c3;color:#854d0e'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold" style="{{ $cc[$app->category] ?? 'background:#f1f5f9;color:#475569' }}">{{ $app->category }}</span>
                        </td>
                        <td class="px-5 py-4 text-right text-xs text-slate-400 hidden sm:table-cell">{{ $app->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <p class="text-slate-400 text-sm">No applications found{{ $search ? ' matching &ldquo;'.$search.'&rdquo;' : '' }}.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($applications->hasPages())
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Showing {{ $applications->firstItem() }}-{{ $applications->lastItem() }} of {{ $applications->total() }}</p>
            {{ $applications->links(data: ['scrollTo' => false]) }}
        </div>
    @endif
</div>
