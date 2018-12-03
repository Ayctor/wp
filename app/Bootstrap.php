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
        define('ACF_LITE', env('ACF_LITE', true));

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

        // Remove H1 from editor
        add_filter('tiny_mce_before_init', [$this, 'removeH1FromEditor']);

        // Search on metas
        add_filter('posts_join', [$this, 'customSearchJoin']);
        add_filter('posts_where', [$this, 'customSearchWhere']);
        add_filter('posts_distinct', [$this, 'customSearchDistinct']);

        // Images custom sizes
        $this->addCustomImagesSizes();
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

    /**
     * Allow to remove the H1 tag from the editor
     *
     * @param array $settings The settings
     *
     * @return array
     */
    public function removeH1FromEditor(array $settings): array
    {
        $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';
        return $settings;
    }

    /**
     * Change the JOIN statement on admin search query
     *
     * @param string $join The query
     *
     * @return string
     */
    public function customSearchJoin(string $join): string
    {
        global $pagenow, $wpdb;

        if (is_admin() && 'edit.php' === $pagenow && !empty($_GET['s'])) {
            $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
        }

        return $join;
    }

    /**
     * Change the WHERE statement on admin search query
     *
     * @param string $where The query
     *
     * @return string
     */
    public function customSearchWhere(string $where): string
    {
        global $pagenow, $wpdb;

        if (is_admin() && 'edit.php' === $pagenow && !empty($_GET['s'])) {
            $where = preg_replace(
                '/\(\s*' . $wpdb->posts . '.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/',
                '(' . $wpdb->posts . '.post_title LIKE $1) OR (' . $wpdb->postmeta . '.meta_value LIKE $1)',
                $where
            );
        }

        return $where;
    }

    /**
     * Add the DISTINCT statement on admin search query
     *
     * @param string $where The query
     *
     * @return string
     */
    public function customSearchDistinct(string $where): string
    {
        global $pagenow, $wpdb;

        if (is_admin() && $pagenow === 'edit.php' && !empty($_GET['s'])) {
            return 'DISTINCT';
        }

        return $where;
    }

    /**
     * Add custom images sizes
     *
     * @return void
     */
    private function addCustomImagesSizes(): void
    {
        // add_image_size('small', 250, 250, true);
        // add_image_size('medium', 250);
    }
}
