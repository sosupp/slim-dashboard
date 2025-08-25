@props(['name' => 'image', 'label' => 'Select Image'])
<div x-data="{
        imagePreview: $wire.entangle('previewImagePath'),
        progress: 0,
        uploading: false,
        isSuccess: false,
    }"
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false;isSuccess=true"
    x-on:livewire-upload-cancel="uploading = false"
    x-on:livewire-upload-error="uploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"

    class="image-upload-wrapper">


    <!-- File Input -->
    <input type="file"
           style="display: none;"
           id="imageInput"
           class="image-input-file"
           x-on:change="file => {
                isSuccess=false;
                const reader = new FileReader();
                reader.onload = e => imagePreview = e.target.result;
                reader.readAsDataURL(file.target.files[0]);
           }"
           wire:model="{{$name}}">

    <!-- Trigger Input -->
    <label for="imageInput"
           class="image-upload-label as-pointer">
        {{$label}}
    </label>

    <!-- Image Preview -->
    <div class="image-preview-container">
        <img :src="imagePreview"
             alt="Selected Image"
             class="selected-image-preview">
        <div class="image-upload-icon">
            <x-icons.upload />
        </div>
    </div>

    <div class="progress-indicator">
        <x-loaders.rotation class="loader-border" x-cloak x-show="uploading" />
        <x-utils.success-check x-cloak x-show="isSuccess" />
    </div>

</div>
