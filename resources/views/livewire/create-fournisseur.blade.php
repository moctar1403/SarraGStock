<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Nom Fournisseur -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom Fournisseur') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('four_nom') border-red-500 bg-red-100 @enderror"
                   wire:model="four_nom" 
                   name="four_nom">
            @error('four_nom')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Société -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Société') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('four_societe') border-red-500 bg-red-100 @enderror"
                   wire:model="four_societe" 
                   name="four_societe">
            @error('four_societe')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Civilité -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Civilité') }}" />
            <select wire:model.live="four_civilite"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('four_civilite') border-red-500 bg-red-100 @enderror">
                <option value="">{{ __('Séléctionner la civilité') }}</option>
                <option value="Mr">{{ __('Mr') }}</option>
                <option value="Mme">{{ __('Mme') }}</option>
                <option value="Mlle">{{ __('Mlle') }}</option>
            </select>
            @error('four_civilite')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Téléphone -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Téléphone') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('four_tel') border-red-500 bg-red-100 @enderror"
                   wire:model="four_tel" 
                   name="four_tel">
            @error('four_tel')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Adresse -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Adresse') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('four_adresse') border-red-500 bg-red-100 @enderror"
                   wire:model="four_adresse" 
                   name="four_adresse">
            @error('four_adresse')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Email') }}" />
            <input type="email"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('four_email') border-red-500 bg-red-100 @enderror"
                   wire:model="four_email" 
                   name="four_email">
            @error('four_email')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Observations -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Observations') }}" />
            <textarea
                   class="block mt-1 rounded-md border-gray-300 w-full @error('four_observations') border-red-500 bg-red-100 @enderror"
                   wire:model="four_observations" 
                   name="four_observations"
                   rows="3"></textarea>
            @error('four_observations')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('fournisseurs.index') }}" 
               class="bg-red-600 hover:bg-red-700 rounded-md px-4 py-2 text-sm text-white transition">
                {{ __('Annuler') }}
            </a>
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md text-sm text-white transition">
                {{ __('Ajouter') }}
            </button>
        </div>
    </form>
</div>