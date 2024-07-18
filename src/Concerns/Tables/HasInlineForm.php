<?php
namespace Sosupp\SlimDashboard\Concerns\Tables;

use App\Concerns\HtmlForms\WithSideModal;

trait HasInlineForm
{
    use WithSideModal;

    public abstract function save();
}
