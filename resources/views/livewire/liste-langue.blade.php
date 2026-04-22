<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- En-tête avec navigation --}}
        @include('navs.nav3')
        
        {{-- Contenu principal --}}
        <div class="flex flex-col mt-4">
            
            {{-- Section à développer --}}
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        
                        {{-- Message temporaire ou à remplacer --}}
                        <div class="text-center py-8 text-gray-500">
                            {{ __('') }}
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>