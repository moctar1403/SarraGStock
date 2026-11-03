<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Libellé article') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('ar_lib') border-red-500 bg-red-100 @enderror"
                wire:model.live="ar_lib" name="ar_lib">
            @error('ar_lib')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Référence') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('ar_reference') border-red-500 bg-red-100 @enderror"
                wire:model.live="ar_reference" name="ar_reference">
            @error('ar_reference')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Description') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('ar_description') border-red-500 bg-red-100 @enderror"
                wire:model.live="ar_description" name="ar_description">
            @error('ar_description')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Code barre') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('ar_codebarre') border-red-500 bg-red-100 @enderror"
                wire:model.live="ar_codebarre" name="ar_codebarre">
            @error('ar_codebarre')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Gérer le stock (Lecture seule) -->
        <div class="p-5 flex flex-col bg-gray-50 border-t border-b">
            <label class="inline-flex items-center cursor-not-allowed">
                <input type="checkbox" disabled {{ $article->gerer_stock ? 'checked' : '' }} class="rounded border-gray-300 text-gray-500 shadow-sm w-5 h-5 opacity-50">
                <span class="ml-2 text-gray-500 font-semibold">{{ __('Gérer le stock pour cet article') }}</span>
            </label>
            <p class="text-xs text-gray-400 mt-1 ml-7">{{ __('Ce paramètre ne peut plus être modifié après la création de l\'article.') }}</p>
        </div>

        <!-- Affichage conditionnel selon si c'est un plat ou un article de stock -->
        @if(!$article->gerer_stock)
            <!-- MODE RESTO : Catégorie + Unité forcée -->
            <div class="p-5 flex flex-col">
                <x-label value="{{ __('Catégorie') }}" />
                <select wire:model.live="categorie_id"
                        class="block mt-1 rounded-md border-gray-300 w-full @error('categorie_id') border-red-500 bg-red-100 @enderror">
                    <option value="">{{ __('Sélectionner une catégorie') }}</option>
                    @foreach ($categoriesListe as $cat)
                        <option value="{{ $cat->id }}">{{ __($cat->nom) }}</option>
                    @endforeach
                </select>
                @error('categorie_id')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="p-5 flex flex-col">
                <x-label value="{{ __('Unité de vente') }}" />
                <div class="mt-1 p-2 bg-gray-100 rounded-md text-gray-600 text-sm border">
                    {{ __('Vendu à l\'unité (Article de restaurant)') }}
                </div>
            </div>
        @else
            <!-- MODE STOCK : Unité, Quantités, Prix d'achat -->
            <div class="p-5 flex flex-col">
                <x-label value="{{ __('Unité de vente') }}" />
                <div class="mt-1 p-2 bg-gray-100 rounded-md text-gray-600 text-sm border">
                    {{ __('Unité') }}
                </div>
            </div>

            <div class="p-5 flex flex-col">
                <x-label value="{{ __('Quantité') }}" />
                <input type="text"
                    class="block mt-1 rounded-md border-gray-300 w-full bg-gray-100 @error('ar_qte') border-red-500 bg-red-100 @enderror"
                    wire:model="ar_qte" name="ar_qte" readonly>
                @error('ar_qte')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="p-5 flex flex-col">
                <x-label value="{{ __('Quantité minimale') }}" />
                <input type="text"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('ar_qte_mini') border-red-500 bg-red-100 @enderror"
                    wire:model="ar_qte_mini" name="ar_qte_mini">
                @error('ar_qte_mini')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="p-5 flex flex-col">
                <x-label value="{{ __('Prix achat') }}" />
                <input type="text"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('ar_prix_achat') border-red-500 bg-red-100 @enderror"
                    wire:model="ar_prix_achat" name="ar_prix_achat">
                @error('ar_prix_achat')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
        @endif
        
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix vente') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-full @error('ar_prix_vente') border-red-500 bg-red-100 @enderror"
                wire:model="ar_prix_vente" name="ar_prix_vente">
            @error('ar_prix_vente')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="p-5 flex justify-between items-center bg-gray-100">
            <a href="{{ route('articles.index') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                {{ __('Annuler') }}
            </a>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{__('Modifier')}}</button>
        </div>
    </form>
</div>