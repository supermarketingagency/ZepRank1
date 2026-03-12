<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ __('QR Code Manager') }}
        </h1>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($branches as $branch)
            <div class="card p-8 flex flex-col items-center">
                <div class="mb-2 text-center">
                    <h3 class="text-xl font-google font-bold text-neutral-900">{{ $branch->name }}</h3>
                    <p class="text-sm text-neutral-700">{{ $branch->google_review_url ? 'Link Connected' : 'No link set' }}</p>
                </div>

                <div class="my-8 p-6 bg-neutral-100 rounded-3xl border-8 border-white shadow-inner">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(route('review.start', $branch->slug)) }}" alt="QR Code" class="w-48 h-48">
                </div>

                <div class="w-full space-y-6">
                    <div class="bg-neutral-50 p-4 rounded-xl border border-neutral-200">
                        <label class="text-[10px] font-bold text-neutral-700 uppercase block mb-1">Direct URL</label>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-primary-600 font-medium truncate pr-4">{{ route('review.start', $branch->slug) }}</span>
                            <button class="text-neutral-700 hover:text-primary-600 transition">
                                <span class="material-symbols-rounded text-lg">content_copy</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button class="flex-1 btn-pill bg-neutral-900 hover:bg-neutral-800 text-white py-3 text-sm font-bold flex items-center justify-center gap-2">
                            <span class="material-symbols-rounded text-lg">download</span>
                            PNG
                        </button>
                        <button class="flex-1 btn-pill border border-neutral-300 hover:bg-neutral-50 text-neutral-900 py-3 text-sm font-bold flex items-center justify-center gap-2">
                            <span class="material-symbols-rounded text-lg">print</span>
                            Sticker
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
