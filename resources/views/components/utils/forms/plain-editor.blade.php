
<div>
    <div class="note-textarea {{$wrapperCss}}" wire:ignore wire:key="note_body{{$id}}" >
        <label for="{{$id}}" class="{{$labelCss}}">{{$label}}</label>
        <textarea class="plain-textarea {{$inputCss}}"
            wire:model.blur="{{$model}}"
            id="{{$id}}"
            placeholder=""></textarea>
    </div>
    @error($model) <p class="error">{{$message}}</p> @enderror


</div>
