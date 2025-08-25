@props([
    'id' => '$id',
    'label' => '$label',
    'labelCss' => 'special-input-label inherit-bg',
    'wrapperCss' => 'special-input-wrapper',
    'inputCss' => 'special-input',
    'name' => '',
    'state' => '',
    'xClick' => '',
])

<div class="{{$wrapperCss}}" wire:ignore>
    <label for="{{$id}}" class="{{$labelCss}}">{{$label}}</label>
    <textarea
        id="{{$id}}"
        {!! $attributes->merge() !!}
        wire:model="{{$name}}"
        class="{{$inputCss}}">{{old($name)}}</textarea>

    @error($name)
        <span class="error form-error">{{$message}}</span>
    @enderror
</div>

