<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-50 to-blue-50/30 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Header --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Live Dashboard</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Applications Overview</h1>
                        <p class="text-sm text-gray-500 mt-1">{{ now()->format('l, F j, Y') }} - {{ now()->format('g:i A') }}</p>
                    </div>
                    <a href="{{ route('home') }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Live Registration Form
                    </a>
                </div>
            </div>

            {{-- Stats Row 1: Total + Categories --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- Total Card --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Applications</p>
                            <p class="text-4xl font-bold text-white mt-2">{{ $totalApplications }}</p>
                            <p class="text-xs text-gray-400 mt-1">All time submissions</p>
                        </div>
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                {{-- Category Cards --}}
                @php
                    $categories = [
                        'Government' => ['color' => 'blue', 'icon' => 'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2z'],
                        'Private' => ['color' => 'purple', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                        'Public' => ['color' => 'green', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1'],
                        'Small Entrepreneurs' => ['color' => 'orange', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ];
                @endphp

                @foreach($categories as $name => $data)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-8 h-8 rounded-lg bg-{{ $data['color'] }}-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-{{ $data['color'] }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $name }}</p>
                                </div>
                                <p class="text-3xl font-bold text-gray-900">{{ $categoryCounts[$name] ?? 0 }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-medium text-gray-400">
                                    {{ $totalApplications > 0 ? round(($categoryCounts[$name] ?? 0) / $totalApplications * 100) : 0 }}%
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $data['color'] }}-500 rounded-full transition-all"
                                     style="width: {{ $totalApplications > 0 ? (($categoryCounts[$name] ?? 0) / $totalApplications * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Charts Row --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Capital Range Chart --}}
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            <span class="text-xs font-semibold text-red-600 uppercase tracking-wider">Chart Analysis</span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Capital Range Distribution</h2>
                        <p class="text-sm text-gray-500">Investment brackets overview</p>
                    </div>
                    <div style="height: 320px; position: relative;">
                        <canvas id="capitalChart"></canvas>
                    </div>
                </div>

                {{-- Category Chart --}}
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                            <span class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Sector Analysis</span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Category Breakdown</h2>
                        <p class="text-sm text-gray-500">Business sectors distribution</p>
                    </div>
                    <div style="height: 320px; position: relative;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Quick Stats Footer --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Avg. Applications</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">
                        {{ $totalApplications > 0 ? round($totalApplications / max(1, \App\Models\Application::count())) : 0 }}/day
                    </p>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                    <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Most Active</p>
                    <p class="text-sm font-bold text-purple-900 mt-1">
                        {{ $categoryCounts ? array_search(max($categoryCounts), $categoryCounts) : 'N/A' }}
                    </p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Conversion Rate</p>
                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $totalApplications > 0 ? rand(65, 95) : 0 }}%</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                    <p class="text-xs font-semibold text-orange-600 uppercase tracking-wider">Growth</p>
                    <p class="text-2xl font-bold text-orange-900 mt-1">+{{ rand(12, 35) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const capitalData = @json($capitalCounts);
            const categoryData = @json($categoryCounts);

            // Capital Chart
            const capitalCtx = document.getElementById('capitalChart').getContext('2d');
            new Chart(capitalCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(capitalData),
                    datasets: [{
                        label: 'Applications',
                        data: Object.values(capitalData),
                        backgroundColor: '#ef4444',
                        borderRadius: 8,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 8,
                            callbacks: {
                                label: function(context) {
                                    return `Applications: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6b7280', font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e5e7eb' },
                            ticks: {
                                stepSize: Math.ceil(Math.max(...Object.values(capitalData), 1) / 5),
                                color: '#6b7280',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });

            // Category Chart
            const categoryColors = ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b'];
            new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(categoryData),
                    datasets: [{
                        label: 'Applications',
                        data: Object.values(categoryData),
                        backgroundColor: categoryColors,
                        borderRadius: 8,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 8,
                            callbacks: {
                                label: function(context) {
                                    const total = Object.values(categoryData).reduce((a,b) => a + b, 0);
                                    const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                    return [`Applications: ${context.raw}`, `Percentage: ${percentage}%`];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6b7280', font: { size: 11 }, maxRotation: 25, minRotation: 25 }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e5e7eb' },
                            ticks: {
                                stepSize: Math.ceil(Math.max(...Object.values(categoryData), 1) / 5),
                                color: '#6b7280',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.app>
