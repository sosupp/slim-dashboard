<?php
namespace Sosupp\SlimDashboard\Concerns;

use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;


trait Breadcrumbable
{
    use WithBreadcrumb;

    public abstract function basePage();
    public abstract function baseUrl();
    public abstract function currentPage();

}
