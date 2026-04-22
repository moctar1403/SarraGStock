<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom de la société') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_nom') border-red-500 bg-red-100 @enderror"
                wire:model="soc_nom" name="soc_nom">
            @error('soc_nom')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Adresse') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_adresse') border-red-500 bg-red-100 @enderror"
                wire:model="soc_adresse" name="soc_adresse">
            @error('soc_adresse')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Téléphone') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_tel') border-red-500 bg-red-100 @enderror"
                wire:model="soc_tel" name="soc_tel">
            @error('soc_tel')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Email') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_email') border-red-500 bg-red-100 @enderror"
                wire:model="soc_email" name="soc_email">
            @error('soc_email')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Code Postal') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_code_postal') border-red-500 bg-red-100 @enderror"
                wire:model="soc_code_postal" name="soc_code_postal">
            @error('soc_code_postal')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('NIF') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_nif') border-red-500 bg-red-100 @enderror"
                wire:model="soc_nif" name="soc_nif">
            @error('soc_nif')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Registre de commerce') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_rc') border-red-500 bg-red-100 @enderror"
                wire:model="soc_rc" name="soc_rc">
            @error('soc_rc')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        @if ($old_logo)
            <div class="p-5 flex">
                <x-label value="{{ __('Ancien LOGO') }}" />
                <img src="{{ asset($societe->soc_logo) }}" alt="Logo">
            </div>
        @endif
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nouveau LOGO') }}" />
            <input type="file"
                class="block mt-1 rounded-md border-gray-300 w-full @error('soc_new_logo') border-red-500 bg-red-100 @enderror"
                wire:model="soc_new_logo" 
                name="soc_new_logo" 
                id="soc_new_logo"
                accept="image/png, image/jpeg, image/jpg">
            @error('soc_new_logo')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex justify-between items-center bg-gray-100">
            <a href="{{ route('configs.societe') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                {{ __('Annuler') }}
            </a>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{__('Modifier')}}</button>
        </div>
    </form>
</div>