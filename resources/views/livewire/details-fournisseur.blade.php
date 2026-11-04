<div>
    <div class="mt-5">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            {{-- En-tête --}}
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $fournisseur->four_nom }}
                    </h2>
                    <p class="text-gray-500">{{ $fournisseur->four_societe }} - {{ $fournisseur->four_tel }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ __('Situation actuelle') }}</p>
                    <p class="text-2xl font-bold {{ $fournisseur->four_situation > 0 ? 'text-red-500' : ($fournisseur->four_situation < 0 ? 'text-green-500' : 'text-gray-800') }}">
                        {!! format_number($fournisseur->four_situation) !!}
                    </p>
                </div>
            </div>

            {{-- Tableau de l'historique --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-center">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Date') }}</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Type') }}</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Référence') }}</th>
                            <th class="px-4 py-2 text-sm font-medium text-gray-900">{{ __('Montant') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historique as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold bg-{{ $item['color'] }}-100 text-{{ $item['color'] }}-800">
                                        {{ __($item['type']) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $item['ref'] }}</td>
                                <td class="px-4 py-2 text-sm font-bold {{ $item['montant'] > 0 ? 'text-red-500' : 'text-green-500' }}">
                                    {!! format_number($item['montant']) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <a href="{{ route('fournisseurs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                    &larr; {{ __('Retour à la liste') }}
                </a>
            </div>
        </div>
    </div>
</div>