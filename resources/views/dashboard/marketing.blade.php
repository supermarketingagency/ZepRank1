<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketing & Ads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Google Ads Collaboration -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 overflow-hidden shadow-sm sm:rounded-2xl border-none">
                <div class="p-8 text-white flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold mb-2">Boost Your Business with Google Ads</h3>
                        <p class="text-blue-100 mb-6">Drive more customers to your profile by launching local search ads. Get ₹20,000 credit when you spend your first ₹20,000.</p>
                        <div class="flex gap-4">
                            <button class="bg-white text-blue-600 px-6 py-3 rounded-full font-bold">Connect Google Ads</button>
                            <button class="bg-transparent border border-white text-white px-6 py-3 rounded-full font-bold">Learn More</button>
                        </div>
                    </div>
                    <div class="w-48 h-48 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <span class="material-symbols-rounded text-6xl">ads_click</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Keyword Suggestions -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-rounded text-yellow-500">key</span>
                        Suggested Ad Keywords
                    </h4>
                    <p class="text-sm text-gray-500 mb-4">Use these high-intent keywords for your Google Ads campaigns to attract local customers.</p>

                    <div class="space-y-3">
                        @foreach($suggestedKeywords as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-700">{{ $item['keyword'] }}</span>
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-bold">{{ $item['intent'] }} Intent</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Local SEO Strategy -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-rounded text-blue-500">auto_graph</span>
                        Local SEO Strategy
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">1</div>
                            <p class="text-sm text-gray-600">Update your GMB profile with the optimized description from our <a href="{{ route('dashboard.audit') }}" class="text-blue-600 font-bold">Audit</a>.</p>
                        </li>
                        <li class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">2</div>
                            <p class="text-sm text-gray-600">Reply to at least 3 reviews per week using our <a href="{{ route('dashboard.reviews.manage') }}" class="text-blue-600 font-bold">AI Suggestions</a>.</p>
                        </li>
                        <li class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">3</div>
                            <p class="text-sm text-gray-600">Ensure your target keywords appear in your customer review responses.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
