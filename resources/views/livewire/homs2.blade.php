<div>
    <div class="bg-gray-500 bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-2 lg:gap-8 p-6 lg:p-8 pb-2 ">    
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="total_ventes()">Ventes {{$ventes_sum}} MRU </a>
                </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="vsans_credit()" >{{ __('Total Ventes') }} sans Crédit : {{$sans_credit}} Mru</a>
                </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="ventes_credit()">crédit {{$credit}} MRU</a>
                </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="ventes_espece()">Espèce {{$espece}} MRU </a>
                </h2>
        </div>
    </div>
    <div class="bg-gray-500 bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-2 lg:gap-8 p-6 lg:p-8 pb-2 ">    
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="ventes_app()">Ventes par App {{$bankily+$masrivi}} MRU</a>
                </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="ventes_bankily()">Bankily {{$bankily}} MRU</a>
                </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#" wire:click="ventes_masrivi()">Masrivi {{$masrivi}} MRU</a>
                </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="#">{{ __('Profit') }} {{$profit}} MRU</a>  
                </h2>
        </div>
    </div>
    <div class="pl-2 pr-2 lg:p-8 bg-gray-500 bg-opacity-25  grid grid-cols-3 flex gap-2">
        <div class="col-span-2 bg-white rounded-lg" >
            <h4 class="mt-8 text-2xl font-medium text-gray-900 p-6">
                {{$ventes_msg}}
            </h4>
            <p class="mt-6 text-gray-500 leading-relaxed">
                <table class="min-w-full text-center">
                                <thead class="border-b bg-gray-50">
                                    <tr style="vertical-align:middle">
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Date</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Client </th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Article</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Quantité</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Prix</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Prix Total</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">Mode de Paiement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($ventes_liste as $item)
                                        <tr class="border-b-2 border-gray-100" style="vertical-align:middle">
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->updated_at->format('d/m/Y') }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->cli_nom }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ar_lib }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ve_quantite }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ve_prix_vente}}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->ve_prix_tot }}</td>  
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                @switch($item->type_p)
                                                        @case('0')
                                                            Espèce
                                                            @break
                                                    
                                                        @case('1')
                                                            Crédit
                                                            @break
                                                    
                                                        @case('2')
                                                            Bankily
                                                            @break
                                                    
                                                        @case('3')
                                                            Masrivi
                                                            @break
                                                    
                                                        @default
                                                            Espèce
                                                    @endswitch        
                                            </td>            
                                        </tr>
                                @empty
                                        <tr class="w-full">
                                            <td class=" flex-1 w-full items-center justify-center" colspan="4">
                                                <div>
                                                    <p class="flex justify-center content-center p-4"> <img
                                                            src="{{ image_empty() }}" alt=""
                                                            class="w-20 h-20">
                                                    <div>{{ __('Aucun élément trouvé!') }}</div>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse        
                                </tbody>
                            </table>
                            {{-- <div class="mt-3">
                                {{ $ventes_liste }} 
                            </div> --}}
            </p>
        </div>
        <div class=" bg-white rounded-lg ">
            <h4 class="mt-8 text-2xl font-medium text-gray-900 p-6">
                {{ __('Situation financière') }}
            </h4>
            <p class="mt-6 text-gray-500 leading-relaxed">
                <div class="text-sm font-medium text-gray-900 px-2 py-2">
                    Espèce : {{$espece}} Mru
                </div>
                <div class="text-sm font-medium text-gray-900 px-2 py-2">
                    Bankily : {{$bankily}} Mru
                </div>
                <div class="text-sm font-medium text-gray-900 px-2 py-2">
                    Masrivi : {{$masrivi}} Mru
                </div>
                <div class="text-sm font-medium text-gray-900 px-2 py-2">
                    {{ __('Total Ventes') }} sans Crédit : {{$espece+$bankily+$masrivi}} Mru
                </div>
                <div class="text-sm font-medium text-gray-900 px-2 py-2">
                    Crédit : {{$credit}} Mru
                </div>
                <div class="text-sm font-medium text-gray-900 px-2 py-2" >
                    {{ __('Total Ventes') }} : {{$espece+$bankily+$masrivi+$credit}} Mru
                </div>
            </p>
            
        </div>
    </div>
</div>