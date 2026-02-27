<?php
namespace Sosupp\SlimDashboard\Concerns;

trait ModelDeleteable
{
    abstract function useModel();

    public function deleteConditions($modelId)
    {
        return true;
    }

    public function delete($modelId, $authorize = null)
    {
        $model = $this->useModel()::where('id', $modelId)
        ->first();

        // dd($model, (bool)$authorize);
        if(!$this->deleteConditions($modelId)){
            return;
        }

        if(!(bool)$authorize){
            $this->authorize('delete', $model);
        }

        $this->failAlert('Record deleted...You can refresh page for changes');

        return $model->delete();

    }

    public function restorable($modelId, $authorize = null)
    {
        $model = $this->useModel()::withTrashed()
        ->where('id', $modelId)
        ->first();

        // dd($model, (bool)$authorize);

        if(!(bool)$authorize){
            $this->authorize('restore', $model);
        }

        $this->successAlert('Deleted record restored...You can refresh page for changes');

        return $model->restore();

    }


}
