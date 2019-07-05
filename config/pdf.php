<?php

return [

    'options' => [
        'no-outline',
        'dpi' => 300,
        'disable-smart-shrinking',
        'margin-top'    => 10,
        'margin-right'  => 10,
        'margin-bottom' => 20,
        'margin-left'   => 10,
        'binary' => env('WKHTML_BINARY', '/usr/local/bin/wkhtmltopdf'),
        'commandOptions' => [
        	'enableXvfb' => env('WKHTML_XVFB', false),
        ],
        'use-xserver' => env('WKHTML_XVFB', false),
    ],

];
