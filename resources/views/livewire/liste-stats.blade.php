<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Navigation des statistiques --}}
        <div class="flex flex-wrap items-center justify-start rtl:justify-end gap-2 p-4 border-b">
            @can('view stats_methodes')
                <x-nav-link-dashboard :route="route('stats.methodes')" :active="request()->routeIs('stats.methodes')">
                    {{ __('Méthodes de paiement') }}
                </x-nav-link-dashboard>
            @endcan

            {{-- Ajoutez d'autres liens de statistiques ici si nécessaire --}}
            @can('view stats_ventes')
                <x-nav-link-dashboard :route="route('stats.ventes')" :active="request()->routeIs('stats.ventes')">
                    {{ __('Ventes') }}
                </x-nav-link-dashboard>
            @endcan

            @can('view stats_articles')
                <x-nav-link-dashboard :route="route('stats.articles')" :active="request()->routeIs('stats.articles')">
                    {{ __('Articles') }}
                </x-nav-link-dashboard>
            @endcan
        </div>

        {{-- Contenu principal --}}
        <div class="flex flex-col mt-4">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        {{-- Contenu à venir --}}
                        <div class="text-center py-8 text-gray-500">
                            {{ __('Sélectionnez une option ci-dessus') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>