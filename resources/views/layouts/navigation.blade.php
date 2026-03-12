<nav x-data="{ open: false }" class="bg-white border-b border-neutral-200 fixed top-0 left-0 right-0 z-50 h-16">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between h-full">
            <div class="flex items-center gap-4">
                <!-- Hamburger -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-full text-neutral-500 hover:bg-neutral-100 focus:outline-none transition duration-150 ease-in-out">
                    <span class="material-symbols-rounded">menu</span>
                </button>

                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-8 w-auto fill-current text-primary-600" />
                        <span class="text-xl font-google text-neutral-700 tracking-tight">ZEPRANK</span>
                    </a>
                </div>
            </div>

            <!-- Right side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <button class="p-2 text-neutral-500 hover:bg-neutral-100 rounded-full transition">
                    <span class="material-symbols-rounded">help</span>
                </button>
                <button class="p-2 text-neutral-500 hover:bg-neutral-100 rounded-full transition">
                    <span class="material-symbols-rounded">notifications</span>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="ml-2 flex items-center justify-center w-10 h-10 rounded-full bg-primary-600 text-white font-bold text-sm hover:shadow-lg transition">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-neutral-100">
                            <p class="text-sm font-bold text-neutral-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-neutral-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('My Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sign Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
