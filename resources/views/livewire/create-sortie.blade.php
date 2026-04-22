<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Sélection article -->
        <div class="p-5 flex flex-col">
            <label for="article_id">{{ __('Sélectionner un article') }}</label>
            
            <select id="article_id"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('article_id') border-red-500 bg-red-100 @enderror"
                    wire:model.live='article_id'>
                <option value="0">{{ __('------') }}</option>
                @foreach ($articlesList as $item)
                    <option value="{{ $item->id }}">{{ $item->ar_lib }}</option>
                @endforeach
            </select>
            @error('article_id')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
            
            <div class="text-green-500 mt-2">
                {{ __('Recherche rapide de l\'article') }}
            </div>
            
            <input type="text"
                   id="recherche_article"
                   placeholder="{{ __('Id, Référence, CB') }}"
                   class="w-64 block mt-1 rounded-md border-gray-300"
                   wire:model.live="recherche_article">
        </div>

        <!-- Motif de sortie -->
        <div class="p-5 flex flex-col">
            <label for="sor_motif">{{ __('Motif de sortie') }}</label>
            <select id="sor_motif"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('sor_motif') border-red-500 bg-red-100 @enderror"
                    wire:model.live='sor_motif'>
                <option value="perte">{{ __('Perte') }}</option>
            </select>
            @error('sor_motif')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité disponible -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Quantité disponible') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 bg-gray-100 @error('sor_qte_dispo') border-red-500 bg-red-100 @enderror"
                   wire:model="sor_qte_dispo" 
                   name="sor_qte_dispo" 
                   readonly>
            @error('sor_qte_dispo')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité à sortir -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Quantité à sortir') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('sor_qte') border-red-500 bg-red-100 @enderror"
                   wire:model="sor_qte" 
                   name="sor_qte">
            @error('sor_qte')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Date') }}" />
            <input type="date"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('sor_date') border-red-500 bg-red-100 @enderror"
                   wire:model="sor_date" 
                   name="sor_date">
            @error('sor_date')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('articles.index') }}" 
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