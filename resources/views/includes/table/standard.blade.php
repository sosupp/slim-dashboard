@if ($this->showStandardTable())
<div class="table-and-loading" x-data="{
    tableSidePanel: false,
    sidePanelTitle: 'MORE INFO',
    selectedMoreId: null,
    moreData: {},
    moreKeys: [],
    setMoreCols(){
        $wire.useMoreCols().then(result => {
            if(result) {
                this.moreKeys = result;
            }
        })

    },
    toggleTableSidePanel(data = null,){
        this.tableSidePanel = !this.tableSidePanel;
        this.moreData = data;
        this.selectedMoreId = data.id;
        $wire.resolveMobileRecord(data.id).then(result => {
            if(result) {

            }
        })
    },
    getRecords(placeholder = '-'){
        const data = this.moreData;
        const cols = this.moreKeys;

        return cols.map(colObj => ({
            label: colObj.label,
            value: data.hasOwnProperty(colObj.col)
                ? data[colObj.col]
                : placeholder
        }));
    }
}" x-init="setMoreCols()">
    <x-slim-dashboard::table :theadings="$this->tableCols()"
        :withCheckbox="$this->withCheckbox"
        :hasActions="$this->hasActions">
        <x-slot:bodyRow>



        @if (!empty($this->useCustomTable()))
            @includeIf($this->useCustomTable())
        @else
            @forelse ($this->tableRecords as $index => $record)
                <tr wire:key="table_{{$index}}_{{$record['id']}}">
                    @if ($this->withCheckbox)
                    <td scope="row">
                        <input type="checkbox" value="{{$record['id']}}" wire:model="checkRecords">
                    </td>
                    @endif
                    @foreach ($this->tableCols() as $colHeading)
                        @if($colHeading['canView'] && $colHeading['screen'] == 'all')
                            <td class="">
                                @if ($colHeading === 'image')
                                    <img src="{{ asset($record[$colHeading]) }}" width="50">
                                @else
                                    @if (is_array($colHeading))
                                        @if (isset($colHeading['key']) && $colHeading['key'] === 'image')
                                            @include('slim-dashboard::includes.table.table-inline-image')
                                        @else
                                            @if (isset($colHeading['relation']) || $colHeading['callback'] !== null)
                                            <div class="inline-edit-wrapper">
                                                <div class="{{$colHeading['valueCss']}}">
                                                    {!! $this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['callback'] ?? null, $colHeading['valueCss']) !!}
                                                </div>
                                                @if ($colHeading['inlineEdit'])
                                                @include('slim-dashboard::includes.table.table-inline-edit')
                                                @endif
                                            </div>
                                            @else
                                                @if (isset($colHeading['type']) && $colHeading['type'] === 'toggle')
                                                    @if ($record->deleted_at)
                                                    <p class="deleted-label">Deleted</p>
                                                    @else
                                                    <label class="switch">
                                                        <input type="checkbox" value="{{ $record[$colHeading['col']] }}"
                                                            wire:click="toggleStatus({{ $record['id'] }}, '{{$colHeading['col']}}')"
                                                            {{ $record[$colHeading['col']] === 'active' ? 'checked' : '' }}>
                                                        <span class="slider round" :class="darkmode ? 'dmode-slider' : 'slider-bg'"></span>
                                                    </label>
                                                    @endif
                                                @elseif (isset($colHeading['type']) && ($colHeading['type'] === 'date' || $colHeading['format'] === 'date'))
                                                    {{ $this->customDateFormat($record[$colHeading['col']])}}
                                                @elseif ($colHeading['col'] == 'created_at' || $colHeading['col'] == 'updated_at' || $colHeading['col'] == 'deleted_at' || $colHeading['col'] == 'date')
                                                    {{$this->customDateFormat($record[$colHeading['col']])}}
                                                @elseif (isset($colHeading['format']) && $colHeading['format'] === 'number')
                                                {!! shortNumberFormat($record[$colHeading['col']]) !!}
                                                @else
                                                    @if ($colHeading['inlineEdit'])
                                                        <div class="inline-edit-wrapper">
                                                            <div class="{{$colHeading['valueCss']}}">{{ $record[$colHeading['col']] }}</div>
                                                            @include('slim-dashboard::includes.table.table-inline-edit')
                                                        </div>
                                                    @else
                                                        <div class="{{$colHeading['valueCss']}}">{{ $record[$colHeading['col']] }}</div>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        <div class="{{$colHeading['valueCss']}}">{{ $record[$colHeading] }}</div>
                                    @endif
                                @endif
                            </td>
                        @endif
                    @endforeach

                    @if ($this->hasActions)
                    <td wire:ignore>
                        @forelse ($this->tableActions() as $action)
                            @include('slim-dashboard::includes.table.table-actions')
                        @empty
                        @endforelse
                    </td>
                    @endif
                </tr>
            @empty

            @endforelse
        @endif

        </x-slot:bodyRow>
    </x-slim-dashboard::table>

    <div x-cloak x-show="tableSidePanel">
        <div class="side-modal-overlay" x-on:click="tableSidePanel=false"></div>
        <div class="table-form side-modal-panel">
            {{-- @includeIf($this->tableForm()) --}}
            <div class="side-modal-heading-wrapper">
                <p class="side-modal-heading" x-text="sidePanelTitle"></p>
                <span class="close-modal as-pointer" x-on:click="tableSidePanel=false">
                    <x-icons.close />
                </span>
            </div>

            <div>
                <template x-for="item in getRecords()" :key="item.label">
                    <div class="table-more-item-wrapper">
                        <div class="more-item-label" x-text="item.label"></div>
                        <div class="more-item-value" x-text="item.value"></div>
                    </div>
                </template>
            </div>

            <div class="table-more-actions">
                <p class="panel-content-heading">
                    <b>More Actions: </b>
                </p>
                @if ($this->hasActions)
                     @forelse ($this->tableActions() as $action)
                        @include('slim-dashboard::includes.table.table-actions', [
                            'screen' => 'more',
                            'record' => $this->mobileMoreRecord
                        ])
                    @empty
                    @endforelse
                @endif
            </div>
        </div>
    </div>

    <div wire:loading>
        <div class="full-table-loading">
            <div class="loading-spinner">
                <x-icons.bars-spinner-fade w="50" h="50" />
            </div>
        </div>
    </div>
</div>
@endif
