<?php

namespace Sosupp\SlimDashboard\Livewire\Traits;

use Livewire\Attributes\Url;

trait HandlesTabMethodCall
{
    #[Url(as: 'call', history: true)]
    public $callAction = null;

    public function mountHandlesTabMethodCall()
    {
        if($this->callAction){
            $this->hasSidePanel = true;
            $method = $this->callAction;

            $this->dispatch('extra-data-reset', 'callAction');

            $this->closePanel();

            return $this->dispatch(
                'opensidepanel',
                title: $this->generalPanelTitle, componentName: $method,
            );
        }
    }
}
