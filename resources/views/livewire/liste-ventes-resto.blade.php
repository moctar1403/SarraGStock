<div>
    <div class="mt-5">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
            
            {{-- En-tête avec titre et filtres --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Ventes du Restaurant') }}
                    </h2>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('pos.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm shadow font-bold transition">
                            {{ __('Continuer les ventes (POS)') }}
                        </a>
                        <a href="{{ route('caisse.liste') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm shadow font-bold transition">
                            {{ __('Historique des Caisses') }}
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto md:justify-end">
                    <input type="text" 
                           class="rounded-md border-gray-300 w-full md:w-64" 
                           placeholder="{{ __('Rechercher (Ticket, Caissier...)') }}"
                           wire:model.live.debounce.300ms="search">
                    
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <input type="date" 
                               class="rounded-md border-gray-300 w-full md:w-auto text-sm" 
                               wire:model.live="date_debut"
                               title="{{ __('Date de début') }}">
                        <span class="text-gray-500">-</span>
                        <input type="date" 
                               class="rounded-md border-gray-300 w-full md:w-auto text-sm" 
                               wire:model.live="date_fin"
                               title="{{ __('Date de fin') }}">
                    </div>
                </div>
            </div>

            {{-- Bandeau Total --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 mb-4 rounded text-blue-800 flex justify-between items-center shadow-sm">
                <span class="font-bold text-lg">{{ __('Total des ventes pour cette période') }} :</span>
                <span class="font-bold text-xl">{!! format_number($total_ventes) !!} {{ $monnaie }}</span>
            </div>

            {{-- Tableau --}}
            <div class="flex flex-col">
                <div class="overflow-x-auto">
                    <div class="py-4 inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-center">
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Date / Heure') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('N° Ticket') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Caissier') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Total') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Mode de Paiement') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($factures as $item)
                                        <tr class="border-b-2 border-gray-100 hover:bg-gray-50">
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                {{ $item->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                #{{ $item->fa_num }}
                                                
                                                {{-- NOUVEAU : Badge Mixte --}}
                                                @if($item->fa_origine === 'mixte')
                                                    <span class="ml-1 px-2 py-0.5 bg-purple-100 text-purple-800 rounded text-xs font-bold" title="{{ __('Cette vente contient des plats et des articles de stock') }}">
                                                        Mixte
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                {{ $item->caissier ?? '-' }}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                {!! format_number($item->fa_tot) !!} {{ $monnaie }}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                {{ __($item->meth_nom) }}
                                            </td>
                                            <td class="text-sm font-medium text-center whitespace-nowrap">
                                                <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                    
                                                    {{-- Bouton Ticket --}}
                                                    <a href="{{ route('factures.ticket', $item->id) }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs inline-flex items-center" title="{{ __('Imprimer le ticket') }}">
                                                        Ticket
                                                    </a>

                                                    {{-- Bouton PDF --}}
                                                    <a href="{{ route('factures.pdf', $item->id) }}" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded text-xs inline-flex items-center" title="{{ __('PDF') }}">
                                                        PDF
                                                    </a>

                                                    {{-- Bouton Détails --}}
                                                    <a href="{{ route('factures.detail', $item->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs inline-flex items-center" title="{{ __('Voir détails') }}">
                                                        {{ __('Détails') }}
                                                    </a>

                                                    {{-- Bouton Supprimer --}}
                                                    @can('delete facture')
                                                        @include('partials.boutton_supprimer')
                                                    @endcan
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-gray-500">
                                                {{ __('Aucune vente de restaurant trouvée.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                {{ $factures->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmation de suppression --}}
    @include('partials.confirm-delete-modal')
</div>