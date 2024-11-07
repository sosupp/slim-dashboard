@if ($this->showPaginationFilter())
<div class="custom-pagination-wrapper">

    <div class="mobile-page-filters">
        <div class="mobile-filter-modal" x-data="{
            filterModal: false,
            toggleFilter() {
                this.desktop = !this.desktop;
                this.filterModal = !this.filterModal;
                console.log('effect')
            },
            filterResult(label, call = null){
                this.mobileFilterLabel = label
                this.toggleFilter()
            }
        }">

            <button type="button" class="filter-wrapper filter-trigger as-pointer"
                x-on:click="toggleFilter">
                Filter
                <x-icons.chevron />
            </button>

            <div x-cloak x-show="filterModal" x-on:keydown.escape.window="filterModal = false">
                <div class="action-modal" style="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="modal-title"><h3>Filters</h3></span>
                            <span id="modalClose" class="as-pointer" x-on:click="filterModal=false">
                                &times;
                            </span>
                        </div>
                        <div class="modal-body" x-data="{
                            openSection: null
                        }">
                            <div class="modal-filter-wrapper">
                                @foreach ($this->pageFilters() as $filter)
                                    <div class="modal-filter-item-wrapper">
                                        <button type="button" class="as-pointer modal-filter-item-label"
                                        x-on:click="openSection = (openSection === '{{$filter['label']}}' ? null : '{{$filter['label']}}')">
                                            {{$filter['label']}}

                                            <span x-show="openSection!=='{{$filter['label']}}'"><x-icons.chevron-right /></span>
                                            <span x-show="openSection==='{{$filter['label']}}'"><x-icons.chevron /></span>

                                        </button>
                                    </div>

                                    <div x-cloak x-show="openSection==='{{$filter['label']}}'" class="modal-filter-items">
                                        @if ($filter['options'])
                                            @foreach ($filter['options'] as $key => $option)
                                                <div class="modal-filter-item-wrapper">
                                                    <button class="modal-filter-item as-pointer" type="button"
                                                        wire:click="{{$filter['wireAction'] . "('".  $option[$filter['optionId']] ."')" }}"
                                                        x-on:click="filterResult('{{$option[$filter['optionKey']]}}')">{{$option[$filter['optionKey']]}}</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($this->showPagination())
        @include('slim-dashboard::includes.table.table-navs')
        @endif
    </div>

</div>
@endif

<div class="search-and-listing">

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
    
    @if ($this->showPagination())
    <div class="record-count">
        <span x-cloak x-show="mobileFilterLabel" x-text="mobileFilterLabel"></span>
        <span class="total-record-count">({{$this->tableRecords->total()}})</span>
    </div>
    @endif
    
    <div class="item-listings-wrapper">
        {!! $this->listAsCards() !!}
    </div>
</div>
