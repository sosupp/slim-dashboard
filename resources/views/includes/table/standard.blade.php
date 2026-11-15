@php
    $visibleColumns = collect($this->tableCols())
        ->filter(fn ($col) =>
            $col['canView'] && $col['screen'] === 'all'
        )->count();

    $totalColumns = $visibleColumns
        + ($this->withCheckbox ? 1 : 0)
        + ($this->hasActions ? 1 : 0);
@endphp

@if ($this->showStandardTable())
<div class="table-and-loading">

    <x-slim-dashboard::table :theadings="$this->tableCols()"
        :withCheckbox="$this->withCheckbox"
        :hasActions="$this->hasActions">

        <x-slot:bodyRow>
            @if ($this->showGroupedTable())

                {{-- Grouped table toolbar --}}
                <tr class="date-group-toolbar">
                    <td colspan="{{ $totalColumns }}">
                        <div class="date-group-toolbar-inner">

                            <span>
                                {{ count($this->tableRecords) }}
                                RECORDS
                            </span>

                            <div class="date-group-controls">
                                <button
                                    type="button"
                                    @click="expandAllDates()"
                                >
                                    Expand all
                                </button>

                                <button
                                    type="button"
                                    @click="collapseAllDates()"
                                >
                                    Collapse all
                                </button>
                            </div>

                        </div>
                    </td>
                </tr>

                {{-- Date groups --}}
                @forelse ($this->groupedTableRecords() as $date => $records)

                    @php
                        $groupDate = $date;
                    @endphp

                    {{-- Date heading --}}
                    <tr class="date-group-header"
                        wire:key="date-group-{{ $date }}">

                        <td colspan="{{ $totalColumns }}">

                            <button
                                type="button"
                                class="date-group-trigger"
                                @click.stop="toggleDate(@js($date))"
                                :aria-expanded="isDateOpen(@js($date))"
                            >

                                <span class="date-group-info">

                                    <span class="date-group-day">
                                        {{ $groupDate->format('d') }}
                                    </span>

                                    <span class="date-group-labels">

                                        <strong>
                                            {{ $groupDate->format('d F Y') }}
                                        </strong>

                                        <small>
                                            {{ $groupDate->format('l') }}
                                            &middot;
                                            {{ $records->count() }} RECORDS
                                        </small>

                                    </span>

                                </span>

                                <span class="date-group-chevron"
                                    :class="{
                                        'is-open': isDateOpen(@js($date))
                                    }">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>

                            </button>

                        </td>
                    </tr>

                    {{-- Records belonging to this date --}}
                    @foreach ($records as $index => $record)

                        @include(
                            'slim-dashboard::includes.table.desktop.table-record-row',
                            [
                                'record' => $record,
                                'index' => $index,
                                'groupDate' => $date,
                                'grouped' => true,
                            ]
                        )

                    @endforeach

                @empty

                    <tr>
                        <td colspan="{{ $totalColumns }}">
                            <div style="color:#94a3b8;text-align: center">
                                <p>No records found</p>
                                <span>Records matching your filters will appear here.</span>
                            </div>
                        </td>
                    </tr>

                @endforelse

            @else

                {{-- EXISTING STANDARD TABLE RENDERER --}}

                @if (!empty($this->useCustomTable()))
                    @includeIf($this->useCustomTable())
                @else

                    @forelse ($this->tableRecords as $index => $record)
                        @include(
                            'slim-dashboard::includes.table.desktop.table-record-row',
                            [
                                'record' => $record,
                                'index' => $index,
                                'grouped' => false,
                            ]
                        )
                    @empty
                        <tr>
                            <td colspan="{{ $totalColumns }}">
                                <div style="color:#94a3b8;text-align: center">
                                    <p>No records found</p>
                                    <span>Records matching your filters will appear here.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                @endif

            @endif
        </x-slot:bodyRow>
    </x-slim-dashboard::table>

</div>
@endif
