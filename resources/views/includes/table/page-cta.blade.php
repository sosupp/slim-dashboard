@if (is_array($this->pageCta()))
<div x-data="{
    dropdownAction(){
        console.log('selected')
    }
}">
    @foreach ($this->pageCta() as $key => $cta)
        @if (isset($cta['show']) && $cta['show'])
            @if (isset($cta['type']))
                @if ($cta['type'] === 'link')

                    @if ($cta['withSidePanel'])
                    <button type="button" class="custom-btn as-pointer {{$cta['css'] ?? ''}}"
                        x-on:click="toggleSidePanel('{{ $cta['label'] }}')">{{ $cta['label'] }}</button>
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
@endif
