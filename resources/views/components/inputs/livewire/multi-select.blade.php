@props([
    'id' => '$id',
    'name' => '',
    'action' => '',
    'option' => [],
    'optionId' => '',
    'optionKey' => '',
    'options' => [],
    'label' => '$label',
    'class' => '',
])

<div wire:Key="multi_text_area" {{$attributes->merge(['class' => $class])}}>
    <label for="{{$id}}">{{$label}}</label>
    <select class="form-control"
        id="{{$id}}"
        wire:model="{{$name}}"
        wire:key="{{$id}}_{{$label}}"
        {{$action}}
        multiple>



        @foreach ($options as $key => $opt)
        <option value="{{$opt[$optionId] ?? $opt}}">
            {{$opt[$optionKey] ?? $opt}}
        </option>
        @endforeach
    </select>
    @error($name)
        <span class="form-error">{{$message}}</span>
    @enderror
</div>
