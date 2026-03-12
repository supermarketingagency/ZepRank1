<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('Review Activity Log') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Detailed audit trail of every scan, tap, and interaction on the platform.</p>
            </div>
            <div class="flex gap-3">
                <button class="btn-pill border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-dark-surface hover:bg-neutral-50 dark:hover:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-rounded text-lg">download</span>
                    Export CSV
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Filters Bar -->
    <div class="mb-8 flex flex-wrap gap-4 animate-slide-up">
        <div class="flex-1 min-w-[200px]">
            <select class="w-full bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 rounded-2xl text-sm font-bold px-6 py-3 dark:text-neutral-300 shadow-sm focus:ring-primary-500">
                <option>All Branches</option>
                @foreach(auth()->user()->currentBusiness->branches as $branch)
                    <option>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <select class="w-full bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 rounded-2xl text-sm font-bold px-6 py-3 dark:text-neutral-300 shadow-sm focus:ring-primary-500">
                <option>All Ratings</option>
                <option>5 Stars</option>
                <option>4 Stars</option>
                <option>3 Stars & Below</option>
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <select class="w-full bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 rounded-2xl text-sm font-bold px-6 py-3 dark:text-neutral-300 shadow-sm focus:ring-primary-500">
                <option>All Channels</option>
                <option>QR Scan</option>
                <option>NFC Tap</option>
                <option>Direct Link</option>
            </select>
        </div>
    </div>

    <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 animate-slide-up" style="animation-delay: 100ms;">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-neutral-50 dark:bg-neutral-900/50 text-[10px] uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-black border-b border-neutral-200 dark:border-neutral-800">
                        <th class="px-8 py-5">Location</th>
                        <th class="px-8 py-5">Rating</th>
                        <th class="px-8 py-5">Platform Status</th>
                        <th class="px-8 py-5 text-right">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition">
                            <td class="px-8 py-6">
                                <p class="text-sm font-bold dark:text-neutral-100">{{ $review->branch->name }}</p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span class="material-symbols-rounded text-xs text-neutral-400">near_me</span>
                                    <span class="text-[10px] text-neutral-500 font-bold uppercase tracking-tighter">{{ $review->touchpoint_type }} interaction</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-rounded text-base {{ $i <= $review->star_rating ? ($review->star_rating >= 4 ? 'text-success-400' : 'text-warning-400') : 'text-neutral-200 dark:text-neutral-700' }}">star</span>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($review->google_redirect_completed)
                                    <span class="px-3 py-1 bg-success-50 dark:bg-success-900/20 text-success-500 text-[10px] rounded-full font-black uppercase tracking-widest">Posted to Google</span>
                                @elseif($review->route === 'private_feedback')
                                    <span class="px-3 py-1 bg-warning-400/10 text-warning-500 text-[10px] rounded-full font-black uppercase tracking-widest">Private Feedback</span>
                                @else
                                    <span class="px-3 py-1 bg-neutral-100 dark:bg-neutral-800 text-neutral-500 text-[10px] rounded-full font-black uppercase tracking-widest">In Progress</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-xs text-neutral-400 font-medium">{{ $review->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center text-neutral-400 dark:text-neutral-600 italic bg-neutral-50/50 dark:bg-dark-surface">
                                <span class="material-symbols-rounded text-5xl mb-3">history</span>
                                <p class="text-sm font-medium">No review activity recorded yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
        <div class="px-8 py-6 border-t border-neutral-100 dark:border-neutral-800">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
