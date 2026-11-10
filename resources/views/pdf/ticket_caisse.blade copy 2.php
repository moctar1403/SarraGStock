<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Caisse {{ $caisse_id }}</title>
    <style>
        @page { margin: 0cm; padding: 0cm; }
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 11px; 
            color: #000000; 
            margin: 0; 
            padding: 0; 
            line-height: 1.2;
            font-weight: bold;
            page-break-inside: avoid;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; padding-right: 2px; }
        .text-left { text-align: left; }
        .bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 6px; }
        
        hr { border: 0; border-top: 1px solid #000; margin: 3px 0; }
        
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        td { padding: 1px 0; vertical-align: top; }
        
        h2 { font-size: 14px; margin: 0; }
        p { font-size: 9px; margin: 0; }
    </style>
</head>
<body>
    <!-- L'ASTUCE : backtop="-15mm" pour remonter le texte et annuler la marge du pilote -->
    <page backtop="-15mm" backbottom="0mm" backleft="0mm" backright="0mm">
        
        <div class="text-center mb-2" style="margin-top: 2px;">
            <h2 class="bold">{{ $soc_nom }}</h2>
            <p>{{ $soc_adresse }}</p>
            <p>Tél: {{ $soc_tel }}</p>
        </div>

        <hr>

        <div class="text-center bold mb-2" style="font-size: 12px;">
            RAPPORT DE CAISSE N°{{ $caisse_id }}
        </div>

        <table class="mb-2">
            <tr><td class="text-left">Caissier :</td><td class="text-right bold">{{ $caissier }}</td></tr>
            <tr><td class="text-left">Ouverture :</td><td class="text-right">{{ $date_ouverture }}</td></tr>
            <tr><td class="text-left">Clôture :</td><td class="text-right">{{ $date_cloture }}</td></tr>
        </table>

        <hr>

        <table class="mb-2">
            <tr><td class="text-left">Fond initial :</td><td class="text-right">{{ number_format($montant_initial, 0, ',', ' ') }}</td></tr>
            <tr><td class="text-left">Nb Factures :</td><td class="text-right">{{ $nb_factures }}</td></tr>
            <tr><td class="text-left bold">Total Ventes :</td><td class="text-right bold">{{ number_format($total_ventes, 0, ',', ' ') }}</td></tr>
        </table>

        <hr>

        <!-- DÉTAIL PAR MODE DE PAIEMENT -->
        <div class="text-center bold mb-1" style="font-size: 11px;">
            DÉTAIL PAR PAIEMENT
        </div>
        <table class="mb-2">
            @forelse($details_paiements as $detail)
                <tr>
                    <td class="text-left">{{ $detail['nom'] }} :</td>
                    <td class="text-right">{{ number_format($detail['montant'], 0, ',', ' ') }} {{ $monnaie }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Aucun paiement</td>
                </tr>
            @endforelse
        </table>

        <hr>

        <table class="mb-2">
            <tr><td class="text-left">Théorique :</td><td class="text-right">{{ number_format($montant_theorique, 0, ',', ' ') }} {{ $monnaie }}</td></tr>
            <tr>
                <td class="text-left bold">Écart :</td>
                <td class="text-right bold">{{ $ecart !== null ? number_format($ecart, 0, ',', ' ') : '-' }} {{ $monnaie }}</td>
            </tr>
        </table>

        <hr>

        <div class="text-center mt-2" style="font-size: 9px; margin-top: 6px; margin-bottom: 5px;">
            Généré le {{ now()->format('d/m/Y H:i') }}<br>
            Merci !
        </div>

    </page>
</body>
</html>