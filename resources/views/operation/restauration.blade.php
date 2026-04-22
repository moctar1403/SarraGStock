<x-app-layout>
    <x-slot name="header">
        {{-- Header vide mais conservé pour la structure --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-5">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Restauration de la base de données') }}</h2>
                        
                        {{-- Formulaire d'upload --}}
                        <form method="POST" action="{{ route('backup.restore') }}" enctype="multipart/form-data" class="mb-4">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="backup_file" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Fichier de sauvegarde') }}
                                </label>
                                <input type="file" 
                                       id="backup_file"
                                       name="backup_file" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500
                                              @error('backup_file') border-red-500 bg-red-50 @enderror"
                                       accept=".sql,.zip,.gz">
                                @error('backup_file')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-xs mt-1">
                                    {{ __('Formats acceptés :') }} {{ __(' .sql, .zip, .gz') }}
                                </p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    {{ __('Restaurer') }}
                                </button>
                                
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md transition">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </form>

                        {{-- Section d'information --}}
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong class="font-medium">{{ __('Attention') }} :</strong>
                                        {{ __('La restauration va remplacer toutes les données actuelles. Cette action est irréversible.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>