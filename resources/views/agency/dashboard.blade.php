<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agency Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Agency Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                        <span class="material-symbols-rounded">group</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Active Clients</p>
                        <h4 class="text-2xl font-bold">{{ $managedClients->count() }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <span class="material-symbols-rounded">campaign</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Active Campaigns</p>
                        <h4 class="text-2xl font-bold">{{ $totalCampaigns }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <span class="material-symbols-rounded">rocket_launch</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Review Impact</p>
                        <h4 class="text-2xl font-bold">{{ $totalReviews }}</h4>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                <h3 class="font-bold text-lg mb-4">Agency Campaigns</h3>
                <div class="bg-blue-50 p-8 rounded-2xl border border-blue-100 text-center">
                    <span class="material-symbols-rounded text-blue-400 text-5xl mb-4">campaign</span>
                    <h4 class="text-xl font-bold mb-2">Ready to scale?</h4>
                    <p class="text-gray-500 mb-6">Start a WhatsApp or Email campaign to collect reviews for all your clients in bulk.</p>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold transition-colors">Create Bulk Campaign</button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                <h3 class="font-bold text-lg mb-4">Client Portfolio Onboarding</h3>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-blue-200 transition-colors cursor-pointer">
                    <span class="material-symbols-rounded text-gray-300 text-5xl mb-4">upload_file</span>
                    <h4 class="text-lg font-medium text-gray-700">Import Clients via CSV</h4>
                    <p class="text-gray-500 text-sm mt-1">Upload your customer list to onboard them in bulk.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
