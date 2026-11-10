<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        
        {{-- Filtres de dates --}}
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de début') }}</label>
                <input type="date" class="block w-full rounded-md border-gray-300" wire:model.live="date1">
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date de fin') }}</label>
                <input type="date" class="block w-full rounded-md border-gray-300" wire:model.live="date2">
            </div>
        </div>

        <div class="flex flex-col px-2 mb-4">
            <h4 class="text-xl font-bold text-gray-900 border-b pb-2">
                {{ __('Situation Globale') }}
            </h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Ventes --}}
            <div class="bg-white rounded-lg border">
                <table class="min-w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="text-sm font-bold text-gray-900 px-4 py-2" colspan="2">{{ __('Ventes') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Classiques (Espèces / Apps)') }}</td>
                            <td class="text-sm font-medium text-green-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_esp) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Classiques (Crédit)') }}</td>
                            <td class="text-sm font-medium text-orange-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_cre) !!}</span>
                            </td>
                        </tr>
                        
                        <tr class="border-b hover:bg-orange-50 bg-orange-50/50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Resto (Espèces / Apps)') }}</td>
                            <td class="text-sm font-medium text-green-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_resto_esp) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-orange-50 bg-orange-50/50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Resto (Crédit)') }}</td>
                            <td class="text-sm font-medium text-orange-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_resto_cre) !!}</span>
                            </td>
                        </tr>

                        {{-- NOUVELLES LIGNES POUR LE MIXTE --}}
                        <tr class="border-b hover:bg-purple-50 bg-purple-50/50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Mixte (Espèces / Apps)') }}</td>
                            <td class="text-sm font-medium text-green-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_mixte_esp) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-purple-50 bg-purple-50/50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Mixte (Crédit)') }}</td>
                            <td class="text-sm font-medium text-orange-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_mixte_cre) !!}</span>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Valeur de stock restant') }}</td>
                            <td class="text-sm font-medium text-blue-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($val_stck) !!}</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-100 font-bold">
                            <td class="text-sm font-bold text-gray-900 px-4 py-2">{{ __('Total Actif') }}</td>
                            <td class="text-sm font-bold text-green-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($total2) !!}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Achats & Charges --}}
            <div class="bg-white rounded-lg border">
                <table class="min-w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="text-sm font-bold text-gray-900 px-4 py-2" colspan="2">{{ __('Achats & Charges') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Achats fournisseurs') }}</td>
                            <td class="text-sm font-medium text-orange-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($val_achat_four) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Achats autres') }}</td>
                            <td class="text-sm font-medium text-orange-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($val_achat_autres) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Pertes') }}</td>
                            <td class="text-sm font-medium text-red-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($pertes) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Remises') }}</td>
                            <td class="text-sm font-medium text-red-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">-{!! format_number($remises) !!}</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-100 font-bold">
                            <td class="text-sm font-bold text-gray-900 px-4 py-2">{{ __('Total Charges') }}</td>
                            <td class="text-sm font-bold text-orange-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($total1 + $remises + $pertes) !!}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Résultat Net --}}
            <div class="bg-white rounded-lg border flex flex-col justify-center items-center p-6 text-center">
                <h4 class="text-lg font-bold text-gray-700 mb-4">{{ __('Résultat Net') }}</h4>
                <div class="text-4xl font-bold {{ $resultat_net >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    <span class="number-cell">{!! format_number($resultat_net) !!}</span>
                </div>
                <p class="text-xs text-gray-500 mt-4">{{ __('Calculé sur les ventes réelles (hors valeur du stock)') }}</p>
            </div>
        </div>
    </div>
</div>