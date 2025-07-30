@if ($this->showStandardTable())
<div class="table-and-loading ">
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

    <div wire:loading>
        <div class="full-table-loading">
            <div class="loading-spinner">
                <x-icons.bars-spinner-fade w="50" h="50" />
            </div>
        </div>
    </div>
</div>
@endif