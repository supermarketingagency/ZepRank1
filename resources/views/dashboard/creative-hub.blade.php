<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('AI Creative Hub') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Generate branded festival posters and social content for <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ auth()->user()->currentBusiness->name }}</span>.</p>
            </div>
            <div class="flex gap-3">
                <button class="btn-pill bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 text-sm flex items-center gap-2 shadow-xl transition-all active:scale-95">
                    <span class="material-symbols-rounded text-lg">auto_awesome</span>
                    Custom Design
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-12">
            <!-- Upcoming Festivals -->
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-all hover:shadow-m3-2">
                <div class="p-8">
                    <h3 class="font-google font-bold text-lg mb-10 dark:text-neutral-50 flex items-center gap-3">
                        <span class="material-symbols-rounded text-primary-500">celebration</span>
                        Upcoming Festivals
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                        @forelse($upcomingFestivals as $fest)
                        <div class="p-5 bg-neutral-50 dark:bg-neutral-900/50 rounded-2xl border border-neutral-100 dark:border-neutral-800 text-center space-y-4 hover:shadow-m3-1 transition-all">
                            <div class="w-14 h-14 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-primary-600 dark:text-primary-400 mx-auto">
                                <span class="material-symbols-rounded">calendar_today</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm dark:text-neutral-200">{{ $fest->name }}</h4>
                                <p class="text-[10px] text-neutral-500 font-bold uppercase tracking-widest mt-1">{{ $fest->festival_date->format('M d, Y') }}</p>
                            </div>
                            <form action="{{ route('dashboard.creative.generate', $fest->id) }}" method="POST">
                                @csrf
                                <button class="w-full bg-white dark:bg-neutral-800 border border-primary-200 dark:border-primary-900/50 text-primary-600 dark:text-primary-400 text-xs py-2.5 rounded-xl font-bold hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all active:scale-95">Generate</button>
                            </form>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm col-span-5 text-center py-4">No upcoming festivals found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Generated Posters Gallery -->
            <div class="space-y-8">
                <div class="flex items-center justify-between">
                    <h3 class="font-google font-bold text-lg dark:text-neutral-50 flex items-center gap-3">
                        <span class="material-symbols-rounded text-primary-500">gallery_thumbnail</span>
                        Branded Poster Gallery
                    </h3>
                    <button class="text-primary-600 dark:text-primary-400 text-xs font-black uppercase tracking-widest hover:underline">Manage All Assets</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    @forelse($generatedPosters as $poster)
                    <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 group transition-all hover:shadow-m3-3">
                        <div class="aspect-square bg-neutral-100 dark:bg-neutral-900 relative overflow-hidden">
                            <!-- Placeholder for generated image -->
                            <div class="absolute inset-0 flex items-center justify-center text-neutral-300 dark:text-neutral-700">
                                <span class="material-symbols-rounded text-6xl group-hover:scale-110 transition-transform duration-500">auto_awesome</span>
                            </div>
                            <div class="absolute inset-0 bg-neutral-900/40 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-4">
                                <button class="bg-white text-neutral-900 w-12 h-12 rounded-full flex items-center justify-center shadow-xl hover:scale-110 transition-transform">
                                    <span class="material-symbols-rounded">visibility</span>
                                </button>
                                <form action="{{ route('dashboard.scheduler.post', $poster->id) }}" method="POST" class="w-full px-6">
                                    @csrf
                                    <button class="w-full bg-primary-600 text-white py-3 rounded-full text-xs font-bold shadow-xl hover:bg-primary-700 transition-colors">Post Now</button>
                                </form>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-sm truncate dark:text-neutral-100">{{ $poster->festival->name ?? 'Special Update' }}</h4>
                                <span class="text-[10px] text-neutral-400 font-medium">{{ $poster->created_at->format('M d') }}</span>
                            </div>
                            <p class="text-[11px] text-neutral-500 dark:text-neutral-400 line-clamp-2 leading-relaxed italic">"{{ $poster->caption }}"</p>
                            <div class="mt-4 pt-4 border-t border-neutral-100 dark:border-neutral-800 flex justify-between items-center">
                                <span class="px-2 py-0.5 {{ $poster->status === 'posted' ? 'bg-success-50 dark:bg-success-900/20 text-success-500' : 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' }} text-[9px] rounded font-black uppercase tracking-widest border {{ $poster->status === 'posted' ? 'border-success-100 dark:border-success-900' : 'border-primary-100 dark:border-primary-900' }}">{{ $poster->status }}</span>
                                <button class="text-neutral-400 hover:text-danger-500 transition">
                                    <span class="material-symbols-rounded text-lg">delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-24 text-center text-neutral-400 dark:text-neutral-600 bg-white dark:bg-dark-surface rounded-3xl border border-dashed border-neutral-200 dark:border-neutral-800">
                        <span class="material-symbols-rounded text-6xl mb-4">image_search</span>
                        <p class="text-sm font-medium">No branded posters generated yet.</p>
                        <p class="text-xs mt-1">Select a festival above to generate your first AI creative.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
