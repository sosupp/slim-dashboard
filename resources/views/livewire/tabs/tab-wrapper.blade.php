<div>
    @if (!empty($this->tabPageHeading()))
    <h3 class="tab-pageheading">{!! $this->tabPageHeading() !!}</h3>
    @endif

    @includeIf($this->viewBeforeTabs())

    <div class="{{$this->tabContentWrapper()}}"
        x-data="{
            selectedTab: $wire.entangle('selectedTab').live,
            setNextTab: null,
            tabItems: [],
            endOfTabItems: false,
            getTabItems(){
                $wire.tabHeadings().then(result => {
                    this.tabItems = objectToArray(result);
                })
            },
            toggleSelected(tab){
                this.selectedTab = tab
            },
            nextTab() {
                const tabs = Array.isArray(this.tabItems)
                    ? this.tabItems.filter(t => t.isVisible)
                    : [];

                const currentIndex = tabs.findIndex(t => t.key === this.selectedTab);

                if (currentIndex === -1 || currentIndex >= tabs.length - 1) {
                    this.endOfTabItems = true;
                    return;
                }

                const nextIndex = currentIndex + 1;
                const nextTab = tabs[nextIndex].key;
                const nextTabObj = tabs.find(t => t.key === nextTab);
                const selectedTabObj = tabs.find(t => t.key === this.selectedTab);

                if (currentIndex < tabs.length - 1) {
                    this.toggleSelected(tabs[currentIndex + 1].key);
                }

                $dispatch('toggle-tab-component', {
                    component: nextTabObj.component,
                    url: nextTabObj.url,
                    view: nextTabObj.view,
                    tab: nextTabObj.key
                });

            }
        }" x-init="getTabItems()">

        @persist('tabheadings')
        <div class="{{$this->headingCss()}}">
            @foreach ($this->tabHeadings() as $tab)
            @if ($tab['isVisible'])
                @if ($this->useWireNavigate())
                <a class="{{$this->headingItemCss()}} as-pointer"
                    wire:key="{{$tab['key']}}"
                    wire:navigate.hover
                    href="{{$tab['url']}}"
                    :class="selectedTab == '{{$tab['key']}}' ? '{{$this->activeItemCss()}}' : ''"
                    x-on:click.prevent="toggleSelected('{{$tab['key']}}')"
                    tabindex="0"
                    role="tab"
                    :aria-selected="selectedTab == '{{$tab['key']}}' ? 'true' : 'false'"
                    aria-controls="tab-panel-{{$tab['key']}}"
                >
                {{$tab['heading']}}
                </a>
                @else
                <span class="{{$this->headingItemCss()}} as-pointer"
                    wire:key="{{$tab['key']}}"
                    :class="selectedTab == '{{$tab['key']}}' ? '{{$this->activeItemCss()}}' : ''"
                    x-on:click="
                        $dispatch('toggle-tab-component', {
                            component: '{{$tab['component']}}',
                            url: '{{$tab['url']}}',
                            view: '{{$tab['view']}}',
                            tab: '{{$tab['key']}}'
                        });
                        toggleSelected('{{$tab['key']}}')
                    "
                    tabindex="0"
                    role="button"
                    :aria-selected="selectedTab == '{{ $tab['key'] }}' ? 'true' : 'false'"
                >
                    {{$tab['heading']}}
                </span>
                @endif
            @endif
            @endforeach
            <!-- Right angle button to go to next tab -->
            <button type="button"
                class="tab-next-btn as-pointer"
                x-on:click="nextTab()"
                aria-label="Next Tab"
                :disabled="endOfTabItems"
                x-show="!endOfTabItems"
                x-cloak
            >
                &rsaquo;
            </button>
        </div>
        @endpersist

        <div class="selected-tab-items">
            <div class="order-items-wrapper">
                @if (isset($componentName) && !empty($componentName))
                    @livewire($componentName, $this->passExtraData(), key($componentName))
                @else
                @includeIf($this->useViewFile, $this->passExtraData())
                @endif

            </div>

            <div wire:loading.delay>
                <div class="full-table-loading">
                    <div class="loading-spinner">
                        <x-icons.bars-spinner-fade w="50" h="50" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
