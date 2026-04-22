<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-8 text-gray-900">
                <h4 class="text-xl font-bold mb-4">{{ __("Création d'utilisateur") }}</h4>
                
                <form method="POST" wire:submit.prevent="store">
                    @csrf
                    @method('post')

                    <!-- Nom utilisateur -->
                    <div class="p-5 flex flex-col">
                        <x-label for="name" value="{{ __('Nom utilisateur') }}" />
                        <input type="text" 
                               id="name"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('name') border-red-500 bg-red-100 @enderror"
                               name="name" 
                               wire:model.live="name">
                        @error('name')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="p-5 flex flex-col">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <input type="email" 
                               id="email"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('email') border-red-500 bg-red-100 @enderror"
                               name="email" 
                               wire:model.live="email">
                        @error('email')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="p-5 flex flex-col">
                        <x-label for="password" value="{{ __('Mot de passe') }}" />
                        <input type="password" 
                               id="password"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('password') border-red-500 bg-red-100 @enderror"
                               name="password" 
                               wire:model.live="password">
                        @error('password')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="p-5 flex flex-col">
                        <x-label for="password_confirmation" value="{{ __('Confirmation mot de passe') }}" />
                        <input type="password" 
                               id="password_confirmation"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('password_confirmation') border-red-500 bg-red-100 @enderror"
                               name="password_confirmation" 
                               wire:model.live="password_confirmation">
                        @error('password_confirmation')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rôles -->
                    <div class="p-5 flex flex-col">
                        <x-label for="roles" value="{{ __('Rôles') }}" />
                        <select id="roles"
                                class="block mt-1 rounded-md border-gray-300 @error('roles') border-red-500 bg-red-100 @enderror"
                                name="roles[]" 
                                wire:model.live="roles" 
                                multiple>
                            <option value="">{{ __('Sélectionner un rôle') }}</option>
                            @foreach ($roles1 as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">{{ __('Maintenez Ctrl pour sélectionner plusieurs rôles') }}</p>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="p-5 flex justify-between items-center bg-gray-100 rounded-b-lg">
                        <a href="{{ url('users') }}" 
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