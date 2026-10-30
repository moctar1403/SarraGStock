<x-app-layout>
    @php
        $isRtl = session('locale') === 'ar';
    @endphp
    
    <!-- Conteneur principal avec direction RTL conditionnelle -->
    <div class="py-12" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- 1. MENU LATÉRAL (Toujours en premier dans le code) -->
            <div class="w-full md:w-1/4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sticky top-4">
                    <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2 {{ $isRtl ? 'text-right' : 'text-left' }}">
                        {{ __('📚 Sommaire') }}
                    </h3>
                    
                    <ul class="space-y-2 text-sm {{ $isRtl ? 'text-right' : 'text-left' }}">
                        <li><a href="{{ route('documentation.show', 'user_guide') }}" class="block {{ $current_page == 'user_guide' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('🏠 Accueil (Guide)') }}</a></li>
                        <li class="pt-2 border-t mt-2"><span class="text-xs font-bold text-gray-400">{{ __('DÉMARRAGE') }}</span></li>
                        <li><a href="{{ route('documentation.show', 'demarrage') }}" class="block {{ $current_page == 'demarrage' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __("🚀 Lancer l'application") }}</a></li>
                        <li><a href="{{ route('documentation.show', 'prerequis-client') }}" class="block {{ $current_page == 'prerequis-client' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('💻 Prérequis PC') }}</a></li>
                        <li class="pt-2 border-t mt-2"><span class="text-xs font-bold text-gray-400">{{ __('MODULES') }}</span></li>
                        <li><a href="{{ route('documentation.show', 'articles') }}" class="block {{ $current_page == 'articles' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('📦 Articles & Stock') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'ventes') }}" class="block {{ $current_page == 'ventes' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('🛒 Ventes & Factures') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'achats') }}" class="block {{ $current_page == 'achats' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('🚚 Achats (Entrées)') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'tiers') }}" class="block {{ $current_page == 'tiers' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('🤝 Clients & Fournisseurs') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'tresorerie-clients') }}" class="block {{ $current_page == 'tresorerie-clients' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('💰 Paiements Clients') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'tresorerie-fournisseurs') }}" class="block {{ $current_page == 'tresorerie-fournisseurs' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('💸 Paiements Fournisseurs') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'sorties') }}" class="block {{ $current_page == 'sorties' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('📉 Sorties (Pertes)') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'inventaire') }}" class="block {{ $current_page == 'inventaire' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('📊 Inventaire') }}</a></li>
                        <li class="pt-2 border-t mt-2"><span class="text-xs font-bold text-gray-400">{{ __('CONFIGURATION') }}</span></li>
                        <li><a href="{{ route('documentation.show', 'methodes-paiement') }}" class="block {{ $current_page == 'methodes-paiement' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('⚙️ Méthodes de paiement') }}</a></li>
                        <li><a href="{{ route('documentation.show', 'admin_guide') }}" class="block {{ $current_page == 'admin_guide' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-500' }}">{{ __('🔐 Guide Administrateur') }}</a></li>
                    </ul>
                </div>
            </div>

            <!-- 2. CONTENU (Toujours en second dans le code) -->
            <div class="w-full md:w-3/4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    
                    <div class="mb-6 {{ $isRtl ? 'text-right' : 'text-left' }}">
                        <a href="{{ route('dashboard') }}" class="text-sm text-blue-500 hover:underline">
                            @if($isRtl) 
                                <span class="ml-2">→</span> {{ __('Retour au tableau de bord') }}
                            @else 
                                <span class="mr-2">&larr;</span> {{ __('Retour au tableau de bord') }}
                            @endif
                        </a>
                    </div>

                    <div class="prose prose-blue max-w-none text-gray-700 {{ $isRtl ? 'text-right' : 'text-left' }}">
                        {!! $content !!}
                    </div>

                </div>
            </div>

        </div>
    </div>

    @if($isRtl)
    <style>
        .prose ul { padding-right: 1.5rem !important; padding-left: 0 !important; }
        .prose ol { padding-right: 1.5rem !important; padding-left: 0 !important; }
    </style>
    @endif
</x-app-layout>