<div x-data="{...sidepanel($wire), ...image()}">

    {!! $this->withRender() !!}

    <div class="">
        @if ($this->useSideModal())
        @include('slim-dashboard::includes.table.side-panel')
        @endif
    </div>
</div>
