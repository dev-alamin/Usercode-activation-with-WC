<?php 
namespace Woo\MC\Backend;

class FormHandler{

    public function __construct(){
        add_action( 'admin_notice', [ $this, 'admin_notice' ] );
    }

    public function Form_handler(){

        if (!isset($_POST['submit_reg_code'])) {
            return;
        }
    
        if (!wp_verify_nonce($_POST['_wpnonce'], 'new-code')) {
            wp_die('Are you cheating?');
        }
    
        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

    
        /**
         * Insert data if everything goes well
         * 
         */

        global $wpdb;
        $table = $wpdb->prefix . 'bbg_user_list';
    
        if (isset($_POST['submit_reg_code'])) {
            $name = $_POST['name'] ? sanitize_text_field($_POST['name']) : '';
            $bear = $_POST['bear'] ?? $_POST['bear'];
            $code = $_POST['code'] ?? $_POST['code'];
            
            $user = get_current_user_id();
    
            if (!empty($name) && !empty($bear) && !empty($code)) {
    
                $inserted_data = $wpdb->insert(
                    $table,
                    array(
                        'name' => $name,
                        'code' => $code,
                        'created_by' => $user,
                        'created_at' => current_time('mysql')
                    ),
                    array(
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                    )
                );
    
                // Table where we update the code status
                $code_list_table = $wpdb->prefix . 'bbg_user_registration';
    
                $update_code_list_status = $wpdb->update(
                    $code_list_table,
                    array(
                        'product_id' => $bear,
                        'status' => 1
                    ),
                    array(
                        'code' => $code
                    )
                );
    
              

                if (is_wp_error($inserted_data)) {
                    wp_die($inserted_data->get_error_message());
                }
            
            
                if (is_wp_error($update_code_list_status)) {
                    wp_die($update_code_list_status->get_error_message());
                }
            }
        }
    

    }

    public function admin_notice(){ ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Record added successfully!', 'bbg'); ?></p>
        </div>
    <?php
    }
    
}