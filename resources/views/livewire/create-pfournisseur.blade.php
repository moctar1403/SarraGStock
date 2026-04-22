<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Sélection fournisseur -->
        <div class="p-5 flex flex-col">
            <label for="fournisseur_id">{{ __('Sélectionner un fournisseur') }}</label>
            
            <select id="fournisseur_id"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('fournisseur_id') border-red-500 bg-red-100 @enderror"
                    wire:model.live='fournisseur_id'>
                <option value="">{{ __('------') }}</option>
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

        <!-- Montant -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Montant') }}" />
            
            @if ($this->current_fournisseur)
                <p class="text-sm text-gray-600 mt-1">
                    {{ __('Situation du fournisseur') }}: 
                    <span class="text-green-500 font-semibold">
                        {!! format_number($this->montant_actuel) !!}
                    </span>
                </p>
            @endif
            
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('fpay_montant') border-red-500 bg-red-100 @enderror"
                   wire:model.live="fpay_montant" 
                   name="fpay_montant">
            @error('fpay_montant')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Frais -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Frais') }}" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('fpay_frais') border-red-500 bg-red-100 @enderror"
                   wire:model.live="fpay_frais" 
                   name="fpay_frais">
            @error('fpay_frais')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Type de paiement -->
        <div class="p-5 flex flex-col">
            <label for="fpay_type_p">{{ __('Type de paiement') }}</label>
            <select id="fpay_type_p"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('fpay_type_p') border-red-500 bg-red-100 @enderror"
                    wire:model.live='fpay_type_p'>
                <option value="">{{ __('------') }}</option>
                @foreach ($methodesList as $item)
                    <option value="{{ $item->id }}">{{ __($item->meth_nom) }}</option>
                @endforeach
            </select>
            @error('fpay_type_p')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Date') }}" />
            <input type="date"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('fpay_date') border-red-500 bg-red-100 @enderror"
                   wire:model="fpay_date" 
                   name="fpay_date">
            @error('fpay_date')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('paiements.index') }}" 
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