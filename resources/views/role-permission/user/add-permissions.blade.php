
<x-ap-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <!-- Message qui apparaitera après l'opération -->
                <div class="p-3">
                    @if (Session::get('succes'))  
                     <div class="p-2 border-blue-300 bg-blue-400 animate-bounce text-white">
                         {{Session::get('succes')}}
                     </div>
                    @elseif (Session::get('danger'))  
                     <div class="p-2 border-blue-300 bg-red-400 animate-bounce text-white">
                         {{__(Session::get('danger')) }}
                     </div>
                     @endif
                 </div>
                <div class="p-8 text-gray-900">
                    <h4>Role : {{$role->name}}</h4>
                    <form method="POST" action="{{ url('roles/'.$role->id.'/give-permissions') }}">
                        @csrf
                        @method('PUT')
                        @if (Session::get('error'))
                            <div class="p-5">
                                <div class="p-2 border-red-300 bg-red-400 animate-bounce text-white">{{ Session::get('error') }}</div>
                            </div>
                        @endif
                        <div class="p-5 flex flex-col">
                            <label for="" >Permission</label>
                            <div>
                                @foreach ($permissions as $permission )
                                    <div>
                                        <input type="checkbox" 
                                               class="block mt-1 rounded-md border-gray-300  @error('permission') border-red-500 bg-red-100 animate-bounce @enderror" 
                                               name="permission[]"
                                               value="{{$permission->name}}" 
                                               {{ in_array($permission->id,$rolePermissions) ? 'checked' : '' }}
                                        />
                                        {{$permission->name}}       
                                    </div>
                                @endforeach
                            </div>
                           
                                
                            @error('permission')
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
