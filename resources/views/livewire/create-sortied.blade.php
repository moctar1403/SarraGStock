<div class="p-2 bg-white shadow-sm">
    <form method="POST" wire:submit.prevent="store">
        @csrf
        @method('post')

        <div class="p-5 flex flex-col">
            <x-label value="{!! __('Article principal') !!}" />
            <x-label value="{!! __('Sélectionner un article') !!}" />

            <select id="article_id1"
                    class="block mt-1 rounded-md border-gray-300 w-64 @error('article_id1') border-red-500 bg-red-100 @enderror"
                    wire:model.live='article_id1'>
                <option value="0">------</option>
                @foreach ($articlesList as $item)
                    @php
                        $articlePrincipal = App\Models\Article::find($item->dar_principal);
                    @endphp
                    <option value="{{ $item->id }}">{{ $articlePrincipal->ar_lib ?? '' }}</option>
                @endforeach
            </select>
            @error('article_id1')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror

            <x-label value="{!! __('Recherche rapide de l\'article') !!}" class="mt-2" />
            <input type="text"
                   id="recherche_article"
                   placeholder="{{ __('Id, Référence, CB') }}"
                   class="w-64 block mt-1 rounded-md border-gray-300"
                   wire:model.live="recherche_article">

            <div class="mt-2 space-y-1">
                <x-label value="{!! __('Quantité Disponible') !!}" />
                <span class="text-green-600 font-semibold">{{ $sor_qte_dispo }}</span>
            </div>

            <x-label value="{!! __('Quantité sortie') !!}" class="mt-2" />
            <input type="text"
                   class="block mt-1 rounded-md border-gray-300 w-64 @error('sor_qte') border-red-500 bg-red-100 @enderror"
                   wire:model.live="sor_qte" 
                   name="sor_qte">
            @error('sor_qte')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>

        @if ($article_id1)
            <div class="p-5 flex flex-col">
                <x-label value="{!! __('Article de détail') !!}" />
                <input type="text"
                       class="block mt-1 rounded-md border-gray-300 w-64 bg-gray-100"
                       wire:model.live="article_id3" 
                       name="article_id3"
                       readonly>
            </div>

            <div class="px-5 flex flex-col">
                <x-label value="{!! __('Quantité de l\'article de détail par une unité de l\'article principal') !!}" />
                <input type="text"
                       class="block mt-1 rounded-md border-gray-300 w-64 bg-gray-100 @error('ent_qte2_par_1') border-red-500 bg-red-100 @enderror"
                       wire:model.live="ent_qte2_par_1" 
                       name="ent_qte2_par_1" 
                       readonly>
                @error('ent_qte2_par_1')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="px-5 flex flex-col">
                <x-label value="{{ __('Quantité Totale entrée') }}" />
                <input type="text"
                       class="block mt-1 rounded-md border-gray-300 w-64 bg-gray-100 @error('ent_qte2') border-red-500 bg-red-100 @enderror"
                       wire:model.live="ent_qte2" 
                       name="ent_qte2" 
                       readonly>
                @error('ent_qte2')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="px-5 flex flex-col">
                <x-label value="{!! __('Prix d\'achat') !!}" />
                <input type="text"
                       class="block mt-1 rounded-md border-gray-300 w-64 @error('nprix_achat') border-red-500 bg-red-100 @enderror"
                       wire:model.live="nprix_achat" 
                       name="nprix_achat">
                @error('nprix_achat')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="px-5 flex flex-col">
                <x-label value="{{ __('Prix de vente') }}" />
                <input type="text"
                       class="block mt-1 rounded-md border-gray-300 w-64 @error('nprix_vente') border-red-500 bg-red-100 @enderror"
                       wire:model.live="nprix_vente" 
                       name="nprix_vente">
                @error('nprix_vente')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="px-5 flex flex-col">
                <x-label value="{{ __('Date') }}" />
                <input type="date"
                       class="block mt-1 rounded-md border-gray-300 w-64 @error('sor_date') border-red-500 bg-red-100 @enderror"
                       wire:model.live="sor_date" 
                       name="sor_date">
                @error('sor_date')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <div class="px-5 flex justify-between items-center bg-gray-100 rounded-b-lg mt-4">
            @include('partials.bouton-confirmer-action', [
                'action' => 'store',
                'label' => __('Ajouter')
            ])
            <a href="{{ route('listedetails.index') }}" 
               class="bg-red-600 hover:bg-red-700 rounded-md px-4 py-2 text-sm text-white transition">
                {{ __('Annuler') }}
            </a>
        </div>

        @include('partials.confirm-action-modal')
    </form>
</div>