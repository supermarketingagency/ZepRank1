<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Step 2: Setup your first branch') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('onboarding.step2') }}">
                    @csrf
                    <div>
                        <x-input-label for="branch_name" :value="__('Branch Name')" />
                        <x-text-input id="branch_name" class="block mt-1 w-full" type="text" name="branch_name" :value="old('branch_name', 'Main Branch')" required autofocus />
                        <x-input-error :messages="$errors->get('branch_name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="google_review_url" :value="__('Google Review URL')" />
                        <x-text-input id="google_review_url" class="block mt-1 w-full" type="url" name="google_review_url" :value="old('google_review_url')" required placeholder="https://search.google.com/local/writereview?placeid=..." />
                        <x-input-error :messages="$errors->get('google_review_url')" class="mt-2" />
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
