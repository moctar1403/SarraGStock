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
                        <h3 class="">Users</h3>
                        <a href="{{ url('users/create') }}" class="bg-blue-500 rounded-md p-1 text-white">{{ __('Ajouter') }} User</a> 
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
                                            <th class="text-sm font-medium text-gray-900 px-6 py-6">Email
                                            </th>
                                            <th class="text-sm font-medium text-gray-900 px-6 py-6">Roles
                                            </th>
                                            <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ __('Actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @forelse ($users as $user)
                                        <tr class="border-b-4 border-gray-400">
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">{{$user->id}}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">{{$user->name}}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">{{$user->email}}
                                            </td>
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $rolename )
                                                        <label for="" class="bg-cyan-500 rounded-md p-1 text-white">{{$rolename}}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="flex  ">
                                                @can('update user')
                                                <a href="{{ url('users/'.$user->id.'/edit') }}" class="text-sm p-2 bg-blue-400 text-white rounded-sm">{{ __('Editer') }}</a>  
                                                @can('delete user')
                                                @endcan
                                                <a href="{{ url('users/'.$user->id.'/delete') }}" class="text-sm p-2 bg-red-400 text-white rounded-sm">{{ __('Supprimer') }}</a> 
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
