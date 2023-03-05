<?php

/**
 * Plugin Name: BBG User Activation
 * Plugin URI:  
 * Description: This is the Benebear Extension Plugin.
 * Version:     1.0
 * Author:      Al Amin
 * Author URI:  https://almn.me
 * Text Domain: woomc
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     BbgUrActivation
 * @author      BBIL
 * @copyright   2022 BBIL
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      woomc
 */


defined('ABSPATH') || die('No script kiddies please!');

require_once __DIR__ . '/vendor/autoload.php'; // Composer
require_once __DIR__ . '/templates/PageTemplater.php'; // Page template for Printing certificate

final class Woocommerce_membership_card{

    // Version
    const version = '1.0';

    private function __construct(){
        $this->define_constants();

        register_activation_hook(__FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin']);
    }


    public static function init(){
        static $instance = false;

        if( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define plugin's constant
     * 
     */

     public function define_constants(){
        define('WOOMC_VERSION', self::version );
        define('WOOMC_PLUGIN', __FILE__);
        define('WOOMC_PLUGIN_URL', plugin_dir_url(__FILE__));
        define('WOOMC_PLUGIN_PATH', plugin_dir_path(__FILE__));        
     }

   
    /**
     * Init Plugin
     * @return Void
     */

    public function init_plugin(){
        new \Woo\MC\Assets();
        new \Woo\MC\User();
        new \Woo\MC\Frontend\WC\Classes\Myaccount();
        new \Woo\MC\Frontend\Form\activate();
        
        if( is_admin() ) {
            new \Woo\MC\Admin(); // Specific only for admin
            new \Woo\MC\Backend\Menu();
            // \Woo\MC\Backend\PageTemplater::get_instance();
        }else{
            
        }

        load_plugin_textdomain('woomc', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

     /**
      * Activate plugin
      *@return void
      */

      public function activate(){
        // Stuff do upon plugin activation

        $installer = new \Woo\MC\Installer();
        $installer->run();

      }
}

// Plugin activation function
function woocommerce_membership_card(){
    return Woocommerce_membership_card::init();
}

// Kick-off the plugin
woocommerce_membership_card();





// Kick out the db staff || Update, Insert etc 
// is post type urcode 
$post_type = $_GET['post_type'] ?? '';

if (isset($post_type) && 'urcode' == $post_type && is_admin()) {
    add_action('admin_init', 'get_all_code_from_db');
}
function get_all_code_from_db()
{

    global $wpdb;
    $table = $wpdb->prefix . 'bbg_user_registrations';

    $sql = "SELECT * FROM $table LIMIT 500";
    $result = $wpdb->get_results($sql);

    // foreach ($result as $code) {

    //     $is_exists = "SELECT * FROM $wpdb->posts WHERE post_title = '$code->code' LIMIT 50";
    //     $is_ex = $wpdb->get_results($is_exists);

    //     if (count($is_ex) == 0) {
    //         $arr = array(
    //             'post_type' => 'urcode',
    //             'post_title' => wp_strip_all_tags($code->code),
    //             'post_date' => $code->created_at,
    //             'post_status' => 'publish',
    //             'meta_input' => [
    //                 'bbg_urcode_email' => wp_strip_all_tags($code->email),
    //                 'bbg_urcode_uid' => wp_strip_all_tags($code->user_id),
    //                 'bbg_urcode_is_used' => wp_strip_all_tags($code->is_used),
    //             ],
    //             'tax_input' => [
    //                 'codetype' => 17
    //             ],
    //         );

    //         $insert_post = wp_insert_post($arr, true);
    //     }
    // }

    foreach ($result as $code) {
        $arrup = array(
            'ID' => $code->post_id,
            'post_type' => 'urcode',
            'post_status' => 'publish',
            'post_date' => $code->created_at,
            'meta_input' => [
                'bbg_urcode_email' => $code->email,
                'bbg_urcode_uid' => $code->user_id,
                'bbg_urcode_is_used' => $code->is_used,
            ],
        );

        if (!empty($code->email) || $code->email != null || $code->created_at != null) {
            $update_posts = wp_update_post($arrup);
        }

        // if (is_wp_error($update_posts)) {
        //     wp_die($update_posts->get_error_message());
        // }
    }


    // Get all the UR Code type posts
    $psql = "SELECT * FROM $wpdb->posts WHERE post_type = 'urcode' AND post_status='publish'";
    $res = $wpdb->get_results($psql);

    // Get all the ids for update 

    $all_post_ids = [];
    foreach ($result as $post) {
        $all_post_ids[] = $post->post_id;
    }

    foreach ($all_post_ids as $id) {
        if (empty($id) || null == $id) {
            foreach ($res  as $p) {
                // Update our custom table with the inserted id
                $update_post = $wpdb->update(
                    $table,
                    array(
                        'post_id' => $p->ID,
                    ),
                    array(
                        'code' => $p->post_title
                    )
                );
            }
        }
    }

    // Insert primary code to our new table 
    // require_once BBG_PLUGIN_PATH . 'assets/code/unique-code.php';
    // require_once BBG_PLUGIN_PATH . 'assets/code/code_5500.php';
    
    // For dog type 
    require_once BBG_PLUGIN_PATH . 'assets/code/dog-code.php';

    /**
     * Insert raw || created UUID through file
     */
    
     $unique_codes = array_map( 'strtoupper', $dogs );

     foreach ($unique_codes as $item) {
        // Check if the data already exists in the database
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table WHERE code = %s", $item);
        $count = $wpdb->get_var($sql);

        $item = strip_tags( $item );
        $item = trim( $item );
        $item = stripslashes( $item );
        $item = stripcslashes( $item );

      
            if ($count == 0) {
                // Actual data
                $data = array(
                    'code' => $item,
                    'type' => 'dog'
                );
                
                // Define format to insert in DB
                $where = [
                    '%s',
                    '%s',
                ];

                $wpdb->insert( $table, $data, $where );

            }
      }
}

