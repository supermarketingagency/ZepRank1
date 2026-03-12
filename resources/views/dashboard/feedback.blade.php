<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('Private Feedback Inbox') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Intercepted low ratings are safely stored here for your internal follow-up.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card p-6 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black uppercase tracking-widest text-neutral-500">Unresolved</span>
                        <span class="material-symbols-rounded text-warning-500">pending_actions</span>
                    </div>
                    <div class="mt-4 flex items-end gap-2">
                        <span class="text-3xl font-google font-bold dark:text-neutral-50">{{ $feedbacks->where('status', 'new')->count() }}</span>
                        <span class="text-xs font-bold text-neutral-400 mb-1">Items</span>
                    </div>
                </div>
                <div class="card p-6 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black uppercase tracking-widest text-neutral-500">Avg Sentiment</span>
                        <span class="material-symbols-rounded text-success-500">mood</span>
                    </div>
                    <div class="mt-4 flex items-end gap-2">
                        <span class="text-3xl font-google font-bold dark:text-neutral-50">Neutral</span>
                        <span class="text-xs font-bold text-neutral-400 mb-1">Overall</span>
                    </div>
                </div>
                <div class="card p-6 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black uppercase tracking-widest text-neutral-500">Bypass Rate</span>
                        <span class="material-symbols-rounded text-primary-500">shield</span>
                    </div>
                    <div class="mt-4 flex items-end gap-2">
                        <span class="text-3xl font-google font-bold dark:text-neutral-50">14%</span>
                        <span class="text-xs font-bold text-success-500 mb-1">Protected</span>
                    </div>
                </div>
            </div>

            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <div class="p-0">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-neutral-50 dark:bg-neutral-900/50 text-[10px] uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-black border-b border-neutral-200 dark:border-neutral-800">
                                <th class="px-8 py-5">Timestamp</th>
                                <th class="px-8 py-5">Branch / Location</th>
                                <th class="px-8 py-5">Rating</th>
                                <th class="px-8 py-5">AI Sentiment</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            @forelse($feedbacks as $feedback)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition group">
                                    <td class="px-8 py-6 text-xs text-neutral-500 dark:text-neutral-400 font-medium">{{ $feedback->created_at->diffForHumans() }}</td>
                                    <td class="px-8 py-6 font-bold text-neutral-900 dark:text-neutral-100">{{ $feedback->branch->name }}</td>
                                    <td class="px-8 py-6">
                                        <div class="flex gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="material-symbols-rounded text-base {{ $i <= $feedback->star_rating ? ($feedback->star_rating <= 2 ? 'text-danger-400 fill-1' : 'text-warning-400 fill-1') : 'text-neutral-200 dark:text-neutral-700' }}">star</span>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($feedback->sentiment_label === 'negative')
                                            <span class="px-3 py-1 bg-danger-400/10 text-danger-500 text-[10px] rounded-full font-black uppercase tracking-widest border border-danger-400/20">Critical Negative</span>
                                        @else
                                            <span class="px-3 py-1 bg-neutral-100 dark:bg-neutral-800 text-neutral-500 text-[10px] rounded-full font-black uppercase tracking-widest border border-neutral-200 dark:border-neutral-700">Neutral / Mild</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-full text-[10px] font-black uppercase tracking-widest border border-primary-100 dark:border-primary-900/50">{{ $feedback->status }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <button class="btn-icon opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="material-symbols-rounded text-lg">open_in_new</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-neutral-400 dark:text-neutral-600 italic">No feedback received yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($feedbacks->hasPages())
                <div class="p-6 border-t border-neutral-100 dark:border-neutral-800">
                    {{ $feedbacks->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
