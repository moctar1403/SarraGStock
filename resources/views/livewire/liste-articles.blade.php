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
            @can('create article')
                @include('partials.bouton_ajouter', [
                    'url' => route('articles.create'),
                    'texte' => __('Nouveau Article'),
                ])
            @endcan
        </div>

        {{-- Tableau des articles --}}
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
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Référence') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Description') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Code barre') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité minimale') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Unité de vente') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix Achat') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix Vente') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($articles as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_reference }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_description }}</td>
                                        
                                        {{-- Code barre (NE PAS formater, c'est une chaîne) --}}
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_codebarre }}</td>
                                        
                                        {{-- Quantité minimale --}}
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ar_qte_mini) !!}</span>
                                        </td>
                                        
                                        {{-- Quantité avec couleur conditionnelle --}}
                                        @php
                                            $qteColor = ($item->ar_qte >= $item->ar_qte_mini) ? 'text-green-500' : 'text-red-500';
                                            $qteValue = ($item->ar_unite == 1) ? (int)$item->ar_qte : $item->ar_qte;
                                        @endphp
                                        <td class="text-sm font-medium {{ $qteColor }} px-2 py-2">
                                            <span class="number-cell">{!! format_number($qteValue) !!}</span>
                                        </td>
                                        
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->unit_lib) }}</td>
                                        
                                        {{-- Prix Achat --}}
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ar_prix_achat) !!}</span>
                                        </td>
                                        
                                        {{-- Prix Vente --}}
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ar_prix_vente) !!}</span>
                                        </td>
                                        
                                        {{-- Actions --}}
                                        <td class="text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                @can('update article')
                                                    @include('partials.boutton_modifier', [
                                                        'url' => route('articles.edit', $item->id)
                                                    ])
                                                @endcan
                                                
                                                @can('delete article')
                                                    @include('partials.boutton_supprimer')
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
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
                            {{ $articles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>