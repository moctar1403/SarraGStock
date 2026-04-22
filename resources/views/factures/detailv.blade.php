<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-4">
                <div><a href="{{route('ventes.print',$vente)}}" class="text-sm bg-cyan-500 p-1 text-white rounded-sm moctpos ">{{ __('Imprimer') }}
                    </a>
                </div>
                {{-- <div><a href="{{route('factures.pdf',$vente)}}" class="text-sm bg-cyan-500 p-1 text-white rounded-sm moctpos ">{{ __('PDF') }}
                    </a>
                </div> --}}
                <div>
                    <a href="{{route('ventes.index')}}" class="text-sm bg-cyan-500 p-1 text-white rounded-sm moctpos ">{{ __('Retour') }}
                    </a>
                </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @livewire('detail-vente',['vente'=>$vente])
               </div> 
        </div>
    </div>
</x-app-layout>
