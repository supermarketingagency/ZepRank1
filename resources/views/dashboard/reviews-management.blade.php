<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-6">Recent Google Reviews</h3>

                    <div class="space-y-6">
                        @forelse($reviews as $review)
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 flex flex-col md:flex-row gap-6">
                            <div class="flex-shrink-0 text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl font-bold mx-auto mb-2">
                                    {{ substr($review->reviewer_name, 0, 1) }}
                                </div>
                                <div class="text-yellow-500 font-bold">
                                    @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                </div>
                            </div>

                            <div class="flex-grow space-y-2">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold">{{ $review->reviewer_name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $review->review_date->diffForHumans() }} • {{ $review->branch->name }}</p>
                                    </div>
                                    <span class="px-2 py-1 {{ $review->replied_at ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs rounded-full">
                                        {{ $review->replied_at ? 'Replied' : 'Pending Reply' }}
                                    </span>
                                </div>
                                <p class="text-gray-700 italic">"{{ $review->comment }}"</p>

                                @if(!$review->replied_at)
                                <div class="mt-4 p-4 bg-white rounded-xl border border-gray-200" x-data="{ suggestion: '{{ $review->reply_suggestion }}', loading: false }">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold text-blue-600 uppercase">AI Reply Suggestion</span>
                                        <button
                                            @click="loading = true; fetch('/dashboard/reviews/{{ $review->id }}/suggest').then(r => r.json()).then(d => { suggestion = d.suggestion; loading = false })"
                                            class="text-xs text-gray-500 hover:text-blue-600"
                                            :disabled="loading"
                                        >
                                            <span x-show="!loading">Regenerate</span>
                                            <span x-show="loading">Generating...</span>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4" x-text="suggestion || 'Click regenerate to get an AI suggestion.'"></p>
                                    <div class="flex gap-2">
                                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Post to Google</button>
                                        <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">Edit</button>
                                    </div>
                                </div>
                                @else
                                <div class="mt-2 p-3 bg-green-50 rounded-lg border border-green-100">
                                    <p class="text-xs font-bold text-green-600 uppercase mb-1">Your Reply</p>
                                    <p class="text-sm text-gray-600">{{ $review->actual_reply }}</p>
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
