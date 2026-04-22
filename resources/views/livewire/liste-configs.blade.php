<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Navigation --}}
        @include('role-permission.nav-links')
        
        {{-- Contenu principal --}}
        <div class="flex flex-col mt-4">
            
            {{-- Section à développer --}}
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        {{-- Message temporaire --}}
                        <div class="text-center py-8 text-gray-500">
                            {{ __('Sélectionnez une option ci-dessus') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>