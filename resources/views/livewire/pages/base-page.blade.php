<div x-data="{...sidepanel($wire), ...image()}" x-on:opensidepanel.window="toggleSidePanel($event.detail.component, $event.detail.title)">
    <div class="justify-inline-wrapper" style="margin-top: 10px">
        @if ($this->showStandardPageFilters())
            @includeIf($this->includePageFilters())
        @endif

        @if ($this->showPageCtas())
            @include('slim-dashboard::includes.table.page-cta')
        @endif
    </div>

    {!! $this->withRender() !!}

    @if ($this->useSideModal())
    @include('slim-dashboard::includes.table.side-panel')
    @endif

    @if ($this->withMobileFilters())
    @include('slim-dashboard::includes.table.mobile.record-filters')
    @endif


    <div wire:loading>
        <div class="full-table-loading">
            <div class="loading-spinner">
                <x-slim-dashboard::icons.bars-spinner-fade w="50" h="50" />
            </div>
        </div>
    </div>
</div>
