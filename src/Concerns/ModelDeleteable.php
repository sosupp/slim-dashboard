<?php
namespace Sosupp\SlimDashboard\Concerns;

trait ModelDeleteable
{
    abstract function useModel();

    public function customDeletetionFlow($modelId = null): mixed
    {
        return null;
    }

    public function deleteConditions($modelId)
    {
        return true;
    }

    public function delete($modelId, $authorize = false)
    {
        $model = $this->useModel()::where('id', $modelId)->first();

        if (!$model) {
            $this->failAlert('Record not found');
            return;
        }

        // Check authorization FIRST
        if (!$authorize) {
            try {
                $this->authorize('delete', $model);
            } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
                $this->failAlert('You are not authorized to delete this record');
                return;
            }
        }

        // Then check conditions
        if (!$this->deleteConditions($modelId)) {
            $this->failAlert('Cannot delete this record');
            return;
        }

        // Check custom flow before attempting deletion
        $customResult = $this->customDeletetionFlow($modelId);
        if (!is_null($customResult)) {
            return $customResult;
        }

        // Perform deletion
        $result = $model->delete();

        if(!$result){
            $this->failAlert('Record not deleted. Something went wrong.');
            return;
        }

        $this->successAlert('Record deleted successfully');
        return $result;
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
