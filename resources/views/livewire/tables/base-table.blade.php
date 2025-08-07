
<div key="{{str()->random(20)}}" x-data="{
        sidePanel: $wire.entangle('hasSidePanel'),
        sidePanelTitle: '',
        subnav: $wire.entangle('subnav').live,
        useComponent: false,
        componentName: $wire.entangle('sidePanelComponent').live,
        selectFilterLabel: $wire.entangle('selectFilterLabel'),
        dateLabel: $wire.entangle('dateLabel'),
        mobileDateLabel: $wire.entangle('mobileDateLabel'),
        searchFilters: false,
        imagePreview: null,
        imgsrc: null,
        imagePath: null,
        subActive(key){
            this.subnav = key
        },
        toggleSidePanel(component = '', title = '', record = null){
            this.sidePanelTitle = title
            this.sidePanel = !this.sidePanel
            if(component !== ''){
                this.useComponent = true
                this.componentName = component
            }else {
                this.useComponent = false
            }
            if(record !== null){
                $wire.sidePanelModel(record)
                $wire.resolvePanelModel(record)
            }
        },
        closePanel(){
            this.sidePanel = !this.sidePanel
        }
    }" x-init="imagePreview = '{{asset($previewImagePath)}}'">

    @persist('pagesubnavs')
        @if (!empty($this->pageSubNavs))
        <div class="page-sub-navs">
            @forelse ($this->pageSubNavs as $item)
            <a href="{{!empty($item['url']) ? $item['url'] : '#'}}"
                wire:navigate
                class="page-sub-nav-item dmode-element-bg"
                :class="subnav == '{{$item['key']}}' ? 'dark-active-bottom' : ''"
                x-on:click="subActive('{{$item['key']}}')"
                :key="'{{$item['key']}}'"
                >{{$item['name']}}</a>
            @empty
                No nav items
            @endforelse
        </div>
        @endif
    @endpersist()

    <div class="composite-page-data">
        {{$this->compositePage()}}
    </div>

    {{$this->viewBeforeTable()}}

    @if ($this->hasCardListing())
        <div class="for-mobile">
            @include('slim-dashboard::includes.table.card-listing')
            @if ($this->useSideModal())
                @include('slim-dashboard::includes.table.side-panel')
            @endif
        </div>
    @endif

    <div class="page-grid-layout {{$this->hasCardListing() ? 'for-desktop' : ''}}">
        @if (!empty($this->pageSideData()))
        <div class="page-side-data" :class="darkmode ? 'use-dark-theme card-wrapper' : ''">
            {{$this->pageSideData()}}
        </div>
        @endif

        <div class="page-table-section" :class="darkmode ? 'use-dark-theme card-wrapper' : '{{$this->tableWrapperCss}}'">
            @if ($this->showTableCta())
            <div class="table-cta-wrapper {{$this->tableHeadingCss}}">
                @if (!empty($this->tableHeading()))
                <div class="table-heading">{!! $this->tableHeading() !!}</div>
                @endif

                <div class="search-input-and-results" x-data="{openResults: true}">
                    @include('slim-dashboard::includes.platform.search-input')

                    <template x-if="searchFilters">
                        <span>Searching:
                            <small class="active-pill" x-text="selectFilterLabel">all branches</small>
                            <small class="active-pill" x-text="dateLabel"></small>
                        </span>
                    </template>

                    @if ($this->hasSearchResultDropdown)
                    <div x-show="openResults" @click.outside="openResults=!openResults">
                        @if (!empty($this->search))
                            @includeIf($this->searchResultDropdownView)
                        @endif
                    </div>
                    @endif
                </div>


                @include('slim-dashboard::includes.table.page-cta')

            </div>
            @endif

            @if ($this->useSideModal())
            @include('slim-dashboard::includes.table.side-panel')
            @endif

            @if ($this->showPaginationFilter())
            <div class="custom-pagination-wrapper">
                @if ($this->showPagination())
                <div class="record-count">
                    <span class="total-record-count">
                        {{ $this->tableRecords ? $this->tableRecords->total() : ''}} records
                    </span>
                </div>
                @endif

                <div class="filters-and-pagination">
                    @if($this->showTableFilters())
                    @include('slim-dashboard::includes.table.table-filters')
                    @endif

                    @if ($this->showPagination())
                    @include('slim-dashboard::includes.table.table-navs')
                    @endif
                </div>

            </div>
            @endif

            @if ($this->showInlineTableStatistics)
            @include('slim-dashboard::includes.table.table-inline-statistics')
            @endif


            @if($this->useCustomTableView())
                {{ $this->useCustomTableView() }}
            @else
                @include('slim-dashboard::includes.table.table-to-cards')
                @include('slim-dashboard::includes.table.standard')
            @endif


        </div>
    </div>



</div>
