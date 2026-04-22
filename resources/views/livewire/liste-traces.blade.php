<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec recherche et bouton de suppression --}}
        <div class="flex justify-between items-center mb-4">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
            
            {{-- Bouton suppression des traces --}}
            @can('delete traces')
                @include('partials.boutton_supprimer_traces')
            @endcan
        </div>

        {{-- Tableau des traces --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Date') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('User name') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Adresse IP') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Model') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Informations') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($traces as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->user_name }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ip }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                {{ class_basename($item->model) }}
                                            </span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2 max-w-xs truncate">{{ $item->data }}</td>
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
                            {{ $traces->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>