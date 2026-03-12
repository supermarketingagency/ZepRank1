<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ __('Analytics & Insights') }}
        </h1>
    </x-slot>

    <div class="space-y-8">
        <!-- Review Trends -->
        <div class="card p-8">
            <h3 class="text-lg font-google font-bold mb-6">Review Growth (Past 30 Days)</h3>
            <div class="h-64 flex items-end gap-2 px-4">
                @foreach([12, 18, 15, 25, 22, 30, 28, 35, 42, 38, 45, 50] as $h)
                    <div class="flex-1 bg-primary-100 rounded-t-sm hover:bg-primary-500 transition cursor-pointer" style="height: {{ $h * 2 }}px;"></div>
                @endforeach
            </div>
            <div class="flex justify-between mt-4 text-[10px] text-neutral-500 font-bold uppercase tracking-widest px-4">
                <span>Week 1</span>
                <span>Week 2</span>
                <span>Week 3</span>
                <span>Week 4</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Sentiment Breakdown -->
            <div class="card p-8">
                <h3 class="text-lg font-google font-bold mb-6">Customer Sentiment</h3>
                <div class="flex items-center gap-8">
                    <div class="w-32 h-32 rounded-full border-[12px] border-success border-r-warning border-b-danger"></div>
                    <div class="flex-1 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-success"></div> Positive
                            </span>
                            <span class="font-bold">78%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-warning"></div> Neutral
                            </span>
                            <span class="font-bold">15%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-danger"></div> Negative
                            </span>
                            <span class="font-bold">7%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Competitor Benchmarking -->
            <div class="card p-8">
                <h3 class="text-lg font-google font-bold mb-6">Competitor Benchmarking</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">Y</div>
                            <span class="text-sm font-bold">You ({{ $business->name }})</span>
                        </div>
                        <span class="text-sm font-bold text-success">4.8 ★</span>
                    </div>
                    @foreach(['The Local Bistro', 'Downtown Grill', 'Garden Kitchen'] as $comp)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-neutral-200 text-neutral-600 flex items-center justify-center font-bold text-xs">{{ substr($comp, 0, 1) }}</div>
                                <span class="text-sm text-neutral-700">{{ $comp }}</span>
                            </div>
                            <span class="text-sm font-medium text-neutral-500">{{ 4.2 + (rand(0, 5) / 10) }} ★</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 pt-6 border-t border-neutral-100">
                    <p class="text-[11px] text-neutral-500 italic">You are currently ranking #1 in your local area for review growth this month!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
