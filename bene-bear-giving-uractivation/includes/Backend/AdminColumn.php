<?php
namespace Benebear\Backend;

class AdminColumn{
    public function __construct(){
        add_filter('manage_urcode_posts_columns', [ $this, 'move_column' ] );
        add_action('manage_urcode_posts_custom_column', [ $this, 'control' ] , 10, 2);
        add_filter('manage_edit-urcode_sortable_columns', [ $this, 'set_column' ] );
        
    }

    public function move_column($columns){
        unset($columns['date']);
        unset($columns['taxonomy-bbgstatus']);
        $columns['isused'] = __('Status', 'bbgurcode');
        $columns['mydate'] = __('Date', 'bbgurcode');
        $columns['bbg_uemail'] = __('Email', 'bbgurcode');

        return $columns;
    }

    public function control($column, $post_id)
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


    public function set_column($columns)
    {
        $columns['bbg_uemail'] = 'usermail';
        $columns['taxonomy-bbgstatus'] = 'status';
        $columns['mydate'] = 'dates';
        $columns['isused'] = 'applied';

        //To make a column 'un-sortable' remove it from the array
        //unset($columns['date']);

        return $columns;
    }
}

