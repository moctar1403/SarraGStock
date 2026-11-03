<div class="flex space-x-2 rtl:space-x-reverse px-14">
    @can('view vente')
        <x-nav-link-dashboard :route="route('factures.index')" :active="request()->routeIs('factures.index')">
            {{ __('Factures') }}
        </x-nav-link-dashboard>
    @endcan
</div>