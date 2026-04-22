<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Navigation des tiers --}}
        <div class="flex flex-wrap items-center justify-start rtl:justify-end gap-2 p-4 border-b">
            @if(app()->getLocale() == 'ar')
                {{-- Ordre inversé pour l'arabe --}}
                @can('view fournisseur')
                    <x-nav-link-dashboard :route="route('fournisseurs.index')" :active="request()->routeIs('fournisseurs.index')">
                        {{ __('Fournisseurs') }}
                    </x-nav-link-dashboard>
                @endcan

                @can('view client')
                    <x-nav-link-dashboard :route="route('clients.index')" :active="request()->routeIs('clients.index')">
                        {{ __('Clients') }}
                    </x-nav-link-dashboard>
                @endcan
            @else
                {{-- Ordre normal pour le français --}}
                @can('view client')
                    <x-nav-link-dashboard :route="route('clients.index')" :active="request()->routeIs('clients.index')">
                        {{ __('Clients') }}
                    </x-nav-link-dashboard>
                @endcan

                @can('view fournisseur')
                    <x-nav-link-dashboard :route="route('fournisseurs.index')" :active="request()->routeIs('fournisseurs.index')">
                        {{ __('Fournisseurs') }}
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