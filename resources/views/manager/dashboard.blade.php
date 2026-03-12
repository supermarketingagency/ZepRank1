<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('GMB Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Manager Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <span class="material-symbols-rounded">business</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Managed Clients</p>
                        <h4 class="text-2xl font-bold">{{ $managedBusinesses->count() }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <span class="material-symbols-rounded">reviews</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Reviews Generated</p>
                        <h4 class="text-2xl font-bold">{{ $totalReviews }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                        <span class="material-symbols-rounded">star</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Avg Rating Across Clients</p>
                        <h4 class="text-2xl font-bold">{{ number_format($avgRating, 1) }}</h4>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Your Managed Clients</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase tracking-wider">Business Name</th>
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase tracking-wider">Branches</th>
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($managedBusinesses as $client)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-4">{{ $client->name }}</td>
                                    <td class="py-4 px-4">{{ $client->branches->count() }}</td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $client->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ ucfirst($client->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View as Client</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">No managed clients found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
