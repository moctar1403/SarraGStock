<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        
        <!-- En-tête -->
        <div class="flex justify-between items-start mb-6 border-b pb-4">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Détails de la Caisse') }} #{{ $caisse->id }}
                </h2>
                <p class="text-gray-600 mt-1">
                    {{ __('Caissier') }} : <strong>{{ $caisse->user->name ?? 'N/A' }}</strong>
                </p>
                <p class="text-gray-600">
                    {{ __('Ouverture') }} : {{ \Carbon\Carbon::parse($caisse->date_ouverture)->format('d/m/Y H:i') }}
                </p>
                @if($caisse->date_cloture)
                    <p class="text-gray-600">
                        {{ __('Clôture') }} : {{ \Carbon\Carbon::parse($caisse->date_cloture)->format('d/m/Y H:i') }}
                    </p>
                @endif
                
                <!-- Liste des modes de paiement -->
                <div class="mt-4 bg-gray-50 p-4 rounded-lg border inline-block">
                    <h3 class="font-bold text-sm text-gray-700 mb-2 border-b">{{ __('Répartition par mode de paiement') }}</h3>
                    <ul class="space-y-1">
                        @forelse($totaux_par_methode as $methode)
                            <li class="flex justify-between text-sm space-x-4">
                                <span>{{ __($methode['nom']) }} :</span>
                                <strong class="text-gray-900">{!! format_number($methode['total']) !!}</strong>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">{{ __('Aucune vente encaissée.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="text-right flex flex-col items-end">
                <a href="{{ route('caisse.liste') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-bold mb-4 inline-block">
                    &larr; {{ __('Retour à l\'historique') }}
                </a>
                <div class="mt-2 text-lg bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <p>{{ __('Fond de caisse') }} : <strong>{!! format_number($caisse->montant_initial) !!}</strong></p>
                    <p>{{ __('Total Ventes') }} : <strong class="text-green-600">{!! format_number($total_ventes) !!}</strong></p>
                    <p>{{ __('Total Théorique') }} : <strong class="text-blue-600">{!! format_number($caisse->montant_initial + $total_ventes) !!}</strong></p>
                    
                    @if($caisse->montant_final_reel !== null)
                        <hr class="my-2 border-blue-200">
                        <p>{{ __('Montant Réel') }} : <strong>{!! format_number($caisse->montant_final_reel) !!}</strong></p>
                        <p>{{ __('Écart') }} : 
                            <strong class="{{ $caisse->ecart < 0 ? 'text-red-500' : ($caisse->ecart > 0 ? 'text-yellow-500' : 'text-green-500') }}">
                                {!! format_number($caisse->ecart) !!}
                            </strong>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tableau des ventes -->
        <div class="flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('Détail des ventes') }}</h3>
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden border rounded-lg">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Heure') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('N° Facture') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Article') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Qté') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Prix Unitaire') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Total') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Paiement') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ventes as $vente)
                                    @php
                                        $methodeVente = \App\Models\Methode::find($vente->type_p);
                                    @endphp
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ \Carbon\Carbon::parse($vente->created_at)->format('H:i') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $vente->facture_id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $vente->article->ar_lib ?? 'N/A' }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $vente->ve_quantite }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{!! format_number($vente->ve_prix_vente) !!}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{!! format_number($vente->ve_prix_tot) !!}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($methodeVente->meth_nom ?? '') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-gray-500">
                                            {{ __('Aucune vente enregistrée pour cette caisse.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>