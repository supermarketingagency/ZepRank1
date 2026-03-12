<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reseller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Reseller Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <span class="material-symbols-rounded">group</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Your Customers</p>
                        <h4 class="text-2xl font-bold">{{ $customerCount }}</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <span class="material-symbols-rounded">payments</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Monthly Revenue</p>
                        <h4 class="text-2xl font-bold">₹0.00</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <span class="material-symbols-rounded">verified</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Wholesale Plan</p>
                        <h4 class="text-2xl font-bold">{{ ucfirst($reseller->wholesale_plan ?? 'Starter') }}</h4>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                <h3 class="font-bold text-lg mb-4">White-label Branding</h3>
                <p class="text-gray-600 mb-6">Configure your custom domain and branding colors. Your customers will see your brand instead of ZEPRANK.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Custom Domain</p>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">https://</span>
                                <input type="text" value="{{ $reseller->custom_domain ?? 'not-set.zeprank.com' }}" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</p>
                            <input type="text" value="{{ $reseller->brand_name ?? 'My Review SaaS' }}" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Colors</p>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Primary</p>
                                <div class="flex items-center gap-2 p-2 border border-gray-300 rounded-md">
                                    <div class="w-6 h-6 rounded border" style="background-color: {{ $reseller->primary_color ?? '#4F46E5' }}"></div>
                                    <span class="text-sm font-mono">{{ $reseller->primary_color ?? '#4F46E5' }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Secondary</p>
                                <div class="flex items-center gap-2 p-2 border border-gray-300 rounded-md">
                                    <div class="w-6 h-6 rounded border" style="background-color: {{ $reseller->secondary_color ?? '#7C3AED' }}"></div>
                                    <span class="text-sm font-mono">{{ $reseller->secondary_color ?? '#7C3AED' }}</span>
                                </div>
                            </div>
                        </div>
                        <button class="w-full bg-gray-800 text-white px-4 py-2 rounded-md font-medium text-sm hover:bg-gray-700 transition-colors">Save Branding Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
