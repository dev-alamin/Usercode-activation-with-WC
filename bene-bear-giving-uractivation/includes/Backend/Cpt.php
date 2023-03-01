<?php
namespace Benebear\Backend;

class Cpt{
    public function __construct(){
        add_action('init',  [ $this, 'cpt' ] );
        add_action( 'init', [ $this, 'taxonomy'], 0 );
        add_action( 'init', [ $this, 'tax_status' ], 0 );

    }

    /**
     * Register Post Type POST UR Codes
     *
     * @return void
     **/

    public function cpt(){
        $labels = array(
            'name'               => __('UR Codes', 'bbgurcode'),
            'singular_name'      => __('UR Code', 'bbgurcode'),
            'add_new'            => __('Add New UR Code', 'bbgurcode'),
            'add_new_item'       => __('Add New UR Code', 'bbgurcode'),
            'edit_item'          => __('Edit UR Code', 'bbgurcode'),
            'new_item'           => __('New UR Code', 'bbgurcode'),
            'view_item'          => __('View UR Code', 'bbgurcode'),
            'search_items'       => __('Search UR Codes', 'bbgurcode'),
            'not_found'          => __('Not found UR Codes', 'bbgurcode'),
            'not_found_in_trash' => __('Not found UR Codes in trash', 'bbgurcode'),
        );
        $args   = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_rest'       => true, // Adds gutenberg support.
            'query_var'          => true,
            'rewrite'            => array(
                'slug'       => _x('urcode', 'slug', 'bbgurcode'),
                'with_front' => false,
            ),
            'has_archive'        => false,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-book', // https://developer.wordpress.org/resource/dashicons/.
            'supports'           => array('title'),
        );
        register_post_type('urcode', $args);
    }

    /**
     * Register Taxonomy Types
     */
    public function taxonomy() {

        $labels = array(
            'name'          => __( 'Types', 'bbgurcode' ),
            'singular_name' => __( 'Type', 'bbgurcode' ),
            'search_items'  => __( 'Search Type', 'bbgurcode' ),
            'all_items'     => __( 'All Types', 'bbgurcode' ),
            'edit_item'     => __( 'Edit Type', 'bbgurcode' ),
            'update_item'   => __( 'Update Type', 'bbgurcode' ),
            'add_new_item'  => __( 'Add New Type', 'bbgurcode' ),
            'new_item_name' => __( 'Add New Type', 'bbgurcode' ),
        );

        register_taxonomy(
            'codetype',
            array(
                'urcode',
            ),
            array(
                'hierarchical'       => true,
                'public'             => true,
                'publicly_queryable' => true,
                'labels'             => $labels,
                'show_ui'            => true,
                'show_in_rest'       => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'rewrite'            => array(
                    'slug' => _x( 'codetype', 'slug', 'bbgurcode' ),
                ),
            )
        );
    }

    /**
     * Register Taxonomy Status
     */
    function tax_status() {

        $labels = array(
            'name'          => __( 'Status', 'bbg' ),
            'singular_name' => __( 'Status', 'bbg' ),
            'search_items'  => __( 'Search Status', 'bbg' ),
            'all_items'     => __( 'All Status', 'bbg' ),
            'edit_item'     => __( 'Edit Status', 'bbg' ),
            'update_item'   => __( 'Update Status', 'bbg' ),
            'add_new_item'  => __( 'Add New Status', 'bbg' ),
            'new_item_name' => __( 'Add New Status', 'bbg' ),
        );

        register_taxonomy(
            'bbgstatus',
            array(
                'urcode',
            ),
            array(
                'hierarchical'       => false,
                'public'             => true,
                'publicly_queryable' => true,
                'labels'             => $labels,
                'show_ui'            => true,
                'show_in_rest'       => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'rewrite'            => array(
                    'slug' => _x( 'status', 'slug', 'bbg' ),
                ),
            )
        );
    }
}

