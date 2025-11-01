<?php

namespace Sosupp\SlimDashboard\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;

final class GlobalModal extends Component
{
    use HandleUserAlerts;
    
    public $pageTitle;
    public $componentName = '';
    public $useViewFile = '';
    public $selectedUrl = '';
    public $selectedTab = '';
    public $model;
    
    #[On('switch-modal')]
    public function switchComponent(
        $component, $url = null, $view = null, $tab = null,
        mixed $model = null,
    )
    {
        $this->componentName = $component;
        $this->selectedUrl = $url;
        $this->useViewFile = $view;
        $this->model = $model;
    }

    public function passExtraData(): array
    {
        return [
            'model' => $this->model,
        ];
    }

    public function panelWidth()
    {
        return 'inherit';
    }

    public function render()
    {
        return view('slim-dashboard::livewire.global-modal');
    }
}
