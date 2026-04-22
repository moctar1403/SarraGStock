<button type="button" 
        class="text-sm bg-red-500 p-1 text-white rounded-sm" 
        wire:click.prevent="askDelete({{ $item->id }})"
>
    {{ __('Supprimer') }}
</button>
