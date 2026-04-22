<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Nom de la monnaie -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom de la monnaie') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('monn_lib') border-red-500 bg-red-100 @enderror"
                   wire:model="monn_lib" 
                   name="monn_lib">
            @error('monn_lib')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Symbole monnaie -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Symbole monnaie') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('monn_sym') border-red-500 bg-red-100 @enderror"
                   wire:model="monn_sym" 
                   name="monn_sym">
            @error('monn_sym')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Code monnaie -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Code monnaie') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('monn_code') border-red-500 bg-red-100 @enderror"
                   wire:model="monn_code" 
                   name="monn_code">
            @error('monn_code')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('configs.monnaie') }}" 
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