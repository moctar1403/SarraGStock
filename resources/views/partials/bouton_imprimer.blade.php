@if(!isset($itemId))
    @php $itemId = null @endphp
@endif

@if(!isset($texte))
    @php $texte = __('Imprimer') @endphp
@endif

@if(!isset($classes))
    @php $classes = '' @endphp
@endif

<div onclick="openPrint({{ $itemId }})"
     class="inline-flex items-center px-3 py-1.5 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition duration-150 cursor-pointer action-badge {{ $classes }}">
    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
    </svg>
    {{ $texte }}
</div>