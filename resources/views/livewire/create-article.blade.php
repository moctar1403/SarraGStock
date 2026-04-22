<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Libellé Article -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Libellé Article') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_lib') border-red-500 bg-red-100 @enderror"
                   wire:model="ar_lib" 
                   name="ar_lib">
            @error('ar_lib')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Référence -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Référence') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_reference') border-red-500 bg-red-100 @enderror"
                   wire:model="ar_reference" 
                   name="ar_reference">
            @error('ar_reference')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Description') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_description') border-red-500 bg-red-100 @enderror"
                   wire:model="ar_description" 
                   name="ar_description">
            @error('ar_description')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Code barre -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Code barre') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_codebarre') border-red-500 bg-red-100 @enderror"
                   wire:model="ar_codebarre" 
                   name="ar_codebarre">
            @error('ar_codebarre')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Unité de vente -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Unité de vente') }}" />
            <select wire:model.live="ar_unite"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('ar_unite') border-red-500 bg-red-100 @enderror">
                <option value="">{{ __('Sélectionner une unité') }}</option>
                @foreach ($unitesListe as $item)
                    <option value="{{ $item->id }}">{{ __($item->unit_lib) }}</option>
                @endforeach
            </select>
            @error('ar_unite')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Quantité') }}" />
            @if($ar_unite2)
            <p class="text-green-500 text-sm mt-1">{{ __('Par') }} {{ __($ar_unite2->unit_lib) }}</p>
            @endif
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_qte') border-red-500 bg-red-100 @enderror"
                   wire:model.blur="ar_qte" 
                   name="ar_qte">
            @error('ar_qte')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantité minimale -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Quantité minimale') }}" />
            @if($ar_unite2)
            <p class="text-green-500 text-sm mt-1">{{ __('Par') }} {{ __($ar_unite2->unit_lib) }}</p>
            @endif
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_qte_mini') border-red-500 bg-red-100 @enderror"
                   wire:model="ar_qte_mini" 
                   name="ar_qte_mini">
            @error('ar_qte_mini')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix total achat -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix total achat') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_prix_achat_total') border-red-500 bg-red-100 @enderror"
                   wire:model.live="ar_prix_achat_total" 
                   name="ar_prix_achat_total">
            @error('ar_prix_achat_total')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix achat unitaire -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix achat') }}" />
            @if($ar_unite2)
            <p class="text-green-500 text-sm mt-1">{{ __('Par') }} {{ __($ar_unite2->unit_lib) }}</p>
            @endif
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full bg-gray-100 @error('ar_prix_achat') border-red-500 bg-red-100 @enderror"
                   wire:model.live="ar_prix_achat" 
                   name="ar_prix_achat" 
                   readonly>
            @error('ar_prix_achat')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix de vente -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Prix de vente') }}" />
            @if($ar_unite2)
            <p class="text-green-500 text-sm mt-1">{{ __('Par') }} {{ __($ar_unite2->unit_lib) }}</p>
            @endif
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-full @error('ar_prix_vente') border-red-500 bg-red-100 @enderror"
                   wire:model="ar_prix_vente" 
                   name="ar_prix_vente">
            @error('ar_prix_vente')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
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