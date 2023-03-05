<?php 
namespace Woo\MC\Frontend\WC\Classes;

class Myaccount{
    public function __construct(){
        add_action( 'woocommerce_account_menu_items', [ $this, 'my_account_menu'] );
        add_action('init', [ $this, 'myacc_endpoint' ] );
        add_action('woocommerce_account_activation_endpoint', [ $this, 'content' ] );
    }

    /*
    * Part 1. Add Link (Tab) to My Account menu
    * @return HTML Menu
    */

    public function my_account_menu( $menu_links ) {

        $menu_links = array_slice( $menu_links, 0, 5, true)
            + array('activation' => 'Activation')
            + array_slice( $menu_links, 5, NULL, true);

        return $menu_links;
    }

    /*
    * Part 2. Register Permalink Endpoint
    */
    function myacc_endpoint(){
        add_rewrite_endpoint('activation', EP_PAGES);
    }

    /*
    * Part 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
    */ 

    public function content(){ ?>
        <?php include WOOMC_PLUGIN_PATH . '/templates/form.php'; ?>
    <?php
    
    }

}
