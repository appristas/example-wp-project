<?php
/**
 * @package fruits-core
 */

namespace Fruits\Core\Cpt;
use \Carbon_Fields\Container;
use \Carbon_Fields\Field;

/**
 * Create fruit post type
 */
function create_fruit() {
    register_post_type( 'fruit', [
        'labels' => [
            'name' => __( 'Fruits', 'fruits-cpt' ),
            'singular_name' => __( 'Fruit', 'fruits-cpt' ),
            'add_new_item' => __( 'Add New Fruit', 'fruits-cpt' ),
            'edit_item' => __( 'Edit Fruit', 'fruits-cpt' )
         ],
         'public' => true,
         'show_ui' => true,
         'menu_position' => 30,
         'supports' => [ 'title', 'editor', 'thumbnail' ],
         'menu_icon' => 'dashicons-cart'
    ] );
}

/**
 * Register Carbon Fields for fruits post type
 */
function register_fields_fruit() {
    if ( ! function_exists( 'carbon_get_post_meta' ) ) {
        return;
    }
    Container::make( 'post_meta', __( 'Fruits', 'fruits-cpt' ) )
        ->show_on_post_type( 'fruit' )
        ->add_fields( [
            Field::make( 'translatable_text', 'taste', __( 'Taste', 'fruits-cpt' ) ),
            Field::make( 'complex', 'colors', __( 'Colors', 'fruits-cpt' ) )
                ->add_fields( [
                    Field::make( 'color', 'color', __( 'Color', 'fruits-cpt' ) ),
                    Field::make( 'translatable_text', 'name', __( 'Name', 'fruits-cpt' ) )
                ] )
        ] );
}

/**
 * Create taxonomy
 */
function create_fruit_category() {
    register_taxonomy( 'fruit-category', 'fruit', [
        'labels' => [
            'name' => __( 'Category', 'fruits-cpt' ),
            'singular_name' => __( 'Category', 'fruits-cpt' ),
            'add_new_item' => __( 'Add New Category', 'fruits-cpt' ),
            'edit_item' => __( 'Edit Category', 'fruits-cpt' )
        ],
        'public' => true,
    ] );
}

add_action( 'init', 'Fruits\Core\Cpt\create_fruit' );
add_action( 'init', 'Fruits\Core\Cpt\create_fruit_category' );
add_action( 'carbon_register_fields', 'Fruits\Core\Cpt\register_fields_fruit' );
