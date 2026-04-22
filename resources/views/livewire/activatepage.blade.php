<div class="p-2 bg-white shadow-sm">
    <h2 class="text-2xl font-bold mb-4 text-center">{{ __('Activation de la licence') }}</h2>
    
    <form method="POST" action="{{ route('activation.submit') }}">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{{ __('Clé de licence') }}" />
            <input type="text"
                name="license_key"
                pattern="[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}"
                title="Format: XXXX-XXXX-XXXX"
                placeholder="Ex: AB3F-1C2D-9E4F" 
                required
                class="block mt-1 rounded-md border-gray-300 w-full @error('license_key') border-red-500 bg-red-100 @enderror"
                value="{{ old('license_key') }}">
            @error('license_key')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div> 
        
        <div class="p-5 flex justify-between items-center bg-gray-100">
            <a href="{{ route('activation.form') }}" class="bg-red-600 rounded-md p-2 text-sm text-white">
                {{ __('Annuler') }}
            </a>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">
                {{ __('Activer') }}
            </button>
        </div>
    </form>
</div>