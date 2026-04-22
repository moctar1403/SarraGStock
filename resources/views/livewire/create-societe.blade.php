<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Nom de la société -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom de la société') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_nom') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_nom" 
                   name="soc_nom">
            @error('soc_nom')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Adresse -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Adresse') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_adresse') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_adresse" 
                   name="soc_adresse">
            @error('soc_adresse')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Téléphone -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Téléphone') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_tel') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_tel" 
                   name="soc_tel">
            @error('soc_tel')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Email') }}" />
            <input type="email"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_email') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_email" 
                   name="soc_email">
            @error('soc_email')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Code Postal -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Code Postal') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_code_postal') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_code_postal" 
                   name="soc_code_postal">
            @error('soc_code_postal')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- NIF -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('NIF') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_nif') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_nif" 
                   name="soc_nif">
            @error('soc_nif')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Registre de commerce -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Registre de commerce') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_rc') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_rc" 
                   name="soc_rc">
            @error('soc_rc')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- LOGO -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('LOGO') }}" />
            <input type="file"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('soc_logo') border-red-500 bg-red-100 @enderror"
                   wire:model="soc_logo" 
                   name="soc_logo" 
                   id="soc_logo"
                   accept="image/png, image/jpeg, image/jpg">
            @error('soc_logo')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
            
            @if ($soc_logo)
                <div class="mt-2">
                    <img class="w-20 h-20 rounded-md object-cover border" 
                         src="{{ $soc_logo->temporaryUrl() }}" 
                         alt="{{ __('Aperçu du logo') }}">
                </div>
            @endif
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('configs.societe') }}" 
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