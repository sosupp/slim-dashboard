@if ($this->showTableToCards())
                @if (!empty($this->tableAsCardsView()))
                    @includeIf($this->tableAsCardsView())
                @else
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
                                    @if($colHeading['canView'] && $colHeading['screen'] == 'all')
                                        @if (isset($colHeading['key']) && $colHeading['key'] === 'info')

                                            @if (is_array($colHeading))
                                                @if ($colHeading['label'] === 'image')
                                                    @include('slim-dashboard::includes.table.table-inline-image')
                                                @else
                                                    @if (isset($colHeading['relation']) || $colHeading !== null)
                                                    <div class="card-item-wrapper {{$colHeading['valueCss']}}">
                                                        {!! $this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['callback'] ?? null, $colHeading['valueCss']) !!}
                                                        @if ($colHeading['showLabel'])
                                                        <p class="item-label2">{{ $colHeading['label'] }}</p>
                                                        @endif
                                                    </div>
                                                    @else
                                                        @if (isset($colHeading['type']) && $colHeading['type'] === 'toggle')
                                                            @if ($record->deleted_at)
                                                            <p class="deleted-label">Deleted</p>
                                                            @else
                                                            <label class="switch">
                                                                <input type="checkbox" value="{{ $record[$colHeading['col']] }}"
                                                                    wire:click="toggleStatus({{ $record->id }}, '{{$colHeading['col']}}')"
                                                                    {{ $record[$colHeading['col']] === 'active' ? 'checked' : '' }}>
                                                                <span class="slider round" :class="darkmode ? 'dmode-slider' : 'slider-bg'"></span>
                                                            </label>
                                                            @endif

                                                        @elseif(isset($colHeading['type']) && $colHeading['type'] === 'date')
                                                        {{euroDate($record[$colHeading])}}
                                                        @else
                                                            <div class="card-item-wrapper {{$colHeading['valueCss']}}">
                                                                <p class="item-value">{{ $record[$colHeading['col']] }}</p>

                                                                @if ($colHeading['showLabel'])
                                                                <p class="item-label2">{{ $colHeading['label'] }}</p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @else
                                                <div class="card-item-wrapper {{$colHeading['valueCss']}}">
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
            @endif