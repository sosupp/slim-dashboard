<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

use Livewire\Attributes\On;
use Livewire\Attributes\Url;

trait ForwardTabMethodCall
{
    #[Url(as: 'call', history: true)]
    public $callAction = null;

    #[On('extra-data-reset')]
    public function resetPassedData($key)
    {
        $this->reset($key);
    }

    public function mergeWithPassExtraData()
    {
        return ['callAction' => $this->callAction];
    }

}
