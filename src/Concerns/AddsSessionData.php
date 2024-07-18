<?php
declare(strict_types=1);


namespace Sosupp\SlimDashboard\Concerns;

trait AddsSessionData
{
    public $modelName;

    public function forModalAction()
    {
        session([
            'modelName' => $this->modelName,
            'currentRoute' => request()->route()->getName(),
        ]);
    }


}


