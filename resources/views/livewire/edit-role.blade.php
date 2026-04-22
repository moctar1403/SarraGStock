<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-8 text-gray-900">
                <h4>{{ __('Editer') }} Role {{$role->id}}</h4>
                <form method="POST" action="{{ url('roles/'.$role->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-5 flex flex-col">
                        <label for="name">{{ __('Nom') }}</label>
                        <input type="text" 
                               id="name"
                               value="{{$role->name}}" 
                               class="block mt-1 rounded-md border-gray-300 w-full @error('name') border-red-500 bg-red-100 @enderror"
                               name="name"
                               @if ($role->name=='super-admin' || $role->name=='admin') readonly @endif>
                        @error('name')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-5 flex justify-between items-center bg-gray-100">
                        <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{ __('Sauvegarder') }}</button>
                    </div>
                </form>
            </div>
            
            <div class="p-8 text-gray-900">
                <a href="{{ url('roles') }}" class="bg-red-500 rounded-md p-2 text-white">
                    {{ __('Retour') }}
                </a> 
            </div>
        </div>
    </div>
</div>