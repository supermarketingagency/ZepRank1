<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Competitor Analysis') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ view: 'rating' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg">Market Benchmarking: {{ $branch->name }}</h3>
                        <div class="flex bg-gray-100 p-1 rounded-lg">
                            <button @click="view = 'rating'" :class="view === 'rating' ? 'bg-white shadow-sm' : ''" class="px-4 py-1 rounded-md text-sm font-medium transition-all">Rating</button>
                            <button @click="view = 'reviews'" :class="view === 'reviews' ? 'bg-white shadow-sm' : ''" class="px-4 py-1 rounded-md text-sm font-medium transition-all">Review Count</button>
                        </div>
                    </div>

                    <div class="h-96 w-full">
                        <canvas id="competitorChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Comparison Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Competitor Breakdown</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase">Business Name</th>
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase">Google Rating</th>
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase">Review Count</th>
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase">Gap to Top</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-blue-50">
                                    <td class="py-4 px-4 font-bold">{{ $data['branch']['name'] }}</td>
                                    <td class="py-4 px-4 font-bold">{{ number_format($data['branch']['rating'], 1) }} ★</td>
                                    <td class="py-4 px-4 font-bold">{{ $data['branch']['reviews'] }}</td>
                                    <td class="py-4 px-4">-</td>
                                </tr>
                                @foreach($data['competitors'] as $comp)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-4">{{ $comp['name'] }}</td>
                                    <td class="py-4 px-4">{{ number_format($comp['rating'], 1) }} ★</td>
                                    <td class="py-4 px-4">{{ $comp['reviews'] }}</td>
                                    <td class="py-4 px-4 text-red-600 font-medium">
                                        @php
                                            $maxReviews = max(array_column($data['competitors']->toArray(), 'reviews'));
                                            $gap = $maxReviews - $data['branch']['reviews'];
                                        @endphp
                                        +{{ max(0, $gap) }} reviews needed
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
            const labels = [data.branch.name, ...data.competitors.map(c => c.name)];
            const values = [data.branch[type], ...data.competitors.map(c => c[type])];
            const colors = ['#4285F4', '#DADCE0', '#DADCE0', '#DADCE0', '#DADCE0', '#DADCE0'];

            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: type === 'rating' ? 'Google Rating' : 'Review Count',
                        data: values,
                        backgroundColor: colors,
                        borderRadius: 8,
                        barThickness: 40
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { display: false }
                        },
                        y: {
                            grid: { display: false }
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
