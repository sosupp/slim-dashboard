@props([
    'id' => '$id',
    'label' => '$label',
    'name' => '',
    'value' => '',
    'action' => '',
    'class' => '',
    'placeholder' => '',
    'body' => '',
    'rows' => '1'
])

<div {{$attributes->merge(['class' => $class])}}>
    <label for="{{$id}}">{{$label}}</label>
    <textarea
        id="{{$id}}"
        rows="{{$rows}}"
        name="{{$name}}"
        wire:model="{{$name}}"
        class="form-control"
        {{$action}}>{{old($name)}}</textarea>

    @error($name)
        <span class="error">{{$message}}</span>
    @enderror
</div>

@include('includes.ckeditor')
