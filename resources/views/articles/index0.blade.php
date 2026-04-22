<x-app-layout>
    <x-slot name="header">
        <!-- Header vide mais conservé pour la structure -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:liste0-articles />
            </div>
        </div>
    </div>
</x-app-layout>