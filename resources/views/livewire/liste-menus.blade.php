<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
            {{-- En-tête --}}
            <div class="flex justify-between items-center px-8 pt-4">
                <h4 class="font-semibold text-lg text-gray-800">{{ __('Affectation des menus par rôles') }}</h4>
            </div>

            {{-- Formulaire d'affectation --}}
            <div class="px-8 text-gray-900">
                <div class="overflow-x-auto">
                    <div class="py-4 inline-block min-w-full">
                        <div class="overflow-hidden">
                            <form method="POST" action="#">
                                @csrf
                                @method('PUT')
                                
                                <table class="min-w-full text-center">
                                    {{-- En-tête du tableau --}}
                                    <thead class="border-b bg-gray-50">
                                        <tr>
                                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Rôle') }}</th>
                                            <th class="text-sm font-medium text-gray-900 px-2 py-2">{{ __('Menus') }}</th>
                                        </tr>
                                    </thead>

                                    {{-- Corps du tableau --}}
                                    <tbody>
                                        @forelse ($roles as $role)
                                            <tr class="border-b-2 border-blue-400 hover:bg-gray-50">
                                                <td class="text-sm font-medium text-gray-900 px-2 py-2">{{ $role->name }}</td>
                                                <td class="justify-center py-4 px-4 flex flex-wrap gap-2">
                                                    
                                                    {{-- Menu Dashboard --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="dashboard" />
                                                        {{ __('Dashboard') }}
                                                    </label>
                                                    
                                                    {{-- Menu Ventes --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="ventes" />
                                                        {{ __('Ventes') }}
                                                    </label>
                                                    
                                                    {{-- Menu Articles --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="articles" />
                                                        {{ __('Articles') }}
                                                    </label>
                                                    
                                                    {{-- Menu Entrées --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="entrees" />
                                                        {{ __('Entrées') }}
                                                    </label>
                                                    
                                                    {{-- Menu Sorties --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="sorties" />
                                                        {{ __('Sorties') }}
                                                    </label>
                                                    
                                                    {{-- Menu Clients --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="clients" />
                                                        {{ __('Clients') }}
                                                    </label>
                                                    
                                                    {{-- Menu Fournisseurs --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="fournisseurs" />
                                                        {{ __('Fournisseurs') }}
                                                    </label>
                                                    
                                                    {{-- Menu Configurations --}}
                                                    <label class="inline-flex items-center text-sm p-2 bg-blue-400 text-white rounded-sm cursor-pointer">
                                                        <input type="checkbox" 
                                                               class="mr-1 rounded border-gray-300" 
                                                               name="permission[]" 
                                                               value="configurations" />
                                                        {{ __('Configurations') }}
                                                    </label>
                                                    
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <img class="w-20 h-20 mb-2" src="{{ image_empty() }}" alt="">
                                                        <div class="text-gray-500">{{ __('Aucun élément trouvé') }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                {{-- Boutons d'action --}}
                                <div class="flex justify-between items-center bg-gray-100 p-5 mt-4 rounded-b-lg">
                                    <button type="submit" class="bg-green-600 p-3 rounded-sm text-white text-sm hover:bg-green-700">
                                        {{ __('Sauvegarder') }}
                                    </button>
                                    
                                    <a href="{{ url('configs') }}" class="bg-red-500 rounded-md p-3 text-white text-sm hover:bg-red-600">
                                        {{ __('Retour') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>