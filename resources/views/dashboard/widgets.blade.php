<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google font-bold text-neutral-900 dark:text-neutral-50 animate-fade-in">
            {{ __('Review Display Widgets') }}
        </h1>
    </x-slot>

    <div class="space-y-10 animate-slide-up">
        <div class="card p-10 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-10 opacity-[0.03] dark:opacity-[0.05] pointer-events-none">
                <span class="material-symbols-rounded text-[14rem]">widgets</span>
            </div>

            <div class="relative">
                <h3 class="text-2xl font-google font-bold mb-4 dark:text-neutral-50">Embed your success</h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-10 max-w-2xl leading-relaxed text-lg font-light">Showcase your best 5-star Google reviews directly on your website. Build instant trust with visitors using our minimalist, Material 3 widgets.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 relative">
                <!-- Preview -->
                <div class="space-y-6">
                    <p class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Live Visualizer</p>
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-[2rem] p-10 border border-neutral-100 dark:border-neutral-800 min-h-[400px] flex items-center justify-center transition-colors">
                        <!-- Mock Widget -->
                        <div class="max-w-sm bg-white dark:bg-dark-card rounded-2xl shadow-m3-3 border border-neutral-100 dark:border-neutral-700 p-8 transform hover:scale-[1.02] transition-all duration-500">
                            <div class="flex items-center gap-5 mb-6">
                                <div class="w-14 h-14 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold text-lg">JD</div>
                                <div>
                                    <h4 class="text-sm font-bold dark:text-neutral-100">John Doe</h4>
                                    <div class="flex text-warning-400 text-xs mt-0.5">
                                        <span class="material-symbols-rounded text-base">star</span>
                                        <span class="material-symbols-rounded text-base">star</span>
                                        <span class="material-symbols-rounded text-base">star</span>
                                        <span class="material-symbols-rounded text-base">star</span>
                                        <span class="material-symbols-rounded text-base">star</span>
                                    </div>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_Logo.svg" alt="Google" class="w-10 ml-auto opacity-30 dark:opacity-50">
                            </div>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 italic leading-relaxed">"The best experience I've had in a long time. The service at <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $business->name }}</span> was truly exceptional!"</p>
                        </div>
                    </div>
                </div>

                <!-- Customization & Code -->
                <div class="space-y-10">
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Configuration</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300">Widget Theme</label>
                                <select class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-xl focus:border-primary-500 focus:ring-primary-500 dark:text-neutral-300 py-3 px-4 text-sm font-medium">
                                    <option>Light (Google Style)</option>
                                    <option>Dark Mode</option>
                                    <option>Minimalist</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-neutral-700 dark:text-neutral-300">Layout</label>
                                <select class="w-full bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 rounded-xl focus:border-primary-500 focus:ring-primary-500 dark:text-neutral-300 py-3 px-4 text-sm font-medium">
                                    <option>Single Review Card</option>
                                    <option>Grid (3x3)</option>
                                    <option>Interactive Carousel</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-neutral-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Deployment Code</p>
                        <div class="relative group">
                            <textarea readonly class="w-full h-40 bg-neutral-900 dark:bg-black text-primary-100 font-mono text-[11px] p-6 rounded-2xl border-none focus:ring-0 leading-relaxed shadow-xl">&lt;script src="https://cdn.zeprank.com/widget.js"&gt;&lt;/script&gt;
&lt;div id="zeprank-widget"
     data-id="{{ Str::random(10) }}"
     data-theme="m3-google"&gt;
&lt;/div&gt;</textarea>
                            <button class="absolute top-4 right-4 bg-white/10 hover:bg-white/20 text-white p-3 rounded-xl transition backdrop-blur-md active:scale-90" title="Copy Code">
                                <span class="material-symbols-rounded text-xl">content_copy</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-primary-50/30 dark:bg-primary-900/10 rounded-xl border border-primary-100/50 dark:border-primary-800/30">
                            <span class="material-symbols-rounded text-primary-600 dark:text-primary-400 text-sm">info</span>
                            <p class="text-[11px] text-neutral-500 dark:text-neutral-400 leading-tight">Paste this code inside the <code>&lt;head&gt;</code> or <code>&lt;body&gt;</code> of your website to go live.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
