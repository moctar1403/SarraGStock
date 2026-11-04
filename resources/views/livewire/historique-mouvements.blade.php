<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Journal des Mouvements de Stock') }}</h2>

                {{-- Filtres --}}
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-1/3">
                        <input type="text" wire:model.live.debounce.300ms="search" 
                               class="w-full rounded-md border-gray-300" 
                               placeholder="{{ __('Rechercher un article...') }}">
                    </div>
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <input type="date" wire:model.live="date_debut" class="rounded-md border-gray-300 text-sm">
                        <span class="text-gray-500">-</span>
                        <input type="date" wire:model.live="date_fin" class="rounded-md border-gray-300 text-sm">
                    </div>
                </div>

                {{-- Tableau --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Date') }}</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Type') }}</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Article') }}</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Quantité') }}</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Référence') }}</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Utilisateur') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mouvements as $mvt)
                                @php
                                    $isEntree = ($mvt->direction === 'entree');
                                    $color = $isEntree ? 'green' : 'red';
                                    $signe = $isEntree ? '+' : '-';
                                    
                                    // Traduction du motif
                                    $typeLabel = match($mvt->type_mouvement) {
                                        'vente' => 'Vente',
                                        'perte' => 'Perte / Casse',
                                        'detail' => 'Opération de détail',
                                        'achat' => 'Achat / Entrée',
                                        'achat initial' => 'Stock Initial',
                                        default => ucfirst($mvt->type_mouvement)
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($mvt->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ __($typeLabel) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm font-bold text-gray-800">{{ $mvt->article_nom }}</td>
                                    <td class="px-4 py-2 text-sm font-bold text-{{ $color }}-600">
                                        {{ $signe }} {!! format_number($mvt->quantite) !!}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $mvt->reference }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $mvt->utilisateur ?? 'Système' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $mouvements->links() }}
                </div>
            </div>
        </div>
    </div>
</div>