<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Article principal -->
        <div class="p-5 flex flex-col">
            <x-label value="{!! __('Choisissez l\'article principal') !!}" />
            <select class="block mt-1 rounded-md border-gray-300 w-64 @error('dar_principal') border-red-500 bg-red-100 @enderror"
                    wire:model.live="dar_principal" 
                    name="dar_principal">
                <option value="0">{{ __('------') }}</option>
                @foreach ($articlesList as $item)
                    <option value="{{ $item->id }}">{{ $item->ar_lib }}</option>
                @endforeach
            </select>
            @error('dar_principal')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
            
            <input type="text"
                   placeholder="{{ __('Id, Référence, CB') }}"
                   class="w-64 block mt-2 rounded-md border-gray-300"
                   wire:model.live="recherche_article">
        </div>

        <!-- Article de détail -->
        <div class="p-5 flex flex-col">
            <x-label value="{!! __('Choisissez l\'article de détail') !!}" />
            <select class="block mt-1 rounded-md border-gray-300 w-64 @error('dar_detail') border-red-500 bg-red-100 @enderror"
                    wire:model.live="dar_detail" 
                    name="dar_detail">
                <option value="0">{{ __('------') }}</option>
                @foreach ($articlesList2 as $item)
                    <option value="{{ $item->id }}">{{ $item->ar_lib }}</option>
                @endforeach
            </select>
            @error('dar_detail')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
            
            <input type="text"
                   placeholder="{{ __('Id, Référence, CB') }}"
                   class="w-64 block mt-2 rounded-md border-gray-300"
                   wire:model.live="recherche_article2">
        </div>

        <!-- Quantité -->
        <div class="px-5 flex flex-col">
            <x-label value="{!! __('Quantité de l\'article détail par unité d\'article principal') !!}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('dar_qte') border-red-500 bg-red-100 @enderror"
                   wire:model.live="dar_qte" 
                   name="dar_qte">
            @error('dar_qte')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{route('darticles.index')}}" 
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