<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agency Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">Agency Campaigns</h3>
                <div class="bg-blue-50 p-8 rounded-2xl border border-blue-100 text-center">
                    <span class="material-symbols-rounded text-blue-400 text-5xl mb-4">campaign</span>
                    <h4 class="text-xl font-bold mb-2">No active campaigns</h4>
                    <p class="text-gray-500 mb-6">Start a WhatsApp or Email campaign to collect reviews in bulk.</p>
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-full font-bold">Create Campaign</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
