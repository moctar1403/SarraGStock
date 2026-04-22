<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom de la monnaie') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('monn_lib') border-red-500 bg-red-100 @enderror"
                wire:model="monn_lib" name="monn_lib">
            @error('monn_lib')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Symbole monnaie') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('monn_sym') border-red-500 bg-red-100 @enderror"
                wire:model="monn_sym" name="monn_sym">
            @error('monn_sym')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Code monnaie') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('monn_code') border-red-500 bg-red-100 @enderror"
                wire:model="monn_code" name="monn_code">
            @error('monn_code')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex justify-between items-center bg-gray-100">
            <a href="{{ route('configs.monnaie') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                {{ __('Annuler') }}
            </a>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{__('Modifier')}}</button>
        </div>
    </form>
</div>