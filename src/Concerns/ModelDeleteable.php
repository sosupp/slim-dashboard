<?php
namespace Sosupp\SlimDashboard\Concerns;

trait ModelDeleteable
{

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


}
