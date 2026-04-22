<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-8 text-gray-900">
                <h4 class="text-xl font-bold mb-4">{{ __('Création de Permission') }}</h4>
                
                <form method="POST" wire:submit.prevent="store">
                    @csrf
                    @method('post')

                    <!-- Nom Permission -->
                    <div class="p-5 flex flex-col">
                        <label for="name">{{ __('Nom Permission') }}</label>
                        <input type="text"      
                               id="name"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('name') border-red-500 bg-red-100 @enderror"
                               wire:model.live="name"
                               name="name">
                        @error('name')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Boutons d'action -->
                    <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
                        <a href="{{ url('permissions') }}" 
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