<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Configuration de la méthode de valorisation de stock') }}
        </h2>
        
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr class="align-middle">
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4">{{ __('Libellé')}}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4">{{ __('Symbole') }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-4">{{ __('Status/Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mvs as $item)
                                <tr class="align-middle border-b hover:bg-gray-50">
                                    <td class="text-sm text-gray-900 px-6 py-4">{{__($item->mvs_lib)}}</td>
                                    <td class="text-sm text-gray-900 px-6 py-4">{{__($item->mvs_sym)}}</td>
                                    <td class="text-sm text-gray-900 px-6 py-4">
                                        @if ($item->mvs_active==1)
                                            <span class="px-3 py-1 text-sm bg-green-400 text-white rounded-sm inline-block">
                                                {{ __('Activé') }}
                                            </span>
                                        @else
                                            <button class="px-3 py-1 text-sm bg-orange-500 hover:bg-orange-600 text-white rounded-sm transition" 
                                                    wire:click="toggleStatus({{$item->id}})">
                                                {{ __('Rendre active') }}
                                            </button>
                                        @endif
                                    </td> 
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-8">
                                        <div class="flex flex-col items-center justify-center">
                                            <img src="{{ image_empty() }}" alt="" class="w-20 h-20 mb-4">
                                            <p class="text-gray-500">{{ __('Aucun élément trouvé!') }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        @if($mvs->hasPages())
                        <div class="mt-4">
                            {{ $mvs->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>