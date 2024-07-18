<?php

namespace Sosupp\SlimDashboard\Livewire\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;
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
    public $imagePath;

    public $modelId;

    public $currentPage = 'test page';

    // public function mount(){}

    public abstract function buildForm();
    public abstract function relation();
    public abstract function extraView();
    public abstract function wrapperCss();
    public abstract function save();
    public abstract function isUpdateDetails();


    public function updatedImage()
    {
        // dd("yes");
        $this->validate([
            'image' => 'nullable|max:3024',
        ]);

        $this->imagePath = $this->uploadImage(
            data: ['image' => $this->image],
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
