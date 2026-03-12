<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Creative Hub') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Upcoming Festivals -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-6">Upcoming Festivals & Holidays</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        @forelse($upcomingFestivals as $fest)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-center space-y-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mx-auto">
                                <span class="material-symbols-rounded">calendar_today</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">{{ $fest->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $fest->festival_date->format('M d, Y') }}</p>
                            </div>
                            <form action="{{ route('dashboard.creative.generate', $fest->id) }}" method="POST">
                                @csrf
                                <button class="w-full bg-white border border-blue-200 text-blue-600 text-xs py-2 rounded-lg font-bold hover:bg-blue-50 transition-colors">Generate Poster</button>
                            </form>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm col-span-5 text-center py-4">No upcoming festivals found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Generated Posters Gallery -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg">Your Branded Gallery</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @forelse($generatedPosters as $poster)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden group">
                        <div class="aspect-square bg-gray-100 relative">
                            <!-- Placeholder for generated image -->
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <span class="material-symbols-rounded text-4xl">image</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                <button class="w-full bg-white text-gray-900 py-2 rounded-lg text-xs font-bold">Schedule for GMB</button>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-sm truncate">{{ $poster->festival->name ?? 'Custom Poster' }}</h4>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $poster->caption }}</p>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full font-bold uppercase">{{ $poster->status }}</span>
                                <span class="text-[10px] text-gray-400">{{ $poster->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-4 py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
                        <span class="material-symbols-rounded text-5xl mb-2">auto_awesome</span>
                        <p class="text-sm font-medium">Generate your first festival poster to see it here.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
