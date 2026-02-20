<?php

namespace Sosupp\SlimDashboard\Livewire\Traits;

trait HandlesTabMethodCall
{
    public $callAction;

    public function mountHandlesTabMethodCall()
    {
        if($this->callAction){
            $this->hasSidePanel = true;
            $method = $this->callAction;
            $this->$method();
            $this->reset('callAction');
            $this->dispatch('extra-data-reset', 'callAction');
        }
    }
}
