<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Filtres de recherche --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            {{-- Recherche méthode --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Méthode') }}</label>
                <input type="text" 
                       class="block w-full rounded-md border-gray-300" 
                       placeholder="{{ __('Méthode') }}"
                       wire:model.live="search_methode">
            </div>
            
            {{-- Recherche client --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Client') }}</label>
                <input type="text" 
                       class="block w-full rounded-md border-gray-300" 
                       placeholder="{{ __('Nom ou Tél') }}"
                       wire:model.live="search_client">
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
        </div>

        {{-- Tableau des factures --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Date') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Client') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix Total') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Mode de Paiement') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($factures as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->updated_at->format('d/m/Y') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->cli_nom }}</td>
                                        <td class="text-sm font-medium text-green-600 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->fa_tot_apres_remise) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                {{ __($item->meth_nom) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="flex flex-col items-center justify-center">
                                                <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                                <div class="text-gray-500">{{ __('Aucun élément trouvé ou une erreur sur les dates!') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                                {{-- Ligne total --}}
                                <tr class="border-t-2 border-gray-300 bg-gray-50 font-bold">
                                    <td colspan="2" class="text-sm font-bold text-gray-900 px-2 py-2"></td>
                                    <td class="text-sm font-bold text-green-600 px-2 py-2">{{ __('Total') }}</td>
                                    <td class="text-sm font-bold text-green-600 px-2 py-2">
                                        <span class="number-cell">{!! format_number($total) !!}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $factures->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>