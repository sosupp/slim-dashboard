<?php
namespace Sosupp\SlimDashboard\Concerns;

use Exception;

trait StatusToggleable
{
    public $statuses = [];
    public $status;

    public abstract function useModel();

    public function toggleStatus($modelId)
    {
        if($this->useModel() == null){
            throw new Exception("No model defined for delete action. Return an object or string for model.", 1);
            return;
        }
        
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
