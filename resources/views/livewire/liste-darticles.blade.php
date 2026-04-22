<div class="mt-5">
    {{-- En-tête avec recherche et actions --}}
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-4">
        <div class="flex justify-between items-center p-2">
            {{-- Barre de recherche --}}
            <div class="w-1/3">
                <input type="text" 
                       class="block mt-1 rounded-md border-gray-300 w-full" 
                       placeholder="{{ __('Rechercher') }}"
                       wire:model.live="search">
            </div>
        </div>
        
        {{-- Actions principales --}}
        @can('create article')
            <div class="flex flex-wrap gap-2 p-2">
                @include('partials.bouton_ajouter', [
                    'url' => route('darticles.create'),
                    'texte' => __('Ajouter un article de détail'),
                    'couleur' => 'blue',
                    'icone' => false,
                ])
            </div>
        @endcan
    </div>

    {{-- Tableau des données --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="py-4 inline-block min-w-full">
                <div class="overflow-hidden">
                    <table class="min-w-full text-center">
                        {{-- En-tête du tableau --}}
                        <thead class="border-b bg-gray-50">
                            <tr style="vertical-align:middle">
                                <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Id') }}</th>
                                <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Article principal') }}</th>
                                <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Article de détail') }}</th>
                                <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Qté Article de détail/Article principal') }}</th>
                                <th class="text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        {{-- Corps du tableau --}}
                        <tbody>
                            @forelse ($darticles as $item)
                                @php
                                    $articlePrincipal = App\Models\Article::find($item->dar_principal);
                                    $articleDetail = App\Models\Article::find($item->dar_detail);
                                @endphp

                                <tr class="border-b-2 border-gray-100 hover:bg-gray-50" style="vertical-align:middle">
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        {{ $articlePrincipal->ar_lib ?? __('Non défini') }}
                                    </td>
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        {{ $articleDetail->ar_lib ?? __('Non défini') }}
                                    </td>
                                    <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                        <span class="number-cell">{!! format_number($item->dar_qte) !!}</span>
                                    </td>
                                    <td class="text-sm font-medium text-center whitespace-nowrap">
                                        <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                            @can('delete darticle')
                                                @include('partials.boutton_supprimer')
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="flex flex-col items-center justify-center">
                                            <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                            <p class="text-gray-500">{{ __('Aucun élément trouvé!') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $darticles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>