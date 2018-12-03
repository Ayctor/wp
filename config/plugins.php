<?php

return [

    'plugins' => [
        [
            'name'      => 'ACF',
            'slug'      => 'advanced-custom-fields',
            'required'  => true,
        ],
        [
            'name'      => 'Yoast',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ],
    ],

    'config' => [
        'id'           => 'tgmpa_ayctor',
        'is_automatic' => true,
    ],

];
