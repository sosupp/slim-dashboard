<div x-data="{
        imgsrc: null,
        modelImageId: '',
        previewImage(modelId) {

            this.modelImageId = modelId;
            let file = this.$refs.uploadedImage.files[0];
            filename = file.name;

            let form = document.getElementById('imageForm')
            if (!file || file.type.indexOf('image/') === -1) return;
            this.imgsrc = null;

            let reader = new FileReader();

            reader.onload = e => {
                this.imgsrc = e.target.result;
            }

            reader.readAsDataURL(file);
            console.log('yes image')
        }
    }">
    <div class="dashboard-errors-wrapper">
        @forelse ($errors->all() as $message)
            <p class="error">{{$message}}</p>
        @empty

        @endforelse
    </div>
    <div class="{{$this->wrapperCss()}}" :class="darkmode ? 'use-dark-theme dmode-wrapper' : 'form-wrapper'">

        @includeIf($this->extraView())

        {!! $this->buildForm() !!}
        {{-- <x-forms.ckeditor /> --}}

    </div>
</div>