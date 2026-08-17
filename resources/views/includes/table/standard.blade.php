@if ($this->showStandardTable())
<div class="table-and-loading">
    <x-slim-dashboard::table :theadings="$this->tableCols()"
        :withCheckbox="$this->withCheckbox"
        :hasActions="$this->hasActions">
        <x-slot:bodyRow>



        @if (!empty($this->useCustomTable()))
            @includeIf($this->useCustomTable())
        @else
            @forelse ($this->tableRecords as $index => $record)
                <tr wire:key="table_{{$index}}_{{$record['id']}}" 
                    class="{{$record->deleted_at ? 'deleted-record' : ''}}"
                    x-init="entries.push({open: false, id: {{$index}}})"
                    x-on:click="toggle({{$index}})"
                    :class="{ 'is-open': entries[{{$index}}]?.open }">

                    @if ($this->withCheckbox)
                    <td scope="row">
                        <input type="checkbox" value="{{$record['id']}}" wire:model="checkRecords">
                    </td>
                    @endif

                    @foreach ($this->tableCols() as $colHeading)
                        @if($colHeading['canView'] && $colHeading['screen'] == 'all')
                            <td class="{{$colHeading['css'] ?? ''}}">
                                @if ($colHeading === 'image')
                                    <img src="{{ $record[$colHeading] ? asset($record[$colHeading]) : asset('default.webp') }}" width="50">
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
                    <td wire:ignore class="table-actions-row">
                        @forelse ($this->tableActions() as $action)
                            @include('slim-dashboard::includes.table.table-actions')
                        @empty
                        @endforelse
                    </td>
                    @endif
                </tr>

                @if ($this->withExpandableRows)
                    <tr wire:key="expandable_{{$index}}_{{$record['id']}}"
                        x-show="entries[{{$index}}]?.open" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="lines-row"
                        x-init="console.log(selected == entries[selected]?.id, selected)"
                        >
                            <td colspan="6">
                                {{ $this->expandableRowView() }}
                            </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="{{count($this->tableCols())}}">
                        <p style="color: #94a3b8;">No records for the selected filters</p>
                    </td>
                </tr>
            @endforelse
        @endif

        </x-slot:bodyRow>
    </x-slim-dashboard::table>

    <div wire:loading.delay.longest>
        <div class="full-table-loading">
            <div class="loading-spinner">
                <x-slim-dashboard::icons.bars-spinner-fade w="50" h="50" />
            </div>
        </div>
    </div>
</div>
@endif
