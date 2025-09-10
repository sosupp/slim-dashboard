<?php

namespace Sosupp\SlimDashboard\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Lazy;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;

final class GlobalModal extends Component
{
    use HandleUserAlerts;
    
    public $pageTitle;
    public $componentName = '';
    public $useViewFile = '';
    public $selectedUrl = '';
    public $selectedTab = '';
    
    #[On('switch-modal')]
    public function switchComponent($component, $url = null, $view = null, $tab = null)
    {
        $this->componentName = $component;
        $this->selectedUrl = $url;
        $this->useViewFile = $view;
    }

    public function passExtraData(): array
    {
        return [];
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
