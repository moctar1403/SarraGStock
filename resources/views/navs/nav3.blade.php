<div class="flex space-x-2 rtl:space-x-reverse px-14">
    <x-nav-link-dashboard :route="route('lang', 'fr')" :active="app()->getLocale() == 'fr'">
        {{ __('Français') }}
    </x-nav-link-dashboard>

    <x-nav-link-dashboard :route="route('lang', 'ar')" :active="app()->getLocale() == 'ar'">
        {{ __('Arabe') }}
    </x-nav-link-dashboard>
</div>