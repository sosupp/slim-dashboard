<?php
namespace Sosupp\SlimDashboard\Concerns\Html;

trait WithModernTab
{
    public function activeItemCss(): string
    {
        return 'new-active-bottom';
    }
}