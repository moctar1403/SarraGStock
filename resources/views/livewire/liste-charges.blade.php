<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec recherche et bouton d'ajout --}}
        <div class="flex justify-between items-center mb-4">
            <div class="w-1/3">
                <input type="text"
                       class="block mt-1 rounded-md border-gray-300 w-full"
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>

            @can('create charge')
                @include('partials.bouton_ajouter', [
                    'url' => route('charges.create'),
                    'texte' => __('Nouvelle Charge'),
                ])
            @endcan
        </div>

        {{-- Tableau des charges --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Id') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Libellé') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Montant') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Date') }}</th>
                                    {{-- ❌ Colonne Méthode supprimée --}}
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Utilisateur') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Observations') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($charges as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ch_libelle }}</td>
                                        <td class="text-sm font-medium text-red-500 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->ch_montant) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            {{ \Carbon\Carbon::parse($item->ch_date)->format('d/m/Y') }}
                                        </td>
                                        {{-- ❌ Cellule Méthode supprimée --}}
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->user_name }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ch_observations }}</td>

                                        <td class="text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                @can('update charge')
                                                    @include('partials.boutton_modifier', [
                                                        'url' => route('charges.edit', $item->id)
                                                    ])
                                                @endcan

                                                @can('delete charge')
                                                    @include('partials.boutton_supprimer', ['id' => $item->id])
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="flex flex-col items-center justify-center">
                                                <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                                <div class="text-gray-500">{{ __('Aucun élément trouvé!') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $charges->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmation (Version simple) --}}
    @include('partials.confirm-delete-modal')
</div>