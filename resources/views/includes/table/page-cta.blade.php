@if (is_array($this->pageCta()))
<div x-data="{
    mobileCta: false,
    dropdownAction(){
        console.log('selected')
    },
    openMobileCta(){
        this.mobileCta = !this.mobileCta
    },
    isMobile(){
        return window.innerWidth <= 768 ? true : false;
    },
    isDesktop(){
        return window.innerWidth > 768 ? true : false;
    }
}" class="page-cta-wrapper" x-init="isDesktop() ? mobileCta = true : mobileCta = false">

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
                        <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                            wire:click="{{$cta['wireAction']}}"
                            wire:loading.attr="disabled"
                            wire:target="{{$cta['wireTarget']}}"
                            wire:confirm="Do you want to continue?">{{ $cta['label'] }}</button>
                    @endif

                    @if ($cta['type'] === 'select')
                        <select name="bulkAction" id="bulkAction">
                            <option>Bulk Action</option>
                            <option value="">Attach all products</option>
                            <option value="">Delete all products</option>
                        </select>
                    @endif

                    @if ($cta['type'] === 'dropdown')
                        <select name="bulkAction" id="bulkAction" wire:model.live="{{$cta['wireProperty']}}"
                            wire:change="{{$cta['wireAction']}}" class="filter-wrapper select-filter as-pointer">
                            <option>{{$cta['label']}}</option>
                            @forelse ($cta['options'] as $option)
                            <option value="{{$option[$cta['optionId']]}}">{{$option[$cta['optionKey']]}}</option>
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
            <x-icons.close />
        </span>

    </div>
    <span class="as-pointer" x-on:click="openMobileCta" x-show="isMobile()" x-cloak>
        <x-icons.more w="32" color="#000"/>
    </span>
</div>
@endif
