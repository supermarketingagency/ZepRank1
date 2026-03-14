<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 animate-slide-up">
        <div class="max-w-7xl mx-auto space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-m3-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-rounded">business</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-google font-bold dark:text-neutral-50 mb-1">{{ $stats['total_businesses'] }}</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-neutral-400">Total Businesses</p>
                </div>

                <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-m3-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-success-50 dark:bg-success-900/20 text-success-500 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-rounded">group</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-google font-bold dark:text-neutral-50 mb-1">{{ $stats['total_users'] }}</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-neutral-400">Registered Users</p>
                </div>

                <div class="card p-8 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 transition-shadow hover:shadow-m3-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-warning-400/10 text-warning-500 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-rounded">payments</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-google font-bold dark:text-neutral-50 mb-1">₹{{ number_format($stats['total_businesses'] * 299) }}</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-neutral-400">Estimated MRR</p>
                </div>
            </div>

            <div class="card p-10 bg-white dark:bg-dark-surface border-neutral-200 dark:border-neutral-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-[0.03] dark:opacity-[0.05] pointer-events-none">
                    <span class="material-symbols-rounded text-[15rem]">settings</span>
                </div>
                <h3 class="text-xl font-google font-bold mb-8 dark:text-neutral-50 flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center text-primary-600 dark:text-primary-400">
                        <span class="material-symbols-rounded text-xl">admin_panel_settings</span>
                    </div>
                    System Controls
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <a href="{{ route('admin.ai-settings') }}" class="group p-6 bg-neutral-50 dark:bg-neutral-900/50 rounded-3xl border border-neutral-100 dark:border-neutral-800 hover:border-primary-500 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-dark-surface rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-primary-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-rounded">smart_toy</span>
                            </div>
                            <div>
                                <h4 class="font-bold dark:text-neutral-100">Global AI Settings</h4>
                                <p class="text-xs text-neutral-500">Configure providers and API keys.</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.businesses.index') }}" class="group p-6 bg-neutral-50 dark:bg-neutral-900/50 rounded-3xl border border-neutral-100 dark:border-neutral-800 hover:border-primary-500 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-dark-surface rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-primary-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-rounded">business_center</span>
                            </div>
                            <div>
                                <h4 class="font-bold dark:text-neutral-100">Business Management</h4>
                                <p class="text-xs text-neutral-500">Monitor and moderate user accounts.</p>
                            </div>
                        </div>
                    </a>
                    <div class="group p-6 bg-neutral-50 dark:bg-neutral-900/50 rounded-3xl border border-neutral-100 dark:border-neutral-800 opacity-50 cursor-not-allowed">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-dark-surface rounded-2xl flex items-center justify-center shadow-sm">
                                <span class="material-symbols-rounded">security</span>
                            </div>
                            <div>
                                <h4 class="font-bold dark:text-neutral-100">Access Logs</h4>
                                <p class="text-xs text-neutral-500">View detailed system audit logs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
