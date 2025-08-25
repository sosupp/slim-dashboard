@props([
    'id' => '$id',
    'name' => '',
    'action' => '',
    'option' => '',
    'optionId' => '',
    'optionKey' => '',
    'options' => [],
    'label' => '$label',
    'class' => '',
    'allowLabel' => false,
])

<div class="{{$class}}">
    @if ($allowLabel)
    <label for="{{$id}}">{{$label}}</label>
    @endif

    <select class="custom-form-control"
        id="{{$id}}"
        wire:model.live="{{$name}}"
        wire:key="{{$id}}_{{$label}}_{{$name}}"
        {{$action}}>

        <option value="{{$optionId ?? $option}}">{{$option == '' ? $label : $option}}</option>

        @foreach ($options as $opt)
        <option value="{{$opt->id ?? $opt[$optionId] ?? $opt}}">{{$opt->$optionKey ?? $opt[$optionKey] ?? $opt}}</option>
        @endforeach
    </select>

    @error($name)
        <span class="form-error">{{$message}}</span>
    @enderror
</div>
