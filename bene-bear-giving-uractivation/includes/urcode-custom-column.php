<?php
// Add the custom columns to the book post type:
add_filter('manage_urcode_posts_columns', 'manage_bbg_urcode_custom_columns');
function manage_bbg_urcode_custom_columns($columns)
{
    unset($columns['date']);
    unset($columns['taxonomy-bbgstatus']);
    $columns['isused'] = __('Status', 'bbgurcode');
    $columns['mydate'] = __('Date', 'bbgurcode');
    $columns['bbg_uemail'] = __('Email', 'bbgurcode');

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action('manage_urcode_posts_custom_column', 'custom_bbg_urcode_column', 10, 2);
function custom_bbg_urcode_column($column, $post_id)
{
    $email = get_post_meta($post_id, 'bbg_urcode_email', true);
    // $user = get_user_by('email', $email);

    if ('bbg_uemail' == $column) {
        $email = get_post_meta($post_id, 'bbg_urcode_email', true);
        // echo '<a href="' . $user . '">' . $email . '</a>';
        echo $email;
    } elseif ('mydate' == $column) {
        echo get_the_time('l, F j, Y', $post_id);
    } elseif ('isused' == $column) {
        echo get_post_meta(get_the_ID(), 'bbg_urcode_is_used', true);
    }
}


add_filter('manage_edit-urcode_sortable_columns', 'bbg_urcode_sortable_column');
function bbg_urcode_sortable_column($columns)
{
    $columns['bbg_uemail'] = 'usermail';
    $columns['taxonomy-bbgstatus'] = 'status';
    $columns['mydate'] = 'dates';
    $columns['isused'] = 'applied';

    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);

    return $columns;
}
