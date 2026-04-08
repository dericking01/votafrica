<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VotAfrica Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: false, sidebarCollapsed: false }" class="bg-slate-50 antialiased" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur lg:hidden">
            <button type="button"
                    @click="sidebarOpen = true"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition-colors hover:bg-slate-100"
                    aria-label="Open menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <img src="{{ asset('images/votafricalogo-removebg.png') }}" alt="VotAfrica" class="h-8" />
            <div class="h-10 w-10"></div>
        </header>

        <div class="relative">
            <div x-show="sidebarOpen"
                 x-transition.opacity
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
                 style="display:none;"></div>

        {{-- Sidebar --}}
            <aside :class="[
                        sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                        sidebarCollapsed ? 'lg:w-20' : 'lg:w-64'
                    ]"
                   class="fixed inset-y-0 left-0 z-40 w-64 shrink-0 flex flex-col transition-all duration-300"
                   style="background:#0f172a;">

            <div class="flex items-center h-16 px-6" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                <img src="{{ asset('images/votafricalogo-removebg.png') }}" alt="VotAfrica" class="h-8" x-show="!sidebarCollapsed" x-transition.opacity>
                <button type="button"
                        class="ml-auto inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-300 transition-colors hover:bg-white/10 hover:text-white lg:hidden"
                        @click="sidebarOpen = false"
                        aria-label="Close menu">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
                <button type="button"
                        class="ml-auto hidden h-9 w-9 items-center justify-center rounded-lg text-slate-300 transition-colors hover:bg-white/10 hover:text-white lg:inline-flex"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
                    <svg class="h-4 w-4 transition-transform" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-5" style="display:flex;flex-direction:column;gap:2px;">
                <a href="{{ route('dashboard') }}" wire:navigate
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 hover:text-white' }}"
                         style="{{ request()->routeIs('dashboard') ? 'background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.12);box-shadow:0 8px 24px rgba(15,23,42,0.35);' : '' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Dashboard</span>
                </a>

                  <a href="{{ route('applications.index') }}" wire:navigate
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('applications.*') ? 'text-white' : 'text-slate-400 hover:text-white' }}"
                     style="{{ request()->routeIs('applications.*') ? 'background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.12);box-shadow:0 8px 24px rgba(15,23,42,0.35);' : '' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Applications</span>
                </a>
            </nav>

            <div class="px-3 pb-4 pt-4" style="border-top:1px solid rgba(255,255,255,0.08);">
                <div class="flex items-center gap-3 px-3 mb-3" :class="sidebarCollapsed ? 'justify-center' : ''">
                    <div class="h-8 w-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background:#334155;">
                        {{ auth()->user()->initials() }}
                    </div>
                    <div class="flex-1 min-w-0" x-show="!sidebarCollapsed" x-transition.opacity>
                        <p class="text-[13px] font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Sign out</span>
                    </button>
                </form>
            </div>

            </aside>

        {{-- Main content --}}
            <main :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'" class="min-h-screen pt-0 transition-all duration-300">
                <div class="min-h-screen overflow-y-auto">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>
    @livewireScripts
</body>
</html>
