@if(!isset($url))
    @php $url = '#' @endphp
@endif

@if(!isset($texte))
    @php $texte = __('Ajouter') @endphp
@endif

<a href="{{ $url }}"
   class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition duration-150 action-badge">
    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    {{ $texte }}
</a>