<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('Dashboard Overview') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Welcome back! Here's what's happening with your reviews.</p>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('dashboard.sync-gmb') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pill border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-dark-surface hover:bg-neutral-50 dark:hover:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-rounded text-lg">sync</span>
                        Sync GMB
                    </button>
                </form>
                <a href="{{ route('dashboard.qr') }}" class="btn-pill bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm transition-transform active:scale-95">
                    <span class="material-symbols-rounded text-lg">qr_code</span>
                    Generate QR
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 animate-slide-up">
        @if (session('success'))
            <div class="p-4 bg-success/10 border-l-4 border-success text-success text-sm font-medium rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6 flex flex-col bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-md">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
                        <span class="material-symbols-rounded">reviews</span>
                    </div>
                    <span class="text-success-500 text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">trending_up</span>
                        +12%
                    </span>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 dark:text-neutral-50 mb-1">{{ $stats['total_reviews'] }}</h3>
                <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">Total Reviews</p>
            </div>

            <div class="card p-6 flex flex-col bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-md">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-warning-400/10 text-warning-500 flex items-center justify-center">
                        <span class="material-symbols-rounded text-warning-500">star_rate</span>
                    </div>
                    <span class="text-success-500 text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">trending_up</span>
                        +0.2
                    </span>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 dark:text-neutral-50 mb-1">{{ number_format($stats['avg_rating'], 1) }}</h3>
                <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">Average Rating</p>
            </div>

            <div class="card p-6 flex flex-col bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-md">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center">
                        <span class="material-symbols-rounded">tap_and_play</span>
                    </div>
                    <span class="text-success-500 text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">trending_up</span>
                        +8%
                    </span>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 dark:text-neutral-50 mb-1">{{ $stats['qr_scans'] }}</h3>
                <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">Total Scans</p>
            </div>

            <div class="card p-6 flex flex-col bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-md">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-danger-400/10 text-danger-500 flex items-center justify-center">
                        <span class="material-symbols-rounded">feedback</span>
                    </div>
                    <span class="text-danger-500 text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">trending_up</span>
                        +2
                    </span>
                </div>
                <h3 class="text-3xl font-google font-bold text-neutral-900 dark:text-neutral-50 mb-1">{{ $stats['private_feedbacks'] }}</h3>
                <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">Private Feedbacks</p>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
            <div class="px-8 py-6 border-b border-neutral-200 dark:border-neutral-800 flex justify-between items-center">
                <h3 class="text-lg font-google font-bold text-neutral-900 dark:text-neutral-50">Live Interaction Feed</h3>
                <a href="{{ route('dashboard.reviews') }}" class="text-primary-600 dark:text-primary-400 text-xs font-black uppercase tracking-widest hover:underline">View Audit Log</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-neutral-50 dark:bg-neutral-900/50 text-[10px] uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-black border-b border-neutral-200 dark:border-neutral-800">
                            <th class="px-8 py-4">Time</th>
                            <th class="px-8 py-4">Location</th>
                            <th class="px-8 py-4">Platform Action</th>
                            <th class="px-8 py-4 text-right">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse($recentActivity as $activity)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition group">
                                <td class="px-8 py-5 text-xs text-neutral-500 dark:text-neutral-500">{{ $activity->created_at->diffForHumans() }}</td>
                                <td class="px-8 py-5 font-bold text-neutral-900 dark:text-neutral-100">{{ $activity->branch->name }}</td>
                                <td class="px-8 py-5">
                                    @if($activity->google_redirect_completed)
                                        <div class="flex items-center gap-2 text-success-500 text-[10px] font-black uppercase tracking-widest">
                                            <span class="material-symbols-rounded text-base fill-1">check_circle</span>
                                            <span>Posted to Google</span>
                                        </div>
                                    @elseif($activity->route === 'private_feedback')
                                        <div class="flex items-center gap-2 text-warning-500 text-[10px] font-black uppercase tracking-widest">
                                            <span class="material-symbols-rounded text-base fill-1">lock</span>
                                            <span>Private Bypass</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-neutral-400 text-[10px] font-black uppercase tracking-widest">
                                            <span class="material-symbols-rounded text-base">near_me</span>
                                            <span>Review Session</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="font-black {{ $activity->star_rating >= 4 ? 'text-success-500' : 'text-danger-500' }}">
                                        {{ $activity->star_rating }} ★
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-neutral-700 dark:text-neutral-500 italic bg-neutral-50/50 dark:bg-dark-surface">
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
