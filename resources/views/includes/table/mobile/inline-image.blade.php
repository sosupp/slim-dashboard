@props(['record' => null, 'image' => null, 'imageName' => ''])
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
            x-on:change="previewImage({{$record->id}}, '{!!$imageName!!}')"
            multiple>
    </label>

    <template x-if="!imgsrc">
        <img src="{{ $image ? asset($image) : asset($record->image) }}" width="50">
    </template>

    <template x-if="imgsrc">
        <p>
            <img src="{{ $image ? asset($image) : asset($record->image) }}" :src="imgsrc" class="imgPreview">
        </p>

    </template>

    @if (session('inline-upload-success'.$record->id))
    <span class="image-upload-success">
        <x-icons.check stroke="2" strokeColor="#fff" />
    </span>
    @endif
</form>
