<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Step 4: Branding & Customization') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('onboarding.step4') }}">
                    @csrf
                    <div>
                        <x-input-label for="welcome_message" :value="__('Welcome Message')" />
                        <x-text-input id="welcome_message" class="block mt-1 w-full" type="text" name="welcome_message" :value="old('welcome_message', 'How was your experience?')" />
                        <x-input-error :messages="$errors->get('welcome_message')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="primary_color" :value="__('Primary Color (Hex)')" />
                        <x-text-input id="primary_color" class="block mt-1 w-full" type="text" name="primary_color" :value="old('primary_color', '#4285F4')" />
                        <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
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
