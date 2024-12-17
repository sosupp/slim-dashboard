<?php

if(! function_exists('subdomain')){
    function subdomain()
    {
        $host = collect(str(request()->host())->explode('.'));
        return $host->first();
    }
}