<?php

namespace Ayctor\Bootstrap;

class Plugin
{
    /**
     * Action to init tgmpa
     */
    public function __construct()
    {
        add_action('tgmpa_register', [$this, 'plugins']);
    }

    /**
     * Declare required and recomended plugins
     */
    public function plugins()
    {
        $plugins = array(
            array(
                'name'      => 'ACF',
                'slug'      => 'advanced-custom-fields',
                'required'  => true,
            ),
            array(
                'name'      => 'Yoast',
                'slug'      => 'wordpress-seo',
                'required'  => false,
            ),
            array(
                'name'      => 'Bugsnag',
                'slug'      => 'bugsnag',
                'required'  => false,
            ),
        );
        $config = array(
            'id'           => 'tgmpa_ayctor',
            'is_automatic' => true
        );
        tgmpa($plugins, $config);
    }
}
