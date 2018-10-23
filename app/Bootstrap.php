<?php

namespace Ayctor;

use Ayctor\Utils\Helper;

/**
 * Class Bootstrap to init functions inside WP
 */
class Bootstrap
{
    /**
     * Initialize the app
     *
     * @return void
     */
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
     *
     * @return void
     */
    public function themeSupports(): void
    {
        // Add post thumbnails support.
        add_theme_support('post-thumbnails', [
            'post',
            'page',
        ]);

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
     *
     * @return void
     */
    public function menu(): void
    {
        register_nav_menu('primary-menu', __('Primary Menu', 'wordplate'));
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueueScripts(): void
    {
        wp_deregister_script('jquery');
        wp_deregister_script('wp-embed');

        wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');
        wp_enqueue_style('app', Helper::mix('styles/app.css'), [], '', 'all');

        wp_enqueue_script('app', Helper::mix('scripts/app.js'), [], '', true);

        wp_localize_script('app', 'urls', [
            'ajax' => admin_url('admin-ajax.php'),
            'template' => get_template_directory_uri(),
        ]);
    }

    /**
     * Remove Emoji support
     *
     * @return void
     */
    public function removeEmoji(): void
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('emoji_svg_url', '__return_false');
        add_filter('tiny_mce_plugins', function ($plugins): array {
            if (is_array($plugins)) {
                return array_diff($plugins, [
                    'wpemoji',
                ]);
            }
            return [];
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
     *
     * @return void
     */
    public function adminMenu(): void
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
     *
     * @param WP_Admin_Bar $menu Admin toolbar object
     *
     * @return void
     */
    public function adminToolbar(\WP_Admin_Bar $menu): void
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
     *
     * @return void
     */
    public function permalink(): void
    {
        global $wp_rewrite;

        $pattern = '/%postname%/';

        $wp_rewrite->set_permalink_structure($pattern);
    }

    /**
     * Text in the left of admin footer
     *
     * @return string
     */
    public function footerText(): string
    {
        return 'Merci d\'avoir fait appel à <a href="http://ayctor.com/" target="_blank">Ayctor</a> pour votre site';
    }
}
