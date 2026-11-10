<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Filtres de dates --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de début') }}</label>
                <input type="date" class="block w-full rounded-md border-gray-300" wire:model.live="date1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de fin') }}</label>
                <input type="date" class="block w-full rounded-md border-gray-300" wire:model.live="date2">
            </div>
        </div>

        {{-- Situation financière --}}
        <div class="bg-white rounded-lg">
            <h4 class="mt-4 text-2xl font-medium text-gray-900 p-6 border-b">
                {{ __('Situation financière') }}
            </h4>
            
            <div class="p-4 space-y-2">
                {{-- Total Ventes --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition border-b pb-2">
                    <span class="font-bold text-lg">{{ __('Total Ventes') }} :</span>
                    <span class="mx-2 text-green-600 font-bold text-lg number-cell">{!! format_number($ventes_sum) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()?->monn_code ?? '') }}</span>
                </div>

                {{-- Total Charges (NOUVEAU : ajouté en haut pour visibilité) --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition border-b pb-2 mt-2">
                    <span class="font-bold text-lg">{{ __('Total Charges') }} :</span>
                    <span class="mx-2 text-red-600 font-bold text-lg number-cell">{!! format_number($charges_totales) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()?->monn_code ?? '') }}</span>
                </div>

                {{-- Distinction Resto / Classique / Mixte --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-2">
                    <div class="bg-blue-50 p-3 rounded text-center border border-blue-100">
                        <span class="block text-xs text-gray-500 uppercase">{{ __('Ventes Classiques') }}</span>
                        <span class="text-lg font-bold text-blue-600">{!! format_number($ventes_classiques) !!}</span>
                    </div>
                    <div class="bg-orange-50 p-3 rounded text-center border border-orange-100">
                        <span class="block text-xs text-gray-500 uppercase">{{ __('Ventes Restaurant') }}</span>
                        <span class="text-lg font-bold text-orange-600">{!! format_number($ventes_resto) !!}</span>
                    </div>
                    <div class="bg-purple-50 p-3 rounded text-center border border-purple-100">
                        <span class="block text-xs text-gray-500 uppercase">{{ __('Ventes Mixtes') }}</span>
                        <span class="text-lg font-bold text-purple-600">{!! format_number($ventes_mixtes ?? 0) !!}</span>
                    </div>
                </div>

                <hr class="my-2">

                {{-- Ventes par méthode --}}
                <h5 class="font-bold text-gray-700 mt-4 mb-2">{{ __('Détail par mode de paiement') }}</h5>
                @foreach ($liste_apps as $key => $item)
                    <div class="text-sm font-medium text-gray-900 px-3 py-1 hover:bg-gray-50 rounded transition">
                        <span class="font-semibold">{{ __($item->meth_nom) }} :</span>
                        <span class="mx-2 text-blue-600 number-cell">{!! format_number($liste_pay[$key]) !!}</span>
                        <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()?->monn_code ?? '') }}</span>
                    </div>
                @endforeach

                <hr class="my-4">

                {{-- Créances et Dettes --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Créances payées par les clients') }} :</span>
                    <span class="mx-2 text-green-600 number-cell">{!! format_number($paiement_cli) !!}</span>
                </div>
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Dettes payées pour les fournisseurs') }} :</span>
                    <span class="mx-2 text-red-600 number-cell">{!! format_number($paiement_four) !!}</span>
                </div>

                <hr class="my-2">

                {{-- Pertes, Remises, Coût de revient --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Pertes') }} :</span>
                    <span class="mx-2 text-red-600 number-cell">-{!! format_number($pertes) !!}</span>
                </div>
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Remises') }} :</span>
                    <span class="mx-2 text-orange-600 number-cell">-{!! format_number($remises) !!}</span>
                </div>
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Coût de revient des ventes') }} :</span>
                    <span class="mx-2 text-orange-600 number-cell">-{!! format_number($p_achat_t) !!}</span>
                </div>
                
                {{-- Charges (AJOUTÉ ICI pour le détail du calcul) --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Charges') }} :</span>
                    <span class="mx-2 text-red-600 number-cell">-{!! format_number($charges_totales) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()?->monn_code ?? '') }}</span>
                </div>

                {{-- Profit --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded mt-4 border-t pt-4">
                    <span class="font-bold text-lg">{{ __('Profit Net') }} :</span>
                    <span class="mx-2 text-green-600 font-bold text-lg number-cell">{!! format_number($profit) !!}</span>
                    <span class="font-bold text-lg">{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()?->monn_code ?? '') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>