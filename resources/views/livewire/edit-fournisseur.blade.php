<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('four_nom') border-red-500 bg-red-100 @enderror"
                wire:model="four_nom" name="four_nom">
            @error('four_nom')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Société') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('four_societe') border-red-500 bg-red-100 @enderror"
                wire:model="four_societe" name="four_societe">
            @error('four_societe')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
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
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Téléphone') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('four_tel') border-red-500 bg-red-100 @enderror"
                wire:model="four_tel" name="four_tel">
            @error('four_tel')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Adresse') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('four_adresse') border-red-500 bg-red-100 @enderror"
                wire:model="four_adresse" name="four_adresse">
            @error('four_adresse')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Email') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('four_email') border-red-500 bg-red-100 @enderror"
                wire:model="four_email" name="four_email">
            @error('four_email')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Observations') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('four_observations') border-red-500 bg-red-100 @enderror"
                wire:model="four_observations" name="four_observations">
            @error('four_observations')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex justify-between items-center bg-gray-100">
            <a href="{{ route('fournisseurs.index') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                {{ __('Annuler') }}
            </a>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{__('Modifier')}}</button>
        </div>
    </form>
</div>