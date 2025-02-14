<div class="external-filters-wrapper as-pointer">
    @forelse ($this->pageFilters() as $filter)
    @if ($filter['showFilter'])
        @if ($filter['type'] == 'select')

        <select wire:model.live="{{$filter['wireProperty']}}" id="externalFilter"
            class="filter-wrapper select-filter as-pointer {{$filter['wrapperCss']}}" :class="darkmode ? 'dmode-input-bg' : ''" x-on:change="selectFilterLabel = $event.target.options[$event.target.selectedIndex].text">
            <option class="as-pointer filter-label" value="all">{{$filter['label']}}</option>

            @if ($filter['options'])
                @foreach ($filter['options'] as $key => $option)
                @if (is_array($option))
                <option class="as-pointer" value="{{$option[$filter['optionId']]}}">{{$option[$filter['optionKey']]}}</option>
                @else
                <option class="as-pointer" value="{{$option}}">{{$option}}</option>
                @endif
                @endforeach
            @endif
        </select>
        @endif

        @if ($filter['type'] == 'dropdown')

        <div x-data="{
                triggerLabel: $wire.entangle('dateLabel')
            }">
            <x-dropdown>
                <x-slot:trigger>
                    <div class="chevron-wrapper">
                        <span x-text="triggerLabel"></span>
                        <x-icons.chevron w="14" />
                    </div>
                </x-slot:trigger>

                <x-slot:content>
                    <div x-data="{
                        toggleDateSelector(){
                            console.log('calendar')
                        }
                    }">
                        @if ($filter['options'])
                            @foreach ($filter['options'] as $key => $option)
                                @if (isset($option['type']) && $option['type'] == 'toggler')
                                <button class="custom-dropdown-btn as-pointer" type="button"
                                    x-on:click="toggleSidePanel('', 'Custom date range'),triggerLabel= '{{$option[$filter['optionKey']]}}'"
                                    id="customToggler">{{$option[$filter['optionKey']]}}</button>
                                @else
                                <button class="custom-dropdown-btn as-pointer" type="button"
                                    wire:click="{{$filter['wireAction'] . "('".  $option[$filter['optionId']] ."')" }}"
                                    x-on:click="triggerLabel= '{{$option[$filter['optionKey']]}}'">{{$option[$filter['optionKey']]}}</button>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </x-slot:content>
            </x-dropdown>
        </div>
        @endif
    @endif

    @empty

    @endforelse
</div>
