<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('GMB Reviews Management') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Manage and reply to your official Google Business Profile reviews.</p>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('dashboard.sync-gmb') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pill border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-dark-surface hover:bg-neutral-50 dark:hover:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-rounded text-lg">sync</span>
                        Fetch Latest
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <div class="p-6">
                    <h3 class="font-google font-bold text-lg mb-6 dark:text-neutral-50">Recent Google Reviews</h3>

                    <div class="space-y-6">
                        @forelse($reviews as $review)
                        <div class="p-8 bg-neutral-50 dark:bg-neutral-900/40 rounded-3xl border border-neutral-100 dark:border-neutral-800 flex flex-col md:flex-row gap-8 transition-all hover:shadow-m3-1">
                            <div class="flex-shrink-0 text-center">
                                <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-primary-600 dark:text-primary-400 text-2xl font-bold mx-auto mb-3 shadow-inner">
                                    {{ substr($review->reviewer_name, 0, 1) }}
                                </div>
                                <div class="flex justify-center gap-0.5">
                                    @for($i=1; $i<=5; $i++)
                                        <span class="material-symbols-rounded text-lg {{ $i <= $review->rating ? 'text-warning-400 fill-1' : 'text-neutral-300 dark:text-neutral-700' }}">star</span>
                                    @endfor
                                </div>
                            </div>

                            <div class="flex-grow space-y-2">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold dark:text-neutral-50">{{ $review->reviewer_name }}</h4>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $review->review_date->diffForHumans() }} • {{ $review->branch->name }}</p>
                                    </div>
                                    <span class="px-2 py-1 {{ $review->replied_at ? 'bg-success-50 text-success-500' : 'bg-warning-400/10 text-warning-500' }} text-xs rounded-full font-bold">
                                        {{ $review->replied_at ? 'Replied' : 'Pending Reply' }}
                                    </span>
                                </div>
                                <p class="text-neutral-700 dark:text-neutral-300 italic">"{{ $review->comment }}"</p>

                                @if(!$review->replied_at)
                                <div class="mt-4 p-4 bg-white dark:bg-dark-card rounded-xl border border-neutral-200 dark:border-neutral-700" x-data="{ suggestion: '{{ $review->reply_suggestion }}', loading: false }">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest">AI Reply Suggestion</span>
                                        <button
                                            @click="loading = true; fetch('/dashboard/reviews/{{ $review->id }}/suggest').then(r => r.json()).then(d => { suggestion = d.suggestion; loading = false })"
                                            class="text-xs text-neutral-500 hover:text-primary-600 transition"
                                            :disabled="loading"
                                        >
                                            <span x-show="!loading">Regenerate</span>
                                            <span x-show="loading">Generating...</span>
                                        </button>
                                    </div>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4" x-text="suggestion || 'Click regenerate to get an AI suggestion.'"></p>
                                    <div class="flex gap-2">
                                        <button class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-full text-xs font-bold transition shadow-sm active:scale-95">Post to Google</button>
                                        <button class="bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 px-5 py-2 rounded-full text-xs font-bold transition active:scale-95">Edit</button>
                                    </div>
                                </div>
                                @else
                                <div class="mt-2 p-3 bg-success-50 dark:bg-success-500/10 rounded-lg border border-success-400/20">
                                    <p class="text-[10px] font-bold text-success-500 uppercase tracking-widest mb-1">Your Reply</p>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-300">{{ $review->actual_reply }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-500">
                            No reviews found. Try syncing your GMB profile.
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
