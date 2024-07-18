<div>
    <h3 class="tab-pageheading">{!! $this->tabPageHeading() !!}</h3>

    @includeIf($this->viewBeforeTabs())

    <div class="tab-content-wrapper"
        x-data="{
            selectedTab: $wire.entangle('selectedTab').live,
            tabItems: $wire.tabHeadings(),
            toggleSelected(tab){
                this.selectedTab = tab
            }
        }">

        @persist('tabheadings')
        <div class="tab-heading-wrapper {{$this->headingCss()}}">
            @foreach ($this->tabHeadings() as $tab)
            @if ($tab['isVisible'])
                @if ($this->useWireNavigate())
                <a class="{{$this->headingItemCss()}} as-pointer" wire:key="{{$tab['key']}}"
                    wire:navigate.hover href="{{$tab['url']}}"
                    :class="selectedTab == '{{$tab['key']}}' ? '{{$this->activeItemCss()}}' : ''"
                    x-on:click="toggleSelected('{{$tab['key']}}')">
                    {{$tab['heading']}}
                </a>
                @else
                <span class="{{$this->headingItemCss()}} as-pointer"
                    wire:key="{{$tab['key']}}"
                    :class="selectedTab == '{{$tab['key']}}' ? '{{$this->activeItemCss()}}' : ''"
                    x-on:click="$dispatch('toggle-tab-component', {component: '{{$tab['component']}}', url: '{{$tab['url']}}', view: '{{$tab['view']}}' }), toggleSelected('{{$tab['key']}}')">
                    {{$tab['heading']}}
                </span>
                @endif
            @endif
            @endforeach
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
