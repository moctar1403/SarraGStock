<x-guest-layout>
    <x-slot name="header">
        {{-- @include('navs.nav1') --}}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:Activatepage />
            </div>
        </div>
    </div>
</x-guest-layout>
