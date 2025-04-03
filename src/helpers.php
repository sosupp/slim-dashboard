<?php

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
