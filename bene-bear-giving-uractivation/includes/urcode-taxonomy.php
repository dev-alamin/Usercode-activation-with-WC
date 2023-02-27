<?php 
add_action( 'init', 'bbg_register_tax_status', 0 );
/**
 * Register Taxonomy Status
 */
function bbg_register_tax_status() {

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