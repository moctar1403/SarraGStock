<x-ap-layout>
    @include('role-permission.nav-links')
    <div class="py-2">
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
                <div class="flex justify-between items-center px-8">
                    <h4>Roles</h4>
                    <a href="{{ url('roles/create') }}" class="bg-blue-500 rounded-md p-1 text-white ">{{ __('Ajouter') }} Role</a> 
                </div>
                <div class="px-8 text-gray-900">
                   <!-- Styliser le tableau -->
                    <div class="overflow-x-auto  ">
                        <div class="py-4 inline-block min-w-full  ">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-center">
                                    <thead class="border-b bg-gray-50">
                                        <tr>
                                            <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ __('Id') }}
                                            </th>
                                            <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ __('Nom') }}
                                            </th>
                                            <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ __('Actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @forelse ($roles as $role)
                                        <tr class="border-b-4 border-gray-400">
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">{{$role->id}}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">{{$role->name}}
                                            </td>
                                            <td class="flex  ">
                                                <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" class="text-sm p-2 bg-cyan-400 text-white rounded-sm">
                                                    {{ __('Ajouter') }} / {{ __('Editer') }} Role Permission
                                                </a>  
                                                {{-- @can('update role') --}}
                                                @role('super-admin')
                                                    <a href="{{ url('roles/'.$role->id.'/edit') }}" class="text-sm p-2 bg-blue-400 text-white rounded-sm">
                                                        {{ __('Editer') }}
                                                    </a>  
                                                @endrole
                                                {{-- @endcan --}}
                                                @can('delete role')
                                                <a href="{{ url('roles/'.$role->id.'/delete') }}" class="text-sm p-2 bg-red-400 text-white rounded-sm">
                                                    {{ __('Supprimer') }}
                                                </a>
                                                @endcan  
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="w-full">
                                                <td class=" flex-1 w-full items-center justify-center" colspan="4">
                                                    <div >
                                                        <p class="flex justify-center p-4">
                                                            <img class="w-20 h-20" src="{{image_empty()}}">
                                                            <div class="text-red-500">Aucun élément trouvé</div>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endforelse
                                    </tbody>
                                    
                                </table>
                            
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</x-ap-layout>
