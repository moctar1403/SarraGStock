<div
    x-data="{ open: false, message: '' }"
    x-on:open-delete-modal.window="
        open = true;
        message = $event.detail.message;
    "
    x-on:close-delete-modal.window="open = false"
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
                wire:click.prevent="delete"
                class="px-4 py-2 bg-red-600 text-white rounded">
                {{ __('Supprimer') }}
            </button>
        </div>
    </div>
</div>