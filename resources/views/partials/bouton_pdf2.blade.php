@php
    $itemId = $itemId ?? ($item->id ?? null);
    $type = $type ?? 'pdf';
    $texte = $texte ?? __('PDF');
    $url = $url ?? "/factures/" . $itemId . "/" . $type;
    $couleur = $couleur ?? 'red';
    
    // Mapping des couleurs avec classes statiques
    $classesCouleur = [
        'red' => 'bg-red-500 hover:bg-red-700 focus:ring-red-500',
        'blue' => 'bg-blue-500 hover:bg-blue-700 focus:ring-blue-500',
        'green' => 'bg-green-500 hover:bg-green-700 focus:ring-green-500',
        'orange' => 'bg-orange-500 hover:bg-orange-700 focus:ring-orange-500',
        'purple' => 'bg-purple-500 hover:bg-purple-700 focus:ring-purple-500',
        'gray' => 'bg-gray-500 hover:bg-gray-700 focus:ring-gray-500', // Changé de gray-400 à gray-500
        'pink' => 'bg-pink-500 hover:bg-pink-700 focus:ring-pink-500',
        'indigo' => 'bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500',
        'yellow' => 'bg-yellow-500 hover:bg-yellow-700 focus:ring-yellow-500',
        'teal' => 'bg-teal-500 hover:bg-teal-700 focus:ring-teal-500',
        'cyan' => 'bg-cyan-500 hover:bg-cyan-700 focus:ring-cyan-500',
    ];
    
    $classeCouleur = $classesCouleur[$couleur] ?? $classesCouleur['red'];
@endphp

@if($itemId)
    <button type="button"
            onclick="openDocument('{{ $url }}')"
            class="inline-flex items-center px-3 py-1.5 {{ $classeCouleur }} text-white rounded-md transition-colors duration-150 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        {{ $texte }}
    </button>

    <script>
        function openDocument(url) {
            window.open(url, "_blank", "width=900,height=700");
        }
    </script>
@endif