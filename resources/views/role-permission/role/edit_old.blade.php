<x-ap-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
                <div class="p-8 text-gray-900">
                    <h4>{{ __('Editer') }} Role {{$role->id}}</h4>
                    <form method="POST" action="{{ url('roles/'.$role->id) }}">
                        @csrf
                        @method('PUT')
                        @if (Session::get('error'))
                            <div class="p-5">
                                <div class="p-2 border-red-300 bg-red-400 animate-bounce text-white">{{ Session::get('error') }}</div>
                            </div>
                        @endif
                        <div class="p-5 flex flex-col">
                            <label for="" >Role {{ __('Nom') }}</label>
                            <input type="text" value="{{$role->name}}" class="block mt-1 rounded-md border-gray-300 w-full @error('name') border-red-500 bg-red-100 animate-bounce @enderror"
                                name="name">
                            @error('name')
                                <div class="text text-red-500 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-5 flex justify-between items-center bg-gray-100">
                            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{ __('Sauvegarder') }}</button>
                        </div>
                    </form>
                </div>
                <div class="p-8 text-gray-900">
                   <a href="{{ url('roles') }}" class="bg-red-500 rounded-md p-2 text-white ">
                    {{ __('Retour') }}
                   </a> 
                </div>
            </div>
        </div>
    </div>
</x-ap-layout>
