<?php
namespace Sosupp\SlimDashboard\Concerns;

trait ManageRelationships
{
    public function relation($modelId)
    {
        foreach($this->tableRecords()->where('id', $modelId) as $record){
           foreach($record->roles as $role){
                echo $role->name;
           }
        }
    }
}
