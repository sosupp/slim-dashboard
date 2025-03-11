<?php
namespace Sosupp\SlimDashboard\Concerns;

use Sosupp\SlimDashboard\Concerns\HtmlForms\WithSideModal;
use Sosupp\SlimDashboard\Concerns\Tables\HasCustomPanelView;

trait HasModalPanel
{
    use WithSideModal, HasCustomPanelView;

    abstract function sidePanelModel($id);

    public function tableForm(){}

}
