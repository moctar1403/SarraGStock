<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8" />
    <title>{{ __('Ticket') }} {{ $fa_num }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
            vertical-align: top;
        }
        
        .item-name {
            font-size: 12px;
            margin-bottom: 2px;
        }
        .item-details {
            font-size: 10px;
            color: #444;
            margin-bottom: 5px;
        }
        
        .total-section {
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    <div class="text-center bold" style="font-size: 16px; margin-bottom: 5px;">
        {{ $soc_nom ?? 'SarraGStock' }}
    </div>
    <div class="text-center" style="font-size: 10px;">
        {{ $soc_adresse ?? '' }}<br>
        {{ __('Tél') }}: {{ $soc_tel ?? '' }}
    </div>

    <div class="line"></div>

    <!-- Infos Ticket -->
    <table>
        <tr>
            <td class="text-left">{{ __('N°') }}:</td>
            <td class="text-right bold">{{ $fa_num }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ __('Date') }}:</td>
            <td class="text-right">{{ $created_at }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ __('Client') }}:</td>
            <td class="text-right">{{ $cli_nom ?? __('Client anonyme') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Liste des articles -->
    <table>
        @foreach ($items as $item)
            <tr>
                <td colspan="2" class="item-name bold">
                    {{ $item['ar_lib'] ?? App\Models\Article::find($item['article_id'])->ar_lib ?? '' }}
                </td>
            </tr>
            <tr>
                <td class="item-details text-left">
                    {!! format_number($item['ve_quantite']) !!} x {!! format_number($item['ve_prix_vente']) !!}
                </td>
                <td class="item-details text-right">
                    {!! format_number($item['ve_prix_tot']) !!}
                </td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <!-- Totaux -->
    <table class="total-section">
        <tr>
            <td class="text-left bold">{{ __('TOTAL') }}</td>
            <td class="text-right bold" style="font-size: 14px;">
                {!! format_number($fa_tot) !!} {{ App\Models\Monnaie::where('monn_active', 1)->first()->monn_sym ?? '' }}
            </td>
        </tr>

        @if ($fa_t_remise > 0)
            <tr>
                <td class="text-left">{{ __('Remise') }} ({{ $fa_t_remise }}%)</td>
                <td class="text-right">- {!! format_number($fa_m_remise) !!}</td>
            </tr>
            <tr>
                <td class="text-left bold">{{ __('Net à payer') }}</td>
                <td class="text-right bold">
                    {!! format_number($fa_tot_apres_remise) !!} {{ App\Models\Monnaie::where('monn_active', 1)->first()->monn_sym ?? '' }}
                </td>
            </tr>
        @endif
        
        <tr>
            <td class="text-left">{{ __('Paiement') }}:</td>
            <td class="text-right">{{ __($fa_type_p) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Pied de page -->
    <div class="text-center" style="font-size: 10px; margin-top: 10px;">
        {{ __('Merci de votre visite !') }}<br>
        {{ Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>