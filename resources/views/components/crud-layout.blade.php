{{-- resources/views/components/crud-layout.blade.php --}}
@props([
    'title' => '',
    'subtitle' => '',
    'searchPlaceholder' => 'Rechercher...',
    'addRoute' => null,
    'addLabel' => 'Ajouter',
    'canCreate' => false,
    'stats' => [],
    'searchInfo' => null,
    'selectedCount' => 0,
    'onDeleteSelected' => null,
    'onCancelSelection' => null,
    'deleteConfirmMessage' => 'Êtes-vous sûr de vouloir supprimer ces éléments ?',
    'showSearch' => true,
    'showStats' => true,
])

{{-- Styles CSS --}}
@push('styles')
<link href="{{ asset('css/components/crud-layout.css') }}" rel="stylesheet">
@endpush

<div class="crud-container">
    {{-- En-tête --}}
    <div class="crud-header">
        <div class="header-content">
            <h1 class="crud-title">{{ __($title) }}</h1>
            @if($subtitle)
                <p class="crud-subtitle">{{ __($subtitle) }}</p>
            @endif
        </div>
        
        @if($showSearch || ($addRoute && $canCreate))
        <div class="header-actions">
            @if($showSearch)
            <div class="search-container">
                <div class="relative search-wrapper">
                    <input type="text" 
                           class="search-input" 
                           placeholder="{{ __($searchPlaceholder) }}"
                           wire:model.live.debounce.300ms="search">
                    
                    <div class="search-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    
                    @if($search)
                    <button wire:click="$set('search', '')" class="clear-search-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
            @endif
            
            @if($addRoute && $canCreate)
            <a href="{{ $addRoute }}" class="add-btn">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __($addLabel) }}
            </a>
            @endif
        </div>
        @endif
    </div>
    
    {{-- Informations de recherche --}}
    @if($search && $searchInfo)
    <div class="search-info">
        <p>{{ $searchInfo }}</p>
        <button wire:click="$set('search', '')" class="text-link">
            {{ __('Effacer la recherche') }}
        </button>
    </div>
    @endif
    
    {{-- Actions de sélection --}}
    @if($selectedCount > 0 && $onDeleteSelected && $onCancelSelection)
    <div class="selection-actions">
        <div class="selection-info">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $selectedCount }} {{ __('élément(s) sélectionné(s)') }}</span>
        </div>
        <div class="selection-buttons">
            <button wire:click="{{ $onDeleteSelected }}"
                    wire:confirm="{{ __($deleteConfirmMessage) }}"
                    class="delete-selected-btn">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                {{ __('Supprimer la sélection') }}
            </button>
            <button wire:click="{{ $onCancelSelection }}" class="cancel-selection-btn">
                {{ __('Annuler') }}
            </button>
        </div>
    </div>
    @endif
    
    {{-- Statistiques --}}
    @if($showStats && !empty($stats))
    <div class="stats-grid">
        @foreach($stats as $index => $stat)
        <div class="stat-card stat-{{ $stat['color'] ?? 'gray' }}">
            <div class="stat-icon">
                {!! $stat['icon'] ?? '' !!}
            </div>
            <div class="stat-content">
                <p class="stat-label">{{ __($stat['label']) }}</p>
                <p class="stat-value">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
    {{-- Contenu principal --}}
    {{ $slot }}
</div>