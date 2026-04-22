<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-4">
            {{-- Bouton Imprimer --}}
            <div>
                <button onclick="openPrint({{ $facture->id }})"
                        class="text-sm bg-cyan-500 hover:bg-cyan-600 px-3 py-2 text-white rounded-md transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    {{ __('Imprimer') }}
                </button>
            </div>

            {{-- Bouton PDF --}}
            <div>
                <button onclick="openPdf({{ $facture->id }})"
                        class="text-sm bg-cyan-500 hover:bg-cyan-600 px-3 py-2 text-white rounded-md transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __('PDF') }}
                </button>
            </div>

            {{-- Bouton Retour --}}
            <div>
                <a href="{{ route('factures.index') }}" 
                   class="text-sm bg-cyan-500 hover:bg-cyan-600 px-3 py-2 text-white rounded-md inline-block transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Retour') }}
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Scripts pour l'impression et le PDF --}}
    <script>
        function openPrint(id) {
            window.open("/factures/" + id + "/print", "_blank", "width=900,height=700");
        }
        
        function openPdf(id) {
            window.open("/factures/" + id + "/pdf", "_blank", "width=900,height=700");
        }
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('print-facture', ['facture' => $facture])
            </div> 
        </div>
    </div>
</x-app-layout>