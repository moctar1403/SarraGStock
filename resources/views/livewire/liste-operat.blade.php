<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Filtres de recherche --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            {{-- Recherche texte --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Rechercher') }}</label>
                <input type="text" 
                       class="block w-full rounded-md border-gray-300" 
                       placeholder="{{ __('Méthode de paiement ou Type') }}"
                       wire:model.live="search">
            </div>    
            {{-- Date de début --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de début') }}</label>
                <input type="date" 
                       class="block w-full rounded-md border-gray-300"
                       wire:model.live="date1">
            </div>
            {{-- Date de fin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de fin') }}</label>
                <input type="date" 
                       class="block w-full rounded-md border-gray-300"
                       wire:model.live="date2">
            </div>
            {{-- Montant total --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Montant total') }}</label>
                <div class="block w-full py-2 px-3 bg-gray-100 rounded-md font-semibold">
                    <span class="number-cell">{!! format_number($total2) !!}</span>
                </div>
            </div>
        </div>
        {{-- Tableau des opérations --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Id') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Type') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Méthode') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Montant') }}</th>
                                </tr>
                            </thead>
                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($operats as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @php
                                                $type = '';
                                                if ($item->operat_vent_id != 0) $type = __('Vente');
                                                elseif ($item->operat_tr_id != 0) $type = __('Transfert');
                                                elseif ($item->operat_pa_cli_id != 0) $type = __('Paiement client');
                                                elseif ($item->operat_pa_four_id != 0) $type = __('Paiement fournisseur');
                                                elseif ($item->operat_re_id != 0) $type = __('Remise');
                                            @endphp
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $type }}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->meth_nom) }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->operat_montant) !!}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="flex flex-col items-center justify-center">
                                                <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                                <div class="text-gray-500">{{ __('Aucun élément trouvé ou il y a une erreur dans les dates!') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $operats->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>