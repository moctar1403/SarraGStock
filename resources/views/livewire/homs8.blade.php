<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
    <div class="flex flex-col items-center space-y-4">
        {{-- Message d'erreur --}}
        <div class="bg-yellow-50 rounded-lg p-4 text-center">
            <svg class="w-16 h-16 text-yellow-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-yellow-600 font-medium">
                {{ __("Le lien n'est pas valable") }}
            </p>
        </div>

        {{-- Bouton d'action --}}
        <div>
            <a href="{{ route('dashboard') }}"  
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-sm text-white transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __("Page d'accueil") }}
            </a>
        </div>
    </div>
</div>