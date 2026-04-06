<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-stone-50 p-8">
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('applications.index') }}" wire:navigate
                   class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-slate-700 transition-colors hover:bg-slate-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <div>
                    <p class="text-sm font-medium text-slate-500">Application detail</p>
                    <h1 class="mt-0.5 text-2xl font-bold text-slate-900">{{ $application->organization_name }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        @php
                            $cc = ['Government'=>'background:#dbeafe;color:#1d4ed8','Private'=>'background:#ede9fe;color:#6d28d9','Public'=>'background:#dcfce7;color:#15803d','Small Entrepreneurs'=>'background:#fef9c3;color:#854d0e'];
                        @endphp
                        <span class="inline-flex items-center rounded-xl px-3 py-1.5 text-xs font-semibold" style="{{ $cc[$application->category] ?? 'background:#f1f5f9;color:#475569' }}">{{ $application->category }}</span>
                        <span class="inline-flex items-center rounded-xl px-3 py-1.5 text-xs font-semibold {{ $application->trashed() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                            {{ $application->trashed() ? 'Archived' : 'Active' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                @if($isEditing)
                    <button type="button"
                            wire:click="saveEdit"
                            wire:loading.attr="disabled"
                            wire:target="saveEdit"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveEdit">Save changes</span>
                        <span wire:loading wire:target="saveEdit">Saving...</span>
                    </button>
                    <button type="button"
                            wire:click="cancelEdit"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100">
                        Cancel
                    </button>
                @else
                    <button type="button"
                            wire:click="edit"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100">
                        Edit fields
                    </button>
                @endif

                @if($application->trashed())
                    <button type="button"
                            wire:click="restore"
                            wire:loading.attr="disabled"
                            wire:target="restore"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992V4.356m-.991 4.992A9 9 0 1 0 6.5 17.5" />
                        </svg>
                        <span wire:loading.remove wire:target="restore">Restore application</span>
                        <span wire:loading wire:target="restore">Restoring...</span>
                    </button>
                @else
                    <button type="button"
                            wire:click="archive"
                            wire:loading.attr="disabled"
                            wire:target="archive"
                            class="inline-flex items-center gap-2 rounded-xl bg-rose-100 px-4 py-2.5 text-sm font-semibold text-rose-700 transition-colors hover:bg-rose-200 disabled:cursor-not-allowed disabled:opacity-60">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5m-1.5 0-.663 9.954A2.25 2.25 0 0 1 15.844 19.5H8.156a2.25 2.25 0 0 1-2.243-2.046L5.25 7.5m3-3h7.5" />
                        </svg>
                        <span wire:loading.remove wire:target="archive">Archive application</span>
                        <span wire:loading wire:target="archive">Archiving...</span>
                    </button>
                @endif
            </div>
        </div>

        @if($notice)
            <div x-data="{ show: @entangle('notice').live }"
                 x-show="show"
                 x-transition.opacity.duration.350ms
                 x-init="$watch('show', value => { if (value) { clearTimeout(window.votafricaDetailNoticeTimer); window.votafricaDetailNoticeTimer = setTimeout(() => { show = null; }, 4000); } })"
                 class="rounded-2xl border px-5 py-4 text-sm font-medium {{ $noticeType === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-amber-200 bg-amber-50 text-amber-800' }}">
                {{ $notice }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-4 border-b border-slate-100 px-6 py-5">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="truncate text-lg font-semibold text-slate-900">{{ $application->organization_name }}</h2>
                    <p class="mt-0.5 text-sm text-slate-500">
                        Submitted {{ $application->created_at->format('F j, Y \a\t h:i A') }}
                        @if($application->trashed() && $application->deleted_at)
                            • Archived {{ $application->deleted_at->diffForHumans() }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2">
                <div class="border-b border-slate-100 px-6 py-5">
                    <p class="mb-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">Business Location</p>
                    @if($isEditing)
                        <input type="text" wire:model.blur="business_location" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300" />
                        @error('business_location') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    @else
                        <p class="text-sm font-semibold text-slate-900">{{ $application->business_location }}</p>
                    @endif
                </div>
                <div class="border-b border-slate-100 px-6 py-5 sm:border-l">
                    <p class="mb-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">Phone Number</p>
                    @if($isEditing)
                        <input type="text" wire:model.blur="phone_number" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300" />
                        @error('phone_number') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    @else
                        <p class="text-sm font-semibold text-slate-900">{{ $application->phone_number }}</p>
                    @endif
                </div>
                <div class="border-b border-slate-100 px-6 py-5">
                    <p class="mb-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">Capital Range</p>
                    @if($isEditing)
                        <select wire:model.blur="capital_range" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                            <option value="">Choose range</option>
                            <option value="10M-100M">10M - 100M</option>
                            <option value="100M-1B">100M - 1B</option>
                            <option value="1B and above">1B and above</option>
                        </select>
                        @error('capital_range') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    @else
                        <p class="text-sm font-semibold text-slate-900">{{ $application->capital_range }}</p>
                    @endif
                </div>
                <div class="border-b border-slate-100 px-6 py-5 sm:border-l">
                    <p class="mb-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">Category</p>
                    @if($isEditing)
                        <select wire:model.blur="category" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300">
                            <option value="">Choose category</option>
                            <option value="Government">Government</option>
                            <option value="Private">Private</option>
                            <option value="Public">Public</option>
                            <option value="Small Entrepreneurs">Small Entrepreneurs</option>
                        </select>
                        @error('category') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    @else
                        <p class="text-sm font-semibold text-slate-900">{{ $application->category }}</p>
                    @endif
                </div>
                <div class="px-6 py-5 sm:col-span-2">
                    <p class="mb-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">Business Activity</p>
                    <p class="text-sm font-semibold leading-7 text-slate-900">{{ $application->business_activity }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
