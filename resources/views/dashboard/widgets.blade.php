<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ __('Review Display Widgets') }}
        </h1>
    </x-slot>

    <div class="space-y-8">
        <div class="card p-8">
            <h3 class="text-xl font-google font-bold mb-4">Embed your reviews</h3>
            <p class="text-neutral-700 mb-8 max-w-2xl">Showcase your best 5-star Google reviews directly on your website. Increase customer trust and conversion with our highly customizable, mobile-responsive widgets.</p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Preview -->
                <div class="space-y-4">
                    <p class="text-xs font-bold text-neutral-500 uppercase tracking-widest">Live Preview</p>
                    <div class="bg-neutral-50 rounded-2xl p-8 border border-neutral-200 min-h-[300px] flex items-center justify-center">
                        <!-- Mock Widget -->
                        <div class="max-w-sm bg-white rounded-xl shadow-lg border border-neutral-100 p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold">JD</div>
                                <div>
                                    <h4 class="text-sm font-bold">John Doe</h4>
                                    <div class="flex text-warning text-xs">
                                        <span class="material-symbols-rounded text-sm">star</span>
                                        <span class="material-symbols-rounded text-sm">star</span>
                                        <span class="material-symbols-rounded text-sm">star</span>
                                        <span class="material-symbols-rounded text-sm">star</span>
                                        <span class="material-symbols-rounded text-sm">star</span>
                                    </div>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_Logo.svg" alt="Google" class="w-10 ml-auto opacity-50">
                            </div>
                            <p class="text-xs text-neutral-600 italic">"The best experience I've had in a long time. The service at {{ $business->name }} was exceptional!"</p>
                        </div>
                    </div>
                </div>

                <!-- Customization & Code -->
                <div class="space-y-6">
                    <div class="space-y-4">
                        <p class="text-xs font-bold text-neutral-500 uppercase tracking-widest">Configuration</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-neutral-700 mb-1">Widget Theme</label>
                                <select class="w-full text-sm border-neutral-300 rounded-lg">
                                    <option>Light (Google Style)</option>
                                    <option>Dark Mode</option>
                                    <option>Minimalist</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-neutral-700 mb-1">Layout</label>
                                <select class="w-full text-sm border-neutral-300 rounded-lg">
                                    <option>Single Review Card</option>
                                    <option>Grid (3x3)</option>
                                    <option>Carousel</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="text-xs font-bold text-neutral-500 uppercase tracking-widest">Embed Code</p>
                        <div class="relative">
                            <textarea readonly class="w-full h-32 bg-neutral-900 text-primary-100 font-mono text-[10px] p-4 rounded-xl border-none focus:ring-0">&lt;script src="https://cdn.zeprank.com/widget.js"&gt;&lt;/script&gt;
&lt;div id="zeprank-widget" data-id="{{ Str::random(10) }}"&gt;&lt;/div&gt;</textarea>
                            <button class="absolute top-3 right-3 text-primary-100 hover:text-white transition">
                                <span class="material-symbols-rounded text-lg">content_copy</span>
                            </button>
                        </div>
                        <p class="text-[10px] text-neutral-500 italic">Copy and paste this code into your website's HTML where you want the widget to appear.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
