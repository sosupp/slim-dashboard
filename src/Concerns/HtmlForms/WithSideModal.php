<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

use Illuminate\Contracts\View\View;

trait WithSideModal
{
    public $hasSidePanel = false;

    public function useSideModal()
    {
        return true;
    }

    public function panelExtraView(): string|View
    {
        return '';
    }
}
