<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Titre et Boutton crée --}}
        <div class="flex flex-col">
             {{-- Message qui apparaitra après operation --}}

            @if (Session::get('success'))
                <div class="p-5">
                    <div class="block p-2 bg-green-500 text-white rounded-sm shadow-sm mt-2">
                        {{ __(Session::get('success'))  }}
                    </div>
                </div>
            @endif
            @if (Session::get('danger'))
                <div class="p-5">
                    <div class="block p-2 bg-red-500 text-white rounded-sm shadow-sm mt-2">
                        {{ __(Session::get('danger'))  }}
                    </div>
                </div>
            @endif
        </div>
        <div class="flex justify-between items-center text-sm font-medium text-gray-900 px-6 ">
                <p>
                    @if ($societe) 
                        <img src="/{{$societe->soc_logo}}" class="w-20 h-10 ">
                    @endif
                    Vente N°:{{  $vente->fa_num }}<br>
                    Date de la vente: {{  $vente->updated_at->format('d/m/Y') }}<br />
                </p>
                <p>
                    @if (($client))
                        <b>Client: </b> {{ $client->cli_civilite }} {{$client->cli_nom }}<br>
                        Société:{{ $client->cli_societe}}<br>
                        {{-- Adresse:{{  $client->cli_adresse }}<br> --}}
                        Téléphone:{{  $client->cli_tel }}<br>
                        Email:{{  $client->cli_email }}<br>     
                    @else
                         <b>Client: </b> <br>
                        Société:<br>
                        Adresse:<br>
                        Téléphone:<br>
                        Email:<br>       
                    @endif
                </p>
        </div>
        <div class="flex items-center text-sm font-medium text-gray-900 px-20 py-1 border-b bg-gray-200 ">
            <b>Mode de paiement:</b>
        </div>
        <div class="flex items-center text-sm font-medium text-gray-900 px-20 py-1 ">
            {{  $paiement->meth_nom }}
        </div>
        <div class="flex flex-col">
            {{-- Styliser le tableau --}}
            <div class="overflow-x-auto ">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center px-6">
                            <thead class="border-b bg-gray-200">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-6 py-2"><b>{{ __('Article') }}</b></th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-2"><b>{{ __('Quantité') }}</b></th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-2"><b>{{ __('Prix Unitaire') }}</b></th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-2"><b>{{ __('Prix Total') }}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventes as $item)
                                    <tr class="border-b-2 border-gray-100" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-2">{{ $item->article->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-2">{{ $item->ve_quantite }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-2">{{ $item->ve_prix_vente}}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-2">{{ $item->ve_prix_tot }}</td>                                      
                                    </tr>
                                @endforeach
                                    <tr class="border-b-2 border-gray-100" style="vertical-align:middle" >
                                            <td class="text-sm font-medium text-gray-900 px-6 py-2"></td>
                                            <td class="text-sm font-medium text-gray-900 px-6 py-2"></td>
                                            <td class="text-sm font-bold text-gray-900 px-6 py-2">Montant Total MRU:</td>
                                            <td class="text-sm font-bold text-gray-900 px-6 py-2">{{$vente->fa_tot}}</td>
                                    </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
