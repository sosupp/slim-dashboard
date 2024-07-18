
@props([
    'action' => '',
    'noteId' => '',
    'isSaved' => false,
])

<style>
    .fe{
        fill: orange !important;
    }
    .note-saved{
        background-color: orangered;
    }
</style>
<i class="fe fe-heart {{$isSaved ? 'note-saved' : ''}}"
    id="saveLater"
    {{$action}}
    wire:click="$refresh"></i>
