<div class="{{$this->cardListingWrapper()}}" x-data="{
        cardModal: false,
        selectedCard: null,

        recordDeleted: $wire.entangle('modalRecordDeleted'),
        modalRecordId: null,
        modalRecord: $wire.entangle('modalRecord').live,

        cardItem: [],
        withMoreData: [],

        latestDate: @js($this->latestGroupedDate()),
        openDateGroups: {},

        isDateGroupOpen(date) {
            if (Object.prototype.hasOwnProperty.call(this.openDateGroups, date)) {
                return this.openDateGroups[date];
            }

            return date === this.latestDate;
        },

        toggleDateGroup(date) {
            this.openDateGroups[date] = !this.isDateGroupOpen(date);
            console.log(date, this.openDateGroups, this.dateGroups)
        },

        openCardModal(moreData, item, deleted) {
            const key = moreData.id;

            this.selectedCard = key;
            this.cardModal = true;
            this.cardItem = item;
            this.modalRecordId = key;
            this.modalRecord = item;
            this.recordDeleted = deleted;
            this.withMoreData = moreData;

            this.$wire.openModalRecord(key);
        },

        ctaRoute(url = 'login', model = null) {
            Livewire.navigate(`${url}/${this.selectedCard}`);
        }
    }">

    @if ($this->groupListingByDate())
        <div class="mobile-date-groups">
            @forelse ($this->groupedTableRecords() as $date => $records)
                <section class="mobile-date-group"
                    wire:key="mobile-date-group-{{ $date }}">

                    {{-- Date group heading --}}
                    <button type="button"
                        class="mobile-date-group-heading"
                        x-on:click.stop="toggleDate(@js($date))"
                        x-bind:aria-expanded="isDateOpen(@js($date))"
                        {{-- x-show="isDateOpen(@js($date))" --}}
                        >
                        <span class="mobile-date-group-indicator"></span>

                        <span class="mobile-date-group-info">
                            <span class="mobile-date-group-title">
                                {{ euroDate($date, false)  }}
                            </span>

                            <span class="mobile-date-group-meta">
                                {{ $records->count() }}
                                {{ $records->count() === 1 ? 'record' : 'records' }}
                            </span>
                        </span>

                        <span
                            class="mobile-date-group-chevron"
                            x-bind:class="{ 'is-open': isDateOpen(@js($date)) }"
                        >
                            <x-slim-dashboard::icons.chevron-right
                                w="20"
                                color="currentColor"
                            />
                        </span>
                    </button>

                    {{-- Group records --}}
                    <div class="mobile-date-group-content" x-cloak
                        x-show="isDateOpen(@js($date))"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        @foreach ($records as $record)
                            @include('slim-dashboard::includes.table.mobile.card-item', [
                                'record' => $record,
                            ])
                        @endforeach

                    </div>

                </section>
            @empty
                <div class="mobile-empty-state">
                    <p>No records found</p>
                    <span>Records matching your filters will appear here.</span>
                </div>
            @endforelse

        </div>
    @else
        @forelse ($this->tableRecords as $record)
            @include('slim-dashboard::includes.table.mobile.card-item', [
                'record' => $record,
            ])
        @empty
            <div class="mobile-empty-state">
                <p>No records found</p>
                <span>Records matching your filters will appear here.</span>
            </div>
        @endforelse
    @endif

    {{-- @include('slim-dashboard::includes.utils.load-more') --}}

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
