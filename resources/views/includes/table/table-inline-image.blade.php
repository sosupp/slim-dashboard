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
        <x-slim-dashboard::icons.upload stroke="1" />
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
        <img src="{{ asset($record[$colHeading['col']]) }}" width="50" alt="">
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
