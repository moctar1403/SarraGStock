<div>
    @if(session()->has('ticket_id'))
        {{-- Lien caché qui sera cliqué automatiquement --}}
        <a id="auto-print-ticket" href="{{ route('factures.ticket', session('ticket_id')) }}" target="_blank" class="hidden"></a>
        
        <script>
            // On attend que la page soit chargée, puis on clique sur le lien
            document.addEventListener('DOMContentLoaded', function() {
                const ticketLink = document.getElementById('auto-print-ticket');
                if (ticketLink) {
                    ticketLink.click();
                }
            });
        </script>
    @endif

    {{-- Si le caissier a une caisse ouverte, on affiche l'action en cours --}}
    @if($maCaisseOuverte)
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md shadow-sm flex justify-between items-center">
            <div>
                <p class="font-bold text-lg">{{ __('Vous avez une caisse ouverte !') }}</p>
                <p>{{ __('Ouverte le') }} : {{ \Carbon\Carbon::parse($maCaisseOuverte->date_ouverture)->format('d/m/Y à H:i') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('pos.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold shadow">
                    {{ __('Continuer les ventes (POS)') }}
                </a>
                <a href="{{ route('caisse.cloturer') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold shadow">
                    {{ __('Fermer la caisse') }}
                </a>
                <a href="{{ route('caisse.ventes_resto') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow font-bold">
                    {{ __('Ventes du Restaurant') }}
                </a>
            </div>
        </div>
    @else
        <div class="bg-gray-50 border-l-4 border-gray-500 text-gray-700 p-4 mb-6 rounded-md shadow-sm flex justify-between items-center">
            <div>
                <p class="font-bold text-lg">{{ __('Aucune caisse ouverte.') }}</p>
                <p>{{ __('Vous devez ouvrir une caisse pour commencer à vendre.') }}</p>
            </div>
            <a href="{{ route('caisse.ouvrir') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold shadow-lg text-lg">
                {{ __('Ouvrir une caisse') }}
            </a>
        </div>
    @endif

    <div class="mt-5">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
            
            {{-- En-tête --}}
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Historique des Caisses') }}
                </h2>
                
                <div class="w-1/3">
                    <input type="text" 
                           class="block mt-1 rounded-md border-gray-300 w-full" 
                           placeholder="{{ __('Rechercher par caissier ou statut...') }}"
                           wire:model.live="search">
                </div>
            </div>

            {{-- Tableau --}}
            <div class="flex flex-col">
                <div class="overflow-x-auto">
                    <div class="py-4 inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-center">
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('ID') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Caissier') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Ouverture') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Clôture') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Fond Initial') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Total Théorique') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Écart') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Statut') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($caisses as $caisse)
                                        <tr class="border-b-2 border-gray-100 hover:bg-gray-50">
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $caisse->id }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $caisse->user->name ?? 'N/A' }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ \Carbon\Carbon::parse($caisse->date_ouverture)->format('d/m/Y H:i') }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                {{ $caisse->date_cloture ? \Carbon\Carbon::parse($caisse->date_cloture)->format('d/m/Y H:i') : '-' }}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{!! format_number($caisse->montant_initial) !!}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{!! format_number($caisse->montant_theorique ?? 0) !!}</td>
                                            <td class="text-sm font-medium px-2 py-2">
                                                @if($caisse->ecart !== null)
                                                    <span class="font-bold {{ $caisse->ecart < 0 ? 'text-red-500' : ($caisse->ecart > 0 ? 'text-yellow-500' : 'text-green-500') }}">
                                                        {!! format_number($caisse->ecart) !!}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                @if($caisse->statut == 'ouvert')
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">{{ __('Ouverte') }}</span>
                                                @else
                                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">{{ __('Fermée') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-sm font-medium text-center whitespace-nowrap">
                                                <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                    {{-- NOUVEAU : Bouton Ticket (Rapport de caisse) --}}
                                                    <a href="{{ route('caisses.ticket', $caisse->id) }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs inline-flex items-center" title="{{ __('Imprimer le rapport de caisse') }}">
                                                        Ticket
                                                    </a>

                                                    {{-- Bouton Voir les ventes (existant) --}}
                                                    <a href="{{ route('caisse.details', $caisse->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                                        {{ __('Voir les ventes') }}
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-gray-500">
                                                {{ __('Aucune caisse trouvée.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                {{ $caisses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>