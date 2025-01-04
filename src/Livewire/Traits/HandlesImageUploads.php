<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\File;
use Sosupp\SlimDashboard\Concerns\UploadImages;

trait HandlesImageUploads
{
    use WithFileUploads,
        UploadImages;

    public $imagePath;
    public $image;
    public $previewImagePath;

    public function colForImageName()
    {
        return '';
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

        $this->imagePath = $this->uploadImage(
            data: [
                'image' => $this->image,
                'filename' => $this->colForImageName()
            ],
        );

    }

}
