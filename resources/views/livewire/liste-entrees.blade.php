<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec recherche et bouton d'ajout --}}
        <div class="flex justify-between items-center mb-4">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
            
            {{-- Bouton d'ajout --}}
            @can('create entree')
                @include('partials.bouton_ajouter', [
                    'url' => route('entrees.create'),
                    'texte' => __('Nouvelle entrée en stock'),
                ])
            @endcan
        </div>

        {{-- Tableau des entrées --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Date') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Article') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Fournisseur') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix Achat') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix Vente') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Valeur') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Observations') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($entrees as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->updated_at->format('d/m/Y') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->four_nom }}</td>
                                        
                                        {{-- Quantité avec formatage selon unité --}}
                                        @php
                                            $qteValue = ($item->ar_unite == 1) ? (int)$item->ent_qte : $item->ent_qte;
                                        @endphp
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($qteValue) !!}</span>
                                        </td>
                                        
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ent_prix_achat) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ent_prix_vente) !!}</span>
                                        </td>                                                              
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ent_qte * $item->ent_prix_achat) !!}</span>
                                        </td>                                                              
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->ent_observations) }}</td>
                                        
                                        {{-- Actions --}}
                                        <td class="text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                @can('delete entree')
                                                    @if ($item->ent_motif != 'detail')
                                                        @include('partials.boutton_supprimer')
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
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
                            {{ $entrees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>