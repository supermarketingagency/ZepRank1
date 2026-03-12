<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Step 5: Get your QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Your Setup is complete!</h3>
                <p class="mb-8 text-gray-600">You can now download your QR code and start collecting reviews.</p>

                <div class="mb-8 flex justify-center">
                    <!-- Placeholder for QR Code -->
                    <div class="border-4 border-gray-200 p-4 rounded-lg">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('dashboard')) }}" alt="QR Code">
                    </div>
                </div>

                <form method="POST" action="{{ route('onboarding.step5') }}">
                    @csrf
                    <x-primary-button>
                        {{ __('Go to Dashboard') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
