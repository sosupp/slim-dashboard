
<div>
    <div class="note-textarea" wire:ignore wire:key="note_body" >
        <textarea data-description="@this"
            wire:model.blur="{{$model}}"
            id="{{$id}}"
            placeholder=""
            {{$action}}>{{$this->$model ?? old($model)}}</textarea>

        @error($model) <p class="error">{{$message}}</p> @enderror
    </div>
    @error($model) <p class="error">{{$message}}</p> @enderror

    <script>
        var ready = (callback) => {
                if (document.readyState != "loading") callback();
                else document.addEventListener("DOMContentLoaded", callback);
            }
            ready(() =>{
                ClassicEditor
                    .create(document.querySelector('#customEditor'), {
                        simpleUpload: {
                            uploadUrl: "{{route('editor.image.upload').'?_token='.csrf_token() }}",
                        },
                        removePlugins: [

                        ],
                        fontSize: {
                            options: [
                                'default'
                            ]
                        }
                    })
                    .then(editor => {
                        document.querySelector("#publishBtn").addEventListener("click", ()=>{
                            @this.set(@json($model), editor.getData());
                        })
                        document.querySelector("#draftBtn").addEventListener("click", ()=>{
                            @this.set(@json($model), editor.getData());
                        })
                        // editor.model.document.on('change:data', () => {
                        //     @this.set('body', editor.getData());
                        // })
                        Livewire.on('reinit', () => {
                            editor.setData('', '')
                        })
                    })
                    .catch(error => {
                        console.error(error);
                    });
            })




    </script>
</div>
