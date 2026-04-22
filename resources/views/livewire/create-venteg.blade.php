<div class="p-2 bg-white shadow-sm rounded-lg">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <!-- Section 1 : Informations vendeur -->
        <div class="bg-gray-50 p-4 rounded-lg border mb-4">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-100">
                                <tr class="align-middle">
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Méthode de Paiement') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Client') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Recherche rapide') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <!-- Méthode de paiement -->
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        @if ($type_paiement)
                                            <p class="text-sm font-medium text-green-500 mb-1">
                                                {{ __('Méthode') }}: {{ __($type_paiement->meth_nom) }}
                                            </p>
                                        @endif
                                        <select wire:model.live="paiement_id"
                                                class="block mt-1 rounded-md border-gray-300 w-full @error('paiement_id') border-red-500 bg-red-100 @enderror">
                                            <option value="0">------</option>
                                            @foreach ($methodesList as $item)
                                                <option value="{{ $item->id }}">{{ __($item->meth_nom) }}</option>
                                            @endforeach
                                        </select>
                                        @error('paiement_id')
                                            <div class="text-red-500 mt-1 text-xs">{{ $message }}</div>
                                        @enderror
                                    </td>

                                    <!-- Client -->
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        @if ($client)
                                            <p class="text-sm font-medium text-green-500 mb-1">
                                                {{ $client->cli_nom }} {{ $client->cli_tel }}
                                            </p>
                                        @endif
                                        <select wire:model.live="client_id"
                                                class="block mt-1 rounded-md border-gray-300 w-full @error('client_id') border-red-500 bg-red-100 @enderror">
                                            <option value="0">------</option>
                                            @foreach ($clientsList as $item)
                                                <option value="{{ $item->id }}">{{ $item->cli_nom }} {{ $item->cli_tel }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <div class="text-red-500 mt-1 text-xs">{{ $message }}</div>
                                        @enderror
                                    </td>

                                    <!-- Recherche rapide -->
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        <label for="recherche_client" class="text-sm">{{ __('Tél ou Email') }}</label>
                                        <input type="text"
                                               id="recherche_client"
                                               wire:model.live.debounce.500ms="recherche_client"
                                               class="w-full block mt-1 rounded-md border-gray-300 @error('recherche_client') border-red-500 bg-red-100 @enderror"
                                               placeholder="{{ __('Tél ou Email') }}">
                                        @error('recherche_client')
                                            <div class="text-red-500 mt-1 text-xs">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2 : Articles vendus -->
        <div class="bg-gray-50 p-4 rounded-lg border mb-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ __('Articles vendus') }}</h3>
            
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-100">
                                <tr class="align-middle">
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Article') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2"></th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Qté dispo') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Quantité') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Prix Unit') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">{{ __('Prix Total') }}</th>
                                    <th class="text-sm font-medium text-gray-700 px-3 py-2">--</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vgs as $index => $vg)
                                    <!-- Ligne de sélection -->
                                    <tr class="align-middle bg-blue-50">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2" colspan="7">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                @if ($vgs[$index]['article_id'] && $vgs[$index]['article_id'] != '0')
                                                    @php
                                                        $article = App\Models\Article::find($vgs[$index]['article_id']);
                                                    @endphp
                                                    <span class="text-green-600 text-sm font-medium">
                                                        {{ __('Article') }}: {{ $article->ar_lib ?? '' }}
                                                    </span>
                                                @endif
                                                <label class="inline-flex items-center">
                                                    <input type="radio" 
                                                           value="1" 
                                                           wire:model.live="vgs.{{ $index }}.selectPro" 
                                                           class="mr-1 rtl:ml-1">
                                                    <span class="text-xs">{{ __("Sélectionner") }}</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" 
                                                           value="0" 
                                                           wire:model.live="vgs.{{ $index }}.selectPro" 
                                                           class="mr-1 rtl:ml-1">
                                                    <span class="text-xs">{{ __("Rechercher") }}</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Ligne des champs -->
                                    <tr class="align-middle border-b border-gray-200">
                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @if ($vgs[$index]['selectPro'] == 1)
                                                <select wire:model.live="vgs.{{ $index }}.article_id"
                                                        class="block mt-1 rounded-md border-gray-300 w-full @error('vgs.'.$index.'.article_id') border-red-500 bg-red-100 @enderror">
                                                    <option value="0">------</option>
                                                    @foreach ($articlesList as $item)
                                                        <option value="{{ $item->id }}">{{ $item->ar_lib }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text"
                                                       class="block mt-1 rounded-md border-gray-300 w-full @error('vgs.'.$index.'.code_barre') border-red-500 bg-red-100 @enderror"
                                                       wire:model.live.debounce.500ms="vgs.{{ $index }}.code_barre"
                                                       placeholder="{{ __('Id,Réf,CB') }}">    
                                            @endif
                                            @error('vgs.'.$index.'.article_id')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                            @error('vgs.'.$index.'.code_barre')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @if ($vgs[$index]['selectPro'] == 0 && $vgs[$index]['ar_unite2'])
                                                <span class="text-green-500 text-xs">{{ $vgs[$index]['ar_unite2'] }}</span>
                                            @endif
                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <input type="text"
                                                   wire:model.live="vgs.{{ $index }}.quantite_dispo"
                                                   class="w-20 block mx-auto rounded-md border-gray-300 bg-gray-100 text-center @error('vgs.'.$index.'.quantite_dispo') border-red-500 bg-red-100 @enderror"
                                                   readonly>
                                            @error('vgs.'.$index.'.quantite_dispo')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <input type="number"
                                                   class="w-20 block mx-auto rounded-md border-gray-300 text-center @error('vgs.'.$index.'.ve_quantite') border-red-500 bg-red-100 @enderror"
                                                   wire:model.live.debounce.300ms="vgs.{{ $index }}.ve_quantite"
                                                   min="0"
                                                   step="any">
                                            @error('vgs.'.$index.'.ve_quantite')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <input type="text"
                                                   class="w-32 block mx-auto rounded-md border-gray-300 bg-gray-100 text-center @error('vgs.'.$index.'.ve_prix_vente') border-red-500 bg-red-100 @enderror"
                                                   wire:model.live="vgs.{{ $index }}.ve_prix_vente"
                                                   readonly>
                                            @error('vgs.'.$index.'.ve_prix_vente')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            <input type="text"
                                                   class="w-32 block mx-auto rounded-md border-gray-300 bg-gray-100 text-center font-bold text-green-600 @error('vgs.'.$index.'.ve_prix_tot') border-red-500 bg-red-100 @enderror"
                                                   wire:model.live="vgs.{{ $index }}.ve_prix_tot"
                                                   readonly>
                                            @error('vgs.'.$index.'.ve_prix_tot')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                            @if ($index == 0)
                                                <button type="button"
                                                        class="bg-blue-600 hover:bg-blue-700 rounded-md px-3 py-1 text-white transition"
                                                        wire:click.prevent="addVente">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            @endif
                                            @if (count($vgs) > 1)
                                                <button type="button"
                                                        class="bg-red-600 hover:bg-red-700 rounded-md px-3 py-1 text-white transition"
                                                        wire:click.prevent="removeVente({{ $index }})">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3 : Remise et Totaux -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Bouton Total / Validation -->
                <div>
                    @if ($compteur_remise == 0)
                        <button type="submit" class="bg-green-600 hover:bg-green-700 rounded-lg px-6 py-3 text-white font-bold text-lg transition shadow">
                            {{ __('Montant Total') }} {!! format_number($total_vente) !!}
                        </button>
                    @else
                        <button type="submit" class="bg-green-600 hover:bg-green-700 rounded-lg px-6 py-3 text-white font-bold transition shadow">
                            <div>{{ __('Montant Total') }} {!! format_number($total_vente) !!}</div>
                            <div>{{ __('Montant Remise') }} {!! format_number($mremise) !!}</div>
                            <div>{{ __('Total après remise') }} {!! format_number($total_vente_apres_remise) !!}</div>
                        </button>
                    @endif
                </div>

                <!-- Bouton Activation Remise -->
                <button type="button" 
                        class="{{ $classeremise }} px-4 py-2 rounded-lg font-semibold transition shadow"
                        wire:click.prevent="{{ $clickRemise }}">
                    {{ __($msg_remise) }}
                </button>

                <!-- Formulaire Remise -->
                @if ($compteur_remise)
                    <div class="flex flex-col space-y-2 bg-white p-3 rounded-lg border">
                        <label class="flex items-center">
                            <input type="radio" value="1" wire:model.live="receiveRemise" class="mr-2 rtl:ml-2">
                            <span class="text-sm mr-2 rtl:ml-2">{{ __("Taux Remise %") }}</span>
                            <input type="number"
                                   class="w-32 rounded-md border-gray-300 text-sm @error('remise') border-red-500 bg-red-100 @enderror"
                                   wire:model.live.debounce.300ms="remise"
                                   min="0"
                                   max="100"
                                   step="0.001">
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" value="0" wire:model.live="receiveRemise" class="mr-2 rtl:ml-2">
                            <span class="text-sm mr-2 rtl:ml-2">{{ __("Montant Remise") }}</span>
                            <input type="number"
                                   class="w-32 rounded-md border-gray-300 text-sm @error('remise2') border-red-500 bg-red-100 @enderror"
                                   wire:model.live.debounce.300ms="remise2"
                                   min="0"
                                   step="any">
                        </label>
                        @error('remise2')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                <!-- Bouton Annuler -->
                <a href="{{ route('factures.index') }}" class="bg-red-600 hover:bg-red-700 rounded-lg px-6 py-3 text-white font-semibold transition shadow">
                    {{ __('Annuler') }}
                </a>
            </div>
        </div>
    </form>
</div>