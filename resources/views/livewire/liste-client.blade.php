<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec titre et recherche --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Liste des clients') }}
        </h2>
        
        <div class="flex justify-between items-center mb-4">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>

            {{-- Boutons d'action --}}
            <div class="flex space-x-4 rtl:space-x-reverse">
                @can('create client')
                    @include('partials.bouton_ajouter', [
                        'url' => route('clients.create'),
                        'texte' => __('Ajouter Client'),
                        'couleur' => 'blue',
                        'icone' => false,
                    ])
                @endcan
                
                @include('partials.bouton_ajouter', [
                    'url' => route('paiements.index'),
                    'texte' => __('Liste Paiements'),
                    'couleur' => 'blue',
                    'icone' => false,
                ])
                
                @include('partials.bouton_ajouter', [
                    'url' => route('paiements.create'),
                    'texte' => __('Ajouter Paiement'),
                    'couleur' => 'blue',
                    'icone' => false,
                ])
            </div>
        </div>

        {{-- Tableau des clients --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Nom') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Civilité') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Société') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Tél') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Adresse') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Email') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Situation') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($clients as $item)
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->cli_nom }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->cli_civilite) }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->cli_societe }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->cli_tel) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->cli_adresse }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->cli_email }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($item->cli_situation) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                @can('update client')
                                                    @include('partials.boutton_modifier', [
                                                        'url' => route('clients.edit', $item->id)
                                                    ])
                                                @endcan
                                                
                                                @can('delete client')
                                                    @include('partials.boutton_supprimer')
                                                @endcan
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
                            {{ $clients->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>