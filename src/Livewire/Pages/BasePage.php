<?php
namespace Sosupp\SlimDashboard\Livewire\Pages;

use Livewire\Component;
use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;

abstract class BasePage extends Component
{
    use WithBreadcrumb,
        HandleUserAlerts;

    public $pageTitle;

    abstract function breadcrumbData();
    public function withRender(){}

    public function hasCustomDatePanel()
    {
        return false;
    }

    public function panelWidth()
    {
        return 'inherit';
    }
    
    public function includePageFilters()
    {
        return '';
    }

    public function mobileMoreCtaCss(): string
    {
        return 'bg-goldrod';
    }

    public function render()
    {
        return view('slim-dashboard::livewire.pages.base-page')
        ->layoutData(['breadcrumb' => $this->breadcrumbData()])
        ->title($this->pageTitle);;
    }
}