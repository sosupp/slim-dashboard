<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Sosupp\SlimDashboard\Html\PageCtas;

trait HandlesFileExport
{
    public $selectedExportType;

    abstract function exportModel();
    abstract function exportFilename(): string;

    public function renderingHandlesFileExport()
    {
        $this->mergeWithPageCta();
    }

    public function updatedSelectedExportType($type)
    {

        if($type == 'export') return;

        return $this->executeExport();
    }

    public function rendered()
    {
        $this->reset('selectedExportType');
    }

    public function exportTypes(): array
    {
        return [
            'excel',
            'pdf'
        ];
    }

    public function pageCta()
    {
        // return [''];
        return PageCtas::ctaDropdown(
            label: 'placeholder',
            key: 'place_holder',
            options: [],
            optionId: 'name',
            show: false,
        )
        ->make();
    }

    public function mergeWithPageCta(): array
    {
        $ctas = (array) $this->pageCta();

        $exportCta = PageCtas::cta(
            type: 'export',
            label: 'export',
            options: $this->exportTypes(),
            css: 'custom-btn as-pointer',
            wireAction: 'executeExport'
        )
        ->make();




        return array_merge($ctas, $exportCta);
    }

    public function executeExport()
    {
        $filename = str($this->exportFilename())->slug('_') .'_'. date('Y-m-i-s');

        // dd($this->selectedExportType);
        if($this->selectedExportType == 'export') return;

        if($this->selectedExportType == 'excel'){
            return Excel::download(
                export: $this->exportModel(),
                fileName: $filename.'.xlsx',
            );
        }

        // $html = $this->pdfView();
        // dd($html);
        $pdf = Pdf::loadHtml($this->pdfView())->setPaper('a4');

        return response()->streamDownload(
            fn() => print($pdf->stream()),
            $filename.'.pdf'
        );


    }


}
