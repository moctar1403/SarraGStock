<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ticket {{ $fa_num }}</title>
    <style>
        @page { margin: 0cm; padding: 0cm; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 12px; 
            color: #000000; 
            margin: 0;
            padding: 0; 
            line-height: 1.2;
            font-weight: bold; 
            page-break-inside: avoid; /* Empêche la coupure au milieu du ticket */
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; padding-right: 2px; }
        .text-left { text-align: left; }
        .bold { font-weight: bold; }
        
        .line { border-top: 1px solid #000; margin: 4px 0; width: 100%; }
        
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        td { padding: 1px 0; vertical-align: top; word-wrap: break-word; }
        
        .col-article { width: 60%; }
        .col-prix { width: 40%; text-align: right; }

        .total-row { font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    <!-- L'ASTUCE EST ICI : backtop="-15mm" pour remonter le texte et annuler la marge du pilote -->
    <page backtop="-15mm" backbottom="0mm" backleft="0mm" backright="0mm">
        
        <div class="text-center bold" style="font-size: 15px; margin-top: 2px; margin-bottom: 2px;">
            {{ $soc_nom ?? 'SarraGStock' }}
        </div>
        <div class="text-center" style="font-size: 10px;">
            {{ $soc_adresse ?? '' }}<br>
            Tél: {{ $soc_tel ?? '' }}
        </div>

        <div class="line"></div>

        <table>
            <tr>
                <td class="text-left bold">Ticket N° :</td>
                <td class="text-right bold">{{ $fa_num }}</td>
            </tr>
            <tr>
                <td class="text-left">Date :</td>
                <td class="text-right">{{ $created_at }}</td>
            </tr>
            <tr>
                <td class="text-left">Client :</td>
                <td class="text-right">{{ $cli_nom ?? 'Anonyme' }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <table>
            <tr style="font-weight: bold; font-size: 10px;">
                <td class="col-article">Article</td>
                <td class="col-prix">Total</td>
            </tr>
            
            @foreach ($items as $item)
                <tr>
                    <td colspan="2" class="bold" style="padding-top: 4px;">
                        {{ $item['ar_lib'] ?? App\Models\Article::find($item['article_id'])->ar_lib ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="col-article" style="font-size: 11px;">
                        {{ $item['ve_quantite'] }} x {{ format_number($item['ve_prix_vente']) }}
                    </td>
                    <td class="col-prix bold">
                        {{ format_number($item['ve_prix_tot']) }}
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <table>
            <tr class="total-row">
                <td class="text-left">TOTAL</td>
                <td class="text-right">{{ format_number($fa_tot) }} {{ $monnaie }}</td>
            </tr>

            @if ($fa_t_remise > 0)
                <tr>
                    <td class="text-left">Remise ({{ $fa_t_remise }}%)</td>
                    <td class="text-right">- {{ format_number($fa_m_remise) }} {{ $monnaie }}</td>
                </tr>
                <tr class="bold">
                    <td class="text-left">NET A PAYER</td>
                    <td class="text-right">{{ format_number($fa_tot_apres_remise) }} {{ $monnaie }}</td>
                </tr>
            @endif
            
            <tr>
                <td class="text-left" style="font-size: 10px;">Paiement :</td>
                <td class="text-right" style="font-size: 10px;">{{ $fa_type_p }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="text-center" style="font-size: 10px; margin-top: 8px; margin-bottom: 5px;">
            Merci de votre visite !<br>
            {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>

    </page>
</body>
</html>