<?php

namespace Sosupp\SlimDashboard\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Sosupp\SlimDashboard\Html\MenuNav;

class Navigation extends Component
{
    public $navItems = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $navClass = collect(config('slim-dashboard.navigation_data'));
        // dd($navClass, subdomain(), collect($navClass)->contains('domain', '=', subdomain()));
        // dd($navClass['class']);
        // if(!$navClass['class']){
        //     return $this->navItems = [];
        // }

        if($navClass->contains('domain', '=', subdomain())){
            $items = $navClass->where('domain', subdomain())->first()['class'];
            $this->navItems = (new $items)->navItems();
            return;
        }

        return $this->navItems = [];

        // $navClass = (new $navClass);
        // dd((new $navClass['class'])->navItems());


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation');
    }
}
