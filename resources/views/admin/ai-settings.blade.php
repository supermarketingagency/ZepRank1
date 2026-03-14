<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ __('Global AI Settings') }}
        </h1>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        @if (session('success'))
            <div class="mb-6 p-4 bg-success/10 border-l-4 border-success text-success text-sm font-medium rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.ai-settings.update') }}" class="space-y-8">
            @csrf

            <div class="card p-8">
                <h3 class="text-lg font-google font-bold mb-6">Default AI Provider</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="ai_default_provider" :value="__('Primary Provider')" />
                        <select id="ai_default_provider" name="ai_default_provider" class="block mt-1 w-full border-neutral-300 rounded-lg">
                            <option value="groq" {{ ($settings['ai_default_provider'] ?? '') == 'groq' ? 'selected' : '' }}>Groq (Fastest)</option>
                            <option value="openai" {{ ($settings['ai_default_provider'] ?? '') == 'openai' ? 'selected' : '' }}>OpenAI (GPT-4)</option>
                            <option value="gemini" {{ ($settings['ai_default_provider'] ?? '') == 'gemini' ? 'selected' : '' }}>Google Gemini</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="ai_default_model" :value="__('Default Model')" />
                        <x-text-input id="ai_default_model" name="ai_default_model" type="text" class="mt-1 block w-full" :value="$settings['ai_default_model'] ?? 'llama-3.1-70b-versatile'" />
                    </div>
                </div>
            </div>

            <div class="card p-8">
                <h3 class="text-lg font-google font-bold mb-6">API Configuration</h3>
                <div class="space-y-6">
                    <div>
                        <x-input-label for="groq_api_key" :value="__('Groq API Key')" />
                        <x-text-input id="groq_api_key" name="groq_api_key" type="password" class="mt-1 block w-full" :value="$settings['groq_api_key'] ?? ''" placeholder="gsk_..." />
                    </div>
                    <div>
                        <x-input-label for="openai_api_key" :value="__('OpenAI API Key')" />
                        <x-text-input id="openai_api_key" name="openai_api_key" type="password" class="mt-1 block w-full" :value="$settings['openai_api_key'] ?? ''" placeholder="sk-..." />
                    </div>
                    <div>
                        <x-input-label for="gemini_api_key" :value="__('Gemini API Key')" />
                        <x-text-input id="gemini_api_key" name="gemini_api_key" type="password" class="mt-1 block w-full" :value="$settings['gemini_api_key'] ?? ''" />
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div x-data="{ testing: false, result: null }">
                    <button type="button"
                            @click="testing = true; fetch('{{ route('admin.ai-settings.test') }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                                .then(r => r.json())
                                .then(d => { result = d; testing = false; })"
                            class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 px-6 py-2.5 rounded-full text-xs font-bold transition active:scale-95 flex items-center gap-2"
                            :disabled="testing">
                        <span class="material-symbols-rounded text-sm" :class="testing ? 'animate-spin' : ''" x-text="testing ? 'sync' : 'vitals_check'"></span>
                        <span x-text="testing ? 'Testing...' : 'Test Default Provider'"></span>
                    </button>
                    <template x-if="result">
                        <div class="mt-4 p-4 rounded-2xl text-xs font-medium border animate-slide-up"
                             :class="result.success ? 'bg-success-50 text-success-700 border-success-100' : 'bg-danger-50 text-danger-700 border-danger-100'">
                            <p x-text="result.message"></p>
                        </div>
                    </template>
                </div>
                <x-primary-button class="btn-pill px-12 py-3 shadow-xl shadow-primary-500/20">
                    {{ __('Apply Global Changes') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
