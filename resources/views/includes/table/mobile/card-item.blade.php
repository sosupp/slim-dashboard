<div class="as-card-item-plain as-pointer {{ $record->deleted_at ? 'deleted-record' : '' }}"
    wire:key="mobile-record-{{ $record->id }}"
    x-on:click="openCardModal(
        @js($record),
        @js($this->withCardModalData($record)),
        @js($record->deleted_at)
    )">

    <div class="card-item-details">
        @if ($this->withListCardImage() === 'editable')
            <div class="card-item-image">
                @include('slim-dashboard::includes.table.mobile.inline-image', [
                    'record' => $record,
                    'image' => $this->mobileImageFile($record),
                    'imageName' => $this->mobileEditImageName($record)
                ])
            </div>
        @else
            {{$this->withListCardImage()}}
        @endif

        <div class="card-item-info">
            <div class="card-item-detail">
                @if ($this->tableColsForMobile())
                    @foreach ($this->tableCols() as $key => $rowItem)
                        <div class="card-inline-items">
                            @if ($rowItem['onMobile'] && $rowItem['canView'])
                                @if (isset($rowItem['relation']) || $rowItem['callback'] !== null)
                                <p class="card-item-name item-heading {{$rowItem['css']}}">
                                    <div>
                                        @if ($rowItem['showLabel'])
                                        <span class="{{$rowItem['labelCss']}}">{{$rowItem['label']}}:</span>
                                        @endif

                                        <span class="{{$rowItem['valueCss']}}">{!! $this->relation($record, $rowItem['relation'], $rowItem['col'], $rowItem['callback'] ?? null) !!}</span>
                                    </div>
                                    @if ($rowItem['inlineEdit'])
                                        @include('slim-dashboard::includes.table.table-inline-edit', [
                                            'colHeading' => $rowItem
                                        ])
                                    @endif
                                </p>
                                @elseif (isset($rowItem['type']) && $rowItem['type'] === 'date')
                                    <span class="{{$rowItem['valueCss']}}">{{ $this->customDateFormat($record[$rowItem['col']]) }}</span>
                                @elseif ($rowItem['col'] == 'created_at' || $rowItem['col'] == 'updated_at' || $rowItem['col'] == 'deleted_at' || $rowItem['col'] == 'date')
                                    <span class="{{$rowItem['valueCss']}}">{{ $this->customDateFormat($record[$rowItem['col']]) }}</span>
                                @elseif(isset($rowItem['type']) && $rowItem['type'] === 'toggle')
                                    @if ($record->deleted_at)
                                    <p class="deleted-label">Deleted</p>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" value="{{ $record[$rowItem['col']] }}"
                                            wire:click="toggleStatus({{ $record->id }}, '{{$rowItem['col']}}')"
                                            {{ $record[$rowItem['col']] === 'active' ? 'checked' : '' }}>
                                        <span class="slider round" :class="darkmode ? 'dmode-slider' : 'slider-bg'"></span>
                                    </label>
                                    @endif
                                @else
                                <p class="card-item-name item-heading">
                                    <div>
                                        @if ($rowItem['showLabel'])
                                        <span class="{{$rowItem['labelCss']}}">{{$rowItem['label']}}:</span>
                                        @endif
                                        <span class="{{$rowItem['valueCss']}}">{{$record[$rowItem['col']]}}</span>
                                    </div>

                                    @if ($rowItem['inlineEdit'])
                                        @include('slim-dashboard::includes.table.table-inline-edit', [
                                            'colHeading' => $rowItem
                                        ])
                                    @endif
                                </p>
                                @endif
                            @endif
                        </div>
                    @endforeach
                @else
                    @foreach ($this->cardContents() as $key => $colHeading)
                        <div class="card-inline-items">
                        @foreach ($colHeading as $rowItem)
                            @if ($rowItem['canView'])
                                @if (isset($rowItem['relation']) || $rowItem['callback'] !== null)
                                <div class="{{$rowItem['css'] ?? 'card-item-name item-heading'}}">
                                    @if ($rowItem['label'] !== null)
                                    <span class="{{$rowItem['labelCss']}}">{{$rowItem['label']}}:</span>
                                    @endif

                                    <span class="{{$rowItem['valueCss']}}">{!! $this->relation($record, $rowItem['relation'], $rowItem['name'], $rowItem['callback'] ?? null) !!}</span>
                                </div>
                                @elseif (isset($colHeading['type']) && $colHeading['type'] === 'date')
                                    <span class="{{$rowItem['valueCss']}}">{{ $this->customDateFormat($record[$rowItem['name']]) }}</span>
                                @elseif ($rowItem['name'] == 'created_at' || $rowItem['name'] == 'updated_at' || $rowItem['name'] == 'deleted_at' || $rowItem['name'] == 'date')
                                    <span class="{{$rowItem['valueCss']}}">{{ $this->customDateFormat($record[$rowItem['name']]) }}</span>
                                @elseif(isset($rowItem['type']) && $rowItem['type'] === 'toggle')
                                    @if ($record->deleted_at)
                                    <p class="deleted-label">Deleted</p>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" value="{{ $record[$rowItem['name']] }}"
                                            wire:click="toggleStatus({{ $record->id }}, '{{$rowItem['name']}}')"
                                            {{ $record[$rowItem['name']] === 'active' ? 'checked' : '' }}>
                                        <span class="slider round" :class="darkmode ? 'dmode-slider' : 'slider-bg'"></span>
                                    </label>
                                    @endif
                                @else
                                <p class="card-item-name item-heading">
                                    @if ($rowItem['label'] !== null)
                                    <span class="{{$rowItem['labelCss']}}">{{$rowItem['label']}}:</span>
                                    @endif
                                    <span class="{{$rowItem['valueCss']}}">{{$record[$rowItem['name']]}}</span>
                                </p>
                                @endif
                            @endif
                        @endforeach
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="card-item-cta as-pointer">
                @if ($this->showMobileCardChevron())
                <x-slim-dashboard::icons.chevron-right w="32" color="#535151" stroke="1"/>
                @endif

                @if ($this->withListCardEdit($record))
                    @if (!empty($this->withListCardEdit($record)->navigate))
                        <a wire:navigate href="{{$this->withListCardEdit($record)->navigate}}"
                            class="card-inline-edit"
                            x-on:click.stop>
                            <x-slim-dashboard::icons.edit w="21" color="green"/>
                        </a>
                    @else

                        <span class="card-inline-edit" x-on:click.stop="toggleSidePanel(
                            '{{$this->withListCardEdit($record)->form}}',
                            '{{$this->withListCardEdit($record)->title}}',
                            '{{$record->id}}'
                        )">
                            <x-slim-dashboard::icons.edit w="21" color="green"/>
                        </span>
                    @endif
                @endif
            </div>
        </div>
    </div>

</div>
