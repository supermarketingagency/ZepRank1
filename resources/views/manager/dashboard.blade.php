<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('GMB Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">Your Managed Clients</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center">
                        <span class="material-symbols-rounded text-gray-400 text-4xl mb-2">business</span>
                        <p class="text-gray-500 text-sm">Managed Clients</p>
                        <h4 class="text-2xl font-bold">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
