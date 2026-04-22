<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec titre, recherche et bouton d'ajout --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Liste des ventes') }}
            </h2>
            
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
            
            {{-- Bouton d'ajout --}}
            @can('create vente')
                @include('partials.bouton_ajouter', [
                    'url' => route('ventes.create_g'),
                    'texte' => __('Nouvelle vente'),
                ])
            @endcan
        </div>

        {{-- Tableau des factures --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            {{-- En-tête du tableau --}}
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Date') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('N° Facture') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Client/Tél') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Total') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Remise') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Total Après Remise') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Mode de Paiement') }}</th>
                                    <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            {{-- Corps du tableau --}}
                            <tbody>
                                @forelse ($factures as $item)
                                    @php
                                        $remise = App\Models\Remise::where('facture_id', $item->id)->first();
                                    @endphp
                                    
                                    <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->updated_at->format('d/m/Y') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->fa_num }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @if ($item->cli_tel == 0)
                                                {{ $item->cli_nom }} 
                                            @else
                                                {{ $item->cli_nom }} {{ $item->cli_tel }}  
                                            @endif
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($remise->re_montant_facture ?? $item->fa_tot) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($remise->re_montant_remise ?? 0) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <span class="number-cell">{!! format_number($remise->re_prix_tot_apres_remise ?? $item->fa_tot) !!}</span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ __($item->meth_nom) }}</td>
                                        
                                        {{-- Actions --}}
                                        <td class="text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                @include('partials.bouton_details', ['itemId' => $item->id])
                                                
                                                <a href="#" onclick="openPrint({{ $item->id }})">
                                                    @include('partials.bouton_imprimer', ['itemId' => $item->id])
                                                </a>
                                                
                                                @include('partials.bouton_pdf2', [
                                                    'itemId' => $item->id,
                                                    'couleur' => 'gray'
                                                ])
                                                
                                                @can('delete facture')
                                                    @include('partials.boutton_supprimer')
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="flex flex-col items-center justify-center">
                                                <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                                <div class="text-gray-500">{{ __('Aucun élément trouvé!') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $factures->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>

{{-- Script pour l'impression --}}
<script>
    function openPrint(id) {
        window.open("/factures/" + id + "/print", "_blank", "width=900,height=700");
    }
</script>

{{-- Styles pour l'affichage des nombres en RTL --}}
@push('styles')
<style>
    .number-cell {
        direction: ltr;
        unicode-bidi: embed;
        display: inline-block;
    }
    [dir="rtl"] .number-cell {
        text-align: left;
    }
</style>
@endpush