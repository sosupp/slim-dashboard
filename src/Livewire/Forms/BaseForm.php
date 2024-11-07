<?php

namespace Sosupp\SlimDashboard\Livewire\Forms;

use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Sosupp\SlimDashboard\Concerns\UploadImages;
use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;
use Sosupp\SlimDashboard\Livewire\Traits\PreparesFormEdit;

abstract class BaseForm extends Component
{
    use WithFileUploads,
        UploadImages,
        PreparesFormEdit,
        WithBreadcrumb;

    public $pageTitle;
    public $isUpdate = false;
    
    #[Validate()]
    public $imagePath;
    public $image;

    public $modelId;

    public $currentPage = 'test page';

    // public function mount(){}

    public abstract function buildForm();
    public abstract function relation();
    public abstract function extraView();
    public abstract function wrapperCss();
    public abstract function save();
    public abstract function isUpdateDetails();


    public function colForImageName(): string
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
                ->max('10mb')
            ],
        ]);

        $this->imagePath = $this->uploadImage(
            data: [
                'image' => $this->image,
                'filename' => $this->colForImageName()
            ],
        );

        // dd($this->imagePath);
    }
    
    public function basePage()
    {
        return '';
    }

    public function baseUrl()
    {
        return '';
    }

    public function currentPage()
    {
        return $this->pageTitle;
    }

    public function showPagination()
    {
        return false;
    }

    public function render()
    {
        return view('slim-dashboard::livewire.forms.base-form')
        ->title($this->pageTitle);
    }
}
