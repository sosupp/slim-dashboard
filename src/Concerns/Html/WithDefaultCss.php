<?php
namespace Sosupp\SlimDashboard\Concerns\Html;

trait WithDefaultCss
{
    public $tableWrapperCss = 'table-with-heading-wrapper';
    public $tableHeadingCss = 'table-heading-wrapper';
    public $tableActionsCss = 'table-actions-wrapper';

    public function mobileListingMainWrapper()
    {
        return 'search-and-listing';
    }
}
