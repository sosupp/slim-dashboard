<?php
namespace Sosupp\SlimDashboard\Concerns\Html;

trait WithDefaultCss
{
    public $tableWrapperCss = 'table-with-heading-wrapper';
    public $tableHeadingCss = 'table-heading-wrapper';
    public $tableActionsCss = 'table-actions-wrapper';
    public $cardListItemCss = 'as-card-item-plain';

    public function mobileListingMainWrapper()
    {
        return 'search-and-listing';
    }

    public function cardListingWrapper(): string
    {
        return 'item-listings-wrapper ';
    }
}
