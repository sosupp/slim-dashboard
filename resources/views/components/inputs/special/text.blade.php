@props([
    'type' => 'text',
    'id' => '',
    'label' => '',
    'labelCss' => 'inherit-bg',
    'wrapperCss' => '',
    'inputCss' => '',
    'name' => '',
    'state' => '',
    'xClick' => '',
])

<div class="special-input-wrapper {{$wrapperCss}}">
    <label for="{{$id}}" class="special-input-label {{$labelCss}}">{{$label}}</label>

    <input class="special-input {{$inputCss}}" {!! $attributes->merge() !!}
        type="{{$type}}"
        name="{{$name}}"
        id="{{$id}}"
        wire:model{{$state}}="{{$name}}"
        x-on:click="{{$xClick}}"
    />

    @error($name)
        <span class="error form-error">{{$message}}</span>
    @enderror
</div>
