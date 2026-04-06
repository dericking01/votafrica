<x-layouts.app>
    <div class="p-8 space-y-6">

        {{-- Page header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('applications.index') }}" wire:navigate
               class="flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-colors shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
            <div>
                <p class="text-sm text-slate-500">Application detail</p>
                <h1 class="text-2xl font-bold text-slate-900 mt-0.5">{{ $application->organization_name }}</h1>
            </div>
        </div>

        {{-- Detail card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Card header --}}
            <div class="px-6 py-5 flex items-center gap-4" style="border-bottom:1px solid #f1f5f9;">
                <div class="h-11 w-11 rounded-xl flex items-center justify-center shrink-0" style="background:#fef2f2;">
                    <svg class="w-5 h-5" style="color:#ef4444;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="font-semibold text-slate-900 truncate">{{ $application->organization_name }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Submitted {{ $application->created_at->format('F j, Y \a\t h:i A') }}</p>
                </div>
                @php
                    $cc = ['Government'=>'background:#dbeafe;color:#1d4ed8','Private'=>'background:#ede9fe;color:#6d28d9','Public'=>'background:#dcfce7;color:#15803d','Small Entrepreneurs'=>'background:#fef9c3;color:#854d0e'];
                @endphp
                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shrink-0" style="{{ $cc[$application->category] ?? 'background:#f1f5f9;color:#475569' }}">{{ $application->category }}</span>
            </div>

            {{-- Fields grid --}}
            <div class="grid sm:grid-cols-2">
                <div class="px-6 py-5" style="border-bottom:1px solid #f8fafc;">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Business Location</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $application->business_location }}</p>
                </div>
                <div class="px-6 py-5" style="border-bottom:1px solid #f8fafc;border-left:1px solid #f8fafc;">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Phone Number</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $application->phone_number }}</p>
                </div>
                <div class="px-6 py-5" style="border-bottom:1px solid #f8fafc;">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Capital Range</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $application->capital_range }}</p>
                </div>
                <div class="px-6 py-5" style="border-bottom:1px solid #f8fafc;border-left:1px solid #f8fafc;">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Category</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $application->category }}</p>
                </div>
                <div class="px-6 py-5 sm:col-span-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Business Activity</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $application->business_activity }}</p>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
