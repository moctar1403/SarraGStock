@php
    $itemId = $itemId ?? ($item->id ?? null);
    $texte = $texte ?? __('Détails');
    $couleur = $couleur ?? 'green';
    $methode = $methode ?? 'detail'; // Nom de la méthode Livewire à appeler
    $component = $component ?? null; // Pour cibler un composant spécifique (optionnel)
    
    // Mapping des couleurs avec classes statiques
    $classesCouleur = [
        'red' => 'bg-red-500 hover:bg-red-700 focus:ring-red-500',
        'blue' => 'bg-blue-500 hover:bg-blue-700 focus:ring-blue-500',
        'green' => 'bg-green-500 hover:bg-green-700 focus:ring-green-500',
        'orange' => 'bg-orange-500 hover:bg-orange-700 focus:ring-orange-500',
        'purple' => 'bg-purple-500 hover:bg-purple-700 focus:ring-purple-500',
        'gray' => 'bg-gray-500 hover:bg-gray-700 focus:ring-gray-500',
        'pink' => 'bg-pink-500 hover:bg-pink-700 focus:ring-pink-500',
        'indigo' => 'bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500',
        'yellow' => 'bg-yellow-500 hover:bg-yellow-700 focus:ring-yellow-500',
        'teal' => 'bg-teal-500 hover:bg-teal-700 focus:ring-teal-500',
        'cyan' => 'bg-cyan-500 hover:bg-cyan-700 focus:ring-cyan-500',
    ];
    
    $classeCouleur = $classesCouleur[$couleur] ?? $classesCouleur['green'];
    
    // Icône pour les détails (œil)
    $icone = $icone ?? true;
    
    // Construction de l'appel Livewire
    if ($component) {
        // Pour cibler un composant spécifique avec wire:key
        $wireClick = "\$dispatch('" . $component . "', { id: " . $itemId . " })";
    } else {
        // Appel direct de la méthode dans le composant courant
        $wireClick = $methode . "(" . $itemId . ")";
    }
@endphp

@if($itemId)
    <a href="#" 
       wire:click.prevent="{{ $wireClick }}"
       class="inline-flex items-center px-3 py-1.5 {{ $classeCouleur }} text-white rounded-md transition-colors duration-150 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2">
        @if($icone)
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        @endif
        {{ $texte }}
    </a>
@endif
