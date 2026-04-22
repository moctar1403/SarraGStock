<x-app-layout>
    @include('role-permission.nav-links')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <!-- Message qui apparaitera après l'opération -->
                <div class="p-3">
                    @if (Session::get('succes'))  
                     <div class="p-2 border-blue-300 bg-blue-400 animate-bounce text-white">
                         {{__(Session::get('succes'))}}
                     </div>
                    @elseif (Session::get('danger'))  
                     <div class="p-2 border-blue-300 bg-red-400 animate-bounce text-white">
                         {{__(Session::get('danger')) }}
                     </div>
                     @endif
                 </div>
                <div class="p-8 text-gray-900">
                    <h4>Role : {{$role->name}}</h4>
                    <div class="">
                        <input type="text" class="block mt-1 rounded-md border-gray-300 w-50" placeholder="{{ __('Rechercher') }}"
                                wire:model.live="search">
                    </div>
                    <form method="POST" action="{{ url('roles/'.$role->id.'/give-permissions') }}">
                        @csrf
                        @method('PUT')
                        @if (Session::get('error'))
                            <div class="p-3">
                                <div class="p-2 border-red-300 bg-red-400 animate-bounce text-white">{{ Session::get('error') }}</div>
                            </div>
                        @endif
                        <div class="p-2 flex flex-col">
                            <label for="" >Permissions</label>
                            <div>
                                @foreach ($permissions as $permission )
                                    <div class="p-1 flex flex-row space-x-2">
                                        <div>
                                            <input type="checkbox" 
                                               class="block mt-1 rounded-md border-gray-300" 
                                               name="permission[]"
                                               value="{{$permission->name}}"
                                               @if ($role->name=='super-admin')
                                                   checked
                                                @else
                                               {{ in_array($permission->id,$rolePermissions) ? 'checked' : '' }}
                                               @endif 
                                        />     
                                        </div>
                                        <div>
                                            {{$permission->name}}           
                                        </div>                              
                                    </div>
                                @endforeach
                            </div> 
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
