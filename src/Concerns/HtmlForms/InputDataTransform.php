<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

trait InputDataTransform
{
    public function selectSearchData(array $options)
    {
        return array_map(function ($data) {
            return $data;
        }, $options);
    }
}
