@props(['screen' => 'for-desktop'])
<div class="quick-links-wrapper {{$screen}}">
    <x-slim-dashboard::dropdown wrapperCss="" dropdownCss="reset-dropdown">
        <x-slot:trigger>
            <x-slim-dashboard::icons.circle-plus w="45" class="as-pointer" />
        </x-slot:trigger>

        <x-slot:content>
            @includeIf(config('slim-dashboard.global_cta_view'))
        </x-slot:content>
    </x-slim-dashboard::dropdown>
</div>
