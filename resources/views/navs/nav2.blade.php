<div class="flex space-x-2 rtl:space-x-reverse px-14">
    @can('view vente')
        <x-nav-link-dashboard :route="route('factures.index')" :active="request()->routeIs('factures.index')">
            {{ __('Ventes') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view remise')
        <x-nav-link-dashboard :route="route('remises.index')" :active="request()->routeIs('remises.index')">
            {{ __('Ventes avec Remises') }}
        </x-nav-link-dashboard>
    @endcan
</div>