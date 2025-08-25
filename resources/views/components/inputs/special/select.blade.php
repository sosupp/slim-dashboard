@props([
    'id' => '$id',
    'name' => '',
    'action' => '',
    'option' => null,
    'optionId' => '',
    'optionKey' => '',
    'options' => [],
    'label' => '$label',
    'class' => '',
    'allowLabel' => true,
    'labelCss' => 'inherit-bg',
    'wrapperCss' => '',
    'inputCss' => '',
    'showHolder' => true,
    'state' => '',

])

<div class="special-input-wrapper {{$class}}">
    @if ($allowLabel)
    <label for="{{$id}}" class="special-input-label {{$labelCss}}">{{$label}}</label>
    @endif

    <select class="special-input {{$inputCss}}"
        id="{{$id}}"
        wire:model{{$state}}="{{$name}}"
        wire:key="{{$id}}_{{$label}}_{{$name}}"
        {{$action}} {!! $attributes->merge() !!}>

        @if ($showHolder)
        <option value="{{$optionId ?? $option}}">{{$option == null ? '' : $option}}</option>
        @endif

        @foreach ($options as $opt)
        <option value="{{$opt->id ?? $opt[$optionId] ?? $opt}}">{{$opt->$optionKey ?? $opt[$optionKey] ?? $opt}}</option>
        @endforeach
    </select>

    @error($name)
        <span class="form-error">{{$message}}</span>
    @enderror
</div>
