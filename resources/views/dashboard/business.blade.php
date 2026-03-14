<x-app-layout>
    <x-slot name="header">
        <h2 class="font-google font-bold text-xl text-neutral-900 dark:text-neutral-50 animate-fade-in">
            {{ __('Business Profile & Branches') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-slide-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <!-- Business Details -->
            <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800">
                <h3 class="text-lg font-google font-bold mb-6 dark:text-neutral-100 flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary-500">info</span>
                    Business Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Legal Entity Name</p>
                        <p class="text-lg font-medium dark:text-neutral-50">{{ $business->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Industry Category</p>
                        <p class="text-lg font-medium dark:text-neutral-50">{{ $business->category }}</p>
                    </div>
                </div>
            </div>

            <!-- Syncing & Branches -->
            <div class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800" x-data="{ tab: 'branches' }">
                <div class="border-b border-neutral-100 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900/50">
                    <div class="flex">
                        <button @click="tab = 'branches'" :class="tab === 'branches' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-500'" class="px-8 py-5 font-google font-bold text-sm border-b-2 transition-all">Operational Branches</button>
                        <button @click="tab = 'oauth'" :class="tab === 'oauth' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-500'" class="px-8 py-5 font-google font-bold text-sm border-b-2 transition-all">Google OAuth Sync</button>
                        <button @click="tab = 'manual'" :class="tab === 'manual' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-500'" class="px-8 py-5 font-google font-bold text-sm border-b-2 transition-all">Manual Web Sync</button>
                    </div>
                </div>

                <!-- Branches Tab -->
                <div x-show="tab === 'branches'" class="animate-fade-in" x-data="{ showAddBranch: false }">
                    <div class="p-6 border-b border-neutral-100 dark:border-neutral-800 flex justify-between items-center">
                        <p class="text-sm text-neutral-500">Manage your physical locations and their specific settings.</p>
                        <button @click="showAddBranch = true" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-full text-xs font-bold shadow-sm transition active:scale-95 flex items-center gap-2">
                            <span class="material-symbols-rounded text-sm">add</span> Add Branch
                        </button>
                    </div>

                    <!-- Add Branch Form -->
                    <div x-show="showAddBranch" class="p-8 bg-neutral-50 dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-800 animate-slide-up">
                        <form action="{{ route('dashboard.business.branches.store') }}" method="POST" class="max-w-3xl space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-widest">Branch Name</label>
                                    <input type="text" name="name" required class="w-full bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 rounded-2xl py-3 px-6 text-sm focus:border-primary-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-widest">Google Review URL</label>
                                    <input type="url" name="google_review_url" required class="w-full bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 rounded-2xl py-3 px-6 text-sm focus:border-primary-500">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-widest">Address</label>
                                <input type="text" name="address" required class="w-full bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 rounded-2xl py-3 px-6 text-sm focus:border-primary-500">
                            </div>
                            <div class="flex gap-4">
                                <button type="submit" class="bg-primary-600 text-white px-8 py-3 rounded-full text-xs font-bold shadow-lg shadow-primary-500/20 active:scale-95">Save Branch</button>
                                <button type="button" @click="showAddBranch = false" class="text-neutral-500 text-xs font-bold">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-neutral-50/50 dark:bg-neutral-900/20 text-[10px] uppercase tracking-widest text-neutral-500 dark:text-neutral-400 font-black">
                                <th class="px-8 py-4">Branch Name</th>
                                <th class="px-8 py-4">Google Review URL</th>
                                <th class="px-8 py-4 text-center">Threshold</th>
                                <th class="px-8 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            @foreach($branches as $branch)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40 transition text-sm">
                                    <td class="px-8 py-5 font-bold dark:text-neutral-100">{{ $branch->name }}</td>
                                    <td class="px-8 py-5 text-primary-600 dark:text-primary-400 truncate max-w-xs font-medium">{{ $branch->google_review_url }}</td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 rounded-lg font-bold text-xs">{{ $branch->negative_review_threshold }} ★</span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <button @click="$dispatch('open-branch-settings', { id: {{ $branch->id }} })" class="text-primary-600 dark:text-primary-400 hover:underline font-bold text-xs uppercase tracking-tight">Manage</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- OAuth Sync Tab -->
                <div x-show="tab === 'oauth'" class="p-10 animate-fade-in space-y-8">
                    <div class="max-w-2xl">
                        <h4 class="text-xl font-google font-bold dark:text-neutral-50 mb-2">Automated Google Sync</h4>
                        <p class="text-neutral-500 dark:text-neutral-400">Connect your official Google Business Profile to automatically sync reviews, ratings, and business information.</p>

                        <div class="mt-8 p-6 bg-primary-50 dark:bg-primary-900/20 rounded-3xl border border-primary-100 dark:border-primary-800 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white dark:bg-dark-surface rounded-full flex items-center justify-center shadow-sm">
                                    <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png" class="w-6 h-6">
                                </div>
                                <div>
                                    <p class="font-bold dark:text-neutral-50">Google Business Profile</p>
                                    <p class="text-xs text-neutral-500">Not connected</p>
                                </div>
                            </div>
                            <a href="{{ route('auth.google.redirect') }}" class="bg-primary-600 text-white px-8 py-3 rounded-full text-sm font-bold shadow-lg shadow-primary-500/20 active:scale-95 transition-all">Connect Now</a>
                        </div>
                    </div>
                </div>

                <!-- Manual Sync Tab -->
                <div x-show="tab === 'manual'" class="p-10 animate-fade-in space-y-8">
                    <div class="max-w-2xl">
                        <h4 class="text-xl font-google font-bold dark:text-neutral-50 mb-2">Manual Web Syncing</h4>
                        <p class="text-neutral-500 dark:text-neutral-400">If you don't have API access or prefer not to use OAuth, you can sync your data manually by providing your public Google Maps URL.</p>

                        <form action="{{ route('dashboard.business.manual-sync') }}" method="POST" class="mt-8 space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-widest">Public Maps URL</label>
                                <input type="url" name="maps_url" required value="{{ $branches->first()?->google_review_url }}" placeholder="https://maps.google.com/maps?cid=..." class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-2xl py-4 px-6 text-sm focus:border-primary-500">
                            </div>
                            <button type="submit" class="bg-neutral-900 dark:bg-primary-600 text-white px-10 py-4 rounded-2xl font-bold shadow-xl active:scale-95 transition-all">Start Manual Sync</button>
                        </form>

                        @if($branches->first() && $branches->first()->business_description)
                            <div class="mt-10 p-8 bg-neutral-50 dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 rounded-[2rem] space-y-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 bg-success rounded-full animate-pulse"></div>
                                    <h5 class="text-sm font-bold dark:text-neutral-50">Profile Successfully Synced</h5>
                                </div>

                                <div class="space-y-4">
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black text-neutral-400 uppercase tracking-widest">Fetched Description</p>
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed italic">"{{ $branches->first()->business_description }}"</p>
                                    </div>

                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-neutral-400 uppercase tracking-widest">Profile Keywords</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($branches->first()->target_keywords ?? [] as $keyword)
                                                <span class="px-3 py-1 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-full text-[10px] font-bold text-neutral-500 dark:text-neutral-400">{{ $keyword }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800">
                                    <p class="text-[10px] text-neutral-400 font-medium">Last synced: {{ $branches->first()->last_google_sync?->diffForHumans() ?? 'Never' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Review Gate Customization (Mock for current branch) -->
            @if($branches->count() > 0)
            <div class="card p-10 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-[0.03] dark:opacity-[0.05] pointer-events-none">
                    <span class="material-symbols-rounded text-[12rem]">tune</span>
                </div>

                <h3 class="text-xl font-google font-bold mb-10 dark:text-neutral-50 flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center text-primary-600 dark:text-primary-400">
                        <span class="material-symbols-rounded text-xl">settings_suggest</span>
                    </div>
                    Review Gate: {{ $branches->first()->name }}
                </h3>

                <div class="max-w-3xl space-y-10 relative">
                    <div class="flex items-center justify-between p-6 bg-neutral-50 dark:bg-neutral-900/50 rounded-[1.5rem] border border-neutral-100 dark:border-neutral-800">
                        <div>
                            <h4 class="font-bold text-sm dark:text-neutral-100">Smart Reputation Filter</h4>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Intercept 1-3 star negative reviews before they go public.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" {{ $branches->first()->review_filter_enabled ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-neutral-200 dark:bg-neutral-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-neutral-400 uppercase tracking-widest">Interface Language</label>
                            <select class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-2xl focus:border-primary-500 focus:ring-primary-500 dark:text-neutral-300 py-4 px-6 text-sm font-medium">
                                <option value="en" {{ $branches->first()->interface_language === 'en' ? 'selected' : '' }}>English (Default)</option>
                                <option value="hi" {{ $branches->first()->interface_language === 'hi' ? 'selected' : '' }}>Hindi (हिन्दी)</option>
                                <option value="ta" {{ $branches->first()->interface_language === 'ta' ? 'selected' : '' }}>Tamil (தமிழ்)</option>
                                <option value="te" {{ $branches->first()->interface_language === 'te' ? 'selected' : '' }}>Telugu (తెలుగు)</option>
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-neutral-400 uppercase tracking-widest">AI Response Tone</label>
                            <select class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-2xl focus:border-primary-500 focus:ring-primary-500 dark:text-neutral-300 py-4 px-6 text-sm font-medium">
                                <option value="professional">Professional</option>
                                <option value="friendly" selected>Friendly</option>
                                <option value="enthusiastic">Enthusiastic</option>
                            </select>
                        </div>
                    </div>

                    <button class="bg-neutral-900 dark:bg-primary-600 text-white px-12 py-4 rounded-2xl font-bold shadow-xl transition hover:scale-[1.02] active:scale-[0.98]">Save Configuration</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
