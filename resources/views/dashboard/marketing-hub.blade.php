<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h1 class="text-2xl font-google text-neutral-900 dark:text-neutral-50">
                    {{ __('Local Marketing Hub') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Boost foot traffic to <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $branch->name }}</span> with AI-powered search ads.</p>
            </div>
            <div class="flex gap-3">
                <button @click="$dispatch('open-ads-wizard')" class="btn-pill bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 text-sm flex items-center gap-2 shadow-xl transition-all active:scale-95">
                    <span class="material-symbols-rounded text-lg">rocket_launch</span>
                    New Campaign
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-12">
            <!-- Google Ads Hero -->
            <div class="bg-gradient-to-br from-primary-600 to-primary-900 dark:from-primary-700 dark:to-primary-950 rounded-[3rem] overflow-hidden shadow-m3-3 border-none relative group">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 dark:bg-primary-400/10 rounded-full -mr-48 -mt-48 blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>

                <div class="p-16 relative flex flex-col md:flex-row items-center gap-16">
                    <div class="flex-grow text-white">
                        <div class="flex items-center gap-3 mb-8">
                            <span class="inline-block px-4 py-1.5 bg-white/20 rounded-full text-[10px] font-bold uppercase tracking-[0.25em] backdrop-blur-md">Premium GMB Tool</span>
                            <div class="w-2 h-2 rounded-full bg-success-400 animate-ping"></div>
                        </div>
                        <h3 class="text-5xl font-google font-bold mb-6 leading-[1.1]">Hyper-Local<br/>Google Search Ads</h3>
                        <p class="text-primary-100 mb-12 text-xl max-w-xl leading-relaxed font-light">Drive targeted local traffic to your business in minutes. Our AI handles the keywords, bidding, and optimization so you don't have to.</p>
                        <div class="flex flex-wrap gap-6">
                            <button @click="$dispatch('open-ads-wizard')" class="bg-white text-primary-700 px-12 py-5 rounded-full font-black uppercase tracking-widest text-xs hover:shadow-2xl transition-all hover:-translate-y-1 active:scale-95 shadow-xl shadow-primary-900/20">Launch Ads Wizard</button>
                            <button class="bg-primary-500/20 border border-white/20 text-white px-12 py-5 rounded-full font-black uppercase tracking-widest text-xs backdrop-blur-sm transition-all hover:bg-primary-500/40">View Case Studies</button>
                        </div>
                    </div>
                    <div class="hidden lg:flex w-80 h-80 bg-white/5 rounded-[3rem] border border-white/10 items-center justify-center backdrop-blur-2xl shadow-inner rotate-3 group-hover:rotate-6 transition-transform duration-700">
                        <span class="material-symbols-rounded text-9xl text-white/50 drop-shadow-2xl">ads_click</span>
                    </div>
                </div>
            </div>

            <!-- Ads Wizard (Modal-like section) -->
            <div x-data="{ step: 1, open: false }"
                 @open-ads-wizard.window="open = true"
                 x-show="open"
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="card overflow-hidden bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 shadow-m3-3">
                <div class="p-6 border-b border-neutral-100 dark:border-neutral-800 flex justify-between items-center bg-neutral-50 dark:bg-neutral-900/50">
                    <h4 class="font-google font-bold text-lg dark:text-neutral-50">Local Ads Wizard</h4>
                    <div class="flex items-center gap-3">
                        <div class="flex gap-1">
                            <template x-for="i in 3">
                                <div class="w-8 h-1.5 rounded-full transition-colors" :class="i <= step ? 'bg-primary-500' : 'bg-neutral-200 dark:bg-neutral-700'"></div>
                            </template>
                        </div>
                        <span class="text-[10px] font-bold text-neutral-400 dark:text-neutral-500 uppercase ml-2">Step <span x-text="step"></span>/3</span>
                    </div>
                </div>

                <form action="{{ route('dashboard.marketing.ads') }}" method="POST" class="p-10">
                    @csrf
                    <!-- Step 1: Budget & Radius -->
                    <div x-show="step === 1" class="space-y-8 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-200 uppercase tracking-widest text-[10px]">Daily Budget (INR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 font-bold">₹</span>
                                    <input type="number" name="budget" value="1000" class="w-full pl-8 pr-4 py-4 bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-2xl focus:border-primary-500 focus:ring-primary-500 dark:text-white font-bold text-xl">
                                </div>
                                <p class="text-[10px] text-neutral-400 font-medium">Recommended: ₹500 - ₹2,000 per day</p>
                            </div>
                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-200 uppercase tracking-widest text-[10px]">Target Radius (km)</label>
                                <div class="pt-4">
                                    <input type="range" name="radius" min="1" max="50" value="5" class="w-full h-2 bg-neutral-200 dark:bg-neutral-800 rounded-lg appearance-none cursor-pointer accent-primary-600">
                                    <div class="flex justify-between text-[10px] font-bold text-neutral-400 mt-4">
                                        <span>1 km</span>
                                        <span class="text-primary-600 dark:text-primary-400 text-sm">Radius: 5 km</span>
                                        <span>50 km</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="step = 2" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-primary-500/20 active:scale-[0.98]">Continue to Keywords</button>
                    </div>

                    <!-- Step 2: Keywords -->
                    <div x-show="step === 2" class="space-y-8 animate-fade-in">
                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-200 uppercase tracking-widest text-[10px]">Target Keywords</label>
                            <textarea name="keywords" class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-2xl h-40 focus:border-primary-500 focus:ring-primary-500 p-6 dark:text-neutral-300 leading-relaxed" placeholder="Enter keywords separated by commas...">{{ implode(', ', array_column($suggestedKeywords, 'keyword')) }}</textarea>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="text-[10px] text-neutral-400 font-bold uppercase mr-2 mt-1">Suggested:</span>
                                @foreach($suggestedKeywords as $kw)
                                <span class="px-2 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-[10px] rounded font-bold transition cursor-pointer hover:bg-primary-100">{{ $kw['keyword'] }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="button" @click="step = 1" class="flex-1 bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 py-4 rounded-2xl font-bold hover:bg-neutral-200 transition-colors">Back</button>
                            <button type="button" @click="step = 3" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-primary-500/20">Preview Your Ad</button>
                        </div>
                    </div>

                    <!-- Step 3: Confirmation -->
                    <div x-show="step === 3" class="space-y-8 animate-fade-in text-center">
                        <div class="p-8 border border-primary-100 dark:border-primary-900/50 bg-primary-50/30 dark:bg-primary-900/10 rounded-3xl text-left relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4">
                                <span class="px-2 py-1 bg-primary-500 text-white text-[8px] font-black rounded uppercase">Ad</span>
                            </div>
                            <span class="text-[10px] font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest">Google Search Preview</span>
                            <h5 class="text-xl font-google font-bold text-primary-800 dark:text-primary-300 mt-4 leading-tight">Best {{ $branch->business->category }} in {{ $branch->address }}</h5>
                            <p class="text-sm text-primary-600 dark:text-primary-400 mt-2 leading-relaxed">Visit us today for the best experience. Verified 4.9 stars customer rating.</p>
                            <div class="mt-6 flex items-center gap-3 text-[11px] text-primary-500 font-bold">
                                <span class="material-symbols-rounded text-sm">location_on</span> {{ $branch->address }}
                                <span class="w-1 h-1 rounded-full bg-primary-300"></span>
                                <span class="material-symbols-rounded text-sm">call</span> Call Now
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="button" @click="step = 2" class="flex-1 bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 py-4 rounded-2xl font-bold hover:bg-neutral-200 transition-colors">Back</button>
                            <button type="submit" class="flex-1 bg-success-400 hover:bg-success-500 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-success-500/20">Launch Campaign Now</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ad Performance Section (Placeholder) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- WhatsApp & Email Requests -->
                <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 shadow-m3-1">
                    <div class="flex items-center justify-between mb-8">
                        <h4 class="font-google font-bold text-lg dark:text-neutral-50">Direct Review Requests</h4>
                        <div class="flex gap-2">
                            <span class="material-symbols-rounded text-primary-600">contact_mail</span>
                        </div>
                    </div>

                    <div x-data="{ type: 'whatsapp' }" class="space-y-6">
                        <div class="flex p-1 bg-neutral-100 dark:bg-neutral-900 rounded-xl">
                            <button @click="type = 'whatsapp'" :class="type === 'whatsapp' ? 'bg-white dark:bg-neutral-800 shadow-sm text-primary-600' : 'text-neutral-500'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all">WhatsApp</button>
                            <button @click="type = 'email'" :class="type === 'email' ? 'bg-white dark:bg-neutral-800 shadow-sm text-primary-600' : 'text-neutral-500'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all">Email</button>
                        </div>

                        <form action="{{ route('dashboard.marketing.send') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="type" :value="type">
                            <input type="hidden" name="branch_id" value="{{ $branch->id }}">

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-neutral-400 uppercase tracking-widest" x-text="type === 'whatsapp' ? 'Phone Number' : 'Email Address'"></label>
                                <input :type="type === 'whatsapp' ? 'tel' : 'email'" name="recipient" required :placeholder="type === 'whatsapp' ? '+91 98765 43210' : 'customer@example.com'" class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-xl py-3 px-4 text-sm focus:border-primary-500">
                            </div>

                            <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-xl font-bold text-sm shadow-lg shadow-primary-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-rounded text-lg" x-text="type === 'whatsapp' ? 'send' : 'mail'"></span>
                                Send <span x-text="type === 'whatsapp' ? 'WhatsApp' : 'Email'"></span> Request
                            </button>
                        </form>

                        <div class="pt-6 border-t border-neutral-100 dark:border-neutral-800">
                            <h5 class="text-[10px] font-black text-neutral-400 uppercase tracking-widest mb-4 text-center">Bulk Campaign</h5>
                            <form action="{{ route('dashboard.marketing.bulk') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="type" :value="type">
                                <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                <textarea name="recipients" required :placeholder="type === 'whatsapp' ? '9876543210, 9876543211...' : 'user1@email.com, user2@email.com...'" class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-xl h-24 p-4 text-xs focus:border-primary-500"></textarea>
                                <button type="submit" class="w-full border-2 border-primary-600 text-primary-600 py-3 rounded-xl font-bold text-sm hover:bg-primary-50 dark:hover:bg-primary-900/10 active:scale-95 transition-all">Launch Bulk Campaign</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Ad Performance Section -->
                <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 shadow-m3-1">
                    <h4 class="font-google font-bold text-lg mb-8 dark:text-neutral-50">Active Campaigns</h4>
                    <div class="text-center py-16 text-neutral-400 dark:text-neutral-600 bg-neutral-50/50 dark:bg-neutral-900/20 rounded-3xl border border-dashed border-neutral-200 dark:border-neutral-800">
                        <span class="material-symbols-rounded text-6xl mb-4">bar_chart</span>
                        <p class="text-sm font-medium">No active campaigns found. Boost your foot traffic today!</p>
                        <button @click="$dispatch('open-ads-wizard')" class="mt-6 text-primary-600 dark:text-primary-400 font-bold text-xs hover:underline">Launch Your First Ad</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</x-app-layout>
