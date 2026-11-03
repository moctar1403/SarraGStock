<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6">{{ __('Ouverture de Caisse') }}</h2>
    
    @if (session()->has('danger'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('danger') }}</div>
    @endif

    <form wire:submit.prevent="ouvrir">
        <div class="mb-4">
            <label for="montant_initial" class="block text-gray-700 text-sm font-bold mb-2">
                {{ __('Fond de caisse initial (Espèces)') }}
            </label>
            <input type="number" step="0.01" id="montant_initial" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('montant_initial') border-red-500 @enderror" 
                   wire:model="montant_initial">
            @error('montant_initial') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                {{ __('Ouvrir la caisse') }}
            </button>
        </div>
    </form>
</div>