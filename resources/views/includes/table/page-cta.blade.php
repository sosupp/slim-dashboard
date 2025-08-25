@if (is_array($this->pageCta()))
<div x-data="{
    mobileCta: false,
    canShow: 'none',
    dropdownAction(){
        console.log('selected')
    },
    openMobileCta(){
        this.mobileCta = !this.mobileCta
        if(this.canShow == '' || this.canShow =='none'){
            this.canShow = 'block'
            return;
        }

        if(this.canShow='block'){
            this.canShow = 'none'
        }

    },
    isMobile(){
        return window.innerWidth <= 768 ? true : false;
    },
    isDesktop(){
        return window.innerWidth > 768 ? true : false;
    }
}" class="page-cta-wrapper">

    <div class="page-cta-wrapper-items mobile-cta for-desktop">
        @foreach ($this->pageCta() as $key => $cta)
            @if (isset($cta['show']) && $cta['show'])
                @if (isset($cta['type']))
                    @if ($cta['type'] === 'link')

                        @if ($cta['withSidePanel'])
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}}"
                            x-on:click="toggleSidePanel('{{ $cta['component'] }}', '{{ $cta['label'] }}')">{{ $cta['label'] }}</button>
                        @else
                        <a href="{{ $cta['route'] }}" wire:navigate class="custom-btn {{$cta['css'] ?? ''}}">{{ $cta['label'] }}</a>
                        @endif
                    @endif

                    @if ($cta['type'] === 'button')
                        @if ($cta['shouldConfirm'])
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                            wire:click="{{$cta['wireAction']}}"
                            wire:loading.attr="disabled"
                            wire:target="{{$cta['wireTarget']}}"
                            wire:confirm="Do you want to continue?">{{ $cta['label'] }}</button>
                        @else
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                            wire:click="{{$cta['wireAction']}}"
                            wire:loading.attr="disabled"
                            wire:target="{{$cta['wireTarget']}}">{{ $cta['label'] }}</button>
                        @endif
                    @endif

                    @if ($cta['type'] === 'export')
                        <select name="bulkAction" id="bulkAction"
                            class="{{$cta['css'] ?? 'custom-btn'}}"
                            wire:model.live="selectedExportType"
                            wire:change="{{$cta['wireAction']}}">
                            <option>{{$cta['label']}}</option>
                            @forelse ($cta['options'] as $key => $option)
                                @if (is_array($option))
                                <option value="{{$option[$cta['optionId']]}}">{{$option[$cta['optionKey']]}}</option>
                                @else
                                <option value="{{$option}}">{{$option}}</option>
                                @endif
                            @empty
                                Add options.
                            @endforelse
                        </select>
                    @endif

                    @if ($cta['type'] === 'dropdown' || $cta['type'] === 'select')
                        <select name="bulkAction" id="bulkAction" wire:model.live="{{$cta['wireProperty']}}"
                            wire:change="{{$cta['wireAction']}}"

                            class="filter-wrapper as-pointer">
                            <option>{{$cta['label']}}</option>
                            @forelse ($cta['options'] as $option)
                                @if (is_array($option))
                                <option value="{{$option[$cta['optionId']]}}">{{$option[$cta['optionKey']]}}</option>
                                @else
                                <option value="{{$option}}">{{$option}}</option>
                                @endif
                            @empty
                                Add options.
                            @endforelse
                        </select>
                    @endif
                @endif
            @endif
        @endforeach
    </div>

    <div class="page-cta-wrapper-items mobile-cta" x-show="mobileCta" x-cloak>
        @foreach ($this->pageCta() as $key => $cta)
            @if (isset($cta['show']) && $cta['show'])
                @if (isset($cta['type']))
                    @if ($cta['type'] === 'link')

                        @if ($cta['withSidePanel'])
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}}"
                            x-on:click="toggleSidePanel('{{ $cta['component'] }}', '{{ $cta['label'] }}')">{{ $cta['label'] }}</button>
                        @else
                        <a href="{{ $cta['route'] }}" wire:navigate class="custom-btn {{$cta['css'] ?? ''}}">{{ $cta['label'] }}</a>
                        @endif
                    @endif

                    @if ($cta['type'] === 'button')
                        @if ($cta['shouldConfirm'])
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                            wire:click="{{$cta['wireAction']}}"
                            wire:loading.attr="disabled"
                            wire:target="{{$cta['wireTarget']}}"
                            wire:confirm="Do you want to continue?">{{ $cta['label'] }}</button>
                        @else
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                            wire:click="{{$cta['wireAction']}}"
                            wire:loading.attr="disabled"
                            wire:target="{{$cta['wireTarget']}}">{{ $cta['label'] }}</button>
                        @endif
                    @endif

                    @if ($cta['type'] === 'export')
                        <select name="bulkAction" id="bulkAction"
                            class="{{$cta['css'] ?? 'custom-btn'}}"
                            wire:model.live="selectedExportType"
                            wire:change="{{$cta['wireAction']}}">
                            <option>{{$cta['label']}}</option>
                            @forelse ($cta['options'] as $key => $option)
                                @if (is_array($option))
                                <option value="{{$option[$cta['optionId']]}}">{{$option[$cta['optionKey']]}}</option>
                                @else
                                <option value="{{$option}}">{{$option}}</option>
                                @endif
                            @empty
                                Add options.
                            @endforelse
                        </select>
                    @endif


                    @if ($cta['type'] === 'dropdown' || $cta['type'] === 'select')
                        <select name="bulkAction" id="bulkAction" wire:model.live="{{$cta['wireProperty']}}"
                            wire:change="{{$cta['wireAction']}}"

                            class="filter-wrapper filter-wrapper as-pointer">
                            <option>{{$cta['label']}}</option>
                            @forelse ($cta['options'] as $option)
                                @if (is_array($option))
                                <option value="{{$option[$cta['optionId']]}}">{{$option[$cta['optionKey']]}}</option>
                                @else
                                <option value="{{$option}}">{{$option}}</option>
                                @endif
                            @empty
                                Add options.
                            @endforelse
                        </select>
                    @endif
                @endif
            @endif
        @endforeach
    </div>

    <div class="mobile-menu-overlay" x-show="mobileCta" x-cloak x-on:click="openMobileCta">
        <span class="as-pointer mobile-close-cta" id="mobileCtaClose" x-show="isMobile()" x-cloak>
            <x-slim-dashboard::icons.close />
        </span>
    </div>

    <span class="as-pointer mobile-more-trigger {{$this->mobileMoreCtaCss()}}" x-on:click="openMobileCta" x-show="isMobile()" x-cloak>
        <x-slim-dashboard::icons.more w="32" color="#fff"/>
    </span>
</div>
@endif
