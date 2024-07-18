<?php
namespace Sosupp\SlimDashboard\Concerns;

use App\Models\Product;
use App\Services\Products\ProductCrudService;

trait StatusToggleable
{
    public $statuses = [];
    public $status;

    public abstract function useModel();

    public function toggleStatus($modelId)
    {
        return $this->useModel()::where('id', $modelId)
        ->update([
            'status' => $this->setStatus($modelId)
        ]);
    }

    protected function setStatus($modelId)
    {
        return $this->tableRecords()->where('id', $modelId)->first()->status === 'active'
        ? 'inactive'
        : 'active';
    }
}
