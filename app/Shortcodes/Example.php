<?php

namespace Ayctor\Shortcodes;

use WpCore\Shortcodes\Shortcode;

/**
 * Class Example to set Example shortcode
 */
class Example extends Shortcode
{
    /**
     * Name of the shortcode to use in wp admin
     *
     * @var string
     */
    protected $name = 'example';

    /**
     * Defaults values for arguments
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Blade template of the shortcode
     *
     * @var string
     */
    protected $template = 'shortcodes.example';
}
