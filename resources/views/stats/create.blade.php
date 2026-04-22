<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Créer un utilisateur') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2 bg-white shadow-sm">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        @method('post')
        @if (Session::get('error'))
            <div class="p-5">
                <div class="p-4 border-red-500 bg-red-400 animate-bounce text-white">{{ Session::get('error') }}</div>
            </div>
        @endif
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Nom') }}" />
            <input type="text"
                class="block mt-1 rounded-md border-gray-300 w-1/2 @error('name')
            border-red-500 bg-red-100 animate-bounce
        @enderror"
                wire:model="name" name="name">
            @error('name')
                <div class="text text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Email') }}" />
            <input type="email"
                class="block mt-1 rounded-md border-gray-300 w-1/2 @error('email')
            border-red-500 bg-red-100 animate-bounce
        @enderror"
                wire:model="email" name="email">
            @error('email')
                <div class="text text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Mot de passe') }}" />
            <input type="password"
                class="block mt-1 rounded-md border-gray-300 w-1/2 @error('password')
            border-red-500 bg-red-100 animate-bounce
        @enderror"
                wire:model="password" name="password">
            @error('password')
                <div class="text text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Verification Mot de passe') }}" />
            <input type="password"
                class="block mt-1 rounded-md border-gray-300 w-1/2 @error('password_confirmation')
            border-red-500 bg-red-100 animate-bounce
        @enderror"
                wire:model="password_confirmation" name="password_confirmation">
            @error('password_confirmation')
                <div class="text text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
        <div class="p-5 flex justify-between items-center bg-gray-100">
            <a href="{{ route('articles.index') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                {{ __('Annuler') }}</a>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">Ajouter</button>
        </div>


    </form>
</div>          
            </div> 
        </div>
    </div>
</x-app-layout>
