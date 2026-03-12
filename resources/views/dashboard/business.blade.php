<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Profile & Branches') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Business Details -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
                <h3 class="text-lg font-bold mb-4">Business Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Name</p>
                        <p class="font-medium">{{ $business->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Category</p>
                        <p class="font-medium">{{ $business->category }}</p>
                    </div>
                </div>
            </div>

            <!-- Branches -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Your Branches</h3>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Add Branch</button>
                </div>
                <div class="p-0">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-xs uppercase text-gray-500">
                                <th class="px-6 py-3">Branch Name</th>
                                <th class="px-6 py-3">Review URL</th>
                                <th class="px-6 py-3">Threshold</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                                <tr class="border-t border-gray-100 text-sm">
                                    <td class="px-6 py-4 font-medium">{{ $branch->name }}</td>
                                    <td class="px-6 py-4 text-blue-600 truncate max-w-xs">{{ $branch->google_review_url }}</td>
                                    <td class="px-6 py-4">{{ $branch->negative_review_threshold }} ★</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span>
                                            <button @click="$dispatch('open-branch-settings', { id: {{ $branch->id }} })" class="text-blue-600 hover:underline">Settings</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Review Gate Customization (Mock for current branch) -->
            @if($branches->count() > 0)
            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-rounded text-blue-600">tune</span>
                    Review Gate Customization: {{ $branches->first()->name }}
                </h3>

                <div class="space-y-8">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div>
                            <h4 class="font-bold text-sm">Smart Review Filter</h4>
                            <p class="text-xs text-gray-500">Automatically route 1-3 star reviews to private feedback form.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" {{ $branches->first()->review_filter_enabled ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Interface Language</label>
                            <select class="w-full border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                                <option value="en" {{ $branches->first()->interface_language === 'en' ? 'selected' : '' }}>English (Default)</option>
                                <option value="hi" {{ $branches->first()->interface_language === 'hi' ? 'selected' : '' }}>Hindi (हिन्दी)</option>
                                <option value="ta" {{ $branches->first()->interface_language === 'ta' ? 'selected' : '' }}>Tamil (தமிழ்)</option>
                                <option value="te" {{ $branches->first()->interface_language === 'te' ? 'selected' : '' }}>Telugu (తెలుగు)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">AI Response Tone</label>
                            <select class="w-full border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                                <option value="professional">Professional</option>
                                <option value="friendly" selected>Friendly</option>
                                <option value="enthusiastic">Enthusiastic</option>
                            </select>
                        </div>
                    </div>

                    <button class="bg-gray-900 text-white px-8 py-3 rounded-xl font-bold">Save Gate Settings</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
