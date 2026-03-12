<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('GMB Social Scheduler') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Automate your Google My Business posts and festival updates.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dashboard.creative') }}" class="btn-pill bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 text-sm flex items-center gap-2 shadow-xl transition-all active:scale-95">
                    <span class="material-symbols-rounded text-lg">add_box</span>
                    New Update
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <div class="p-6">
                    <h3 class="font-google font-bold text-lg mb-8 dark:text-neutral-50">Upcoming GMB Updates</h3>

                    <div class="space-y-4">
                        @forelse($scheduledPosts as $post)
                        <div class="flex items-center gap-6 p-6 bg-neutral-50 dark:bg-neutral-900/40 rounded-[2rem] border border-neutral-100 dark:border-neutral-800 transition hover:shadow-m3-2 group">
                            <div class="w-20 h-20 bg-neutral-200 dark:bg-neutral-800 rounded-2xl flex-shrink-0 flex items-center justify-center relative overflow-hidden shadow-inner">
                                <span class="material-symbols-rounded text-neutral-400 text-3xl group-hover:scale-110 transition-transform">image</span>
                                @if($post->status === 'posted')
                                    <div class="absolute inset-0 bg-success-500/20 flex items-center justify-center">
                                        <span class="material-symbols-rounded text-success-600 bg-white rounded-full p-1 shadow-sm">check</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-bold text-base dark:text-neutral-100">{{ $post->festival->name ?? 'GMB Social Update' }}</h4>
                                    @if($post->status === 'scheduled')
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></div>
                                    @endif
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 truncate max-w-lg italic">"{{ $post->caption }}"</p>
                            </div>
                            <div class="text-right flex items-center gap-10">
                                <div class="space-y-1">
                                    <span class="block text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Publish Date</span>
                                    <span class="text-xs font-bold dark:text-neutral-200">{{ $post->scheduled_at ? $post->scheduled_at->format('M d, Y • H:i') : 'Instant Post' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-5 py-2 {{ $post->status === 'posted' ? 'bg-success-50 dark:bg-success-900/20 text-success-600' : 'bg-primary-50 dark:bg-primary-900/20 text-primary-600' }} text-[10px] rounded-full font-black uppercase tracking-widest border {{ $post->status === 'posted' ? 'border-success-100 dark:border-success-800' : 'border-primary-100 dark:border-primary-800' }}">
                                        {{ $post->status }}
                                    </span>
                                    @if($post->status !== 'posted')
                                    <button class="w-10 h-10 rounded-full border border-neutral-200 dark:border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-danger-500 hover:border-danger-200 transition active:scale-90">
                                        <span class="material-symbols-rounded text-lg">delete</span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-20 text-neutral-400 dark:text-neutral-600">
                            <span class="material-symbols-rounded text-6xl mb-4">event_busy</span>
                            <p class="text-sm font-medium">No posts scheduled yet.</p>
                            <p class="text-xs mt-1">Go to the <a href="{{ route('dashboard.creative') }}" class="text-primary-600 dark:text-primary-400 font-bold hover:underline">Creative Hub</a> to generate your next update.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
