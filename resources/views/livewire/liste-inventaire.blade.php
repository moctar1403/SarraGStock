<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec recherche --}}
        <div class="flex justify-between items-center mb-4">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
        </div>

        {{-- Tableau d'inventaire --}}
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
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité minimale') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Stock initial') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Entrées') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Sorties') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Pertes') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Stock final') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Unité de vente') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __("Prix d'achat") }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Valeur') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($articles as $item)
                                    @php
                                        $stockColor = ($final_stock[$item->id] >= $item->ar_qte_mini) ? 'text-green-500' : 'text-red-500';
                                        $entrees = $sum_entrees[$item->id] - $initials[$item->id];
                                        $pertes = $sorties_pertes[$item->id] + $sorties_dons[$item->id];
                                    @endphp
                                    
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ar_qte_mini) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($initials[$item->id]) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($entrees) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($sorties_stock[$item->id]) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($pertes) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium {{ $stockColor }} px-2 py-2">
                                            <span class="number-cell">{!! format_number($final_stock[$item->id]) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->unit_lib) }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ar_prix_achat) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ar_prix_achat * $item->ar_qte) !!}</span>
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
</div>