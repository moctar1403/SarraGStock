<x-app-layout>
    <x-slot name="header">
        {{-- Header vide mais conservé pour la structure --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-5">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        {{-- Navigation Sauvegarde / Restauration --}}
                        <div class="flex flex-wrap items-center justify-start rtl:justify-end gap-2 p-4 border-b">
                            @can('create backup')
                                <x-nav-link-dashboard :route="route('backup.create')" :active="request()->routeIs('backup.create')">
                                    {{ __('Sauvegarde') }}
                                </x-nav-link-dashboard>
                            @endcan

                            @can('view restauration')
                                <x-nav-link-dashboard :route="route('operation.restauration')" :active="request()->routeIs('operation.restauration')">
                                    {{ __('Restauration') }}
                                </x-nav-link-dashboard>
                            @endcan
                        </div>

                        {{-- Contenu principal --}}
                        <div class="flex flex-col mt-4">
                            <div class="overflow-x-auto">
                                <div class="py-4 inline-block min-w-full">
                                    <div class="overflow-hidden">
                                        {{-- Message temporaire --}}
                                        <div class="text-center py-8 text-gray-500">
                                            {{ __('Sélectionnez une option ci-dessus') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>