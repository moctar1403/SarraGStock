<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-8 text-gray-900">
                <h4>{{__('Modification de la methode de paiement')}} {{$methode->meth_nom}}</h4>
                <form method="POST" wire:submit.prevent="store">
                    @csrf
                    @method('post')
                    
                    <div class="p-5 flex flex-col">
                        <label for="meth_nom">{{__('Nom')}}</label>
                        <input type="text" 
                               id="meth_nom"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('meth_nom') border-red-500 bg-red-100 @enderror"
                               name="meth_nom"
                               wire:model.live="meth_nom"
                               value="{{ old('meth_nom') ?? $methode->meth_nom }}" readonly>
                        @error('meth_nom')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-5 flex flex-col">
                        <label for="meth_tel">{{__('Téléphone')}}</label>
                        <input type="text" 
                               id="meth_tel"
                               class="block mt-1 rounded-md border-gray-300 w-full @error('meth_tel') border-red-500 bg-red-100 @enderror"
                               name="meth_tel"
                               wire:model.live="meth_tel"
                               value="{{ old('meth_tel') ?? $methode->meth_tel }}">
                        @error('meth_tel')
                            <div class="text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="p-5 flex flex-col">
                        <label for="meth_active">{{__('Active')}}</label>
                        <input type="hidden" value="0" name="meth_active">
                        <input type="checkbox" 
                               id="meth_active"
                               class="block mt-1 rounded-md border-gray-300" 
                               name="meth_active"
                               wire:model.live="meth_active"
                               @if ($methode->meth_active==1) checked @endif
                               value="1">     
                    </div>
                    
                    <div class="p-5 flex justify-between items-center bg-gray-100">
                        <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">{{ __('Sauvegarder') }}</button>
                    </div>
                </form>
            </div>
            
            <div class="p-8 text-gray-900">
                <a href="{{ route('methodes.index') }}" class="bg-red-500 rounded-md p-2 text-white">
                    {{ __('Retour') }}
                </a> 
            </div>
        </div>
    </div>
</div>