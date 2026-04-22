<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec logo et informations de facture --}}
        <div class="flex justify-between items-center mb-4 border-b pb-4">
            {{-- Logo de la société --}}
            <div>
                @if ($logoExists && $societe && $societe->soc_logo)
                    <img src="{{ asset($societe->soc_logo) }}" class="max-w-[100px] max-h-[100px]" alt="Logo">
                @endif
            </div>
            
            {{-- Informations de la facture --}}
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800">{{ __('FACTURE') }}</h2>
                <p class="text-sm text-gray-600">{{ __('N°') }}: {{ $facture->fa_num }}</p>
                <p class="text-sm text-gray-600">{{ __('Date') }}: {{ $facture->updated_at->format('d/m/Y') }}</p>
                {{-- <p class="text-sm text-gray-600">{{ __('Impression') }}: {{ Carbon\Carbon::now()->format('d/m/Y') }}</p> --}}
            </div>
        </div>

        {{-- Informations société et client --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Société --}}
            <div class="border rounded-lg p-3 bg-gray-50">
                <h3 class="font-semibold text-gray-700 mb-2">{{ __('Vendeur') }}</h3>
                @if ($societe)
                    <p class="text-sm text-gray-600">{{ $societe->soc_nom }}</p>
                    <p class="text-sm text-gray-600">{{ $societe->soc_adresse }} {{ $societe->soc_code_postal }}</p>
                    @if ($societe->soc_tel)
                        <p class="text-sm text-gray-600">{{ __('Tél') }}: {{ $societe->soc_tel }}</p>
                    @endif
                    @if ($societe->soc_email)
                        <p class="text-sm text-gray-600">{{ __('Email') }}: {{ $societe->soc_email }}</p>
                    @endif
                    <p class="text-sm text-gray-600">
                        @if ($societe->soc_nif) {{ __('NIF') }}: {{ $societe->soc_nif }} @endif
                        @if ($societe->soc_rc) {{ __('RC') }}: {{ $societe->soc_rc }} @endif
                    </p>
                @endif
            </div>

            {{-- Client --}}
            <div class="border rounded-lg p-3 bg-gray-50">
                <h3 class="font-semibold text-gray-700 mb-2">{{ __('Client') }}</h3>
                @if ($client)
                    <p class="text-sm text-gray-600">{{ $client->cli_civilite }} {{ $client->cli_nom }}</p>
                    @if ($client->cli_societe)
                        <p class="text-sm text-gray-600">{{ $client->cli_societe }}</p>
                    @endif
                    <p class="text-sm text-gray-600">{{ __('Tél') }}: {{ $client->cli_tel }}</p>
                    <p class="text-sm text-gray-600">{{ __('Email') }}: {{ $client->cli_email }}</p>
                @else
                    <p class="text-sm text-gray-500">{{ __('Client anonyme') }}</p>
                @endif
            </div>
        </div>

        {{-- Mode de paiement --}}
        <div class="mb-4 p-2 bg-gray-100 rounded-lg inline-block">
            <span class="font-semibold text-gray-700">{{ __('Mode de paiement') }}:</span>
            <span class="ml-2 text-gray-600">{{ __($paiement->meth_nom) ?? '' }}</span>
        </div>

        {{-- Tableau des articles --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-2 inline-block min-w-full">
                    <div class="overflow-hidden border rounded-lg">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="text-sm font-semibold text-gray-700 px-3 py-2">{{ __('Article') }}</th>
                                    <th class="text-sm font-semibold text-gray-700 px-3 py-2">{{ __('Quantité') }}</th>
                                    <th class="text-sm font-semibold text-gray-700 px-3 py-2">{{ __('Unité') }}</th>
                                    <th class="text-sm font-semibold text-gray-700 px-3 py-2">{{ __('Prix Unitaire') }}</th>
                                    <th class="text-sm font-semibold text-gray-700 px-3 py-2">{{ __('Prix Total') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @foreach ($ventes as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="text-sm text-gray-800 px-3 py-2">{{ $item->article->ar_lib ?? '' }}</td>
                                        {{-- <td class="text-sm text-gray-800 px-3 py-2">{{ $item->ve_quantite }}</td> --}}
                                        <td class="text-sm text-gray-800 px-3 py-2">{!! format_number($item->ve_quantite) !!}</td>
                                        <td class="text-sm text-gray-800 px-3 py-2">
                                            {{ __(App\Models\Unite::find($item->article->ar_unite ?? 0)->unit_lib) ?? '' }}
                                        </td>
                                        <td class="text-sm text-gray-800 px-3 py-2">{!! format_number($item->ve_prix_vente) !!}</td>
                                        <td class="text-sm text-gray-800 px-3 py-2">{!! format_number($item->ve_prix_tot) !!}</td>
                                    </tr>
                                @endforeach

                                {{-- Lignes de totaux --}}
                                <tr class="border-t-2 border-gray-300 bg-gray-50 font-bold">
                                    <td colspan="3" class="px-3 py-2"></td>
                                    <td class="text-sm font-bold text-left text-gray-800 px-3 py-2">{{ __('Total') }}</td>
                                    <td class="text-sm font-bold text-gray-800 px-3 py-2">{!! format_number($facture->fa_tot) !!} {{ $monnaie->monn_sym ?? '' }}</td>
                                </tr>

                                @if ($remise)
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-3 py-1"></td>
                                        <td class="text-sm text-left text-gray-600 px-3 py-1">{{ __('Taux de Remise') }} (%)</td>
                                        <td class="text-sm text-gray-600 px-3 py-1">{{ $remise->re_taux_remise }}</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-3 py-1"></td>
                                        <td class="text-sm text-left text-gray-600 px-3 py-1">{{ __('Montant Remise') }}</td>
                                        <td class="text-sm text-gray-600 px-3 py-1">- {!! format_number($remise->re_montant_remise) !!} {{ $monnaie->monn_sym ?? '' }}</td>
                                    </tr>
                                    <tr class="border-t bg-gray-100 font-bold">
                                        <td colspan="3" class="px-3 py-2"></td>
                                        <td class="text-sm font-bold text-left text-gray-800 px-3 py-2">{{ __('Total après Remise') }}</td>
                                        <td class="text-sm font-bold text-gray-800 px-3 py-2">{!! format_number($remise->re_prix_tot_apres_remise) !!} {{ $monnaie->monn_sym ?? '' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pied de page --}}
        <div class="mt-6 text-center text-xs text-gray-500">
            {{ __('Document généré le') }} {{ Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>
</div>