<div class="flex flex-wrap items-center {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }} gap-2 p-4 border-b">
    
    @can('view operations')
        <x-nav-link-dashboard :route="route('operat.index')" :active="request()->routeIs('operat.index')">
            {{ __('Opérations sur méthodes de paiement') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view paiements_clients')
        <x-nav-link-dashboard :route="route('paiements.index')" :active="request()->routeIs('paiements.index')">
            {{ __('Paiements clients') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view paiements_fournisseurs')
        <x-nav-link-dashboard :route="route('fournisseurs.pindex')" :active="request()->routeIs('fournisseurs.pindex')">
            {{ __('Paiements fournisseurs') }}
        </x-nav-link-dashboard>
    @endcan

    @can('view sauvegarde')
        <x-nav-link-dashboard :route="route('operation.sauvegarde_restauration')" :active="request()->routeIs('operation.sauvegarde_restauration')">
            {{ __('Base de données') }}
        </x-nav-link-dashboard>
    @endcan

</div>