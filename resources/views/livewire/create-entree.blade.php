<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Sélection article -->
        <div class="p-5 flex flex-col">
            <label for="article_id">{{ __('Sélectionner un article') }}</label>
            
            @if ($this->current_article)
                <p class="text-green-500 mt-1">
                    {{ __('Article') }}: {{ $this->current_article->ar_lib }}
                </p>
            @endif
            
            <select id="article_id"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('article_id') border-red-500 bg-red-100 @enderror"
                    wire:model.live='article_id'>
                <option value="0">------</option>
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

        <!-- Sélection fournisseur -->
        <div class="p-5 flex flex-col">
            <label for="fournisseur_id">{{ __('Sélectionner un fournisseur') }}</label>
            
            @if ($this->current_fournisseur)
                <p class="text-green-500 mt-1">
                    {{ __('Fournisseur') }}: {{ $this->current_fournisseur->four_nom }} {{ $this->current_fournisseur->four_societe }}
                </p>
            @endif
            
            <select id="fournisseur_id"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('fournisseur_id') border-red-500 bg-red-100 @enderror"
                    wire:model.live='fournisseur_id'>
                <option value="0">------</option>
                @foreach ($fournisseursList as $item)
                    <option value="{{ $item->id }}">{{ $item->four_nom }}</option>
                @endforeach
            </select>
            @error('fournisseur_id')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
            
            <div class="text-green-500 mt-2">
                {{ __('Recherche rapide du fournisseur') }}
            </div>
            
            <input type="text"
                   id="recherche_fournisseur"
                   class="w-64 block mt-1 rounded-md border-gray-300"
                   wire:model.live="recherche_fournisseur"
                   placeholder="{{ __('Id, Tél, Email') }}">
        </div>

        <!-- Quantité -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Quantité') }}" />
            
            @if ($this->current_article)
                <p class="text-sm text-gray-600 mt-1">
                    {{ __('Quantité actuelle') }}: 
                    <span class="text-green-500 font-semibold">
                        {{ $this->qute_actuelle }} {{ $this->unite }}
                    </span>
                </p>
            @endif
            
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('ent_qte') border-red-500 bg-red-100 @enderror"
                   wire:model="ent_qte" 
                   name="ent_qte">
            @error('ent_qte')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix total achat -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix total achat') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('ar_prix_achat_total') border-red-500 bg-red-100 @enderror"
                   wire:model.live="ar_prix_achat_total" 
                   name="ar_prix_achat_total">
            @error('ar_prix_achat_total')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix achat unitaire -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix achat unitaire') }}" />
            
            @if ($this->current_article)
                <p class="text-sm text-gray-600 mt-1">
                    {{ __('Prix achat actuel') }}: 
                    <span class="text-green-500 font-semibold">
                        {!! format_number($this->prix_achat_actuel) !!}
                    </span>
                </p>
            @endif
            
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 bg-gray-100 @error('ent_prix_achat') border-red-500 bg-red-100 @enderror"
                   wire:model="ent_prix_achat" 
                   name="ent_prix_achat" 
                   readonly>
            @error('ent_prix_achat')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix de vente -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix de vente') }}" />
            
            @if ($this->current_article)
                <p class="text-sm text-gray-600 mt-1">
                    {{ __('Prix de vente actuel') }}: 
                    <span class="text-green-500 font-semibold">
                        {!! format_number($this->prix_vente_actuel) !!}
                    </span>
                </p>
            @endif
            
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('ent_prix_vente') border-red-500 bg-red-100 @enderror"
                   wire:model="ent_prix_vente" 
                   name="ent_prix_vente">
            @error('ent_prix_vente')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Date') }}" />
            <input type="date"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('ent_date') border-red-500 bg-red-100 @enderror"
                   wire:model="ent_date" 
                   name="ent_date">
            @error('ent_date')
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