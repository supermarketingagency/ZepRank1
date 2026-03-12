<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-google text-neutral-900">
                {{ __('Dashboard Overview') }}
            </h1>
            <div class="flex gap-3">
                <form action="{{ route('dashboard.sync-gmb') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pill border border-neutral-300 bg-white hover:bg-neutral-50 text-neutral-700 px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-rounded text-lg">sync</span>
                        Sync GMB
                    </button>
                </form>
                <a href="{{ route('dashboard.qr') }}" class="btn-pill bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-rounded text-lg">qr_code</span>
                    Generate QR
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        @if (session('success'))
            <div class="p-4 bg-success/10 border-l-4 border-success text-success text-sm font-medium rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center">
                        <span class="material-symbols-rounded">reviews</span>
                    </div>
                    <span class="text-success text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">trending_up</span>
                        +12%
                    </span>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 mb-1">{{ $stats['total_reviews'] }}</h3>
                <p class="text-sm text-neutral-700">Total Reviews</p>
            </div>

            <div class="card p-6 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-warning/10 text-warning flex items-center justify-center">
                        <span class="material-symbols-rounded">star_rate</span>
                    </div>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 mb-1">{{ number_format($stats['avg_rating'], 1) }}</h3>
                <p class="text-sm text-neutral-700">Average Rating</p>
            </div>

            <div class="card p-6 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center">
                        <span class="material-symbols-rounded">tap_and_play</span>
                    </div>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 mb-1">{{ $stats['qr_scans'] }}</h3>
                <p class="text-sm text-neutral-700">Total Scans</p>
            </div>

            <div class="card p-6 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-danger/10 text-danger flex items-center justify-center">
                        <span class="material-symbols-rounded">feedback</span>
                    </div>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 mb-1">{{ $stats['private_feedbacks'] }}</h3>
                <p class="text-sm text-neutral-700">Private Feedbacks</p>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="card overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-200 flex justify-between items-center">
                <h3 class="text-lg font-google font-bold text-neutral-900">Recent Activity</h3>
                <button class="text-primary-600 text-sm font-bold hover:underline">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-neutral-50 text-[11px] uppercase tracking-wider text-neutral-700 font-bold border-b border-neutral-200">
                            <th class="px-6 py-3">Timestamp</th>
                            <th class="px-6 py-3">Location</th>
                            <th class="px-6 py-3">Outcome</th>
                            <th class="px-6 py-3 text-right">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($recentActivity as $activity)
                            <tr class="hover:bg-neutral-50 transition text-sm">
                                <td class="px-6 py-4 text-neutral-700">{{ $activity->created_at->format('M d, H:i') }}</td>
                                <td class="px-6 py-4 font-medium text-neutral-900">{{ $activity->branch->name }}</td>
                                <td class="px-6 py-4">
                                    @if($activity->google_redirect_completed)
                                        <div class="flex items-center gap-2 text-success">
                                            <span class="material-symbols-rounded text-lg">check_circle</span>
                                            <span>Google Post</span>
                                        </div>
                                    @elseif($activity->route === 'private_feedback')
                                        <div class="flex items-center gap-2 text-warning">
                                            <span class="material-symbols-rounded text-lg">lock</span>
                                            <span>Private Feedback</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-neutral-700">
                                            <span class="material-symbols-rounded text-lg">near_me</span>
                                            <span>Interaction</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold {{ $activity->star_rating >= 4 ? 'text-success' : 'text-danger' }}">
                                        {{ $activity->star_rating }} ★
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-neutral-700 italic bg-neutral-50/50">
                                    No activity recorded yet. Deploy your QR codes to start tracking!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
