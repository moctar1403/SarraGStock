<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      @if (app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Facture') }} N° {{ $facture->fa_num }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/mycss.css') }}">
    
    <style>
        body { 
            font-family: 'Figtree', sans-serif; 
            padding: 20px; 
            background: white;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
        .facture-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
        }
        /* Style pour les nombres en RTL */
        [dir="rtl"] .text-right {
            text-align: left;
        }
        [dir="rtl"] .text-left {
            text-align: right;
        }
        .number-cell {
            direction: ltr;
            unicode-bidi: embed;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="facture-container">
        {{-- En-tête avec logo et informations --}}
        <div class="flex justify-between items-start border-b-2 border-gray-300 pb-4 mb-4">
            {{-- Logo --}}
            <div>
                @if ($logoExists && $societe && $societe->soc_logo)
                    <img src="{{ asset($societe->soc_logo) }}" 
                         style="max-width: 100px; max-height: 100px;" 
                         alt="Logo">
                @endif
            </div>
            
            {{-- Titre et numéro --}}
            <div class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                <h1 class="text-2xl font-bold text-gray-800">{{ __('FACTURE') }}</h1>
                <p class="text-sm text-gray-600">{{ __('N°') }}: {{ $facture->fa_num }}</p>
            </div>
        </div>

        {{-- Informations société et client --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
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

        {{-- Dates --}}
        <div class="flex justify-between text-sm text-gray-600 mb-4 px-2">
            <p>{{ __('Date de facture') }}: <span class="font-semibold">{{ $facture->updated_at->format('d/m/Y') }}</span></p>
            {{-- <p>{{ __("Date d'impression") }}: <span class="font-semibold">{{ Carbon\Carbon::now()->format('d/m/Y H:i') }}</span></p> --}}
        </div>

        {{-- Mode de paiement --}}
        <div class="mb-4 p-2 bg-gray-100 rounded-lg inline-block">
            <span class="font-semibold text-gray-700">{{ __('Mode de paiement') }}:</span>
            <span class="ml-2 rtl:mr-2 rtl:ml-0 text-gray-600">{{ __($paiement->meth_nom) ?? '' }}</span>
        </div>

        {{-- Tableau des articles --}}
        <div class="overflow-x-auto mb-4">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 border-b-2 border-gray-300">
                        <th class="text-sm font-bold text-gray-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">{{ __('Article') }}</th>
                        <th class="text-sm font-bold text-gray-700 px-4 py-2 text-center">{{ __('Quantité') }}</th>
                        <th class="text-sm font-bold text-gray-700 px-4 py-2 text-center">{{ __('Unité') }}</th>
                        <th class="text-sm font-bold text-gray-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Prix Unitaire') }}</th>
                        <th class="text-sm font-bold text-gray-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Prix Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventes as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="text-sm text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">{{ $item->article->ar_lib ?? '' }}</td>
                            {{-- <td class="text-sm text-gray-800 px-4 py-2 text-center">{{ $item->ve_quantite }}</td> --}}
                            <td class="text-sm text-gray-800 px-4 py-2 text-center">{!! format_number($item->ve_quantite) !!}</td>
                            <td class="text-sm text-gray-800 px-4 py-2 text-center">
                                {{ __(App\Models\Unite::find($item->article->ar_unite ?? 0)->unit_lib) ?? '' }}
                            </td>
                            <td class="text-sm text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($item->ve_prix_vente) !!}</span>
                            </td>
                            <td class="text-sm text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($item->ve_prix_tot) !!}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{-- Total --}}
                    <tr class="border-t-2 border-gray-300 bg-gray-100">
                        <td colspan="3" class="px-4 py-2"></td>
                        <td class="text-sm font-bold text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Total') }}</td>
                        <td class="text-sm font-bold text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                            <span class="number-cell">{!! format_number($facture->fa_tot) !!}</span> {{ $monnaie->monn_sym ?? '' }}
                        </td>
                    </tr>

                    {{-- Remise si présente --}}
                    @if ($remise)
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-4 py-1"></td>
                            <td class="text-sm text-gray-600 px-4 py-1 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Taux de Remise') }} (%)</td>
                            <td class="text-sm text-gray-600 px-4 py-1 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                {{-- <span class="number-cell">{!! format_number($remise->re_taux_remise) !!}</span> --}}
                                <span class="number-cell">{{$remise->re_taux_remise}}</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-4 py-1"></td>
                            <td class="text-sm text-gray-600 px-4 py-1 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Montant Remise') }}</td>
                            <td class="text-sm text-gray-600 px-4 py-1 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">- {!! format_number($remise->re_montant_remise) !!}</span> {{ $monnaie->monn_sym ?? '' }}
                            </td>
                        </tr>
                        <tr class="border-t border-gray-300 bg-gray-100 font-bold">
                            <td colspan="3" class="px-4 py-2"></td>
                            <td class="text-sm font-bold text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Total après Remise') }}</td>
                            <td class="text-sm font-bold text-gray-800 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($remise->re_prix_tot_apres_remise) !!}</span> {{ $monnaie->monn_sym ?? '' }}
                            </td>
                        </tr>
                    @endif
                </tfoot>
            </table>
        </div>

        {{-- Pied de page --}}
        <div class="text-center text-xs text-gray-500 mt-8 pt-4 border-t border-gray-200">
            {{ __('Document généré le') }} {{ Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>
    </div>

    {{-- Script d'impression automatique --}}
    <script class="no-print">
        setTimeout(function() {
            window.print();
        }, 500);
    </script>
</body>
</html>