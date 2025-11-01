<form x-data="{
        imgsrc: null,
        modelImageId: @entangle('modelImageId'),
        selectedImageName: @entangle('selectedImageName'),
        previewImage(modelId, imageName = null) {
            this.modelImageId = modelId;
            this.selectedImageName = imageName;
            let file = this.$refs.uploadedImage.files[0];
            filename = file.name;

            let form = document.getElementById('imageForm'+modelId);
            if (!file || file.type.indexOf('image/') === -1) return;
            this.imgsrc = null;

            let reader = new FileReader();

            reader.onload = e => {
                this.imgsrc = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    }" class="inline-image-upload" id="imageForm{{$record->id}}">

    <label class="inline-image-label" for="selectedImage{{$record->id}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>

        <input wire:model="inlineImages.{{$record->id}}" type="file" id="selectedImage{{$record->id}}" class="inline-image-input as-pointer"
            x-ref="uploadedImage"
            x-on:change="previewImage({{$record->id}}, '{{$this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['colForImageName'] ?? null)}}')"
            multiple>
    </label>

    @if ($colHeading['relation'])
        <template x-if="!imgsrc">
            <img src="{{ asset($this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['callback'] ?? null)) }}" width="50">
        </template>

        <template x-if="imgsrc">
            <p>
                <img src="{{ asset($this->relation($record, $colHeading['relation'], $colHeading['col'], $colHeading['callback'] ?? null)) }}" :src="imgsrc" class="imgPreview">
            </p>

        </template>
    @else
    <template x-if="!imgsrc">
        <img src="{{ $record[$colHeading['col']] ? asset($record[$colHeading['col']]) : asset('images/default.webp') }}" width="50">
    </template>

    <template x-if="imgsrc">
        <p>
            <img src="{{ asset($record[$colHeading['col']]) }}" :src="imgsrc" class="imgPreview">
        </p>

    </template>
    @endif

    @if (session('inline-upload-success'.$record->id))
    <span class="image-upload-success">
        <x-slim-dashboard::icons.check stroke="2" strokeColor="#fff" />
    </span>
    @endif
</form>
