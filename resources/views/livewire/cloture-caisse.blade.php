<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6">{{ __('Clôture de Caisse (Rapport Z)') }}</h2>
    
    <div class="bg-gray-100 p-4 rounded mb-6">
        <p class="text-lg"><strong>{{ __('Fond de caisse initial') }} :</strong> {!! format_number($caisse->montant_initial) !!}</p>
        <p class="text-lg"><strong>{{ __('Total des ventes de la journée') }} :</strong> {!! format_number($total_ventes) !!}</p>
        <hr class="my-2">
        <p class="text-xl font-bold text-blue-600"><strong>{{ __('Total théorique attendu') }} :</strong> {!! format_number($montant_theorique) !!}</p>
    </div>

    <form wire:submit.prevent="cloturer">
        <div class="mb-4">
            <label for="montant_final_reel" class="block text-gray-700 text-sm font-bold mb-2">
                {{ __('Montant réel compté dans le tiroir-caisse') }}
            </label>
            <input type="number" step="0.01" id="montant_final_reel" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-lg @error('montant_final_reel') border-red-500 @enderror" 
                   wire:model.live="montant_final_reel">
            @error('montant_final_reel') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6 p-4 rounded {{ $ecart < 0 ? 'bg-red-100 text-red-700' : ($ecart > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
            <p class="font-bold text-lg">{{ __('Écart de caisse') }} : {!! format_number($ecart) !!}</p>
            @if($ecart < 0)
                <p class="text-sm">{{ __('Attention : Il manque de l\'argent dans la caisse.') }}</p>
            @elseif($ecart > 0)
                <p class="text-sm">{{ __('Attention : Il y a un excédent d\'argent dans la caisse.') }}</p>
            @else
                <p class="text-sm">{{ __('Parfait, la caisse est équilibrée !') }}</p>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded w-full text-lg">
                {{ __('Clôturer la caisse') }}
            </button>
        </div>
    </form>
</div>