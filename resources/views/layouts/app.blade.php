<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ZEPRANK') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0&display=swap" rel="stylesheet">

    <!-- Design Tokens & Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#E8F0FE',
                            100: '#D2E3FC',
                            200: '#AECBFA',
                            300: '#82ABFA',
                            400: '#5B8DEF',
                            500: '#4285F4',
                            600: '#1A73E8',
                            700: '#1557B0',
                            800: '#0D47A1',
                            900: '#083594'
                        },
                        success: {
                            50: '#E6F4EA',
                            400: '#34A853',
                            500: '#1E8E3E',
                        },
                        warning: {
                            400: '#FBBC04',
                            500: '#F9AB00',
                        },
                        danger: {
                            400: '#EA4335',
                            500: '#D93025',
                        },
                        neutral: {
                            50: '#F8F9FA',
                            100: '#F1F3F4',
                            200: '#E8EAED',
                            300: '#DADCE0',
                            400: '#BDC1C6',
                            500: '#9AA0A6',
                            600: '#80868B',
                            700: '#5F6368',
                            800: '#3C4043',
                            900: '#202124'
                        },
                        dark: {
                            surface: '#1C1C1E',
                            card: '#2C2C2E',
                            background: '#111111'
                        }
                    },
                    fontFamily: {
                        google: ['"Google Sans"', '"Product Sans"', 'sans-serif'],
                        body: ['Roboto', 'sans-serif'],
                    },
                    boxShadow: {
                        'm3-1': '0 1px 2px 0 rgba(60,64,67,0.30), 0 1px 3px 1px rgba(60,64,67,0.15)',
                        'm3-2': '0 1px 2px 0 rgba(60,64,67,0.30), 0 2px 6px 2px rgba(60,64,67,0.15)',
                        'm3-3': '0 1px 2px 0 rgba(60,64,67,0.30), 0 4px 8px 3px rgba(60,64,67,0.15)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Roboto', sans-serif; transition: background-color 300ms ease, color 300ms ease; }
        h1, h2, h3, h4, .font-google { font-family: 'Google Sans', sans-serif; }

        .card { transition: box-shadow 200ms ease, transform 200ms ease; }
        .card:hover { transform: translateY(-1px); }

        .nav-item-active {
            background-color: #E8F0FE;
            color: #1A73E8;
            border-radius: 0 9999px 9999px 0;
            margin-right: 12px;
            position: relative;
        }
        .dark .nav-item-active {
            background-color: rgba(66, 133, 244, 0.15);
            color: #8AB4F8;
        }
        .nav-item-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: #1A73E8;
            border-radius: 0 2px 2px 0;
        }
        .dark .nav-item-active::before { background: #8AB4F8; }

        /* Animation Keyframes */
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slide-up 400ms cubic-bezier(0.4, 0, 0.2, 1); }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in { animation: fade-in 300ms ease-in; }

        /* Star Rating Colors */
        .star-1 { color: #EA4335; }
        .star-2 { color: #FF7043; }
        .star-3 { color: #FBBC04; }
        .star-4 { color: #34A853; }
        .star-5 { color: #1E8E3E; }
    </style>
</head>
<body class="antialiased bg-neutral-50 dark:bg-dark-background text-neutral-900 dark:text-neutral-50"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <div class="flex flex-1 pt-16">
            <!-- Sidebar (Desktop) -->
            <aside class="w-64 fixed left-0 top-16 bottom-0 border-r border-neutral-200 dark:border-neutral-800 bg-white dark:bg-dark-surface hidden lg:block overflow-y-auto pt-4 transition-colors duration-300">
                <nav class="space-y-1">
                    @if(auth()->user()->primary_role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">admin_panel_settings</span>
                        <span class="text-sm font-medium">Platform Admin</span>
                    </a>
                    <a href="{{ route('admin.ai-settings') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('admin.ai-settings') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">smart_toy</span>
                        <span class="text-sm font-medium">AI Control</span>
                    </a>
                    <div class="h-px bg-neutral-200 my-4 mx-4"></div>
                    @endif

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">dashboard</span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('dashboard.reviews') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.reviews') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">history</span>
                        <span class="text-sm font-medium">Review Log</span>
                    </a>
                    <a href="{{ route('dashboard.reviews.manage') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.reviews.manage') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">rate_review</span>
                        <span class="text-sm font-medium">Manage Reviews</span>
                    </a>
                    <a href="{{ route('dashboard.feedback') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.feedback') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">feedback</span>
                        <span class="text-sm font-medium">Private Feedback</span>
                    </a>
                    <a href="{{ route('dashboard.qr') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.qr') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">qr_code</span>
                        <span class="text-sm font-medium">QR & Links</span>
                    </a>
                    <div class="h-px bg-neutral-200 my-4 mx-4"></div>

                    <div class="px-6 py-2 text-xs font-bold text-neutral-400 uppercase tracking-widest">Growth Tools</div>
                    <a href="{{ route('dashboard.competitors') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.competitors') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">monitoring</span>
                        <span class="text-sm font-medium">Competitors</span>
                    </a>
                    <a href="{{ route('dashboard.audit') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.audit') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">fact_check</span>
                        <span class="text-sm font-medium">GMB Audit</span>
                    </a>
                    <a href="{{ route('dashboard.marketing') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.marketing') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">campaign</span>
                        <span class="text-sm font-medium">Marketing & Ads</span>
                    </a>

                    <div class="h-px bg-neutral-200 my-4 mx-4"></div>
                    <a href="{{ route('dashboard.business') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.business') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">business</span>
                        <span class="text-sm font-medium">Business Profile</span>
                    </a>
                    <a href="{{ route('dashboard.analytics') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.analytics') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">analytics</span>
                        <span class="text-sm font-medium">Analytics</span>
                    </a>
                    <a href="{{ route('dashboard.widgets') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.widgets') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">widgets</span>
                        <span class="text-sm font-medium">Review Widgets</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 lg:ml-64 p-8 animate-fade-in">
                @isset($header)
                    <div class="mb-8">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
