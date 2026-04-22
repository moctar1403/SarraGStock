{{-- @include('role-permission.nav-links') --}}
<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
            {{-- En-tête avec titre et bouton d'ajout --}}
            <div class="flex justify-between items-center px-8 pt-4 mb-4">
                <h3 class="font-semibold text-lg text-gray-800">{{ __('Les utilisateurs') }}</h3>
                
                @can('create user')
                    @include('partials.bouton_ajouter', [
                        'url' => route('users.create'),
                        'texte' => __('Ajouter Utilisateur'),
                        'couleur' => 'blue',
                        'icone' => true,
                    ])
                @endcan
            </div>

            {{-- Tableau des utilisateurs --}}
            <div class="px-8 text-gray-900 pb-4">
                <div class="overflow-x-auto">
                    <div class="py-4 inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-center">
                                {{-- En-tête du tableau --}}
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Id') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Nom') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Email') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Rôles') }}</th>
                                        <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>

                                {{-- Corps du tableau --}}
                                <tbody>
                                    @forelse ($users as $item)
                                        <tr class="border-b-2 border-gray-200 hover:bg-gray-50">
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->id }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->name }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $item->email }}</td>
                                            <td class="text-sm font-medium text-gray-900 px-2 py-2">
                                                @if (!empty($item->getRoleNames()))
                                                    @foreach ($item->getRoleNames() as $rolename)
                                                        <span class="inline-block px-2 py-1 bg-cyan-500 text-white rounded-md text-xs my-1">
                                                            {{ $rolename }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-xs text-gray-400 italic">{{ __('Aucun rôle') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-sm font-medium text-center whitespace-nowrap">
                                                <div class="flex justify-center space-x-1 rtl:space-x-reverse">
                                                    @can('update user')
                                                        @include('partials.boutton_modifier', [
                                                            'url' => route('users.edit', $item->id),
                                                            'texte' => __('Editer')
                                                        ])
                                                    @endcan
                                                    
                                                    @can('delete user')
                                                        @include('partials.boutton_supprimer')
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="flex flex-col items-center justify-center">
                                                    <img class="w-20 h-20 mb-2" src="{{ image_empty() }}" alt="">
                                                    <div class="text-gray-500">{{ __('Aucun élément trouvé') }}</div>
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
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>