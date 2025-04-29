<?php
namespace Sosupp\SlimDashboard\Concerns;

trait ModelDeleteable
{
    abstract function useModel();
    
    public function delete($modelId, $authorize = null)
    {
        $model = $this->useModel()::where('id', $modelId)
        ->first();

        // dd($model, (bool)$authorize);

        if(!(bool)$authorize){
            $this->authorize('delete', $model);
        }

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

        return $model->restore();

    }


}
