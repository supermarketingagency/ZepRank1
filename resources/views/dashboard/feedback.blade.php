<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Private Feedback Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-xs uppercase text-gray-500">
                                <th class="px-6 py-3">Time</th>
                                <th class="px-6 py-3">Branch</th>
                                <th class="px-6 py-3">Rating</th>
                                <th class="px-6 py-3">Sentiment</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedbacks as $feedback)
                                <tr class="border-t border-gray-100 text-sm">
                                    <td class="px-6 py-4">{{ $feedback->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4">{{ $feedback->branch->name }}</td>
                                    <td class="px-6 py-4">{{ $feedback->star_rating }} ★</td>
                                    <td class="px-6 py-4 uppercase font-bold text-xs">
                                        @if($feedback->sentiment_label === 'negative')
                                            <span class="text-red-600">Negative</span>
                                        @else
                                            <span class="text-gray-400">Neutral</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">{{ $feedback->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No feedback received yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
