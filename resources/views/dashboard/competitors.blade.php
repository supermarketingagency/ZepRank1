<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('Competitor Benchmarking') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">See how <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $branch->name }}</span> ranks against top local competitors on Google Maps.</p>
            </div>
            <div class="flex gap-3">
                <button class="btn-pill border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-dark-surface hover:bg-neutral-50 dark:hover:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-rounded text-lg">refresh</span>
                    Refresh Data
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up" x-data="{ view: 'rating' }">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="font-google font-bold text-lg dark:text-neutral-50 flex items-center gap-3">
                            <span class="material-symbols-rounded text-primary-500">leaderboard</span>
                            Market Position
                        </h3>
                        <div class="flex bg-neutral-100 dark:bg-neutral-800 p-1.5 rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow-inner">
                            <button @click="view = 'rating'" :class="view === 'rating' ? 'bg-white dark:bg-dark-card shadow-md text-primary-600 dark:text-primary-400' : 'text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300'" class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Rating</button>
                            <button @click="view = 'reviews'" :class="view === 'reviews' ? 'bg-white dark:bg-dark-card shadow-md text-primary-600 dark:text-primary-400' : 'text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300'" class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Review Count</button>
                        </div>
                    </div>

                    <div class="h-96 w-full">
                        <canvas id="competitorChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Comparison Table -->
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <div class="p-0">
                    <div class="px-8 py-6 border-b border-neutral-100 dark:border-neutral-800">
                        <h3 class="font-google font-bold text-lg dark:text-neutral-50">Detailed Local Landscape</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-neutral-50 dark:bg-neutral-900/50 text-[10px] uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-black border-b border-neutral-200 dark:border-neutral-800">
                                    <th class="py-5 px-8">Business Name</th>
                                    <th class="py-5 px-8 text-center">Google Rating</th>
                                    <th class="py-5 px-8 text-center">Review Count</th>
                                    <th class="py-5 px-8 text-right">Market Opportunity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                                <tr class="bg-primary-50/20 dark:bg-primary-900/10">
                                    <td class="py-6 px-8 font-bold dark:text-neutral-100 flex items-center gap-3">
                                        <div class="w-2.5 h-2.5 rounded-full bg-primary-500 shadow-[0_0_8px_rgba(66,133,244,0.5)]"></div>
                                        {{ $data['branch']['name'] }}
                                        <span class="ml-2 px-2 py-0.5 bg-primary-500 text-white text-[8px] font-black uppercase rounded tracking-tighter">You</span>
                                    </td>
                                    <td class="py-6 px-8 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="font-black text-neutral-900 dark:text-neutral-50">{{ number_format($data['branch']['rating'], 1) }}</span>
                                            <span class="material-symbols-rounded text-base text-warning-400 fill-1">star</span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-8 text-center font-bold text-neutral-900 dark:text-neutral-200">{{ number_format($data['branch']['reviews']) }}</td>
                                    <td class="py-6 px-8 text-right font-black text-[10px] uppercase tracking-widest text-neutral-400">-</td>
                                </tr>
                                @foreach($data['competitors'] as $comp)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition">
                                    <td class="py-5 px-6 dark:text-neutral-300">{{ $comp['name'] }}</td>
                                    <td class="py-5 px-6 text-center dark:text-neutral-300">{{ number_format($comp['rating'], 1) }} ★</td>
                                    <td class="py-5 px-6 text-center dark:text-neutral-300">{{ $comp['reviews'] }}</td>
                                    <td class="py-5 px-6 text-right text-danger-500 font-bold text-xs uppercase tracking-tight">
                                        @php
                                            $maxReviews = max(array_column($data['competitors']->toArray(), 'reviews'));
                                            $gap = $maxReviews - $data['branch']['reviews'];
                                        @endphp
                                        +{{ max(0, $gap) }} to beat
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const data = @json($data);
        const ctx = document.getElementById('competitorChart').getContext('2d');
        let chart;

        function updateChart(type) {
            const isDark = document.documentElement.classList.contains('dark');
            const labels = [data.branch.name, ...data.competitors.map(c => c.name)];
            const values = [data.branch[type], ...data.competitors.map(c => c[type])];
            const colors = ['#4285F4', isDark ? '#3C4043' : '#DADCE0', isDark ? '#3C4043' : '#DADCE0', isDark ? '#3C4043' : '#DADCE0', isDark ? '#3C4043' : '#DADCE0', isDark ? '#3C4043' : '#DADCE0'];

            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: type === 'rating' ? 'Google Rating' : 'Review Count',
                        data: values,
                        backgroundColor: colors,
                        borderRadius: 12,
                        barThickness: 32
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#2C2C2E' : '#202124',
                            titleFont: { family: 'Google Sans' },
                            bodyFont: { family: 'Roboto' }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: {
                                color: isDark ? '#9AA0A6' : '#5F6368',
                                font: { family: 'Google Sans', size: 10 }
                            }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                color: isDark ? '#E8EAED' : '#202124',
                                font: { family: 'Google Sans', size: 12 }
                            }
                        }
                    }
                }
            });
        }

        // Initialize with rating
        updateChart('rating');

        // Watch for Alpine variable change manually
        window.addEventListener('click', (e) => {
           if (e.target.innerText === 'Review Count') updateChart('reviews');
           if (e.target.innerText === 'Rating') updateChart('rating');
        });
    </script>
    @endpush
</x-app-layout>
