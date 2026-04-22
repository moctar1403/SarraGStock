<div class="bg-gray-500 bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-2 lg:gap-8 p-6 lg:p-8 pb-2 ">    
    <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                <a href="#">Ventes</a>
                {{$ventes_sum}} MRU 
            </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                <a href="#">{{ __('Profit') }} {{$profit}} MRU</a>
            </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Commandes
                0
            </h2>
        </div>
        <div class="flex items-center bg-white p-6 pb-2 rounded-full ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Revenu 0
            </h2>
        </div>
</div>
<div class="pl-2 pr-2 lg:p-8 bg-gray-500 bg-opacity-25  grid grid-cols-3 flex gap-2">
    <div class="col-span-2 bg-white rounded-lg" >
        <h4 class="mt-8 text-2xl font-medium text-gray-900 p-6">
             Ventes recentes
         </h4>
         <p class="mt-6 text-gray-500 leading-relaxed">
            <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Date</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Client </th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Article</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Quantité</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prix</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prix Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($ventes_liste as $item)
                                    <tr class="border-b-2 border-gray-100" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->updated_at->format('d/m/Y') }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->cli_nom }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->ve_quantite }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->ve_prix_vente}}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->ve_prix_tot }}</td>  
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
                        <div class="mt-3">
                            {{ $ventes_liste }} 
                        </div>
         </p>
    </div>
    <div class=" bg-white rounded-lg ">
        <h4 class="mt-8 text-2xl font-medium text-gray-900 p-6">
             Articles les plus vendus
         </h4>
         <p class="mt-6 text-gray-500 leading-relaxed">
            <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr style="vertical-align:middle">
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Article</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Quantité</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prix moyen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($plus_vendu as $item)
                                    <tr class="border-b-2 border-gray-100" style="vertical-align:middle">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->ar_lib }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->sum_qte }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ number_format($item->avg_prix, 1, ',', ' ')}}</td>
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
         </p>
         
    </div>
</div>
