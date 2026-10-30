<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        
        {{-- Navigation des articles (Sans duplication de code !) --}}
        <div class="flex flex-wrap items-center {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }} gap-2 p-4 border-b">
            
            @can('view article')
                <x-nav-link-dashboard :route="route('articles.index')" :active="request()->routeIs('articles.index')">
                    {{ __('Articles') }}
                </x-nav-link-dashboard>
            @endcan

            @can('view entree')
                <x-nav-link-dashboard :route="route('entrees.index')" :active="request()->routeIs('entrees.index')">
                    {{ __('Entrées des Articles') }}
                </x-nav-link-dashboard>
            @endcan

            @can('view sortie')
                <x-nav-link-dashboard :route="route('sorties.index')" :active="request()->routeIs('sorties.index')">
                    {{ __('Sorties des Articles') }}
                </x-nav-link-dashboard>
            @endcan

            @can('view detail')
                <x-nav-link-dashboard :route="route('listedetails.index')" :active="request()->routeIs('listedetails.index')">
                    {{ __('Détailler un article') }}
                </x-nav-link-dashboard>
            @endcan

            @can('view inventaire')
                <x-nav-link-dashboard :route="route('articles.inventaire')" :active="request()->routeIs('articles.inventaire')">
                    {{ __('Inventaire de stock') }}
                </x-nav-link-dashboard>
            @endcan

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