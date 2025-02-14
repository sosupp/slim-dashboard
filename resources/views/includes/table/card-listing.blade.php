@if ($this->showPaginationFilter())
<div class="custom-pagination-wrapper">

    <div class="mobile-page-filters">
        @include('slim-dashboard::includes.table.mobile.record-filters')

        @if ($this->showPagination())
        @include('slim-dashboard::includes.table.table-navs')
        @endif
    </div>

</div>
@endif

<div class="search-and-listing" x-data="{
        statsPanel: false
    }">

    <div class="search-input-and-results" x-data="{openResults: true}">
        @include('slim-dashboard::includes.platform.search-input')
        @include('slim-dashboard::includes.table.page-cta')

        @if ($this->hasSearchResultDropdown)
        <div x-show="openResults" @click.outside="openResults=!openResults">
            @if (!empty($this->search))
                @includeIf($this->searchResultDropdownView)
            @endif
        </div>
        @endif
    </div>

    <div class="mobile-stats-wrapper">
        @if ($this->showPagination())
        <div class="record-count">
            <span x-cloak x-show="mobileFilterLabel" x-text="mobileFilterLabel"></span>
            <span class="total-record-count">({{$this->tableRecords->total()}})</span>
        </div>
        @endif


        <div class="mobile-record-stats" id="statsContent" x-ref="statsContent">
            @forelse (collect($this->inlineTableStatistics) as $card)
                @if (is_array($card))
                    @if ($card['canView'])
                    <p class="mobile-record-stat-item {{$card['css'] ?? ''}}">
                        {{$card['label']}}: {{$card['value']}}
                    </p>
                    @endif

                @endif
                @empty
            @endforelse

            <span id="mobileMoreStats" class="as-pointer" x-on:click="statsPanel = true;sidePanelTitle='{!! __($this->inlineTableStatistics['description'] ?? '') !!}'">
                <x-icons.open w="28" color="limegreen"/>
            </span>
        </div>

    </div>

    <div x-cloak x-show="statsPanel" id="mobileStatPanel" class="side-modal-panel">
        <div class="side-modal-heading-wrapper">
            <p class="side-modal-heading" x-html="sidePanelTitle">Side Modal Heading</p>
            <span class="close-modal as-pointer" x-on:click="statsPanel=false">
                <x-icons.close />
            </span>
        </div>

        <div>
            @include('slim-dashboard::includes.table.mobile.record-filters', [
                'filterWrapper'=> 'mobile-filter-modal', 'filterTriggerCss' => 'as-absolute'
            ])
            @forelse (collect($this->inlineTableStatistics) as $card)
                @if (is_array($card))
                    @if ($card['canView'])
                    <p class="mobile-record-stat-overview {{$card['css'] ?? ''}}">
                        @if ($card['label'])
                        <span class="stat-item-label">{{$card['label']}}: </span>
                        @endif
                        <span class="stat-item-value">{{$card['value']}}</span>
                    </p>
                    @endif

                @endif
                @empty
            @endforelse
        </div>


    </div>

    <div class="item-listings-wrapper {{$this->cardListingWrapper()}}">


        @if ($this->listAsCards())
        {!! $this->listAsCards() !!}
        @else
        @include('slim-dashboard::includes.table.mobile.card-list')
        @endif


    </div>
</div>



