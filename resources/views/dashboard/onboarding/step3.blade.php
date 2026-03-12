<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Step 3: Set Negative Review Threshold') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-gray-600">Select the minimum star rating that will be directed to Google. Lower ratings will be routed to your private feedback inbox.</p>
                <form method="POST" action="{{ route('onboarding.step3') }}">
                    @csrf
                    <div class="mt-4">
                        <x-input-label for="threshold" :value="__('Minimum rating for Google')" />
                        <select id="threshold" name="threshold" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="1">1 Star and above</option>
                            <option value="2">2 Stars and above</option>
                            <option value="3">3 Stars and above</option>
                            <option value="4" selected>4 Stars and above (Recommended)</option>
                            <option value="5">5 Stars only</option>
                        </select>
                        <x-input-error :messages="$errors->get('threshold')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Next') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
