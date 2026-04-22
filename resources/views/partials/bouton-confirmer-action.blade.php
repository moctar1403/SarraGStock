<button type="button" 
        class="bg-green-600 p-3 rounded-sm text-white text-sm" 
        wire:click.prevent="{{ $action }}"
>
    {{ $label ?? __('Confirmer') }}
</button>