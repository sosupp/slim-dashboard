<?php
namespace Sosupp\SlimDashboard\Concerns;

trait Cacheable
{
    private $cacheKey;
    private $shouldCache = false;

    public function withCache(string $key)
    {
        $this->cacheKey = $key;
        $this->shouldCache = true;
        return $this;
    }

}
