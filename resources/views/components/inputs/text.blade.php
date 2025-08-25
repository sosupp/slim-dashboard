@props([
    'id' => '$id',
    'label' => '$label',
    'labelCss' => '',
    'name' => '',
    'allowLabel' => true,
    'class' => 'custom-form-control'
])

<div class="">
    @if ($allowLabel)
    <label for="{{$id}}" class="input-label {{$labelCss}}">{{$label}}</label>
    @endif

    <input class="{{$class}}"  {!! $attributes->merge() !!}
        name="{{$name}}"
        id="{{$id}}"
    />

    @error($name)
        <span class="error">{{$message}}</span>
    @enderror
</div>
