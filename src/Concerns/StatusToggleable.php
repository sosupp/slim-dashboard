<?php
namespace Sosupp\SlimDashboard\Concerns;

use Exception;

trait StatusToggleable
{
    public $statuses = [];
    public $status;

    public abstract function useModel();

    public function toggleStatus($modelId, $col = 'status')
    {
        if($this->useModel() == null){
            throw new Exception("No model defined for delete action. Return an object or string for model.", 1);
            return;
        }

        return $this->useModel()::where('id', $modelId)
        ->update([
            $col => $this->setStatus($modelId, $col)
        ]);
    }

    protected function setStatus($modelId, $col)
    {
        // dd((string) $col);

        return $this->tableRecords()->where('id', $modelId)->first()->$col === 'active'
        ? 'inactive'
        : 'active';
    }
}
