<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reseller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">White-label Branding</h3>
                <p class="text-gray-600 mb-4">Configure your custom domain and branding colors here.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-500 uppercase">Custom Domain</p>
                        <p class="text-lg">not-set.zeprank.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
