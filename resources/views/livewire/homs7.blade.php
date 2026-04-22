<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
    <div class="flex flex-col items-center space-y-4">
        {{-- Message d'erreur --}}
        <div class="bg-red-50 rounded-lg p-4 text-center">
            <svg class="w-16 h-16 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-red-600 font-medium">
                {{ __("Vous n'avez pas l'autorisation ici") }}
            </p>
        </div>

        {{-- Boutons d'action --}}
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('dashboard') }}"  
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-sm text-white transition">
                <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __("Page d'accueil") }}
            </a>
            
            <a href="{{ $previous }}"  
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-md text-sm text-white transition">
                <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Retour') }}
            </a>
        </div>
    </div>
</div>