<div class="flex flex-wrap items-center justify-start rtl:justify-end gap-2 p-4 border-b">
    @if(app()->getLocale() == 'ar')
        {{-- Ordre inversé pour l'arabe --}}
        @can('view stock')
            <x-nav-link-dashboard :route="route('configs.stock')" :active="request()->routeIs('configs.stock')">
                {{ __('Stock') }}
            </x-nav-link-dashboard>
        @endcan

        {{-- Lien Langue (toujours visible) --}}
        <x-nav-link-dashboard :route="route('configs.langue')" :active="request()->routeIs('configs.langue')">
            {{ __('Langue') }}
        </x-nav-link-dashboard>

        @can('view traces')
            <x-nav-link-dashboard :route="route('configs.traces')" :active="request()->routeIs('configs.traces')">
                {{ __('Traces') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view unite')
            <x-nav-link-dashboard :route="route('configs.unite')" :active="request()->routeIs('configs.unite')">
                {{ __('Unités de vente') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view monnaie')
            <x-nav-link-dashboard :route="route('configs.monnaie')" :active="request()->routeIs('configs.monnaie')">
                {{ __('Monnaie') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view societe')
            <x-nav-link-dashboard :route="route('configs.societe')" :active="request()->routeIs('configs.societe')">
                {{ __('Société') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view methode')
            <x-nav-link-dashboard :route="route('methodes.index')" :active="request()->routeIs('methodes.index')">
                {{ __('Méthodes de paiement') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view user')
            <x-nav-link-dashboard :route="route('users.index')" :active="request()->routeIs('users.index')">
                {{ __('Utilisateurs') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view role')
            <x-nav-link-dashboard :route="route('roles.index')" :active="request()->routeIs('roles.index')">
                {{ __('Rôles') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view permission')
            <x-nav-link-dashboard :route="route('permissions.index')" :active="request()->routeIs('permissions.index')">
                {{ __('Permissions') }}
            </x-nav-link-dashboard>
        @endcan
    @else
        {{-- Ordre normal pour le français --}}
        @can('view permission')
            <x-nav-link-dashboard :route="route('permissions.index')" :active="request()->routeIs('permissions.index')">
                {{ __('Permissions') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view role')
            <x-nav-link-dashboard :route="route('roles.index')" :active="request()->routeIs('roles.index')">
                {{ __('Rôles') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view user')
            <x-nav-link-dashboard :route="route('users.index')" :active="request()->routeIs('users.index')">
                {{ __('Utilisateurs') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view methode')
            <x-nav-link-dashboard :route="route('methodes.index')" :active="request()->routeIs('methodes.index')">
                {{ __('Méthodes de paiement') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view societe')
            <x-nav-link-dashboard :route="route('configs.societe')" :active="request()->routeIs('configs.societe')">
                {{ __('Société') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view monnaie')
            <x-nav-link-dashboard :route="route('configs.monnaie')" :active="request()->routeIs('configs.monnaie')">
                {{ __('Monnaie') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view unite')
            <x-nav-link-dashboard :route="route('configs.unite')" :active="request()->routeIs('configs.unite')">
                {{ __('Unités de vente') }}
            </x-nav-link-dashboard>
        @endcan

        @can('view traces')
            <x-nav-link-dashboard :route="route('configs.traces')" :active="request()->routeIs('configs.traces')">
                {{ __('Traces') }}
            </x-nav-link-dashboard>
        @endcan

        {{-- Lien Langue (toujours visible) --}}
        <x-nav-link-dashboard :route="route('configs.langue')" :active="request()->routeIs('configs.langue')">
            {{ __('Langue') }}
        </x-nav-link-dashboard>

        @can('view stock')
            <x-nav-link-dashboard :route="route('configs.stock')" :active="request()->routeIs('configs.stock')">
                {{ __('Stock') }}
            </x-nav-link-dashboard>
        @endcan
    @endif
</div>