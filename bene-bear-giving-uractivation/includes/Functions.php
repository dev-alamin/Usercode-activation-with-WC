<?php 
/**
 * Get activated item list onto user
 *
 * @return array
 */
 function woomc_activated_item_list(){
    global $wpdb;
    $table = $wpdb->prefix . 'bbg_user_registrations';
    $user_id = get_current_user_id();

    if (null == $user_id) {
        return;
    }

    if (!empty($user_id)) {
        $sql = "SELECT * FROM $table WHERE user_id = %d ORDER BY created_at DESC LIMIT 20";
        $query = $wpdb->prepare($sql, $user_id);
        $result = $wpdb->get_results($query);
    }

    return $result;
}


/**
 * Get all code by user ID
 *
 * @return array
 */

 function woomc_get_user_all_code(){
    global $wpdb;
    $table = $wpdb->prefix . 'bbg_user_registrations';
    $user_id = get_current_user_id();

    if ( null == $user_id ) {
        return;
    }

    if ( ! empty( $user_id ) ) {
        $sql = "SELECT * FROM $table 
        WHERE user_id = %d 
        ORDER BY created_at 
        DESC LIMIT 20";

        $query = $wpdb->prepare( $sql, $user_id );
        $result = $wpdb->get_results( $query );
    }

    $results = [];

    foreach ( $result as $code ) {
        $results[] = $code->code;
    }

    return $results;
}

/**
 * Check user input for certificate print
 *
 * @return void
 */
function woomc_get_print_certificate_item(){
    global $wpdb;
    $table = $wpdb->prefix . 'bbg_user_registrations';
    $user_id = get_current_user_id();
    $code = isset($_GET['certificate']) ? $_GET['certificate'] : '';

    if ( ! in_array( $code, woomc_get_user_all_code() ) ) {
        echo '<div class="bbg-notice notice-error-print-page" id="notice-error">Something went wrong</div>';
        // wp_die( 'Are you cheating?' );
    }

    if ( null == $user_id ) {
        return;
    }

    if ( ! empty( $user_id ) ) {

        $sql = "SELECT * FROM $table 
        WHERE 
        user_id = %d AND code = %s 
        ORDER BY created_at DESC LIMIT 20";

        $query = $wpdb->prepare($sql, $user_id, $code);
        $result = $wpdb->get_row($query);
    }

    return $result;
}




/**
 * Get username or email
 *
 * @return Username
 */
function woomc_get_username_or_email() {

    $user_id = get_current_user_id();
    $user_info =  $user_info = get_userdata( $user_id );
    $username = $user_info->user_login;
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $name = '';

    if ( ! empty( $first_name ) || !empty( $last_name ) ) {
        $name = $first_name . ' ' . $last_name;
    } else {
        $name = $username;
    }

    return esc_html($name);
}

/**
 * Get all used code
 *
 * @return array
 */
function woomc_all_used_codes(){
    global $wpdb;
    $table = $wpdb->prefix . 'bbg_user_registrations';

    $used_check = "SELECT * FROM $table WHERE is_used = 'used'";
    $is_already_used = $wpdb->get_results( $used_check );

    $all_used_codes = [];
    foreach ( $is_already_used as $used ) {
        $all_used_codes[] = $used->code;
    }

    return $all_used_codes;
}