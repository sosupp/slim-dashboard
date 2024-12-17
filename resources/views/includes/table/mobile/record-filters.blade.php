@props(['filterWrapper' => '', 'filterTriggerCss' => ''])
<div class="{{$filterWrapper}}" x-data="{
        filterModal: false,
        toggleFilter() {
            this.desktop = !this.desktop;
            this.filterModal = !this.filterModal;
        },
        filterResult(label, call = null){
            this.mobileFilterLabel = label
            this.toggleFilter()
        }
    }">

    <button type="button" class="filter-wrapper filter-trigger {{$filterTriggerCss}} as-pointer"
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
                                        @if (isset($option['type']) && $option['type'] == 'toggler')
                                        <div class="modal-filter-item-wrapper">
                                            <button class="modal-filter-item as-pointer" type="button"
                                                x-on:click="toggleSidePanel('', 'Custom date range');triggerLabel= '{{$option[$filter['optionKey']]}}';toggleFilter()"
                                                id="customToggler">{{$option[$filter['optionKey']]}}</button>
                                        </div>
                                        @else
                                        <div class="modal-filter-item-wrapper">

                                            <button class="modal-filter-item as-pointer" type="button"
                                                wire:click="{{$filter['wireAction'] . "('".  $option[$filter['optionId']] ."')" }}"
                                                x-on:click="filterResult('{{$option[$filter['optionKey']]}}')">{{$option[$filter['optionKey']]}}</button>
                                        </div>
                                        @endif
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


