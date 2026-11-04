<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Gestion des Catégories') }}</h2>

            {{-- Messages Flash --}}
            @if (session()->has('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if (session()->has('danger'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('danger') }}</div>
            @endif

            {{-- Formulaire --}}
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <form wire:submit.prevent="save" class="flex items-center gap-4">
                    <div class="flex-1">
                        <input type="text" wire:model="nom" class="w-full rounded-md border-gray-300" placeholder="{{ __('Nom de la catégorie') }}">
                        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        {{ $isEditing ? __('Modifier') : __('Ajouter') }}
                    </button>
                    @if($isEditing)
                        <button type="button" wire:click="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            {{ __('Annuler') }}
                        </button>
                    @endif
                </form>
            </div>

            {{-- Tableau --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-center">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Nom') }}</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Nombre d\'articles') }}</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Statut') }}</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            @php
                                $isFige = in_array($cat->nom, $categoriesFigees);
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm font-bold text-gray-800">{{ $cat->nom }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $cat->articles_count }}</td>
                                <td class="px-4 py-2">
                                    @if($isFige)
                                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">🔒 {{ __('Fige') }}</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ __('Modifiable') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{-- On n'affiche les boutons QUE si ce n'est pas figé --}}
                                    @if(!$isFige)
                                        <button wire:click="edit({{ $cat->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">✏️</button>
                                        <button wire:click="askDelete({{ $cat->id }})" class="bg-red-500 text-white px-2 py-1 rounded text-xs">🗑️</button>
                                    @else
                                        <span class="text-xs text-gray-400">{{ __('Action impossible') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>