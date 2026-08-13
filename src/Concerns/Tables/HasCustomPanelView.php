<?php
namespace Sosupp\SlimDashboard\Concerns\Tables;

trait HasCustomPanelView
{

    public ?string $sidePanelComponent = null;

    public bool $useComponent = false;

    public function setSidePanelComponent(string $component): void
    {
        $this->sidePanelComponent = $component;
        $this->useComponent = true;
    }

    public function clearSidePanelComponent(): void
    {
        $this->sidePanelComponent = null;
        $this->useComponent = false;
    }

    public function panelCustomView(): string
    {
        if (!$this->sidePanelComponent) {
            return '';
        }

        $method = $this->sidePanelComponent;

        if (!method_exists($this, $method)) {
            return '';
        }

        $view = $this->{$method}();

        return $view instanceof \Illuminate\Contracts\View\View
            ? $view->render()
            : (string) $view;
    }


}
