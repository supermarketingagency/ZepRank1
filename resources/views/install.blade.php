<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEPRANK Installation Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <style>
        body { font-family: 'Google Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex items-center justify-center p-6">
    @php
        $currentStep = request('step', 1);
    @endphp

    <div class="max-w-xl w-full">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-10">
            <div class="w-16 h-16 bg-blue-600 rounded-3xl flex items-center justify-center shadow-xl shadow-blue-500/20 mb-4">
                <span class="material-symbols-rounded text-white text-3xl font-bold">rocket_launch</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">ZEPRANK <span class="text-blue-600 font-medium">Installer</span></h1>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <!-- Progress Bar -->
            <div class="h-1.5 w-full bg-slate-100 flex">
                <div class="h-full bg-blue-600 transition-all duration-700" style="width: {{ ($currentStep / 4) * 100 }}%"></div>
            </div>

            <div class="p-10 md:p-12">
                @if($currentStep == 1)
                    <!-- Step 1: Environment Check -->
                    <div class="space-y-8 animate-fade-in">
                        <div class="space-y-2">
                            <h2 class="text-xl font-bold">Environment Checks</h2>
                            <p class="text-slate-500 text-sm">We need to make sure your hosting environment is ready.</p>
                        </div>

                        <div class="space-y-3">
                            @foreach($checks as $key => $passed)
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border {{ $passed ? 'border-emerald-100' : 'border-rose-100' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $passed ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                            <span class="material-symbols-rounded text-lg">{{ $passed ? 'check' : 'close' }}</span>
                                        </div>
                                        <span class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                    </div>
                                    <span class="text-[10px] font-black uppercase tracking-widest {{ $passed ? 'text-emerald-600' : 'text-rose-600' }}">{{ $passed ? 'Passed' : 'Failed' }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if(collect($checks)->every(fn($val) => $val))
                            <form action="{{ route('install.index', ['step' => 2]) }}" method="GET">
                                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-600/20 active:scale-[0.98] transition-all">Next: Database Setup</button>
                            </form>
                        @else
                            <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl border border-rose-100 text-sm flex gap-3">
                                <span class="material-symbols-rounded flex-shrink-0">warning</span>
                                <p>Please fix the errors above to continue. Check your folder permissions or PHP configuration.</p>
                            </div>
                            <button onclick="window.location.reload()" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold active:scale-[0.98] transition-all">Retry Checks</button>
                        @endif
                    </div>
                @endif

                @if($currentStep == 2)
                    <!-- Step 2: Database Setup -->
                    <div class="space-y-8 animate-fade-in" x-data="{
                        testing: false,
                        message: '',
                        success: false,
                        testConnection() {
                            this.testing = true;
                            fetch('{{ route('install.database.test') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    db_host: document.getElementsByName('db_host')[0].value,
                                    db_name: document.getElementsByName('db_name')[0].value,
                                    db_user: document.getElementsByName('db_user')[0].value,
                                    db_pass: document.getElementsByName('db_pass')[0].value,
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                this.testing = false;
                                this.message = data.message;
                                this.success = data.success;
                            });
                        }
                    }">
                        <div class="space-y-2">
                            <h2 class="text-xl font-bold">Database Setup</h2>
                            <p class="text-slate-500 text-sm">Enter your database credentials provided by your hosting panel.</p>
                        </div>

                        <form action="{{ route('install.database') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Host</label>
                                    <input type="text" name="db_host" value="localhost" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-5 text-sm focus:border-blue-500 outline-none">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Database Name</label>
                                    <input type="text" name="db_name" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-5 text-sm focus:border-blue-500 outline-none">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                                    <input type="text" name="db_user" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-5 text-sm focus:border-blue-500 outline-none">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                                    <input type="password" name="db_pass" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-5 text-sm focus:border-blue-500 outline-none">
                                </div>
                            </div>

                            <div x-show="message" :class="success ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100'" class="p-4 rounded-2xl border text-xs font-medium" x-text="message"></div>

                            <div class="pt-4 space-y-3">
                                <button type="button" @click="testConnection" :disabled="testing" class="w-full bg-slate-100 text-slate-900 py-4 rounded-2xl font-bold active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-rounded text-lg" :class="testing ? 'animate-spin' : ''">refresh</span>
                                    <span x-text="testing ? 'Testing...' : 'Test Connection'"></span>
                                </button>
                                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-600/20 active:scale-[0.98] transition-all">Save & Continue</button>
                            </div>
                        </form>
                    </div>
                @endif

                @if($currentStep == 3)
                    <!-- Step 3: App Configuration -->
                    <div class="space-y-8 animate-fade-in">
                        <div class="space-y-2">
                            <h2 class="text-xl font-bold">App Configuration</h2>
                            <p class="text-slate-500 text-sm">Fine-tune your application settings.</p>
                        </div>

                        <form action="{{ route('install.app') }}" method="POST" class="space-y-6 text-left">
                            @csrf
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">App Name</label>
                                <input type="text" name="app_name" value="ZEPRANK" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-5 text-sm focus:border-blue-500 outline-none">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">App URL</label>
                                <input type="url" name="app_url" value="{{ url('/') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-5 text-sm focus:border-blue-500 outline-none">
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                <input type="checkbox" name="generate_key" checked id="gen_key" class="w-5 h-5 rounded-lg border-blue-200 text-blue-600 focus:ring-blue-500">
                                <label for="gen_key" class="text-xs font-bold text-blue-800">Auto-generate secure App Key</label>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-600/20 active:scale-[0.98] transition-all">Continue to Finalization</button>
                            </div>
                        </form>
                    </div>
                @endif

                @if($currentStep == 4)
                    <!-- Step 4: Finalization -->
                    <div class="space-y-8 animate-fade-in" x-data="{ installing: false }">
                        <div class="space-y-4 text-center">
                            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="material-symbols-rounded text-4xl">celebration</span>
                            </div>
                            <h2 class="text-2xl font-bold">Ready to Launch!</h2>
                            <p class="text-slate-500 text-sm max-w-xs mx-auto">Click below to build the database schema, seed initial data, and finalize your installation.</p>
                        </div>

                        <form action="{{ route('install.finalize') }}" method="POST" @submit="installing = true">
                            @csrf
                            <button type="submit" :disabled="installing" class="w-full bg-blue-600 text-white py-5 rounded-2xl font-bold shadow-xl shadow-blue-600/30 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <span class="material-symbols-rounded" :class="installing ? 'animate-spin' : ''" x-text="installing ? 'sync' : 'bolt'"></span>
                                <span x-text="installing ? 'Running Migrations...' : 'Run Migrations & Install'"></span>
                            </button>
                        </form>

                        <p class="text-center text-[10px] text-slate-400 font-medium">This may take up to a minute. Do not refresh the page.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center mt-10 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">&copy; 2026 ZEPRANK SaaS Engine</p>
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
