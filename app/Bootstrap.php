<?php

namespace Ayctor;

/**
 * Class Bootstrap to init functions inside WP
 */
class Bootstrap
{
    public function __construct()
    {
        // Hide admin bar
        add_filter('show_admin_bar', '__return_false');

        // Hide ACF in admin
        define('ACF_LITE', true);

        // Setup theme support
        add_action('after_setup_theme', [$this, 'themeSupports']);

        // Register nav menu
        add_action('after_setup_theme', [$this, 'menu']);

        // Enqueue Scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

        // Remove emoji support
        add_action('init', [$this, 'removeEmoji']);

        // Dashboard menus
        add_action('admin_menu', [$this, 'adminMenu']);
        add_action('admin_bar_menu', [$this, 'adminToolbar'], 999);

        // Setup permalink
        add_action('after_setup_theme', [$this, 'permalink']);

        // Footer text
        add_filter('admin_footer_text', [$this, 'footerText']);
    }

    /**
     * Add theme supports
     */
    public function themeSupports()
    {
        // Add post thumbnails support.
        add_theme_support('post-thumbnails');

        // Add support for post formats.
        // add_theme_support('post-formats', ['aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video']);

        // Add title tag theme support.
        add_theme_support('title-tag');

        // Add HTML5 support.
        add_theme_support('html5', [
            'caption',
            'comment-form',
            'comment-list',
            'gallery',
            'search-form',
            'widgets',
        ]);
    }

    /**
     * Register menus
     */
    public function menu()
    {
        // register_nav_menu('primary-menu', __('Primary Menu', 'wordplate'));
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueueScripts()
    {
        wp_deregister_script('jquery');
        wp_deregister_script('wp-embed');

        wp_enqueue_script('html5shiv', 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js');
        wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
        wp_enqueue_script('respond', 'https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js');
        wp_script_add_data('respond', 'conditional', 'lt IE 9');

        // wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');
        wp_enqueue_style('app', $this->mix('styles/app.css'), [], '', 'all');

        // wp_enqueue_script('manifest', $this->mix('scripts/manifest.js'), [], '', true);
        // wp_enqueue_script('vendors', $this->mix('scripts/vendors.js'), [], '', true);
        wp_enqueue_script('app', $this->mix('scripts/app.js'), [], '', true);

        // Add ajax variables
        // $urls = array(
        //     'ajaxUrl' => admin_url('admin-ajax.php'),
        //     'templateUrl' => get_template_directory_uri(),
        // );
        // wp_localize_script('app', 'urls', $urls);
    }

    /**
     * Remove Emoji support
     */
    public function removeEmoji()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('emoji_svg_url', '__return_false');
        // Filter to remove TinyMCE emojis
        add_filter('tiny_mce_plugins', function ($plugins) {
            if (is_array($plugins)) {
                return array_diff($plugins, array( 'wpemoji' ));
            }
            return array();
        });
        // Remove the Really Simple Discovery service link
        remove_action('wp_head', 'rsd_link');
        // Remove the link to the Windows Live Writer manifest
        remove_action('wp_head', 'wlwmanifest_link');
        // Remove the general feeds
        remove_action('wp_head', 'feed_links', 2);
        // Remove the extra feeds, such as category feeds
        remove_action('wp_head', 'feed_links_extra', 3);
        // Remove the displayed XHTML generator
        remove_action('wp_head', 'wp_generator');
        // Remove the REST API link tag
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        // Remove oEmbed discovery links.
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        // Remove rel next/prev links
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    }

    /**
     * Manage Admin left menu
     */
    public function adminMenu()
    {
        $items = [
            'edit-comments.php', // comments
        ];

        foreach ($items as $item) {
            remove_menu_page($item);
        }
    }

    /**
     * Manage Admin toolbar
     * @param  WP_Admin_Bar $menu Admin toolbar object
     */
    public function adminToolbar($menu)
    {
        $items = [
            'comments',
            'wp-logo',
            'updates',
        ];

        foreach ($items as $item) {
            $menu->remove_node($item);
        }
    }

    /**
     * Manage default permalink
     */
    public function permalink()
    {
        global $wp_rewrite;

        $pattern = '/%postname%/';

        $wp_rewrite->set_permalink_structure($pattern);
    }

    /**
     * Text in the left of admin footer
     * @return string New text
     */
    public function footerText()
    {
        return 'Merci d\'avoir fait appel à <a href="http://ayctor.com/" target="_blank">Ayctor</a> pour votre site';
    }

    /**
     * Helper function to get file path with version
     * @param  string $file File to get the path
     * @return string       Path with mix version
     */
    protected function mix($file)
    {
        $path = '';
        $mix_manifest = file_get_contents(__DIR__ . '/../build/mix-manifest.json');
        $manifest = json_decode($mix_manifest);
        $file = '/' . ltrim($file, '/');
        if (isset($manifest->{$file})) {
            $version = $manifest->{$file};
            $path = get_template_directory_uri() . '/build' . $version;
        }
        return $path;
    }
}
