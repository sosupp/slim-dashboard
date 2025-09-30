<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\File;
use Livewire\Attributes\Session;
use Sosupp\SlimDashboard\Concerns\UploadImages;

trait HandlesImageUploads
{
    use WithFileUploads,
        UploadImages;

    #[Session()]
    public $imagePath;
    public $image;

    #[Session()]
    public $previewImagePath;

    public $customImageProperty;

    public function colForImageName(): string
    {
        return '';
    }

    public function customImagePropertyName()
    {
        return '';
    }

    abstract function uploadImageOnSave(): bool;

    public function fileAsPrivate(): bool
    {
        return false;
    }

    public function storageDirectory()
    {
        return null;
    }

    public function uploadImageNow()
    {
        $this->imagePath = $this->uploadImage(
            data: [
                'image' => $this->image,
                'filename' => $this->colForImageName()
            ],
            subDir: $this->storageDirectory(),
            private: $this->fileAsPrivate()
        );

        if(!empty($this->customImagePropertyName())){
            $this->customImageProperty = $this->customImagePropertyName();
            $useImageName = $this->customImageProperty;
            $this->$useImageName = $this->imagePath;

            // To persit state of image preview before save
            $this->previewImagePath = $this->image->temporaryUrl();
        }
    }

    public function updatedImage()
    {
        // dd("yes");
        $this->validate([
            'image' => [
                'nullable',
                File::image()
                ->max('30mb')
            ],
        ]);

        if($this->uploadImageOnSave()){
            return $this->uploadImageNow();
        }

    }

}
