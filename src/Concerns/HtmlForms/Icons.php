<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

trait Icons
{
    public function plusIcon(string $class)
    {
        return view('slim-dashboard::components.icons.plus', [
            'class' => $class
        ]);
    }

    public function spinnerIcon()
    {
        return view('slim-dashboard::components.icons.bars-spinner-fade');
    }

    public function loaderIcon()
    {
        return view('slim-dashboard::components.loaders.rotation', [
            'class' => 'green-loader'
        ]);
    }

    public function successIcon()
    {
        return view('slim-dashboard::components.icons.check', [
            'w' => '30',
            'color' => '#04dd04',
            'stroke' => '2'
        ]);
    }

    public function useIcon(
        string $path = '',
        string $width = '24',
        string $color = '',
        string|null $fill = null,
        string|null $stroke = null,
    )
    {
        return view('slim-dashboard::components.'.$path, [
            'w' => $width,
            'color' => $color,
            'fill' => $fill,
            'stroke' => $stroke
        ]);
    }
}
