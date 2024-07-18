
<div x-data="{
        sidePanel: $wire.entangle('hasSidePanel'),
        sidePanelTitle: '',
        subnav: $wire.entangle('subnav').live,
        useComponent: false,
        componentName: $wire.entangle('sidePanelComponent').live,
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
    }">

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

    <div class="page-grid-layout">
        @if (!empty($this->pageSideData()))
        <div class="page-side-data" :class="darkmode ? 'use-dark-theme card-wrapper' : ''">
            {{$this->pageSideData()}}
        </div>
        @endif

        <div class="page-table-section" :class="darkmode ? 'use-dark-theme card-wrapper' : '{{$this->tableWrapperCss}}'">

            <div class="table-cta-wrapper {{$this->tableHeadingCss}}">
                @if (!empty($this->tableHeading()))
                <h2 class="table-heading">{!! $this->tableHeading() !!}</h2>
                @endif

                <div class="search-input-and-results" x-data="{openResults: true}">
                    @include('slim-dashboard::includes.platform.search-input')

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

            <div class="">
                @if ($this->useSideModal())
                @include('slim-dashboard::includes.table.side-panel')
                @endif
            </div>

            @if ($this->showPaginationFilter())
            <div class="custom-pagination-wrapper">
                @if ($this->showPagination())
                <div class="record-count">
                    <span class="total-record-count">{{$this->tableRecords->total()}} records</span>
                </div>
                @endif

                <div class="filters-and-pagination">
                    @include('slim-dashboard::includes.table.table-filters')

                    @if ($this->showPagination())
                    @include('slim-dashboard::includes.table.table-navs')
                    @endif
                </div>

            </div>
            @endif

            @if ($this->showInlineTableStatistics)
            @include('slim-dashboard::includes.table.table-inline-statistics')
            @endif


            @if ($this->showTableToCards())
            <div class="table-convert-card-wrapper for-small for-mobile">
                @forelse ($this->tableRecords as $index => $record)
                <div class="table-card-item-wrapper" :class="darkmode ? '' : 'lmode-wrapper'">
                    <div class="table-card-item">
                        <div class="table-card-image">
                            @foreach ($this->tableCols() as $index => $colHeading)
                                @if (isset($colHeading['key']) && $colHeading['key'] === 'image')
                                    @if ($colHeading['label'] === 'image')
                                        @include('slim-dashboard::includes.table.table-inline-image')
                                    @endif
                                @endif
                            @endforeach
                        </div>

                        <div class="table-card-info grid-wrapper">
                            @foreach ($this->tableCols() as $index => $colHeading)
                                @if($colHeading['canView'])
                                    @if (isset($colHeading['key']) && $colHeading['key'] === 'info')

                                        @if (is_array($colHeading))
                                            @if ($colHeading['label'] === 'image')
                                                @include('slim-dashboard::includes.table.table-inline-image')
                                            @else
                                                @if (isset($colHeading['relation']))
                                                <div class="card-item-wrapper {{$colHeading['css']}}">
                                                    {!! $this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['callback'] ?? null) !!}
                                                    @if ($colHeading['showLabel'])
                                                    <p class="item-label2">{{ $colHeading['label'] }}</p>
                                                    @endif
                                                </div>
                                                @else
                                                    @if (isset($colHeading['type']) && $colHeading['type'] === 'toggle')
                                                        <label class="switch">
                                                            <input type="checkbox" value="{{ $record[$colHeading['col']] }}"
                                                                wire:click="toggleStatus({{ $record->id }})"
                                                                {{ $record[$colHeading['col']] === 'active' ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    @else
                                                        <div class="card-item-wrapper {{$colHeading['css']}}">
                                                            <p class="item-value">{{ $record[$colHeading['col']] }}</p>

                                                            @if ($colHeading['showLabel'])
                                                            <p class="item-label2">{{ $colHeading['label'] }}</p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            <div class="card-item-wrapper {{$colHeading['css']}}">
                                                {{ $record[$colHeading] }}
                                                @if ($colHeading['showLabel'])
                                                <p class="item-label2">{{ $colHeading['label'] }}</p>
                                                @endif
                                            </div>
                                        @endif

                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="table-card-cta">
                        @forelse ($this->tableActions() as $action)
                            @include('slim-dashboard::includes.table.table-actions')
                        @empty
                        @endforelse
                    </div>
                </div>
                @empty

                @endforelse
            </div>
            @endif

            @if ($this->showStandardTable())
            <div class="table-and-loading ">
                <x-slim-dashboard::table :theadings="$this->tableCols()"
                    :withCheckbox="$this->withCheckbox"
                    :hasActions="$this->hasActions">
                    <x-slot:bodyRow>

                        @if (!empty($this->useCustomTable()))
                            @includeIf($this->useCustomTable())
                        @else
                            @foreach ($this->tableRecords as $index => $record)
                                <tr>
                                    @if ($this->withCheckbox)
                                    <td scope="row">
                                        <input type="checkbox" value="{{$record->id}}" wire:model="checkRecords">
                                    </td>
                                    @endif
                                    @foreach ($this->tableCols() as $colHeading)
                                        @if($colHeading['canView'])
                                            <td class="{{$colHeading['css']}}">
                                                @if ($colHeading === 'image')
                                                    <img src="{{ asset($record[$colHeading]) }}" width="50">
                                                @else
                                                    @if (is_array($colHeading))
                                                        @if ($colHeading['label'] === 'image')
                                                            @include('slim-dashboard::includes.table.table-inline-image')
                                                        @else
                                                            @if (isset($colHeading['relation']))
                                                            <div class="inline-edit-wrapper">
                                                                {!! $this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['callback'] ?? null) !!}
                                                                @if ($colHeading['inlineEdit'])
                                                                @include('slim-dashboard::includes.table.table-inline-edit')
                                                                @endif
                                                            </div>
                                                            @else
                                                                @if (isset($colHeading['type']) && $colHeading['type'] === 'toggle')
                                                                    <label class="switch">
                                                                        <input type="checkbox" value="{{ $record[$colHeading['col']] }}"
                                                                            wire:click="toggleStatus({{ $record->id }})"
                                                                            {{ $record[$colHeading['col']] === 'active' ? 'checked' : '' }}>
                                                                        <span class="slider round" :class="darkmode ? 'dmode-slider' : 'slider-bg'"></span>
                                                                    </label>
                                                                @else
                                                                    @if ($colHeading['inlineEdit'])
                                                                        <div class="inline-edit-wrapper">
                                                                            {{ $record[$colHeading['col']] }}
                                                                            @include('slim-dashboard::includes.table.table-inline-edit')
                                                                        </div>
                                                                    @else
                                                                        {{ $record[$colHeading['col']] }}
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{ $record[$colHeading] }}
                                                    @endif
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach

                                    @if ($this->hasActions)
                                    <td>
                                        @forelse ($this->tableActions() as $action)
                                            @include('slim-dashboard::includes.table.table-actions')
                                        @empty
                                        @endforelse
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif



                    </x-slot:bodyRow>
                </x-slim-dashboard::table>

                <div wire:loading>
                    <div class="full-table-loading">
                        <div class="loading-spinner">
                            <x-icons.bars-spinner-fade w="50" h="50" />
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
