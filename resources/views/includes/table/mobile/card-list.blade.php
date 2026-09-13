<div x-data="{
        cardModal: false,
        selectedCard: null,
        recordDeleted: $wire.entangle('modalRecordDeleted'),
        modalRecordId: null,
        modalRecord: $wire.entangle('modalRecord').live,
        cardItem: [],
        withMoreData: [],

        openCardModal(moreData, item, deleted){
            const key = moreData.id;

            this.selectedCard = key;
            this.cardModal = true;
            this.cardItem = item;
            this.modalRecordId = key;
            this.modalRecord = item;
            this.recordDeleted = deleted;
            this.withMoreData = moreData;

            this.$wire.openModalRecord(key);

            console.log('Successfully opened card modal for ID:', key);
        },
        ctaRoute(url = 'login', model = null){
            let setUrl = `${url}/${this.selectedCard}`
            Livewire.navigate(setUrl)
        }
    }">

    @forelse ($this->tableRecords as $record)
        <div class="as-card-item-plain as-pointer" {{$record->deleted_at ? 'deleted-record' : ''}}
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

                <div class="card-item-info card-item-info-detail">
                    <div>
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
                                        <p class="card-item-name item-heading {{$rowItem['css']}}">
                                            @if ($rowItem['label'] !== null)
                                            <span class="{{$rowItem['labelCss']}}">{{$rowItem['label']}}:</span>
                                            @endif

                                            <span class="{{$rowItem['valueCss']}}">{!! $this->relation($record, $rowItem['relation'], $rowItem['name'], $rowItem['callback'] ?? null) !!}</span>
                                        </p>
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
                        <x-slim-dashboard::icons.chevron-right w="32" color="#535151" stroke="1"/>

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
    @empty

    @endforelse

    <div x-cloak x-show="cardModal" x-on:keydown.escape.window="cardModal = false">
        <div class="action-modal" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"><h3 x-html="cardItem['title'] ?? cardItem[0]"></h3></span>
                    <span id="modalClose" class="as-pointer" x-on:click="cardModal=false">
                        &times;
                    </span>
                </div>
                <div class="modal-body">
                    {!! $this->withCardModalView() !!}

                    @if ($this->mobileModalCta())
                        @forelse ($this->tableActions() as $action)
                            @if ($action['screen'] !== 'more')
                                @include('slim-dashboard::includes.table.mobile.modal-ctas')
                            @endif
                        @empty
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>


</div>
