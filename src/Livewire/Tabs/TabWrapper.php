<?php

namespace Sosupp\SlimDashboard\Livewire\Tabs;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;
use Sosupp\SlimDashboard\Livewire\Traits\ForwardTabMethodCall;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;

abstract class TabWrapper extends Component
{
    use WithBreadcrumb,
        HandleUserAlerts,
        ForwardTabMethodCall;

    public $pageTitle;
    public $componentName = '';
    public $useViewFile = '';
    public $selectedUrl = '';
    public $selectedTab = '';

    #[Url()]
    public ?string $tab = null;


    public abstract function pageTitle();

    public abstract function tabHeadings();

    public function mount(){
        // dd($this->tab);
        $this->withMount();
        $this->configureSelected();

        if($this->callAction){
            $this->dispatch(
                event: 'opensidepanel',
                title: $this->sidePanelTitle(), componentName: $this->callAction,
            );

            $this->reset('callAction');
            // $result = $this->dispatch('extra-data-reset', 'callAction');
        }
    }

    public function withMount(){}
    public function breadcrumbData(){}
    public function viewBeforeTabs(){}

    public function configureSelected()
    {
        // dd($this->tab);
        if($this->tab !== null){

            $component = collect($this->tabHeadings())->where('key', $this->tab)->first();

            // dd($component, $this->tabHeadings());
            if(is_null($component)){
                $this->resetTab();
            }else{
                $this->selectedTab = $component['key'];
                $this->switchComponent(
                    component: $component['component'],
                    url: $component['url'],
                    view: $component['view'],
                    tab: $this->tab
                );
            }
        }

        if(is_null($this->tab)){
            $this->resetTab();
        }

        // dd(collect($this->tabHeadings()));
        if(!empty($this->tabHeadings())){
            // dd(collect($this->tabHeadings()));
            // $this->resetTab();

            // dd($this->componentName, $this->selectedUrl, $this->selectedTab, $this->tab);
            if(empty($this->componentName)){
                $this->useViewFile = collect($this->tabHeadings())->first()['view'];
            }
        }
    }

    public function resetTab()
    {
        $this->componentName = collect($this->tabHeadings())->first()['component'];
        $this->selectedUrl = collect($this->tabHeadings())->first()['url'];
        $this->selectedTab = collect($this->tabHeadings())->first()['key'];
        $this->tab = $this->selectedTab;
    }

    #[On('toggle-tab-component')]
    public function switchComponent($component, $url, $view, $tab = null)
    {
        $this->componentName = $component;
        $this->selectedUrl = $url;
        $this->useViewFile = $view;
        $this->tab = $tab;
    }

    public function withExtraData()
    {
        return array_merge(
            $this->passExtraData(),
            $this->mergeWithPassExtraData(),
        );
    }

    public function passExtraData(): array
    {
        return [];
    }

    public function sidePanelTitle(): string
    {
        return 'ADD';
    }

    public function panelWidth()
    {
        return 'inherit';
    }

    public function tabPageHeading(): string
    {
        return '';
    }

    public function tabContentWrapper()
    {
        return 'tab-content-wrapper';
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

    public function mobileMoreCtaCss(): string
    {
        return 'bg-goldrod';
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
