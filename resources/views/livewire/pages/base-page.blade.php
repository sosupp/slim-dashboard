<div x-data="{...sidepanel($wire), ...image()}">

    {!! $this->withRender() !!}

    @if ($this->useSideModal())
    @include('slim-dashboard::includes.table.side-panel')
    @endif

    @if ($this->withMobileFilters())
    @include('slim-dashboard::includes.table.mobile.record-filters')
    @endif
</div>
