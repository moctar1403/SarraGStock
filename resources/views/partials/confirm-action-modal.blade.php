<div
    x-data="{ open: false, message: '' }"
    x-on:open-action-modal.window="
        open = true;
        message = $event.detail.message;
    "
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4" x-text="message"></h2>

        <div class="flex justify-end gap-2">
            <button
                type="button"
                class="px-4 py-2 bg-gray-300 rounded"
                @click="open = false">
                {{ __('Annuler') }}
            </button>

            <button
                type="button"
                wire:click.prevent="confirmStore"
                class="px-4 py-2 bg-green-600 text-white rounded">
                {{ __('Confirmer') }}
            </button>
        </div>
    </div>
</div>