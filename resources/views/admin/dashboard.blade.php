<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Businesses</p>
                    <h3 class="text-2xl font-bold">{{ $stats['total_businesses'] }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Users</p>
                    <h3 class="text-2xl font-bold">{{ $stats['total_users'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
