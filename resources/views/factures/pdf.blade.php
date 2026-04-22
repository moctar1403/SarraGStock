<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      @if (app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif>
<head>
    <meta charset="utf-8" />
    <title>{{ __('Facture') }} {{ $fa_num }}</title>
    <style>
        body {
            font-family: 'XBRiaz', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #333;
        }
        
        .invoice-box {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            font-size: 14px;
            line-height: 1.5;
            font-family: 'XBRiaz', sans-serif;
            color: #333;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 8px 5px;
            vertical-align: top;
        }

        /* En-tête */
        .invoice-box .top-table td {
            border: none;
        }
        
        .invoice-box .title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        
        .invoice-box .logo-img {
            max-width: 70px;
            max-height: 70px;
        }

        /* Informations société/client */
        .invoice-box .information-table td {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        /* En-têtes de colonnes */
        .invoice-box .heading-row {
            background: #f0f0f0;
            font-weight: bold;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
        }
        
        .invoice-box .heading-row td {
            padding: 10px 5px;
            font-weight: bold;
            background: #f0f0f0;
        }

        /* Lignes d'articles */
        .invoice-box .item-row {
            border-bottom: 1px solid #eee;
        }
        
        .invoice-box .item-row:hover {
            background: #f9f9f9;
        }
        
        .invoice-box .item-row td {
            padding: 8px 5px;
        }

        /* Lignes de totaux */
        .invoice-box .total-row td {
            font-weight: bold;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
        
        .invoice-box .subtotal-row td {
            font-weight: normal;
        }
        
        .invoice-box .grand-total-row td {
            font-weight: bold;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            background: #f9f9f9;
        }

        /* Alignements */
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .number-cell {
            text-align: right;
            font-family: monospace;
            direction: ltr;
            unicode-bidi: embed;
        }
        
        /* Espacements */
        .pt-2 { padding-top: 10px; }
        .pb-2 { padding-bottom: 10px; }
        .mt-2 { margin-top: 10px; }
        .mb-2 { margin-bottom: 10px; }

        /* Style RTL - Amélioré */
        .rtl .text-right { text-align: left; }
        .rtl .text-left { text-align: right; }
        .rtl .number-cell { 
            text-align: left;
            direction: ltr;
        }
        
        /* Ajustements spécifiques pour l'arabe */
        .rtl .heading-row td:first-child {
            text-align: right;
        }
        
        .rtl .heading-row td:last-child {
            text-align: left;
        }
        
        .rtl .total-row td:first-child,
        .rtl .subtotal-row td:first-child,
        .rtl .grand-total-row td:first-child {
            text-align: right;
        }
        
        .rtl .total-row td:last-child,
        .rtl .subtotal-row td:last-child,
        .rtl .grand-total-row td:last-child {
            text-align: left;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box {
                padding: 10px;
                margin: 10px;
            }
            
            .invoice-box table td {
                padding: 5px 3px;
                font-size: 12px;
            }
        }

        @page {
            margin: 20px;
        }
    </style>
</head>

<body class="{{ app()->getLocale() == 'ar' ? 'rtl' : '' }}">
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            {{-- En-tête avec logo et références --}}
            <tr class="top-row">
                <td colspan="5" class="pt-2 pb-2">
                    <table width="100%" class="top-table">
                        <tr>
                            <td class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'title' }}" width="50%">
                                @if (!empty($logoExists) && !empty($soc_logo))
                                    <img src="{{ $soc_logo }}" class="logo-img" alt="Logo">
                                @endif
                            </td>
                            <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}" width="50%">
                                <strong>{{ __('FACTURE') }}</strong><br>
                                {{ __('N°') }}: {{ $fa_num }}<br>
                                {{ __('Date') }}: {{ $created_at }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- Informations société et client --}}
            <tr class="information-row">
                <td colspan="5" class="pt-2 pb-2">
                    <table width="100%" class="information-table">
                        <tr>
                            <td width="50%" class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}" style="vertical-align: top;">
                                <strong>{{ __('Vendeur') }}</strong><br>
                                @if (!empty($soc_nom))
                                    {{ $soc_nom }}<br>
                                @endif
                                @if (!empty($soc_adresse))
                                    {{ $soc_adresse }} {{ $soc_code_postal }}<br>
                                @endif
                                @if (!empty($soc_tel))
                                    {{ __('Tél') }}: {{ $soc_tel }}<br>
                                @endif
                                @if (!empty($soc_email))
                                    {{ __('Email') }}: {{ $soc_email }}<br>
                                @endif
                                @if (!empty($soc_nif))
                                    {{ __('NIF') }}: {{ $soc_nif }}
                                @endif
                                @if (!empty($soc_rc))
                                    {{ __('RC') }}: {{ $soc_rc }}
                                @endif
                            </td>
                            <td width="50%" class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}" style="vertical-align: top;">
                                <strong>{{ __('Client') }}</strong><br>
                                @if (!empty($cli_nom))
                                    {{ $cli_civilite ?? '' }} {{ $cli_nom }}<br>
                                @else    
                                    {{ __('Client anonyme') }}
                                @endif
                                @if (!empty($cli_societe))
                                    {{ $cli_societe }}<br>
                                @endif
                                @if (!empty($cli_adresse))
                                    {{ $cli_adresse }}<br>
                                @endif
                                @if (!empty($cli_tel))
                                    {{ __('Tél') }}: {{ $cli_tel }}<br>
                                @endif
                                @if (!empty($cli_email))
                                    {{ __('Email') }}: {{ $cli_email }}<br>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- Mode de paiement --}}
            <tr class="payment-row">
                <td colspan="5" class="pt-2 pb-2">
                    <table width="100%">
                        <tr>
                            <td width="20%" class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                <strong>{{ __('Paiement') }}:</strong>
                            </td>
                            <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __($fa_type_p) }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- En-tête du tableau des articles --}}
            <tr class="heading-row">
                <td class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}" width="35%"><strong>{{ __('Article') }}</strong></td>
                <td class="text-center" width="15%"><strong>{{ __('Quantité') }}</strong></td>
                <td class="text-center" width="15%"><strong>{{ __('Unité') }}</strong></td>
                <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}" width="17%"><strong>{{ __('Prix unitaire') }}</strong></td>
                <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}" width="18%"><strong>{{ __('Total') }}</strong></td>
            </tr>

            {{-- Articles --}}
            @foreach ($items as $item)
            <tr class="item-row">
                <td class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">{{ $item['ar_lib'] ?? App\Models\Article::find($item['article_id'])->ar_lib ?? '' }}</td>
                <td class="text-center">{!! format_number($item['ve_quantite']) !!}</td>
                {{-- <td class="text-center">{{ $item['ve_quantite'] }}</td> --}}
                <td class="text-center">{{ __($item['unite']) }}</td>
                <td class="number-cell">{!! format_number($item['ve_prix_vente']) !!}</td>
                <td class="number-cell">{!! format_number($item['ve_prix_tot']) !!}</td>
            </tr>
            @endforeach

            {{-- Ligne de total --}}
            <tr class="total-row">
                <td colspan="3"></td>
                <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}"><strong>{{ __('Total') }}</strong></td>
                <td class="number-cell"><strong>{!! format_number($fa_tot) !!} {{ App\Models\Monnaie::where('monn_active', 1)->first()->monn_sym ?? '' }}</strong></td>
            </tr>

            {{-- Remise si présente --}}
            @if ($fa_t_remise > 0)
            <tr class="subtotal-row">
                <td colspan="3"></td>
                <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Taux de Remise') }} (%)</td>
                <td class="number-cell">{{$fa_t_remise}}</td>
            </tr>
            <tr class="subtotal-row">
                <td colspan="3"></td>
                <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('Montant Remise') }}</td>
                <td class="number-cell">- {!! format_number($fa_m_remise) !!} {{ App\Models\Monnaie::where('monn_active', 1)->first()->monn_sym ?? '' }}</td>
            </tr>
            <tr class="grand-total-row">
                <td colspan="3"></td>
                <td class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}"><strong>{{ __('Total après Remise') }}</strong></td>
                <td class="number-cell"><strong>{!! format_number($fa_tot_apres_remise) !!} {{ App\Models\Monnaie::where('monn_active', 1)->first()->monn_sym ?? '' }}</strong></td>
            </tr>
            @endif
        </table>

        {{-- Pied de page --}}
        <div class="mt-2 text-center" style="font-size: 11px; color: #999; border-top: 1px solid #ddd; padding-top: 10px;">
            {{ __('Document généré le') }} {{ Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>