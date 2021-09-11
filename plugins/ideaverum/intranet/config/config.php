<?php
/**
 * Created by PhpStorm.
 * User: Dino
 * Date: 6.12.2019.
 * Time: 16:22
 */

return [
    // This contains the Laravel Packages that you want this plugin to utilize listed under their package identifiers
    'packages' => [
        'intervention/image' => [
            // The namespace to set the configuration under. For this example, this package accesses
            // it's config via config('purifier.' . $key), so the namespace 'purifier' is what we put here
            'config_namespace' => 'purifier',

            // The configuration file for the package itself. Start this out by copying the default
            // one that comes with the package and then modifying what you need.
            'config' => [
                'encoding'      => 'UTF-8',
                'finalize'      => true,
                'cachePath'     => storage_path('app/purifier'),
                'cacheFileMode' => 0755,
            ],
        ],
    ],
];
