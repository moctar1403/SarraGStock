<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Libellé de l\'Unité') }}" />
            <input type="text"
                   id="unit_lib"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('unit_lib') border-red-500 bg-red-100 @enderror"
                   wire:model="unit_lib" 
                   name="unit_lib">
            @error('unit_lib')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('unites.index') }}" 
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