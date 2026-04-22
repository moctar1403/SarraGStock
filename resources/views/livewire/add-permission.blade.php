@push('styles')
    <link href="{{ asset('css/livewire/add-permission.css') }}" rel="stylesheet">
@endpush

<div class="mt-5">
    @include('role-permission.nav-links')
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
                <div class="p-8 text-gray-900">
                    <h4 class="text-xl font-bold mb-4">{{ __('Role : ') }}{{ $role->name }}</h4>
                    
                    @if($isSuperAdmin)
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                        <p class="text-yellow-700 font-semibold">
                            ⚠️ {{ __('Le rôle Super-Admin a automatiquement toutes les permissions. Les cases sont grisées pour information.') }}
                        </p>
                    </div>
                    @endif
                    
                    <!-- Section Recherche avec boutons d'action -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" 
                                           class="block w-full rounded-md border-gray-300 pl-10 pr-10"
                                           placeholder="{{ __('Rechercher une permission...') }}"
                                           wire:model.live.debounce.300ms="search">
                                    
                                    <!-- Icône recherche -->
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    
                                    <!-- Bouton effacer -->
                                    @if($search)
                                    <button wire:click="resetSearch" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                                
                                @if($search)
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ __('Résultats de recherche pour') }} : "<span class="font-semibold">{{ $search }}</span>"
                                </p>
                                @endif
                            </div>
                            
                            <!-- Boutons d'action pour les permissions filtrées -->
                            @if(!$isSuperAdmin && $search)
                            <div class="flex gap-2 rtl:space-x-reverse">
                                <button type="button"
                                        wire:click="toggleFilteredPermissions(true)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                    {{ __('Activer toutes les permissions trouvées') }}
                                </button>
                                <button type="button"
                                        wire:click="toggleFilteredPermissions(false)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                    {{ __('Désactiver toutes les permissions trouvées') }}
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Statistiques -->
                    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-sm text-blue-600">{{ __('Permissions totales') }}</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $permissions->count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <p class="text-sm text-green-600">{{ __('Permissions activées') }}</p>
                            <p class="text-2xl font-bold text-green-700">
                                {{ count(array_intersect($permission, $permissions->pluck('name')->toArray())) }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <p class="text-sm text-gray-600">{{ __('Permissions filtrées') }}</p>
                            <p class="text-2xl font-bold text-gray-700">{{ $permissions->count() }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" wire:submit.prevent="store">
                        @csrf
                        
                        @if($permissions->isEmpty())
                            <div class="p-8 text-center border border-gray-200 rounded-md">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-4 text-gray-500">
                                    {{ __('Aucune permission trouvée pour') }} "<span class="font-semibold">{{ $search }}</span>"
                                </p>
                                <button type="button" wire:click="resetSearch" class="mt-4 text-blue-500 hover:text-blue-700">
                                    {{ __('Réinitialiser la recherche') }}
                                </button>
                            </div>
                        @else
                            <div class="p-2 flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="font-semibold">{{ __('Permissions') }}</label>
                                    @if(!$isSuperAdmin)
                                    <div class="text-sm text-gray-500">
                                        {{ count($permission) }} / {{ $permissions->count() }} {{ __('sélectionnées') }}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded-md">
                                    @foreach ($permissions as $value)
                                        @php
                                            $isChecked = in_array($value->name, $permission);
                                            $isHighlighted = $search && stripos($value->name, $search) !== false;
                                        @endphp
                                        
                                        <div class="p-2 flex flex-row space-x-2 rtl:space-x-reverse items-center rounded hover:bg-gray-50 {{ $isHighlighted ? 'bg-yellow-50 border border-yellow-100' : '' }}">
                                            <div>
                                                <input type="checkbox" 
                                                       id="perm-{{ $value->id }}"
                                                       class="block mt-1 rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 {{ $isSuperAdmin ? 'cursor-not-allowed opacity-50' : '' }}" 
                                                       name="permission[]"
                                                       wire:model.live="permission"
                                                       value="{{ $value->name }}"
                                                       @if($isSuperAdmin) checked disabled @endif>
                                            </div>
                                            <div class="flex-1">
                                                <label for="perm-{{ $value->id }}" 
                                                       class="cursor-pointer {{ $isSuperAdmin ? 'text-gray-500' : '' }} {{ $isChecked ? 'font-semibold text-blue-600' : '' }}">
                                                    @if($isHighlighted)
                                                        @php
                                                            $parts = preg_split('/(' . preg_quote($search, '/') . ')/i', $value->name, -1, PREG_SPLIT_DELIM_CAPTURE);
                                                        @endphp
                                                        @foreach($parts as $part)
                                                            @if(strtolower($part) === strtolower($search))
                                                                <span class="bg-yellow-200 font-semibold">{{ $part }}</span>
                                                            @else
                                                                {{ $part }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {{ $value->name }}
                                                    @endif
                                                </label>           
                                            </div>                              
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Sélection rapide -->
                                @if(!$isSuperAdmin)
                                <div class="mt-4 flex gap-2 rtl:space-x-reverse">
                                    <button type="button"
                                            wire:click="$set('permission', [])"
                                            class="text-sm text-red-500 hover:text-red-700">
                                        {{ __('Tout décocher') }}
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button type="button"
                                            wire:click="$set('permission', {{ json_encode($permissions->pluck('name')->toArray()) }})"
                                            class="text-sm text-green-500 hover:text-green-700">
                                        {{ __('Tout cocher') }}
                                    </button>
                                </div>
                                @endif
                            </div>
                        @endif
                        
                        <div class="p-5 flex justify-between items-center bg-gray-100 mt-4">
                            <button class="bg-green-600 hover:bg-green-700 p-3 rounded-sm text-white text-sm font-medium transition {{ $isSuperAdmin ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                    type="submit"
                                    @if($isSuperAdmin) disabled @endif>
                                {{ __('Sauvegarder les modifications') }}
                            </button>
                            
                            @if($isSuperAdmin)
                            <p class="text-sm text-gray-600 italic">
                                {{ __('Les permissions du Super-Admin sont automatiquement sauvegardées') }}
                            </p>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="p-8 text-gray-900">
                   <a href="{{ url('roles') }}" class="bg-red-500 hover:bg-red-600 rounded-md p-2 text-white transition">
                    {{ __('Retour à la liste des rôles') }}
                   </a> 
                </div>
            </div>
        </div>
    </div>
</div>