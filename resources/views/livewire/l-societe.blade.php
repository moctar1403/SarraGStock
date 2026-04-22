<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec boutons d'action --}}
        <div class="flex justify-end items-center mb-4">
            @if ($societe)
                @can('update societe') 
                    @include('partials.boutton_modifier', [
                        'url' => route('configs.editsoc', $societe),
                        'texte' => __('Modifier les Informations')
                    ])
                @endcan
                
                @can('delete societe') 
                    @include('partials.boutton_supprimer_societe')
                @endcan
            @else
                @can('create societe') 
                    @include('partials.bouton_ajouter', [
                        'url' => route('configs.createsoc'),
                        'texte' => __('Ajouter les Informations'),
                        'couleur' => 'blue',
                        'icone' => true,
                    ])
                @endcan
            @endif
        </div>

        {{-- Informations de la société --}}
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-2 inline-block min-w-full">
                    <div class="overflow-hidden">
                        @if ($societe)
                            <table class="min-w-full border-2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50 w-1/3">{{ __('Nom') }}</td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_nom }}</td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('Adresse') }}</td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_adresse }}</td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('Code Postal') }}</td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_code_postal }}</td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('Téléphone') }}</td>
                                    {{-- Téléphone : ne PAS formater --}}
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_tel }}</td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('Email') }}</td>
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_email }}</td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('N° RC') }}</td>
                                    {{-- RC : ne PAS formater --}}
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_rc }}</td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('NIF') }}</td>
                                    {{-- NIF : ne PAS formater --}}
                                    <td class="text-sm font-medium text-gray-900 px-6 py-3">{{ $societe->soc_nif }}</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="text-sm font-bold text-gray-900 px-6 py-3 border-r bg-gray-50">{{ __('Logo') }}</td>
                                    <td class="px-6 py-3">
                                        @if ($societe->soc_logo)
                                            <img src="{{ asset($societe->soc_logo) }}" class="max-w-[100px] max-h-[100px] border rounded p-1">
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-2">
                                    <div class="text-gray-500">{{ __('Aucune information trouvée') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de confirmation --}}
    @include('partials.confirm-delete-modal')
</div>