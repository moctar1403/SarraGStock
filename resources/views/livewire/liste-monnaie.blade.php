<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec titre, recherche et bouton d'ajout --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Liste des Monnaies') }}
        </h2>
        
        <div class="flex justify-between items-center mb-4">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
            
            {{-- Bouton d'ajout --}}
            @can('create monnaie')
                @include('partials.bouton_ajouter', [
                    'url' => route('configs.monnaie.create'),
                    'texte' => __('Ajouter Monnaie'),
                    'couleur' => 'blue',
                    'icone' => true,
                ])
            @endcan
        </div>

        {{-- Tableau des monnaies --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Id') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Libellé') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Symbole') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Code') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Status/Action') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($monnaies as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->monn_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->monn_sym }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->monn_code }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @if ($item->monn_active == 1)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                    {{ __('Activé') }}
                                                </span>
                                            @else
                                                <button class="px-2 py-1 bg-orange-500 text-white rounded-md text-xs hover:bg-orange-600" 
                                                        wire:click="toggleStatus({{ $item->id }})">
                                                    {{ __('Rendre Active') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="flex flex-col items-center justify-center">
                                                <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                                <div class="text-gray-500">{{ __('Aucun élément trouvé!') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $monnaies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>