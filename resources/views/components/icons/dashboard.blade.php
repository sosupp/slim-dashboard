@props([
    'class' => '',
    'w' => '24',
    'h' => '24',
    'stroke' => '2',
    'color' => '#5f6368',
    'tipMessage' => '',
])
<div class="custom-tooltip">
<svg xmlns="http://www.w3.org/2000/svg" height="{{$w}}px" viewBox="0 -960 960 960" width="{{$w}}px" fill="{{$color}}"><path d="M540-600v-200h260v200H540ZM160-480v-320h260v320H160Zm380 320v-320h260v320H540Zm-380 0v-200h260v200H160Zm40-360h180v-240H200v240Zm380 320h180v-240H580v240Zm0-440h180v-120H580v120ZM200-200h180v-120H200v120Zm180-320Zm200-120Zm0 200ZM380-320Z"/></svg>
    <span class="tooltip-text">{{$tipMessage}}</span>
</div>
