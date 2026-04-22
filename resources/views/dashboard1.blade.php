<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard 1') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- @role('Administrateur')
                je suis un administrateur! <br>
                @can('See Hello world')
                    hello world
                @endcan <br>
                @can('See Good Bye')
                    Good Bye!
                @endcan
                @else
                    je ne suis pas un administrateur! <br>
                @can('See Good Bye')
                    Good Bye
                @endcan
                
            @endrole --}}
                <livewire:Homs1 />
            </div>
        </div>
    </div>
</x-app-layout>
