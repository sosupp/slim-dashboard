<div key="{{str()->random(20)}}">

    @if (isset($externalView) && $externalView)
        @includeIf($externalView)
    @else
        <livewire:is :component="$componentName" :key="str()->random(50)" />
    @endif

</div>
