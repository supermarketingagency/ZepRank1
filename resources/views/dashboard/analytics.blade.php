<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50 animate-fade-in">
            {{ __('Analytics & Insights') }}
        </h1>
    </x-slot>

    <div class="space-y-8 animate-slide-up">
        <!-- Review Trends -->
        <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-google font-bold dark:text-neutral-50">Review Growth</h3>
                <select class="bg-neutral-100 dark:bg-neutral-800 border-none rounded-lg text-xs font-bold px-4 py-2 dark:text-neutral-300">
                    <option>Past 30 Days</option>
                    <option>Past 90 Days</option>
                    <option>All Time</option>
                </select>
            </div>
            <div class="h-72 w-full">
                <canvas id="reviewGrowthChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Sentiment Breakdown -->
            <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <h3 class="text-lg font-google font-bold mb-8 dark:text-neutral-50">Customer Sentiment</h3>
                <div class="flex items-center gap-10">
                    <div class="w-40 h-40">
                        <canvas id="sentimentChart"></canvas>
                    </div>
                    <div class="flex-1 space-y-5">
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2 dark:text-neutral-300">
                                <div class="w-3 h-3 rounded-full bg-success-400"></div> Positive
                            </span>
                            <span class="font-bold dark:text-neutral-50">78%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2 dark:text-neutral-300">
                                <div class="w-3 h-3 rounded-full bg-warning-400"></div> Neutral
                            </span>
                            <span class="font-bold dark:text-neutral-50">15%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2 dark:text-neutral-300">
                                <div class="w-3 h-3 rounded-full bg-danger-400"></div> Negative
                            </span>
                            <span class="font-bold dark:text-neutral-50">7%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Competitor Benchmarking -->
            <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <h3 class="text-lg font-google font-bold mb-6 dark:text-neutral-50">Competitor Benchmarking</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">Y</div>
                            <span class="text-sm font-bold dark:text-neutral-200">You ({{ $business->name }})</span>
                        </div>
                        <span class="text-sm font-bold text-success-500">4.8 ★</span>
                    </div>
                    @foreach(['The Local Bistro', 'Downtown Grill', 'Garden Kitchen'] as $comp)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 flex items-center justify-center font-bold text-xs">{{ substr($comp, 0, 1) }}</div>
                                <span class="text-sm text-neutral-700 dark:text-neutral-400">{{ $comp }}</span>
                            </div>
                            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-500">{{ 4.2 + (rand(0, 5) / 10) }} ★</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 pt-6 border-t border-neutral-100 dark:border-neutral-800">
                    <p class="text-[11px] text-neutral-500 dark:text-neutral-500 italic">You are currently ranking #1 in your local area for review growth this month!</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9AA0A6' : '#5F6368';
        const gridColor = isDark ? '#2C2C2E' : '#F1F3F4';

        // Review Growth Chart
        new Chart(document.getElementById('reviewGrowthChart'), {
            type: 'line',
            data: {
                labels: ['May 01', 'May 05', 'May 10', 'May 15', 'May 20', 'May 25', 'May 30'],
                datasets: [{
                    label: 'Reviews',
                    data: [12, 19, 15, 28, 22, 35, 45],
                    borderColor: '#4285F4',
                    backgroundColor: 'rgba(66, 133, 244, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } },
                    y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 10 } }, border: { display: false } }
                }
            }
        });

        // Sentiment Chart
        new Chart(document.getElementById('sentimentChart'), {
            type: 'doughnut',
            data: {
                labels: ['Positive', 'Neutral', 'Negative'],
                datasets: [{
                    data: [78, 15, 7],
                    backgroundColor: ['#34A853', '#FBBC04', '#EA4335'],
                    borderWidth: 0,
                    cutout: '80%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    </script>
    @endpush
</x-app-layout>
