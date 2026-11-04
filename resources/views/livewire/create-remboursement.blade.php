<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Sélection client -->
        <div class="p-5 flex flex-col">
            <label for="client_id">{{ __('Sélectionner un client (Crédit)') }}</label>
            
            <select id="client_id"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('client_id') border-red-500 bg-red-100 @enderror"
                    wire:model.live='client_id'>
                <option value="">{{ __('------') }}</option>
                @foreach ($clientsList as $item)
                    <option value="{{ $item->id }}">{{ $item->cli_nom }} (Crédit: {!! format_number($item->cli_situation) !!})</option>
                @endforeach
            </select>
            @error('client_id')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
            
            <div class="text-green-500 mt-2">
                {{ __('Recherche rapide du client') }}
            </div>
            
            <input type="text"
                   id="recherche_client"
                   class="w-64 block mt-1 rounded-md border-gray-300"
                   wire:model.live="recherche_client"
                   placeholder="{{ __('Id, Tél, Email') }}">
        </div>

        <!-- Montant -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Montant à rembourser') }}" />
            
            @if ($this->current_client)
                <p class="text-sm text-gray-600 mt-1">
                    {{ __('Crédit disponible chez le client') }} : 
                    <span class="text-red-500 font-semibold">
                        {!! format_number(abs($this->current_client->cli_situation)) !!}
                    </span>
                </p>
            @endif
            
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('rem_montant') border-red-500 bg-red-100 @enderror"
                   wire:model.live="rem_montant" 
                   name="rem_montant">
            @error('rem_montant')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Type de paiement -->
        <div class="p-5 flex flex-col">
            <label for="rem_type_p">{{ __('Moyen de remboursement') }}</label>
            <select id="rem_type_p"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('rem_type_p') border-red-500 bg-red-100 @enderror"
                    wire:model.live='rem_type_p'>
                <option value="">{{ __('------') }}</option>
                @foreach ($methodesList as $item)
                    <option value="{{ $item->id }}">{{ __($item->meth_nom) }}</option>
                @endforeach
            </select>
            @error('rem_type_p')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date -->
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Date') }}" />
            <input type="date"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('rem_date') border-red-500 bg-red-100 @enderror"
                   wire:model="rem_date" 
                   name="rem_date">
            @error('rem_date')
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
                {{ __('Rembourser') }}
            </button>
        </div>
    </form>
</div>