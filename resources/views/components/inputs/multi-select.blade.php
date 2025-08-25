@props([
    'id' => '$id',
    'name' => '',
    'action' => '',
    'currentOption' => '',
    'optionId' => '',
    'optionKey' => 0,
    'options' => [],
    'label' => '$label',
    'class' => ''
])

@foreach ($options as $option)

<span>{{$option['status'] ?? ''}}</span>
@endforeach

<div {{$attributes->merge(['class' => $class])}}>
    <label for="{{$id}}">{{$label}}</label>
    <select class="form-control"
        id="{{$id}}"
        name="{{$name}}[]"
        multiple
        value="{{old($name)}}"
        {{$action}}>

        @foreach ($options as $option)
        <option value="{{$option[$optionId]}}"
            {{isset($option['status']) && $option['status'] == 'present' ? 'selected' : old($name) }}>{{$option[$optionKey]}}</option>
        @endforeach
    </select>

    @error($name)
        <span>{{$message}}</span>
    @enderror
</div>
