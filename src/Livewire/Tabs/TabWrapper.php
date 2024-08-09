<?php

namespace Sosupp\SlimDashboard\Livewire\Tabs;

use Livewire\Component;
use Livewire\Attributes\On;
use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;

abstract class TabWrapper extends Component
{
    use WithBreadcrumb;

    public $pageTitle;
    public $componentName = '';
    public $useViewFile = '';
    public $selectedUrl = '';
    public $selectedTab = '';

    public $tab;


    public abstract function pageTitle();

    public abstract function tabHeadings();

    public function mount(){
        // dd($this->tab);
        $this->configureSelected();
        $this->withMount();
        // $this->switchComponent('')
    }

    public function withMount(){}
    public function breadcrumbData(){}
    public function viewBeforeTabs(){}

    public function configureSelected()
    {

        if($this->tab !== null){
            // dd($this->tab);
            $component = collect($this->tabHeadings())->where('key', $this->tab)->first();
            $this->selectedTab = $component['key'];

            $this->switchComponent(
                component: $component['component'], url: $component['url'],
                view: $component['view']
            );
            return;
        }

        // dd(collect($this->tabHeadings()));
        if(!empty($this->tabHeadings())){
            // dd(collect($this->tabHeadings()));
            $this->componentName = collect($this->tabHeadings())->first()['component'];
            $this->selectedUrl = collect($this->tabHeadings())->first()['url'];
            $this->selectedTab = $this->tab ?? collect($this->tabHeadings())->first()['key'];

            // dd($this->componentName, $this->selectedUrl, $this->selectedTab, $this->tab);
            if(empty($this->componentName)){
                $this->useViewFile = collect($this->tabHeadings())->first()['view'];
            }
        }



        // dd($this->selectedUrl);
    }

    #[On('toggle-tab-component')]
    public function switchComponent($component, $url, $view)
    {
        // dd(route('platform.settings.product_unit'));
        // dd($component, $url);
        $this->componentName = $component;
        $this->selectedUrl = $url;
        $this->useViewFile = $view;
        // $this->dispatch('update-url', url: $url);
    }

    public function passExtraData(): array
    {
        return [];
    }

    public function tabPageHeading(): string
    {
        return '';
    }

    public function headingCss(): string
    {
        return 'tab-item-heading';
    }

    public function headingItemCss(): string
    {
        return 'tab-heading';
    }

    public function activeItemCss(): string
    {
        return 'dark-active-bottom';
    }

    public function useWireNavigate(): bool
    {
        return false;
    }

    public function render()
    {
        // $this->dispatch('update-url', url: $this->selectedUrl);
        return view('slim-dashboard::livewire.tabs.tab-wrapper')
        ->title($this->pageTitle());
    }
}
