<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec recherche et boutons d'ajout --}}
        <div class="flex justify-between items-center mb-4">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
            
            {{-- Boutons d'ajout --}}
            <div class="flex space-x-2 rtl:space-x-reverse">
                @can('create sortie')
                    @include('partials.bouton_ajouter', [
                        'url' => route('sorties.create'),
                        'texte' => __('Nouvelle sortie de stock'),
                        'couleur' => 'blue',
                        'icone' => true,
                    ])
                    
                    {{-- @include('partials.bouton_ajouter', [
                        'url' => route('sorties.detail'),
                        'texte' => __('Nouvelle opération de détail'),
                        'couleur' => 'green',
                        'icone' => true,
                    ]) --}}
                @endcan
            </div>
        </div>

        {{-- Tableau des sorties --}}
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
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix achat') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix vente') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Motif') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Observations') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($sorties as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->updated_at->format('d/m/Y') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->sor_qte) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->sor_prix_achat) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->sor_prix_vente) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @php
                                                $motifColor = match($item->sor_motif) {
                                                    'vente' => 'bg-green-100 text-green-800',
                                                    'perte' => 'bg-red-100 text-red-800',
                                                    'detail' => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 py-1 {{ $motifColor }} rounded-full text-xs">
                                                {{ __(ucfirst($item->sor_motif)) }}
                                            </span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->sor_observations) }}
                                        </td>
                                        
                                        {{-- Actions --}}
                                        <td class="text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                @if($item->sor_motif == 'perte')
                                                    @can('delete sortie')
                                                        @include('partials.boutton_supprimer')
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
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
                            {{ $sorties->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>