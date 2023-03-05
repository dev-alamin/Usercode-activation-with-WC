<?php 
namespace Woo\MC\Frontend\Form;
// ob_start();
class Activate{
    public function __construct(){
        add_action('wp_ajax_update_bbg_user_code', [ $this, 'form_handler']);
        add_action('wp_ajax_nopriv_update_bbg_user_code', [ $this, 'form_handler']);

    }


    /**
     * Submit || Update user input data using Ajax 
     * When user on my-account/activation page
     * Basically updating, checking user input value 
     * With our DB data
     * 
     */

    public function form_handler(){

        // check_ajax_referer('bbg_urcode', 'security');

        if ( isset( $_POST['submit_urcode'] ) && $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $key = isset( $_POST['urcode'] ) ? $_POST['urcode'] : '';
            $user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : '0';

            $key = sanitize_text_field( $key );



            global $wpdb;
            $table = $wpdb->prefix . 'bbg_user_registrations';
            $user_email = get_user_by('id', $user_id);

            // check if already used
           $all_used_codes = woomc_all_used_codes();


            if ( ! empty( $key ) || isset( $key )) {

                if ( ! in_array( $key, $all_used_codes ) ) {
                    $update_code_list_status = $wpdb->update(
                        $table,
                        array(
                            'user_id' => $user_id,
                            'created_at' => current_time( 'mysql' ),
                            'email' => $user_email->user_email,
                            'is_used' => 'used',
                        ),
                        array(
                            'code' => $key,
                            // 'status' => '1'
                        ),
                        array(
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                        ),
                        array(
                            '%s'
                        )
                    );

                    // Set the status 'active'
                    if ( 1 == $update_code_list_status ) {
                        echo '<div class="bbg-notice notice-success" id="notice-success"></div>';
                    } elseif ( 0 == $update_code_list_status ) {
                        echo '<div class="bbg-notice notice-error" id="notice-error"></div>';
                    }
                } else {
                    echo '<div class="bbg-notice notice-info" id="notice-info"></div>';
                }
            } elseif ( empty( $key ) ) {
                echo '<div class="bbg-notice notice-key" id="notice-key"></div>';
            }
        }
        wp_die();
    }

}