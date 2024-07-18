<?php
namespace Sosupp\SlimDashboard\Concerns\Html;

trait WithBreadcrumb
{
    public function renderingWithBreadcrumb($view)
    {
        // dd($view);
        return $view->layoutData(['breadcrumb' => $this->breadcrumbData()]);

    }

    public function breadcrumbSetting()
    {
        return [
            'currentPage' => $this->currentPage(),
            'basePage' => $this->basePage(),
            'baseUrl' => $this->baseUrl(),
        ];
    }

    public function breadcrumbData(){}

}
