<?php
namespace Sosupp\SlimDashboard\Concerns;

trait HasCustomRouteBinding
{
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)
        ->orWhere(function($query) use ($value) {
            $query->where('id', $value);
        })
        ->firstOrFail();
    }
}
