<?php

namespace Ayctor\Models;

class Example extends Model
{
    protected $post_type = 'example';

    protected $label = 'Example';

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
        'supports' => ['title'],
    ];

    protected $taxonomies = [
        'carrot_cat' => [
            'label' => 'Country',
            'hierarchical' => true,
            'rewrite' => ['slug' => '/country']
        ],
        'carrot_tag' => [
            'label' => 'Colors',
            'hierarchical' => false,
            'rewrite' => ['slug' => '/colors']
        ],
    ];

    protected function register()
    {
        // CPT fields
        $this->groupCpt('example_meta', 'Test');
        $this->field('example_meta', [
            'type' => 'text',
            'name' => 'test',
            'label' => 'Test',
        ]);

        // Taxonomy fields
        $this->groupTax('country_meta', 'Test', 'carrot_cat');
        $this->field('country_meta', [
            'type' => 'text',
            'name' => 'test',
            'label' => 'Test',
        ]);

        // Columns
        $this->column('cb', '<input type="checkbox" />', true);
        $this->column('title', 'Title', true);
        $this->column('test', 'Test', false, 'meta');
        $this->column('carrot_cat', 'Country', false, 'term');
        $this->column('carrot_tag', 'Colors', false, 'term');
        $this->column('carrot_custom', 'Custom', false, 'custom', 'My custom value');
        $this->column('date', 'Date', true);

        // Filters
        $options = ['' => 'Carrot radio test', 'yes' => 'Yes', 'no' => 'No'];
        $this->filter('carrot_radio', $options);
    }
}
