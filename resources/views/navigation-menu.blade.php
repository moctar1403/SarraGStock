{{-- Vérification des permissions --}}
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 {{ session('locale') === 'ar' ? 'flex-row-reverse' : '' }}">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between h-10">
            <div class="flex mt-3">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        @php
                            $societeInfo = add_image_societe();
                        @endphp
                        @if ($societeInfo[1] && isset($societeInfo[2]))
                            <img src="{{ asset($societeInfo[2]->soc_logo) }}" 
                                 class="max-w-[70px] max-h-[70px]" 
                                 alt="{{ __('Logo société') }}">
                        @endif
                    </a>
                </div>

                <!-- Navigation Links - Desktop -->
                <div class="hidden sm:-my-px sm:ms-6 sm:flex">
                    @can('view dashboard')
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endcan

                    @can('menu ventes')
                        <x-nav-link :href="route('caisse.ventes_resto')" :active="request()->routeIs('caisse.ventes_resto')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Ventes') }}
                        </x-nav-link>
                    @endcan

                    @can('menu ventes')
                        <x-nav-link href="{{ route('factures.index') }}" :active="request()->routeIs('factures.*')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Factures') }}
                        </x-nav-link>
                    @endcan

                    <x-nav-link :href="route('caisse.liste')" :active="request()->routeIs('caisse.*') || request()->routeIs('pos.*')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                        {{ __('Caisse') }}
                    </x-nav-link>

                    @can('menu articles')
                        <x-nav-link href="{{ route('articles.index') }}" :active="request()->routeIs('articles.index')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Articles') }}
                        </x-nav-link>
                    @endcan
                    @can('menu articles')
                        <x-nav-link href="{{ route('articles.index0') }}" :active="request()->routeIs('articles.index0')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Stock') }}
                        </x-nav-link>
                    @endcan

                    @can('menu tiers')
                        <x-nav-link href="{{ route('tiers') }}" :active="request()->routeIs('tiers')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Tiers') }}
                        </x-nav-link>
                    @endcan
                    
                    @can('menu configurations')
                        <x-nav-link href="{{ route('configs.index') }}" :active="request()->routeIs('configs.*')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Configurations') }}
                        </x-nav-link>
                    @endcan

                    {{-- @can('menu statistiques')
                        <x-nav-link href="{{ route('stats.index') }}" :active="request()->routeIs('stats.*')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Statistiques') }}
                        </x-nav-link>
                    @endcan --}}

                    @can('menu operations')
                        <x-nav-link href="{{ route('operation.index') }}" :active="request()->routeIs('operation.*')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                            {{ __('Opérations') }}
                        </x-nav-link>
                    @endcan

                    <x-nav-link :href="route('documentation')" :active="request()->routeIs('documentation*')" class="bg-cyan-500 rounded-md px-3 py-1 text-white hover:bg-cyan-600 transition mx-1">
                        {{ __('📚 Manuel') }}
                    </x-nav-link>
                    
                    {{-- Sélecteur de langue --}}
                    <div class="border-l border-gray-300 mx-2 h-6 self-center"></div>
                    
                    @if (app()->getLocale() == 'fr')
                        <x-nav-link href="{{ route('lang', 'ar') }}" class="bg-gray-500 rounded-md px-3 py-1 text-white hover:bg-gray-600 transition mx-1">
                            العربية
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('lang', 'fr') }}" class="bg-gray-500 rounded-md px-3 py-1 text-white hover:bg-gray-600 transition mx-1">
                            Français
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- User Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                    {{ Auth::user()->name }}
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Gérer le compte') }}
                            </div>
                            <div class="border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <span class="text-xl">☰</span> <!-- Remplacement du SVG par un caractère simple -->
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @can('view dashboard')
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endcan

            @can('menu ventes')
                <x-responsive-nav-link href="{{ route('caisse.ventes_resto') }}" :active="request()->routeIs('caisse.ventes_resto')">
                    {{ __('Ventes Resto') }}
                </x-responsive-nav-link>
            @endcan

            @can('menu ventes')
                <x-responsive-nav-link href="{{ route('factures.index') }}" :active="request()->routeIs('factures.*')">
                    {{ __('Factures') }}
                </x-responsive-nav-link>
            @endcan

            <x-responsive-nav-link href="{{ route('caisse.liste') }}" :active="request()->routeIs('caisse.*') || request()->routeIs('pos.*')">
                {{ __('Caisse (Resto)') }}
            </x-responsive-nav-link>

            @can('menu articles')
                <x-responsive-nav-link href="{{ route('articles.index0') }}" :active="request()->routeIs('articles.*')">
                    {{ __('Articles') }}
                </x-responsive-nav-link>
            @endcan

            @can('menu tiers')
                <x-responsive-nav-link href="{{ route('tiers') }}" :active="request()->routeIs('tiers')">
                    {{ __('Tiers') }}
                </x-responsive-nav-link>
            @endcan

            @can('menu configurations')
                <x-responsive-nav-link href="{{ route('configs.index') }}" :active="request()->routeIs('configs.*')">
                    {{ __('Configurations') }}
                </x-responsive-nav-link>
            @endcan

            @can('menu statistiques')
                <x-responsive-nav-link href="{{ route('stats.index') }}" :active="request()->routeIs('stats.*')">
                    {{ __('Statistiques') }}
                </x-responsive-nav-link>
            @endcan

            @can('menu operations')
                <x-responsive-nav-link href="{{ route('operation.index') }}" :active="request()->routeIs('operation.*')">
                    {{ __('Opérations') }}
                </x-responsive-nav-link>
            @endcan

            <x-responsive-nav-link :href="route('documentation')" :active="request()->routeIs('documentation*')">
                {{ __('📚 Manuel') }}
            </x-responsive-nav-link>

            <div class="border-t border-gray-200 my-2"></div>
            @if (app()->getLocale() == 'fr')
                <x-responsive-nav-link href="{{ route('lang', 'ar') }}">
                    العربية
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="{{ route('lang', 'fr') }}">
                    Français
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive User Menu -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>