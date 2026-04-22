@php
    // Valeurs par défaut
    $url = $url ?? '#';
    $texte = $texte ?? __('Ajouter');
    $couleur = $couleur ?? 'blue';
    
    // Mapping des couleurs (version claire avec bg-*-100 et text-*-700)
    $classesCouleur = [
        'red' => 'bg-red-100 text-red-700 hover:bg-red-200 focus:ring-red-500',
        'blue' => 'bg-blue-100 text-blue-700 hover:bg-blue-200 focus:ring-blue-500',
        'green' => 'bg-green-100 text-green-700 hover:bg-green-200 focus:ring-green-500',
        'orange' => 'bg-orange-100 text-orange-700 hover:bg-orange-200 focus:ring-orange-500',
        'purple' => 'bg-purple-100 text-purple-700 hover:bg-purple-200 focus:ring-purple-500',
        'gray' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500',
        'pink' => 'bg-pink-100 text-pink-700 hover:bg-pink-200 focus:ring-pink-500',
        'indigo' => 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200 focus:ring-indigo-500',
        'yellow' => 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200 focus:ring-yellow-500',
        'teal' => 'bg-teal-100 text-teal-700 hover:bg-teal-200 focus:ring-teal-500',
        'cyan' => 'bg-cyan-100 text-cyan-700 hover:bg-cyan-200 focus:ring-cyan-500',
    ];
    
    $classeCouleur = $classesCouleur[$couleur] ?? $classesCouleur['green'];
    
    // Icône pour l'ajout (optionnelle)
    $icone = $icone ?? true;
    
    // Support pour Livewire (optionnel)
    $wireClick = $wireClick ?? null;
    $component = $component ?? null;
    $itemId = $itemId ?? null;
    
    // Construction de l'appel Livewire si nécessaire
    if ($component && $itemId) {
        $wireClick = "\$dispatch('" . $component . "', { id: " . $itemId . " })";
    }
@endphp

<a href="{{ $url }}"
   @if($wireClick) wire:click.prevent="{{ $wireClick }}" @endif
   class="inline-flex items-center px-3 py-1.5 {{ $classeCouleur }} rounded-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 action-badge">
    @if($icone)
    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    @endif
    {{ $texte }}
</a>