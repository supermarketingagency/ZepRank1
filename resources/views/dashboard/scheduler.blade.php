<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social Scheduler') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-6">Upcoming GMB Updates</h3>

                    <div class="space-y-4">
                        @forelse($scheduledPosts as $post)
                        <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0"></div>
                            <div class="flex-grow">
                                <h4 class="font-bold text-sm">{{ $post->festival->name ?? 'Update' }}</h4>
                                <p class="text-xs text-gray-500 truncate max-w-md">{{ $post->caption }}</p>
                            </div>
                            <div class="text-right flex items-center gap-4">
                                <div class="space-y-1">
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase">Scheduled For</span>
                                    <span class="text-sm font-medium">{{ $post->scheduled_at ? $post->scheduled_at->format('M d, H:i') : 'Immediate' }}</span>
                                </div>
                                <span class="px-3 py-1 {{ $post->status === 'posted' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} text-xs rounded-full font-bold">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-500">
                            No posts scheduled yet. Go to the <a href="{{ route('dashboard.creative') }}" class="text-blue-600 font-bold">Creative Hub</a> to generate one.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
