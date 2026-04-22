<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Imprimer une sortie') }}
        </h2>
        <a id="btnPrint" href="#" class="text-sm bg-green-500 p-1 text-white rounded-sm moctpos ">Imprimer
        </a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @livewire('print-sortie',['sortie'=>$sortie])
               </div> 
        </div>
    </div>
</x-app-layout>
