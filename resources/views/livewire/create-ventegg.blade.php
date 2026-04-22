<div class="p-2 bg-white shadow-sm">

    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        @if (Session::get('error'))
            <div class="p-5">
                <div class="p-4 border-red-500 bg-red-400 animate-bounce text-white">{{ Session::get('error') }}</div>
            </div>
        @endif
             {{-- Styliser le tableau --}}

            <div class="overflow-x-auto ">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Article</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Client</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Quantité disponible</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Quantité</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prix Unitaire</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prix Total</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">--</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr class="border-b-2 border-gray-100" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                                <select name="" id="" class="block mt-1 rounded-md border-gray-300 w-full "
                                                    wire:model.live='article_id' name="article_id">
                                                    <option value="0">------</option>
                                                    @foreach ($articlesList as $item)
                                                        <option value="{{ $item->id }}">{{ $item->ar_lib }}</option>
                                                    @endforeach
                                                </select>
                                                @error('article_id')
                                                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                                                @enderror
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <select name="" id="" class="block mt-1 rounded-md border-gray-300 w-full"
                                                wire:model.live='client_id' name="client_id">
                                                <option value="0">------</option>
                                                @foreach ($clientsList as $item)
                                                    <option value="{{ $item->id }}">{{ $item->cli_nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <input type="text"
                                                class="block mt-1 rounded-md border-gray-300 w-full @error('quantite_dispo')
                                                 border-red-500 bg-red-100 animate-bounce
                                                @enderror"
                                                wire:model.live="quantite_dispo" name="quantite_dispo" readonly>
                                                @error('quantite_dispo')
                                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                                                @enderror
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <input type="text"
                                                class="block mt-1 rounded-md border-gray-300 w-full @error('ve_quantite')
                                            border-red-500 bg-red-100 animate-bounce
                                        @enderror"
                                                wire:model.live="ve_quantite" name="ve_quantite">
                                            @error('ve_quantite')
                                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <input type="text"
                                                class="block mt-1 rounded-md border-gray-300 w-full @error('ve_prix')
                                                border-red-500 bg-red-100 animate-bounce
                                            @enderror"
                                            wire:model.live="ve_prix" name="ve_prix" readonly>
                                                @error('ve_prix')
                                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                                                @enderror
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <input type="text"
                                                class="block mt-1 rounded-md border-gray-300 w-full @error('ve_prix_tot')
                                                border-red-500 bg-red-100 animate-bounce
                                                @enderror"
                                                wire:model.live="ve_prix_tot" name="ve_prix_tot" readonly>
                                                @error('ve_prix_tot')
                                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                                                @enderror
                                        </td>     
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <a href="#" class="bg-red-600 rounded-md p-2 text-sm text-white">Delete</a>
                                        </td>                             
                                    </tr>
                                    <tr>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <button class="bg-blue-600 rounded-md p-2 text-sm text-white" wire:click.prevent="addProduct">+ Autre article </button>
                                        </td>   
                                    </tr>
                            </tbody>
                        </table>
                        <div class="p-5 flex justify-between items-center bg-gray-100">
                            <button class="bg-green-600 p-3 rounded-md p-2 text-white text-sm" type="submit">{{ __('Valider') }}</button>
                            <a href="{{ route('ventes.index') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                                {{ __('Annuler') }}</a>
                        </div>
    </form>
</div>

