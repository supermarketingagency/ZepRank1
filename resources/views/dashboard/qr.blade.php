<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google font-bold text-neutral-900 dark:text-neutral-50 animate-fade-in">
            {{ __('QR Code Manager') }}
        </h1>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 animate-slide-up">
        @foreach($branches as $branch)
            <div class="card p-10 flex flex-col items-center bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-all hover:shadow-m3-2 group">
                <div class="mb-4 text-center">
                    <h3 class="text-xl font-google font-bold text-neutral-900 dark:text-neutral-50">{{ $branch->name }}</h3>
                    <div class="flex items-center justify-center gap-2 mt-1">
                        <div class="w-1.5 h-1.5 rounded-full {{ $branch->google_review_url ? 'bg-success-400' : 'bg-danger-400' }}"></div>
                        <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">{{ $branch->google_review_url ? 'Live & Connected' : 'Configuration Pending' }}</p>
                    </div>
                </div>

                <div class="my-8 p-8 bg-neutral-50 dark:bg-neutral-900 rounded-[2.5rem] border-[10px] border-neutral-100 dark:border-neutral-800 shadow-inner group-hover:scale-105 transition-transform duration-300 relative">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(route('review.start', $branch->slug)) }}" alt="QR Code" class="w-44 h-44 dark:invert-[0.05]">
                    <div class="absolute inset-0 flex items-center justify-center bg-white/10 dark:bg-black/10 backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]">
                        <span class="material-symbols-rounded text-primary-600 bg-white p-3 rounded-full shadow-xl">qr_code_2</span>
                    </div>
                </div>

                <div class="w-full space-y-8">
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 p-5 rounded-2xl border border-neutral-100 dark:border-neutral-800">
                        <label class="text-[9px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-[0.15em] block mb-2">Direct Review Link</label>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-primary-600 dark:text-primary-400 font-bold truncate pr-6">{{ route('review.start', $branch->slug) }}</span>
                            <button class="text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition active:scale-90">
                                <span class="material-symbols-rounded text-lg">content_copy</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button class="flex-1 bg-neutral-900 dark:bg-primary-600 hover:bg-neutral-800 dark:hover:bg-primary-700 text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center justify-center gap-3 transition shadow-lg active:scale-95">
                            <span class="material-symbols-rounded text-lg">download</span>
                            Download
                        </button>
                        <button class="flex-1 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-900 text-neutral-900 dark:text-neutral-50 py-4 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center justify-center gap-3 transition active:scale-95">
                            <span class="material-symbols-rounded text-lg">print</span>
                            Designer
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
