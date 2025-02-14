<div x-data="{
        cardModal: false,
        selectedCard: null,
        cardItem: [],
        openCardModal(key, item){
            if(key==this.selectedCard){
                this.cardModal = !this.cardModal
                this.cardItem = item
            }
        },
        ctaRoute(url = 'login', model = null){
            let setUrl = `${url}/${this.selectedCard}`
            Livewire.navigate(setUrl)
        }
    }">

    @foreach ($this->tableRecords as $record)

        <div class="as-card-item-plain as-pointer">

            <div class="card-item-details">
                @if ($this->withListCardImage() === 'editable')
                    <div class="card-item-image">
                        @include('slim-dashboard::includes.table.mobile.inline-image', [
                            'record' => $record,
                            'imageName' => $this->mobileEditImageName($record)
                        ])
                    </div>
                @else
                    {{$this->withListCardImage()}}
                @endif

                <div class="card-item-info card-item-info-detail" x-on:click="selectedCard='{{$record->id}}',openCardModal('{{$record->id}}', {{$this->withCardModalData($record)}})">
                    <div>
                        @foreach ($this->cardContents() as $key => $colHeading)
                            <div class="card-inline-items">
                            @foreach ($colHeading as $rowItem)
                                @if ($rowItem['canView'])
                                    @if (isset($rowItem['relation']))
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
                    </div>

                    <div class="card-item-cta as-pointer">
                        <x-icons.chevron-right w="32" color="#535151" stroke="1"/>

                        @if ($this->withListCardEdit($record))
                            @if (!empty($this->withListCardEdit($record)->navigate))
                                <a wire:navigate href="{{$this->withListCardEdit($record)->navigate}}"
                                    class="card-inline-edit"
                                    x-on:click.stop>
                                    <x-icons.edit w="21" color="green"/>
                                </a>
                            @else

                                <span class="card-inline-edit" x-on:click.stop="toggleSidePanel(
                                    '{{$this->withListCardEdit($record)->form}}',
                                    '{{$this->withListCardEdit($record)->title}}',
                                    '{{$record->id}}'
                                )">
                                    <x-icons.edit w="21" color="green"/>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>


        </div>

    @endforeach

    <div wire:loading>
        <div class="full-table-loading">
            <div class="loading-spinner">
                <x-icons.bars-spinner-fade w="50" h="50" />
            </div>
        </div>
    </div>


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
                </div>
            </div>
        </div>
    </div>
</div>
