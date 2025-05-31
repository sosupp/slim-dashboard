<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

use Illuminate\Contracts\View\View;

trait WithSideModal
{
    public $hasSidePanel = false;
    public $panelRecord;

    public function useSideModal()
    {
        return true;
    }

    public function panelExtraView(): string|View
    {
        return '';
    }

    public function resolvePanelModel($id)
    {
        if(method_exists($this, 'tableRecords')){
            $this->panelRecord = $this->tableRecords->where('id', $id)->first();
        }
    }
}
