<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

trait Icons
{
    public function plusIcon(string $class)
    {
        return view('components.icons.plus', [
            'class' => $class
        ]);
    }

    public function spinnerIcon()
    {
        return view('components.icons.bars-spinner-fade');
    }
}
