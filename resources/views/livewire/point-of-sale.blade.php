<div class="h-screen flex bg-gray-100">
    <!-- Partie Gauche : Grille des produits -->
    <div class="w-2/3 p-4 overflow-y-auto">
        
        <!-- En-tête avec bascule et recherche rapide -->
        <div class="mb-6">
            <!-- 1. Ligne des onglets Resto / Stock -->
            <div class="flex space-x-2 mb-4">
                <button wire:click="$set('type_vente', 'resto')" 
                        class="px-4 py-2 rounded-lg font-bold shadow-sm transition {{ $type_vente === 'resto' ? 'bg-orange-600 text-white ring-2 ring-orange-300' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    🍽️ Restaurant
                </button>
                <button wire:click="$set('type_vente', 'stock')" 
                        class="px-4 py-2 rounded-lg font-bold shadow-sm transition {{ $type_vente === 'stock' ? 'bg-blue-600 text-white ring-2 ring-blue-300' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    📦 Articles de Stock
                </button>
            </div>

            <!-- 2. Ligne de recherche rapide et boutons d'action -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Recherche rapide en temps réel -->
                <div class="flex-1 w-full max-w-lg relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="code_barre" 
                           class="w-full rounded-md border-gray-300 pl-10 pr-10 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="{{ __('Scanner ou taper un code-barres / référence...') }}">
                    
                    <!-- Icône Loupe -->
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Bouton Effacer (croix) -->
                    @if(!empty($code_barre))
                        <button wire:click="$set('code_barre', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Boutons d'action (Historique / Clôture) -->
                <div class="flex space-x-2">
                    <a href="{{ route('caisse.liste') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow text-sm font-bold transition">
                        {{ __('Historique') }}
                    </a>
                    <a href="{{ route('caisse.cloturer') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow text-sm font-bold transition">
                        {{ __('Clôturer') }}
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Messages Flash -->
        @if (session()->has('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4 shadow">{{ session('success') }}</div>
        @endif
        @if (session()->has('danger'))
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4 shadow">{{ session('danger') }}</div>
        @endif

        <!-- Grille des Catégories et Articles -->
        <div class="space-y-8">
            @forelse($categories as $categorie)
                @if($categorie->articles->count() > 0)
                    <div>
                        <h3 class="text-xl font-bold text-gray-700 mb-3 border-b-2 border-gray-300 pb-2">
                            {{ $categorie->nom }}
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($categorie->articles as $article)
                                <button wire:click="addToCart({{ $article->id }})" 
                                        class="bg-white p-4 rounded-lg shadow hover:bg-blue-50 flex flex-col items-center justify-center h-32 border-2 border-transparent hover:border-blue-500 transition">
                                    <span class="font-bold text-gray-800 text-center">{{ $article->ar_lib }}</span>
                                    <span class="text-blue-600 font-semibold mt-2">{!! format_number($article->ar_prix_vente) !!}</span>
                                    
                                    {{-- On affiche le stock uniquement pour les articles de stock --}}
                                    @if($article->gerer_stock)
                                        <span class="text-xs text-gray-500 mt-1">Stock: {!! format_number($article->ar_qte) !!}</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center text-gray-400 mt-10">
                    <p>Aucun article trouvé.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Partie Droite : Ticket et Paiement -->
    <div class="w-1/3 bg-white shadow-xl flex flex-col h-full border-l border-gray-200">
        
        <!-- En-tête Ticket -->
        <div class="p-4 bg-gray-800 text-white">
            <h3 class="text-lg font-bold">Ticket de Caisse</h3>
            <p class="text-sm">Caissier : {{ Auth::user()->name }}</p>
        </div>

        <!-- Liste du Panier -->
        <div class="flex-1 overflow-y-auto p-4">
            @forelse($panier as $id => $item)
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <div>
                        <p class="font-bold text-sm">{{ $item['nom'] }}</p>
                        <p class="text-xs text-gray-500">{!! format_number($item['prix']) !!} x {{ $item['quantite'] }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button wire:click="removeFromCart({{ $id }})" class="bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold">-</button>
                        <span class="font-bold text-sm">{!! format_number($item['prix'] * $item['quantite']) !!}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 mt-10">
                    <p>Le panier est vide</p>
                </div>
            @endforelse
        </div>

        <!-- Formulaire de Paiement et Totaux -->
        <div class="p-4 bg-gray-50 border-t">
            
            <!-- Méthode de paiement -->
            <div class="mb-3">
                <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Méthode de Paiement') }}</label>
                <select wire:model.live="paiement_id" class="w-full rounded-md border-gray-300 text-sm shadow-sm">
                    <option value="0">Choisir...</option>
                    @foreach ($methodesList as $item)
                        <option value="{{ $item->id }}">{{ __($item->meth_nom) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- NOUVEAU : Recherche Rapide Client (disponible tout le temps) -->
            <div class="mb-3 bg-white p-2 border rounded border-gray-200">
                <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Recherche Client Rapide (Tél/Email)') }}</label>
                <input type="text" 
                       wire:model.live.debounce.400ms="recherche_client" 
                       class="w-full rounded-md border-gray-300 text-sm shadow-sm" 
                       placeholder="Ex: 22334455...">
                
                @if($client)
                    <div class="mt-1 text-xs text-green-600 font-bold">
                        ✔ {{ $client->cli_nom }}
                    </div>
                @elseif(!empty($recherche_client))
                    <div class="mt-1 text-xs text-red-500">
                        Aucun client trouvé.
                    </div>
                @endif
            </div>

            <!-- Client (si crédit) -->
            @if($meth_credit && $paiement_id == $meth_credit->id)
                <div class="mb-3">
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Client (Obligatoire pour crédit)') }}</label>
                    <select wire:model.live="client_id" class="w-full rounded-md border-gray-300 text-sm shadow-sm">
                        <option value="0">Choisir...</option>
                        @foreach ($clientsList as $item)
                            <option value="{{ $item->id }}">{{ $item->cli_nom }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Remise -->
            <div class="mb-3">
                @if ($compteur_remise == 0)
                    <button type="button" wire:click.prevent="clickRemise1()" class="text-xs text-blue-600 hover:underline">
                        + {{ __('Accorder une remise') }}
                    </button>
                @else
                    <button type="button" wire:click.prevent="clickRemise2()" class="text-xs text-red-600 hover:underline">
                        - {{ __('Supprimer la remise') }}
                    </button>
                    
                    <div class="flex flex-col space-y-2 mt-2 bg-white p-2 border rounded">
                        <label class="flex items-center">
                            <input type="radio" value="1" wire:model.live="receiveRemise" class="mr-2">
                            <span class="text-xs mr-2">Taux %</span>
                            <input type="number" wire:model.live.debounce.300ms="remise" class="w-full rounded-md border-gray-300 text-sm" min="0" max="100" step="0.01">
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" value="0" wire:model.live="receiveRemise" class="mr-2">
                            <span class="text-xs mr-2">Montant</span>
                            <input type="number" wire:model.live.debounce.300ms="remise2" class="w-full rounded-md border-gray-300 text-sm" min="0" step="any">
                        </label>
                    </div>
                @endif
            </div>

            <hr class="my-2">

            <!-- Totaux -->
            <div class="flex justify-between text-lg font-bold mb-1">
                <span>TOTAL</span>
                <span class="text-green-600">{!! format_number($total_vente) !!}</span>
            </div>
            
            @if($compteur_remise > 0)
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Remise</span>
                    <span>- {!! format_number($mremise) !!}</span>
                </div>
                <div class="flex justify-between text-xl font-bold mb-3">
                    <span>{{ __('Net à payer') }}</span>
                    <span class="text-green-600">{!! format_number($total_vente_apres_remise) !!}</span>
                </div>
            @endif

            <button wire:click="validerVente" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg text-lg transition mt-2 shadow-md">
                {{ __('VALIDER LA VENTE') }}
            </button>
        </div>
    </div>
</div>