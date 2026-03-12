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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
