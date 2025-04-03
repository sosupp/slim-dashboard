<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /**
     * Class or array data for menu items
     * Currently only one set of navigation is return based on keys
     * key and domain can be used to determine which navs to show for different types of users
     * within the same app or domain or subdomain use cases.
     */
    'navigation_data' => [
        [
            'key' => 'portal',
            'domain' => '',
            'middleware' => null,
            'class' => null
        ],
        [
            'key' => '',
            'domain' => '',
            'middleware' => null,
            'class' => null
        ],

    ],

    'dashboard_navigation' => null,

    'prefix' => 'slimdashboard',
    'middleware' => ['web', 'auth'], // You can change or add middleware 
];
