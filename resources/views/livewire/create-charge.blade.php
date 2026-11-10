<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6">{{ __('Enregistrer une nouvelle charge') }}</h2>

    <form wire:submit.prevent="store">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Libellé (ex: Achat viande, Gaz...)') }}</label>
            <input type="text" wire:model="ch_libelle" class="w-full rounded-md border-gray-300">
            @error('ch_libelle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Montant') }}</label>
            <input type="number" step="0.01" wire:model="ch_montant" class="w-full rounded-md border-gray-300">
            @error('ch_montant') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Date') }}</label>
            <input type="date" wire:model="ch_date" class="w-full rounded-md border-gray-300">
            @error('ch_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- ❌ Le champ "Moyen de paiement" a été supprimé --}}

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Observations (Optionnel)') }}</label>
            <textarea wire:model="ch_observations" class="w-full rounded-md border-gray-300" rows="2"></textarea>
            @error('ch_observations') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                {{ __('Annuler') }}
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                {{ __('Enregistrer la charge') }}
            </button>
        </div>
    </form>
</div>