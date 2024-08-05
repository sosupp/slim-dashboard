<?php
namespace Sosupp\SlimDashboard\Concerns;

trait ModelDeleteable
{

    public function delete($modelId)
    {
        $model = $this->useModel()::where('id', $modelId)
        ->first();

        // dd($model);
        $this->authorize('delete', $model);
        return $model->delete();

    }


}
