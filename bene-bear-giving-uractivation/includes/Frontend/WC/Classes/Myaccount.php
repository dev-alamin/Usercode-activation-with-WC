<?php 
namespace Benebear\Frontend\WC\Classes;

class Myaccount{
    public function __construct(){
        add_action( 'woocommerce_account_menu_items', [ $this, 'my_account_menu'] );
        add_action('init', [ $this, 'myacc_endpoint' ] );
        add_action('woocommerce_account_bbg-activation_endpoint', [ $this, 'content' ] );
    }

    public function active_list(){
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

    /*
    * Part 1. Add Link (Tab) to My Account menu
    * @return HTML Menu
    */

    public function my_account_menu( $menu_links ) {

        $menu_links = array_slice($menu_links, 0, 5, true)
            + array('bbg-activation' => 'Activation')
            + array_slice($menu_links, 5, NULL, true);

        return $menu_links;
    }

    /*
    * Part 2. Register Permalink Endpoint
    */
    function myacc_endpoint(){
        add_rewrite_endpoint('bbg-activation', EP_PAGES);
    }

    /*
    * Part 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
    */ 

    public function content(){ ?>
        <div class="bbg-activation-wrapper">
            <div id="awesome_form_message"></div>
            <form id="awesome_form" action="" method="POST">
                <div class="load-state"></div>
                <p><label for="code">Place the code you have been provided during purchase</label></p>
                <p class="form-wrapper">
                    <?php
                    $user = get_current_user_id();
                    ?>
                    <input type="hidden" name="user_id" value="<?php echo sanitize_text_field($user); ?>">
                    <input id="ursubmit_input" type="text" name="urcode" placeholder="Input your registration code" style="display: inline-block;">
                    <button id="urcode_submitbtn" class="btn_submit_urcode" type="submit" name="submit_urcode">Activate</button>
                    <span id="loader" class="bbg_awesome_loader loader"><img src="<?php echo BBG_PLUGIN_URL . '/assets/image/loader.gif'; ?>" alt=""></span>
                </p>
            </form>
    
            <!-- Show all activated item list  -->
            <h2>Activated Item List</h2>
            <p>You have <?php echo ( $this->active_list() ? count( $this->active_list()) : '0'); ?> activated <?php echo (count( $this->active_list()) > 1 ? 'bears' : 'bear'); ?> right now</p>
    
    
            <!-- If any item? show or hide the table  -->
            <?php if (count( $this->active_list()) > 0) : ?>
                <!-- // Active Item list  -->
                <?php include BBG_PLUGIN_PATH . '/templates/active_item.php' ?>
                <!-- Certificate table  -->
                <?php include BBG_PLUGIN_PATH . '/templates/certificate.php' ?>
            <?php endif; ?>
        </div>
    
    <?php
    
    }

     

}
