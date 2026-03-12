<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('GMB Health Audit') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">AI-driven analysis of your Google Business Profile optimization status.</p>
            </div>
            <div class="flex gap-3">
                <button class="btn-pill border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-dark-surface hover:bg-neutral-50 dark:hover:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-6 py-2.5 text-sm flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-rounded text-lg">sync</span>
                    Re-Audit Now
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-10">
            <!-- Audit Overview -->
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-all hover:shadow-m3-2">
                <div class="p-10">
                    <div class="flex flex-col md:flex-row items-center gap-12">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-neutral-100 dark:text-neutral-800" stroke-width="2"></circle>
                                <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-success-500" stroke-width="2" stroke-dasharray="100" stroke-dashoffset="{{ 100 - $auditData['score'] }}" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-4xl font-google font-bold dark:text-neutral-50">{{ $auditData['score'] }}</span>
                                <span class="text-[9px] font-black uppercase tracking-widest text-neutral-400">Score</span>
                            </div>
                        </div>
                        <div class="flex-grow text-center md:text-left space-y-2">
                            <h3 class="text-3xl font-google font-bold dark:text-neutral-50">Profile Optimization</h3>
                            <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed max-w-xl">Your profile for <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $branch->name }}</span> is in the <span class="text-success-500 font-bold uppercase tracking-widest text-xs">top 15%</span> of local businesses. Fix the issues below to hit 100.</p>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="px-4 py-2 bg-neutral-50 dark:bg-neutral-900 rounded-xl border border-neutral-100 dark:border-neutral-800 flex items-center gap-3">
                                <span class="material-symbols-rounded text-success-500 text-lg">verified</span>
                                <span class="text-xs font-bold text-neutral-600 dark:text-neutral-400">Verified Profile</span>
                            </div>
                            <div class="px-4 py-2 bg-neutral-50 dark:bg-neutral-900 rounded-xl border border-neutral-100 dark:border-neutral-800 flex items-center gap-3">
                                <span class="material-symbols-rounded text-primary-500 text-lg">schedule</span>
                                <span class="text-xs font-bold text-neutral-600 dark:text-neutral-400">Synced 2h ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Critical Issues -->
                <div class="card p-6 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                    <h4 class="font-bold text-lg mb-4 flex items-center gap-2 dark:text-neutral-50">
                        <span class="material-symbols-rounded text-danger-400">warning</span>
                        Critical Issues
                    </h4>
                    <ul class="space-y-3">
                        @foreach($auditData['critical_issues'] as $issue)
                        <li class="flex gap-3 text-sm text-neutral-600 dark:text-neutral-400">
                            <span class="w-1.5 h-1.5 bg-danger-400 rounded-full mt-1.5 flex-shrink-0"></span>
                            {{ $issue }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- AI Keyword Gap -->
                <div class="card p-6 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                    <h4 class="font-bold text-lg mb-4 flex items-center gap-2 dark:text-neutral-50">
                        <span class="material-symbols-rounded text-primary-500">lightbulb</span>
                        AI Local SEO Insights
                    </h4>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 italic border-l-4 border-primary-100 dark:border-primary-900/50 pl-4">
                        {{ $auditData['keyword_gap'][0] }}
                    </p>
                </div>
            </div>

            <!-- Optimization Suggestions -->
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <div class="p-6">
                    <h3 class="font-google font-bold text-lg mb-6 dark:text-neutral-50">AI Optimization Recommendations</h3>

                    <div class="space-y-6">
                        <div class="p-5 bg-neutral-50 dark:bg-neutral-900/50 rounded-2xl border border-neutral-100 dark:border-neutral-800">
                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">Optimized Business Description</label>
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed">{{ $auditData['optimization_suggestions']['description'] }}</p>
                            <button class="mt-4 text-primary-600 dark:text-primary-400 text-xs font-bold flex items-center gap-2 hover:underline">
                                <span class="material-symbols-rounded text-sm">content_copy</span> Copy to Clipboard
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-5 bg-neutral-50 dark:bg-neutral-900/50 rounded-2xl border border-neutral-100 dark:border-neutral-800">
                                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">Suggested Categories</label>
                                <p class="text-sm text-neutral-700 dark:text-neutral-300 font-medium">{{ $auditData['optimization_suggestions']['category'] }}</p>
                            </div>
                            <div class="p-5 bg-neutral-50 dark:bg-neutral-900/50 rounded-2xl border border-neutral-100 dark:border-neutral-800">
                                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">Keywords to Add to Profile</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $auditData['optimization_suggestions']['keywords_to_add']) as $kw)
                                    <span class="px-2.5 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[10px] rounded-md font-bold uppercase">{{ trim($kw) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
