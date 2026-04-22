@php
    $itemId = $itemId ?? ($item->id ?? null);
    $type = $type ?? 'pdf';
    $texte = $texte ?? __('PDF');
    $url = $url ?? "/factures/" . $itemId . "/" . $type;
    
    $couleurs = [
        'rouge' => 'bg-red-500 hover:bg-red-600',
        'bleu' => 'bg-blue-500 hover:bg-blue-600',
        'vert' => 'bg-green-500 hover:bg-green-600',
        'orange' => 'bg-orange-500 hover:bg-orange-600',
        'violet' => 'bg-purple-500 hover:bg-purple-600',
        'gris' => 'bg-gray-500 hover:bg-gray-600',
        'rose' => 'bg-pink-500 hover:bg-pink-600',
        'indigo' => 'bg-indigo-500 hover:bg-indigo-600',
    ];
    
    $couleurChoisie = $couleur ?? 'rouge';
    $classesCouleur = $couleurs[$couleurChoisie] ?? $couleurs['rouge'];
@endphp

@if($itemId)
    <div onclick="openDocument('{{ $url }}')"
         class="inline-flex items-center px-3 py-1.5 {{ $classesCouleur }} text-white rounded-md transition duration-150 cursor-pointer">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        {{ $texte }}
    </div>

    <script>
        function openDocument(url) {
            window.open(url, "_blank", "width=900,height=700");
        }
    </script>
@endif