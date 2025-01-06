@props([
    'class' => 'green-loader',
    'id' => 'darkBorder',
    'w' => '24',
    'h' => '24',
    'stroke' => '1',
    'strokeColor' => 'currentColor'
])
<span {!! $attributes->merge() !!} class="rotation-loader loader-border {{$class}}" style="width: {{$w}}px; height: {{$w}}px" id="{{$id}}"></span>
