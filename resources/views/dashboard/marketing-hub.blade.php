<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketing Hub') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Google Ads Hero -->
            <div class="bg-gradient-to-br from-blue-700 to-indigo-900 rounded-3xl overflow-hidden shadow-xl border-none">
                <div class="p-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="flex-grow text-white">
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">New Feature</span>
                        <h3 class="text-3xl font-bold mb-4">Hyper-Local Google Ads</h3>
                        <p class="text-blue-100 mb-8 max-w-lg">Launch professional local search ads in under 2 minutes. Drive foot traffic directly to your <span class="font-bold">{{ $branch->name }}</span> location.</p>
                        <div class="flex gap-4">
                            <button @click="$dispatch('open-ads-wizard')" class="bg-white text-blue-700 px-8 py-3 rounded-full font-bold hover:shadow-lg transition-all">Start Ads Wizard</button>
                            <button class="bg-blue-600/30 border border-white/30 text-white px-8 py-3 rounded-full font-bold">View Tutorials</button>
                        </div>
                    </div>
                    <div class="hidden md:block w-64 h-64 bg-white/5 rounded-full border border-white/10 flex items-center justify-center backdrop-blur-md">
                        <span class="material-symbols-rounded text-8xl text-white/40">ads_click</span>
                    </div>
                </div>
            </div>

            <!-- Ads Wizard (Modal-like section) -->
            <div x-data="{ step: 1, open: false }" @open-ads-wizard.window="open = true" x-show="open" class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h4 class="font-bold text-lg">Local Ads Wizard</h4>
                    <span class="text-xs font-bold text-gray-400 uppercase">Step <span x-text="step"></span> of 3</span>
                </div>

                <form action="{{ route('dashboard.marketing.ads') }}" method="POST" class="p-8">
                    @csrf
                    <!-- Step 1: Budget & Radius -->
                    <div x-show="step === 1" class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Daily Budget (INR)</label>
                            <input type="number" name="budget" value="1000" class="w-full border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-400 mt-2">Recommended: ₹500 - ₹2,000 per day</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Target Radius (km)</label>
                            <input type="range" name="radius" min="1" max="50" value="5" class="w-full">
                            <div class="flex justify-between text-[10px] font-bold text-gray-400 mt-1">
                                <span>1 km</span>
                                <span>Current: 5 km</span>
                                <span>50 km</span>
                            </div>
                        </div>
                        <button type="button" @click="step = 2" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold">Continue</button>
                    </div>

                    <!-- Step 2: Keywords -->
                    <div x-show="step === 2" class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Target Keywords</label>
                            <textarea name="keywords" class="w-full border-gray-200 rounded-xl h-32 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter keywords separated by commas...">{{ implode(', ', array_column($suggestedKeywords, 'keyword')) }}</textarea>
                        </div>
                        <div class="flex gap-4">
                            <button type="button" @click="step = 1" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold">Back</button>
                            <button type="button" @click="step = 3" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">Preview Ad</button>
                        </div>
                    </div>

                    <!-- Step 3: Confirmation -->
                    <div x-show="step === 3" class="space-y-6 text-center">
                        <div class="p-6 border border-blue-100 bg-blue-50 rounded-2xl text-left">
                            <span class="text-[10px] font-bold text-blue-600 uppercase">Ad Preview</span>
                            <h5 class="text-lg font-bold text-blue-800 mt-2">Best {{ $branch->business->category }} in {{ $branch->address }}</h5>
                            <p class="text-sm text-blue-600 mt-1">Visit us today for the best experience. 4.9 stars rated.</p>
                            <div class="mt-4 flex items-center gap-2 text-xs text-blue-500">
                                <span class="material-symbols-rounded text-sm">location_on</span> {{ $branch->address }}
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="button" @click="step = 2" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold">Back</button>
                            <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-xl font-bold">Launch Campaign</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ad Performance Section (Placeholder) -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h4 class="font-bold text-lg mb-4">Active Campaigns</h4>
                <div class="text-center py-10 text-gray-400">
                    <span class="material-symbols-rounded text-5xl mb-2">bar_chart</span>
                    <p class="text-sm">No active campaigns found. Start one using the wizard above.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
