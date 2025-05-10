<div wire:key="main_comp_{{str($componentName)->slug()->value}}">

    @if (isset($externalView) && $externalView)
        @includeIf($externalView)
    @else
        @livewire($componentName, $passExtraData, key(str($componentName)->slug()->value))
    @endif

</div>
