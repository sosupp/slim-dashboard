<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

use Livewire\Attributes\On;
use Livewire\Attributes\Url;

trait ForwardTabMethodCall
{
    #[Url(as: 'call', history: true)]
    public $callAction = null;

    // public function mountForwardTabMethodCall()
    // {
    //     $request = request();
    //     // dump($request->route('tab'), $request->input('call'));
    //     $callAction = request()->input('call');
    //     if($this->tab == $request->route('tab') && $callAction){
    //         $this->callAction = $callAction;
    //     }
    // }

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
