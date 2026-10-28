<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Menu latéral de la documentation -->
            <div class="w-full md:w-1/4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sticky top-4">
                    <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">📚 Sommaire</h3>
                    
                    <ul class="space-y-2 text-sm">
                        <!-- Accueil -->
                        <li>
                            <a href="{{ route('documentation.show', 'user_guide') }}" 
                               class="{{ $current_page == 'user_guide' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                🏠 Accueil (Guide)
                            </a>
                        </li>

                        <!-- Démarrage -->
                        <li class="pt-2 border-t mt-2"><span class="text-xs font-bold text-gray-400">DÉMARRAGE</span></li>
                        <li>
                            <a href="{{ route('documentation.show', 'demarrage') }}" 
                               class="{{ $current_page == 'demarrage' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                🚀 Lancer l'application
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'prerequis-client') }}" 
                               class="{{ $current_page == 'prerequis-client' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                💻 Prérequis PC
                            </a>
                        </li>

                        <!-- Modules -->
                        <li class="pt-2 border-t mt-2"><span class="text-xs font-bold text-gray-400">MODULES</span></li>
                        <li>
                            <a href="{{ route('documentation.show', 'articles') }}" 
                               class="{{ $current_page == 'articles' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                📦 Articles & Stock
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'ventes') }}" 
                               class="{{ $current_page == 'ventes' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                🛒 Ventes & Factures
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'achats') }}" 
                               class="{{ $current_page == 'achats' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                🚚 Achats (Entrées)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'tiers') }}" 
                               class="{{ $current_page == 'tiers' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                🤝 Clients & Fournisseurs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'tresorerie-clients') }}" 
                               class="{{ $current_page == 'tresorerie-clients' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                💰 Paiements Clients
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'tresorerie-fournisseurs') }}" 
                               class="{{ $current_page == 'tresorerie-fournisseurs' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                💸 Paiements Fournisseurs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'sorties') }}" 
                               class="{{ $current_page == 'sorties' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                📉 Sorties (Pertes)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'inventaire') }}" 
                               class="{{ $current_page == 'inventaire' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                📊 Inventaire
                            </a>
                        </li>

                        <!-- Configuration et Administration -->
                        <li class="pt-2 border-t mt-2"><span class="text-xs font-bold text-gray-400">CONFIGURATION</span></li>
                        <li>
                            <a href="{{ route('documentation.show', 'methodes-paiement') }}" 
                               class="{{ $current_page == 'methodes-paiement' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                ⚙️ Méthodes de paiement
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('documentation.show', 'admin_guide') }}" 
                               class="{{ $current_page == 'admin_guide' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">
                                🔐 Guide Administrateur
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contenu de la documentation -->
            <div class="w-full md:w-3/4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    
                    <!-- Bouton retour au dashboard -->
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}" class="text-sm text-blue-500 hover:underline">&larr; Retour au tableau de bord</a>
                    </div>

                    <!-- Contenu Markdown converti -->
                    <div class="prose prose-blue max-w-none text-gray-700">
                        {!! $content !!}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>