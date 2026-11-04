<div class="flex items-center space-x-2 rtl:space-x-reverse h-full">
    @can('view dashboard3')
        <x-nav-link-dashboard 
            :route="route('dashboard3')" 
            :active="request()->routeIs('dashboard3')"
            :icon="'shopping-cart'">
            {{ __('Synthèse') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view dashboard4')
        <x-nav-link-dashboard 
            :route="route('dashboard4')" 
            :active="request()->routeIs('dashboard4')"
            :icon="'chart-bar'">
            {{ __('Journal des Ventes') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view dashboard5')
        <x-nav-link-dashboard 
            :route="route('dashboard5')" 
            :active="request()->routeIs('dashboard5')"
            :icon="'cube'">
            {{ __('Analyse des Articles') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view dashboard6')
        <x-nav-link-dashboard 
            :route="route('dashboard6')" 
            :active="request()->routeIs('dashboard6')"
            :icon="'database'">
            {{ __('Bilan Financier') }}
        </x-nav-link-dashboard>
    @endcan
    @can('view dashboard6')
        <x-nav-link-dashboard 
            :route="route('historique.mouvements')" 
            :active="request()->routeIs('historique.mouvements')"
            :icon="'database'">
            {{ __('Journal Mouvements') }}
        </x-nav-link-dashboard>
    @endcan
</div>