<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Filtres de dates --}}
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de début') }}</label>
                <input type="date" 
                       class="block w-full rounded-md border-gray-300"
                       wire:model.live="date1">
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de fin') }}</label>
                <input type="date" 
                       class="block w-full rounded-md border-gray-300"
                       wire:model.live="date2">
            </div>
        </div>

        {{-- Articles à alimenter --}}
        <div class="bg-white rounded-lg mb-8">
            <h4 class="text-lg font-bold text-gray-900 p-4 border-b">
                {{ __('Les articles qui doivent être alimentés') }}
            </h4>
            
            <div class="p-4">
                <table class="min-w-full text-center">
                    <thead class="border-b bg-gray-50">
                        <tr style="vertical-align:middle">
                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Article') }}</th>
                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité minimale') }}</th>
                            <th class="text-sm font-medium text-red-500 px-2 py-2">{{ __('Quantité') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 0; @endphp
                        @forelse ($articles_d_a as $item)
                            @if ((float)($item->ar_qte_mini) > (float)($item->ar_qte))
                                @php $count++; @endphp
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_lib }}</td>
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        <span class="number-cell">{!! format_number($item->ar_qte_mini) !!}</span>
                                    </td>
                                    <td class="text-sm font-medium text-red-500 px-2 py-2">
                                        <span class="number-cell">{!! format_number($item->ar_qte) !!}</span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="flex flex-col items-center justify-center">
                                        <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                        <div class="text-gray-500">{{ __('Aucun élément trouvé!') }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        
                        @if($count == 0)
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="flex flex-col items-center justify-center">
                                        <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                        <div class="text-gray-500">{{ __('Aucun élément trouvé!') }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Articles les plus vendus --}}
        <div class="bg-white rounded-lg">
            <h4 class="text-lg font-bold text-gray-900 p-4 border-b">
                {{ __('Les articles les plus vendus') }}
            </h4>
            
            <div class="p-4">
                <table class="min-w-full text-center">
                    <thead class="border-b bg-gray-50">
                        <tr style="vertical-align:middle">
                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Article') }}</th>
                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Nombre de ventes') }}</th>
                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Quantité Totale') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventes as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->article->ar_lib }}</td>
                                <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                    <span class="number-cell">{!! format_number($item->number_of_article) !!}</span>
                                </td>
                                <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                    <span class="number-cell">{!! format_number($item->sum_qte) !!}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="flex flex-col items-center justify-center">
                                        <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                        <div class="text-gray-500">{{ __('Aucun élément trouvé!') }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>