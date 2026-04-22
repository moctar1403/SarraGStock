{{-- Liste des dépendances CSS --}}
@push('styles')
    <link href="{{ asset('css/livewire/liste-permission.css') }}" rel="stylesheet">
@endpush

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
            {{-- En-tête avec recherche et actions --}}
            <div class="px-2 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ __('Gestion des Permissions') }}</h2>
                        <p class="text-sm text-gray-600 mt-1">{{ __('Gérez les permissions de votre application') }}</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        {{-- Barre de recherche --}}
                        <div class="relative flex-1 md:w-64">
                            <input type="text" 
                                   class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="{{ __('Rechercher une permission...') }}"
                                   wire:model.live.debounce.300ms="search">
                            
                            {{-- Icône recherche --}}
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            
                            {{-- Bouton effacer --}}
                            @if($search)
                                <button wire:click="$set('search', '')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                        
                        {{-- Bouton Ajouter --}}
                        @can('create permission')
                            @include('partials.bouton_ajouter', [
                                'url' => route('permissions.create'),
                                'texte' => __('Ajouter Permission'),
                                'couleur' => 'blue',
                                'icone' => true,
                            ])
                        @endcan
                    </div>
                </div>
                
                {{-- Informations de recherche --}}
                @if($search)
                    <div class="mt-3 flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            {{ __('Résultats pour') }} : 
                            <span class="font-semibold text-blue-600">{{ $search }}</span>
                            <span class="ml-2 text-gray-500">
                                ({{ $permissions->total() }} {{ __('résultat(s)') }})
                            </span>
                        </p>
                        <button wire:click="$set('search', '')" 
                                class="text-sm text-blue-500 hover:text-blue-700">
                            {{ __('Effacer la recherche') }}
                        </button>
                    </div>
                @endif
            </div>

            {{-- Actions groupées --}}
            @if(count($selectedPermissions) > 0)
                <div class="px-2 py-3 bg-blue-50 border-b border-blue-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-700">
                                {{ count($selectedPermissions) }} {{ __('permission(s) sélectionnée(s)') }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            @can('delete permission')
                                <button wire:click="deleteSelected"
                                        wire:confirm="{{ __('Êtes-vous sûr de vouloir supprimer ces permissions ?') }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    {{ __('Supprimer la sélection') }}
                                </button>
                            @endcan
                            
                            <button wire:click="$set('selectedPermissions', [])"
                                    class="inline-flex items-center px-3 py-1.5 bg-gray-600 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Annuler') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tableau des permissions --}}
            <div class="overflow-x-auto permissions-table-container">
                <table class="min-w-full divide-y divide-gray-200 permissions-table">
                    {{-- En-tête du tableau --}}
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           wire:model.live="selectAll"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded permission-checkbox">
                                    <span class="ml-2">{{ __('ID') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Nom de la Permission') }}
                            </th>
                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>

                    {{-- Corps du tableau --}}
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($permissions as $item)
                            <tr class="hover:bg-gray-50 transition duration-150 permission-row {{ in_array($item->id, $selectedPermissions) ? 'permission-row-selected' : '' }}">
                                <td class="px-2 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               wire:model.live="selectedPermissions"
                                               value="{{ $item->id }}"
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded permission-checkbox">
                                        <span class="ml-3 text-sm font-medium text-gray-900">
                                            #{{ $item->id }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-2 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center bg-blue-100 rounded-md">
                                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                @if($search && stripos($item->name, $search) !== false)
                                                    @php
                                                        $parts = preg_split('/(' . preg_quote($search, '/') . ')/i', $item->name, -1, PREG_SPLIT_DELIM_CAPTURE);
                                                    @endphp
                                                    @foreach($parts as $part)
                                                        @if(strtolower($part) === strtolower($search))
                                                            <span class="search-highlight">{{ $part }}</span>
                                                        @else
                                                            {{ $part }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {{ $item->name }}
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ __('Créée le') }} {{ $item->created_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3 action-buttons">
                                        @can('update permission')
                                            @include('partials.boutton_modifier', [
                                                'url' => route('permissions.edit', $item->id)
                                            ])
                                        @endcan
                                        
                                        @can('delete permission')
                                            @include('partials.boutton_supprimer')
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-2 py-12 text-center empty-state">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4 empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Aucune permission trouvée') }}</h3>
                                        <p class="text-gray-500 mb-4">
                                            @if($search)
                                                {{ __('Aucune permission ne correspond à votre recherche') }} "<span class="font-semibold">{{ $search }}</span>"
                                            @else
                                                {{ __('Aucune permission n\'a été créée pour le moment') }}
                                            @endif
                                        </p>
                                        
                                        @if($search)
                                            <button wire:click="$set('search', '')" 
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                                {{ __('Afficher toutes les permissions') }}
                                            </button>
                                        @else
                                            @can('create permission')
                                                @include('partials.bouton_ajouter', [
                                                    'url' => route('permissions.create'),
                                                    'texte' => __('Créer votre première permission'),
                                                    'couleur' => 'blue',
                                                    'icone' => true,
                                                ])
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Pagination --}}
                @if($permissions->hasPages())
                    <div class="px-2 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                {{ __('Affichage de') }}
                                <span class="font-medium">{{ $permissions->firstItem() }}</span>
                                {{ __('à') }}
                                <span class="font-medium">{{ $permissions->lastItem() }}</span>
                                {{ __('sur') }}
                                <span class="font-medium">{{ $permissions->total() }}</span>
                                {{ __('résultats') }}
                            </div>
                            <div class="livewire-pagination">
                                {{ $permissions->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Statistiques --}}
            <div class="px-2 py-4 border-t border-gray-200 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 stats-cards">
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200 stats-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-100 rounded-md">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-10a6.5 6.5 0 01-1.029 3.5m0 0A6.5 6.5 0 0112 3.5c-2.172 0-4.13.923-5.5 2.396m13.286 5.714a6.5 6.5 0 01-5.286 2.714" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">{{ __('Total Permissions') }}</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $permissions->total() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200 stats-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-md">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">{{ __('Sélectionnées') }}</p>
                                <p class="text-2xl font-bold text-gray-900">{{ count($selectedPermissions) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200 stats-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-purple-100 rounded-md">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">{{ __('Recherche active') }}</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $search ? __('Oui') : __('Non') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>