<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Navigation des opérations --}}
        <div class="flex flex-wrap items-center justify-start rtl:justify-end gap-2 p-4 border-b">
            @if(app()->getLocale() == 'ar')
                {{-- Ordre inversé pour l'arabe --}}
                @can('view sauvegarde')
                    <x-nav-link-dashboard :route="route('operation.sauvegarde_restauration')" :active="request()->routeIs('operation.sauvegarde_restauration')">
                        {{ __('Base de données') }}
                    </x-nav-link-dashboard>
                @endcan

                @can('view paiements_fournisseurs')
                    <x-nav-link-dashboard :route="route('fournisseurs.pindex')" :active="request()->routeIs('fournisseurs.pindex')">
                        {{ __('Paiements fournisseurs') }}
                    </x-nav-link-dashboard>
                @endcan

                @can('view paiements_clients')
                    <x-nav-link-dashboard :route="route('paiements.index')" :active="request()->routeIs('paiements.index')">
                        {{ __('Paiements clients') }}
                    </x-nav-link-dashboard>
                @endcan

                @can('view operations')
                    <x-nav-link-dashboard :route="route('operat.index')" :active="request()->routeIs('operat.index')">
                        {{ __('Opérations sur méthodes de paiement') }}
                    </x-nav-link-dashboard>
                @endcan
            @else
                {{-- Ordre normal pour le français --}}
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
            @endif
        </div>

        {{-- Contenu principal --}}
        <div class="flex flex-col mt-4">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <div class="text-center py-8 text-gray-500">
                            {{ __('Sélectionnez une option ci-dessus') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>