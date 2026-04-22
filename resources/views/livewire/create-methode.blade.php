<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-8 text-gray-900">
                <h4 class="text-xl font-bold mb-4">{{ __('Créer une méthode de paiement') }}</h4>
                
                <form method="POST" wire:submit.prevent="store">
                    @csrf
                    @method('post')

                    <!-- Nom -->
                    <div class="p-5 flex flex-col">
                        <label for="meth_nom">{{ __('Nom') }}</label>
                        <input type="text" 
                               id="meth_nom"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('meth_nom') border-red-500 bg-red-100 @enderror"
                               name="meth_nom"
                               wire:model.live="meth_nom">
                        @error('meth_nom')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="p-5 flex flex-col">
                        <label for="meth_tel">{{ __('Téléphone') }}</label>
                        <input type="text" 
                               id="meth_tel"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('meth_tel') border-red-500 bg-red-100 @enderror"
                               name="meth_tel"
                               wire:model.live="meth_tel">
                        @error('meth_tel')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active -->
                    <div class="p-5 flex flex-col">
                        <label for="meth_active" class="flex items-center gap-2">
                            <input type="checkbox" 
                                   id="meth_active"
                                   class="rounded-md border-gray-300" 
                                   name="meth_active"
                                   wire:model.live="meth_active">
                            <span>{{ __('Active') }}</span>
                        </label>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
                        <a href="{{ route('methodes.index') }}" 
                           class="bg-red-500 hover:bg-red-600 rounded-md px-4 py-2 text-white transition">
                            {{ __('Retour') }}
                        </a>
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md text-white text-sm transition">
                            {{ __('Sauvegarder') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>