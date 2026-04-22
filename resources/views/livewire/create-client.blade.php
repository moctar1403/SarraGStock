<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Nom -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('cli_nom') border-red-500 bg-red-100 @enderror"
                   wire:model="cli_nom" 
                   name="cli_nom">
            @error('cli_nom')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Civilité -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Civilité') }}" />
            <select wire:model.live="cli_civilite"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('cli_civilite') border-red-500 bg-red-100 @enderror">
                <option value="">{{ __('Séléctionner la civilité') }}</option>
                <option value="Mr">{{ __('Mr') }}</option>
                <option value="Mme">{{ __('Mme') }}</option>
                <option value="Mlle">{{ __('Mlle') }}</option>
            </select>
            @error('cli_civilite')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Société -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Société') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('cli_societe') border-red-500 bg-red-100 @enderror"
                   wire:model="cli_societe" 
                   name="cli_societe">
            @error('cli_societe')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Téléphone -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Téléphone') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('cli_tel') border-red-500 bg-red-100 @enderror"
                   wire:model="cli_tel" 
                   name="cli_tel">
            @error('cli_tel')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Adresse -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Adresse') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('cli_adresse') border-red-500 bg-red-100 @enderror"
                   wire:model="cli_adresse" 
                   name="cli_adresse">
            @error('cli_adresse')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Email') }}" />
            <input type="email"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('cli_email') border-red-500 bg-red-100 @enderror"
                   wire:model="cli_email" 
                   name="cli_email">
            @error('cli_email')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Observation -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Observation') }}" />
            <textarea
                   class="block mt-1 rounded-md border-gray-300 w-full @error('cli_observations') border-red-500 bg-red-100 @enderror"
                   wire:model="cli_observations" 
                   name="cli_observations"
                   rows="3"></textarea>
            @error('cli_observations')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('clients.index') }}" 
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