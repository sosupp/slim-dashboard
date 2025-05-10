<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

if(! function_exists('subdomain')){
    function subdomain()
    {
        $host = collect(str(request()->host())->explode('.'));
        return $host->first();
    }
}

if (!function_exists('mix_vendor')) {
    function mix_vendor($path, $package)
    {
        $manifestPath = public_path("vendor/{$package}/mix-manifest.json");

        if (!file_exists($manifestPath)) {
            throw new Exception("Mix manifest not found for package: {$package}");
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        $path = '/' . ltrim($path, '/');

        if (!isset($manifest[$path])) {
            throw new Exception("Unable to locate Mix file: {$path} in package: {$package}");
        }

        return asset("vendor/{$package}" . $manifest[$path]);
    }
}

if(!function_exists('cacheLife')){
    function cacheLife(int $hours = 24)
    {
        return 3600*$hours;
    }
}

if(!function_exists('withCacheData')){
    function withCacheData(bool $cache, callable $callback, string|null $key = null, int|null $minutes = null)
    {
        if($cache && $key !== null){
            return Cache::remember($key, $minutes ?? cacheLife(), function () use($callback) {
                return $callback();
            });
        }

        return $callback();
    }
}


if(!function_exists('searchSelector')){
    function searchSelector(Collection|array $options, array $cols = ['value' => 'id', 'label' => 'name'])
    {
        $options = collect($options);

        return $options->map(function ($data) use ($cols) {
            $result = [];

            foreach ($cols as $key => $col) {
                $result[$key] = is_array($data) ? ($data[$col] ?? null) : ($data->$col ?? null);
            }

            return $result;
        })->toArray();
    }
}
if(!function_exists('selectedSearchValues')){
    function selectedSearchValues(Collection|array $options, array|string $key = 'value')
    {
        return collect($options)->map(fn($option) => $option[$key]);
    }
}

if (!function_exists('shortNumberFormat')) {
    function shortNumberFormat($number, $precision = 1)
    {
        if ($number < 900) {
            // 0 - 900
            $n_format = number_format($number, $precision);
            $suffix = '';
        } elseif ($number < 900000) {
            // 0.9k-850k
            $n_format = number_format($number / 1000, $precision);
            $suffix = 'K';
        } elseif ($number < 900000000) {
            // 0.9m-850m
            $n_format = number_format($number / 1000000, $precision);
            $suffix = 'M';
        } elseif ($number < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($number / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($number / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove .0 if precision is 0 or 1
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        $short = $n_format . $suffix;
        return "<span title=\"{$number}\">{$short}</span>";
        return $n_format . $suffix;
    }
}


