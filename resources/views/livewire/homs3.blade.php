<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Filtres de recherche --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            {{-- Recherche méthode --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Rechercher') }}</label>
                <input type="text" 
                       class="block w-full rounded-md border-gray-300" 
                       placeholder="{{ __('Méthode') }}"
                       wire:model.live="search_methode">
            </div>
            
            {{-- Date de début --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de début') }}</label>
                <input type="date" 
                       class="block w-full rounded-md border-gray-300"
                       wire:model.live="date1">
            </div>
            
            {{-- Date de fin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de fin') }}</label>
                <input type="date" 
                       class="block w-full rounded-md border-gray-300"
                       wire:model.live="date2">
            </div>
        </div>

        {{-- Situation financière --}}
        <div class="bg-white rounded-lg">
            <h4 class="mt-4 text-2xl font-medium text-gray-900 p-6 border-b">
                {{ __('Situation financière') }}
            </h4>
            
            <div class="p-4 space-y-2">
                {{-- Total Ventes --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Total Ventes') }} :</span>
                    <span class="mx-2 text-green-600 number-cell">{!! format_number($ventes_sum) !!}</span>
                    {{-- <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span> --}}
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Ventes par méthode --}}
                @foreach ($liste_apps as $key => $item)
                    <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                        <span class="font-semibold">{{ __($item->meth_nom) }} :</span>
                        <span class="mx-2 text-blue-600 number-cell">{!! format_number($liste_pay[$key]) !!}</span>
                        <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                    </div>
                @endforeach

                {{-- Ventes par applications --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Ventes par Applications de paiement') }} :</span>
                    <span class="mx-2 text-blue-600 number-cell">{!! format_number($appl) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Créances payées --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Créances payées par les clients') }} :</span>
                    <span class="mx-2 text-green-600 number-cell">{!! format_number($paiement_cli) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Dettes payées --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Dettes payées pour les fournisseurs') }} :</span>
                    <span class="mx-2 text-red-600 number-cell">{!! format_number($paiement_four) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Pertes --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Pertes') }} :</span>
                    <span class="mx-2 text-red-600 number-cell">-{!! format_number($pertes) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Remises --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Remises') }} :</span>
                    <span class="mx-2 text-orange-600 number-cell">-{!! format_number($remises) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Coût de revient des ventes --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Coût de revient des ventes') }} :</span>
                    <span class="mx-2 text-orange-600 number-cell">-{!! format_number($p_achat_t) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Total Coût de revient --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded transition">
                    <span class="font-semibold">{{ __('Total Coût de revient') }} :</span>
                    <span class="mx-2 text-orange-600 number-cell">-{!! format_number($p_achat_t + $pertes) !!}</span>
                    <span>{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>

                {{-- Profit --}}
                <div class="text-sm font-medium text-gray-900 px-3 py-2 hover:bg-gray-50 rounded mt-4 border-t pt-4">
                    <span class="font-bold text-lg">{{ __('Profit') }} :</span>
                    <span class="mx-2 text-green-600 font-bold text-lg number-cell">{!! format_number($profit) !!}</span>
                    <span class="font-bold text-lg">{{ __(App\Models\Monnaie::where('monn_active','=','1')->first()->monn_code) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>