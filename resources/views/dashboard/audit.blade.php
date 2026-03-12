<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('GMB Profile Audit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Audit Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="relative w-32 h-32">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <path class="text-gray-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-green-500" stroke-width="3" stroke-dasharray="{{ $auditData['score'] }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <text x="18" y="20.35" class="text-2xl font-bold" text-anchor="middle" fill="#374151">{{ $auditData['score'] }}</text>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-2xl font-bold">Optimization Score</h3>
                            <p class="text-gray-500">Your profile for <span class="font-bold text-gray-800">{{ $branch->name }}</span> is doing well, but there is room for growth.</p>
                        </div>
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold">Sync & Re-Audit</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Critical Issues -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-rounded text-red-500">warning</span>
                        Critical Issues
                    </h4>
                    <ul class="space-y-3">
                        @foreach($auditData['critical_issues'] as $issue)
                        <li class="flex gap-3 text-sm text-gray-600">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mt-1.5 flex-shrink-0"></span>
                            {{ $issue }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- AI Keyword Gap -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-rounded text-blue-500">lightbulb</span>
                        AI Local SEO Insights
                    </h4>
                    <p class="text-sm text-gray-600 italic border-l-4 border-blue-100 pl-4">
                        {{ $auditData['keyword_gap'][0] }}
                    </p>
                </div>
            </div>

            <!-- Optimization Suggestions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-6">AI Optimization Recommendations</h3>

                    <div class="space-y-6">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Optimized Business Description</label>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $auditData['optimization_suggestions']['description'] }}</p>
                            <button class="mt-3 text-blue-600 text-xs font-bold flex items-center gap-1">
                                <span class="material-symbols-rounded text-sm">content_copy</span> Copy to Clipboard
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Suggested Categories</label>
                                <p class="text-sm text-gray-700 font-medium">{{ $auditData['optimization_suggestions']['category'] }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Keywords to Add to Profile</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $auditData['optimization_suggestions']['keywords_to_add']) as $kw)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-md font-medium">{{ trim($kw) }}</span>
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
