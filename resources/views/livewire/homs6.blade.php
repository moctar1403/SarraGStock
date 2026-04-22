<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        <div class="flex flex-col px-2 mb-4">
            <h4 class="text-xl font-bold text-gray-900 border-b pb-2">
                {{ __('Situation') }}
            </h4>
        </div>

        {{-- Tableaux de situation --}}
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
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Espèce et Applications') }}</td>
                            <td class="text-sm font-medium text-green-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_esp) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Crédit') }}</td>
                            <td class="text-sm font-medium text-orange-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($ventes_cre) !!}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Valeur de stock restant') }}</td>
                            <td class="text-sm font-medium text-blue-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($val_stck) !!}</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-100 font-bold">
                            <td class="text-sm font-bold text-gray-900 px-4 py-2">{{ __('Total') }}</td>
                            <td class="text-sm font-bold text-green-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($total2) !!}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Achats --}}
            <div class="bg-white rounded-lg border">
                <table class="min-w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="text-sm font-bold text-gray-900 px-4 py-2" colspan="2">{{ __('Achats') }}</th>
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
                            <td class="text-sm font-medium text-gray-700 px-4 py-2">{{ __('Remises') }}</td>
                            <td class="text-sm font-medium text-red-600 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">-{!! format_number($remises) !!}</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-100 font-bold">
                            <td class="text-sm font-bold text-gray-900 px-4 py-2">{{ __('Total') }}</td>
                            <td class="text-sm font-bold text-orange-700 px-4 py-2 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                <span class="number-cell">{!! format_number($total1) !!}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Résultat --}}
            <div class="bg-white rounded-lg border">
                <table class="min-w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="text-sm font-bold text-gray-900 px-4 py-2">{{ __('Résultat') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="text-2xl font-bold text-green-600 px-4 py-6 text-center">
                                <span class="number-cell">{!! format_number($total2 - $total1) !!} </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>