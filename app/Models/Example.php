<?php

namespace Ayctor\Models;

use WpCore\Models\Model;

/**
 * Class Example to set Example CPT
 */
class Example extends Model
{
    /**
     * CPT slug
     *
     * @var string
     */
    protected $post_type = 'example';

    /**
     * CPT name
     *
     * @var string
     */
    protected $label = 'Example';

    /**
     * CPT params
     *
     * @var array
     */
    protected $cpt_args = [
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-carrot',
        'rewrite' => true,
        'menu_position' => null,
        'supports' => [
            'title',
        ],
    ];

    /**
     * CPT taxonomies
     *
     * @var array
     */
    protected $taxonomies = [
        'example_cat' => [
            'label' => 'Category',
            'hierarchical' => true,
            'rewrite' => [
                'slug' => '/example_cat',
            ],
        ],
        'example_tag' => [
            'label' => 'Tag',
            'hierarchical' => false,
            'rewrite' => [
                'slug' => '/example_tag',
            ],
        ],
    ];

    /**
     * Register the CPT
     *
     * @return void
     */
    protected function register(): void
    {
        $this->registerCptFields();
        $this->registerTaxonomiesFields();
        $this->registerColumns();
        $this->registerFilters();
    }

    /**
     * Register the CPT fields
     *
     * @return void
     */
    private function registerCptFields(): void
    {
        $this->groupCpt('example_meta', 'Test');
        $this->field('example_meta', [
            'type' => 'text',
            'name' => 'test',
            'label' => 'Test',
        ]);
    }

    /**
     * Register the taxonomies fields
     *
     * @return void
     */
    private function registerTaxonomiesFields(): void
    {
        $this->groupTax('example_cat_meta', 'Test', 'example_cat');
        $this->field('example_cat_meta', [
            'type' => 'text',
            'name' => 'test',
            'label' => 'Test',
        ]);
    }

    /**
     * Register the columns
     *
     * @return void
     */
    private function registerColumns(): void
    {
        $this->column('cb', '<input type="checkbox" />', true);
        $this->column('title', 'Title', true);
        $this->column('test', 'Test', false, 'meta');
        $this->column('example_cat', 'Category', false, 'term');
        $this->column('example_tag', 'Tag', false, 'term');
        $this->column('example_custom', 'Custom', false, 'custom', 'My custom value');
        $this->column('date', 'Date', true);
    }

    /**
     * Register the filters
     *
     * @return void
     */
    private function registerFilters(): void
    {
        $this->filter('carrot_radio', [
            '' => 'Carrot radio test',
            'yes' => 'Yes',
            'no' => 'No',
        ]);
    }
}
