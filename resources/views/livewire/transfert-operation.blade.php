<div class="p-2 bg-white shadow-sm rounded-lg">
    <form method="POST" wire:submit.prevent="store" class="space-y-4">
        @csrf
        @method('post')

        {{-- Tableau de transfert --}}
        <div class="p-4">
            <table class="min-w-full text-center border rounded-lg">
                <thead class="border-b bg-gray-50">
                    <tr style="vertical-align:middle">
                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Nom') }}</th>
                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Solde réel') }}</th>
                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Méthode alimentée') }}</th>
                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Montant') }}</th>
                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Frais') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-gray-100" style="vertical-align:middle">
                        {{-- Méthode source --}}
                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                            <div class="font-semibold">{{ $meth_nom }}</div>
                            @error('meth_nom')
                                <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </td>

                        {{-- Solde réel --}}
                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                            <input type="text"
                                   wire:model="meth_solder" 
                                   name="meth_solder"
                                   class="w-32 block mx-auto rounded-md border-gray-300 bg-gray-100"
                                   readonly>
                            @error('meth_solder')
                                <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </td>

                        {{-- Méthode sélectionnée --}}
                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                            <select name="meth_selected" 
                                    class="w-32 block mx-auto rounded-md border-gray-300"
                                    wire:model.live="meth_selected">
                                <option value="0">{{ __('Choisir...') }}</option>
                                @foreach ($methodesList as $item)
                                    <option value="{{ $item->id }}">{{ $item->meth_nom }}</option>
                                @endforeach
                            </select>
                            @error('meth_selected')
                                <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </td>

                        {{-- Montant --}}
                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                            <input type="number"
                                   wire:model="montant" 
                                   name="montant"
                                   class="w-32 block mx-auto rounded-md border-gray-300"
                                   min="0"
                                   step="1">
                            @error('montant')
                                <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </td>

                        {{-- Frais --}}
                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                            <input type="number"
                                   wire:model="frais" 
                                   name="frais"
                                   class="w-32 block mx-auto rounded-md border-gray-300"
                                   min="0"
                                   value="0"
                                   step="1">
                            @error('frais')
                                <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Boutons d'action --}}
        <div class="p-4 flex justify-between items-center bg-gray-100 rounded-b-lg">
            <a href="{{ route('operation.index') }}" 
               class="bg-red-600 hover:bg-red-700 rounded-md px-4 py-2 text-sm text-white transition">
                {{ __('Annuler') }}
            </a>
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md text-sm text-white transition">
                {{ __('Effectuer le transfert') }}
            </button>
        </div>
    </form>
</div>