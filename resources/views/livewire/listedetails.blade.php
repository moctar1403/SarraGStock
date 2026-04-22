<div class="mt-5">
    {{-- En-tête avec recherche et actions --}}
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-4">
        {{-- Actions principales --}}
        @can('create article')
            <div class="flex flex-wrap gap-2 p-2">
                @include('partials.bouton_ajouter', [
                    'url' => route('listedetails.operation'),
                    'texte' => __('Liste des opérations de détail'),
                    'couleur' => 'blue',
                    'icone' => false,
                ])

                @include('partials.bouton_ajouter', [
                    'url' => route('darticles.index'),
                    'texte' => __('Liste des articles détaillables'),
                    'couleur' => 'blue',
                    'icone' => false,
                ])
            </div>
        @endcan
    </div>
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>