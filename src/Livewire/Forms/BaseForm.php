<?php

namespace Sosupp\SlimDashboard\Livewire\Forms;

use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;
use Sosupp\SlimDashboard\Livewire\Traits\HandlesImageUploads;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;
use Sosupp\SlimDashboard\Livewire\Traits\PreparesFormEdit;

abstract class BaseForm extends Component
{
    use PreparesFormEdit,
        WithBreadcrumb,
        HandleUserAlerts,
        HandlesImageUploads;

    public $pageTitle;
    public $isUpdate = false;

    public $modelId;

    public $currentPage = 'test page';

    // public function mount(){}

    public abstract function buildForm();
    public abstract function relation();
    public abstract function extraView();
    public abstract function wrapperCss();
    public abstract function save();
    public abstract function isUpdateDetails();

    public function pageHeading(): string
    {
        return '';
    }

    public function colForImageName(): string
    {
        return '';
    }

    public function uploadImageOnSave(): bool
    {
        return true;
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
