<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ __('Google Review Monitor') }}
        </h1>
    </x-slot>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-neutral-50 text-[11px] uppercase tracking-wider text-neutral-700 font-bold border-b border-neutral-200">
                        <th class="px-6 py-4">Review Details</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">AI Suggested Reply</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-neutral-50/50 transition">
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium text-neutral-900 mb-1">{{ $review->branch->name }}</p>
                                <p class="text-xs text-neutral-500">{{ $review->created_at->diffForHumans() }} via {{ ucfirst($review->touchpoint_type) }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex gap-0.5 text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-rounded text-lg {{ $i <= $review->star_rating ? '' : 'text-neutral-200' }}">star</span>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if(isset($review->suggested_reply))
                                    <div class="bg-primary-50/50 p-3 rounded-xl border border-primary-100 text-xs text-neutral-700 italic max-w-xs">
                                        "{{ $review->suggested_reply }}"
                                    </div>
                                @else
                                    <span class="text-neutral-400 text-xs italic">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <button class="btn-pill border border-neutral-300 px-4 py-2 text-xs font-bold hover:bg-neutral-50 transition">
                                    Respond
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-neutral-500 italic">No reviews captured yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-100">
            {{ $reviews->links() }}
        </div>
    </div>
</x-app-layout>
