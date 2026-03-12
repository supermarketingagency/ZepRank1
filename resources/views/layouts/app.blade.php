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
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#E8F0FE',
                            100: '#D2E3FC',
                            500: '#4285F4',
                            600: '#1A73E8',
                            700: '#1557B0'
                        },
                        success: '#34A853',
                        warning: '#FBBC04',
                        danger: '#EA4335',
                        neutral: {
                            50: '#F8F9FA',
                            100: '#F1F3F4',
                            200: '#E8EAED',
                            300: '#DADCE0',
                            700: '#5F6368',
                            900: '#202124'
                        }
                    },
                    fontFamily: {
                        google: ['"Google Sans"', 'sans-serif'],
                        body: ['Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --elevation-1: 0 1px 2px 0 rgba(60,64,67,0.30), 0 1px 3px 1px rgba(60,64,67,0.15);
            --elevation-2: 0 1px 2px 0 rgba(60,64,67,0.30), 0 2px 6px 2px rgba(60,64,67,0.15);
        }
        body { font-family: 'Roboto', sans-serif; background-color: #F8F9FA; color: #202124; }
        h1, h2, h3, h4, .font-google { font-family: 'Google Sans', sans-serif; }
        .card { background: white; border-radius: 12px; border: 1px solid #E8EAED; box-shadow: var(--elevation-1); transition: box-shadow 200ms; }
        .card:hover { box-shadow: var(--elevation-2); }
        .btn-pill { border-radius: 9999px; font-weight: 500; letter-spacing: 0.1px; transition: all 200ms; }
        .nav-item-active { background-color: #E8F0FE; color: #1A73E8; border-radius: 0 9999px 9999px 0; margin-right: 12px; position: relative; }
        .nav-item-active::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 24px; background: #1A73E8; border-radius: 0 2px 2px 0; }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <div class="flex flex-1 pt-16">
            <!-- Sidebar (Desktop) -->
            <aside class="w-64 fixed left-0 top-16 bottom-0 border-right border-neutral-200 bg-white hidden lg:block overflow-y-auto pt-4">
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">dashboard</span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('dashboard.reviews') }}" class="flex items-center gap-4 px-6 py-3 {{ request()->routeIs('dashboard.reviews') ? 'nav-item-active' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <span class="material-symbols-rounded">star</span>
                        <span class="text-sm font-medium">Reviews</span>
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
            <main class="flex-1 lg:ml-64 p-8">
                @isset($header)
                    <div class="mb-8">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
