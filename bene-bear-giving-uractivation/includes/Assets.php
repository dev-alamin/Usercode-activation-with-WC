<?php
namespace Benebear;

class Assets{
    public function __construct(){
        add_action('admin_enqueue_scripts', [ $this, 'admin_scripts' ]);
        add_action('wp_enqueue_scripts', [ $this, 'enque_scripts' ]);
        
    }

    // Register script 
    public function register(){
        wp_enqueue_style('bbg_custom_bootstrap_register');
    }

    
    // Admin Enqueue Scrip 
    public function admin_scripts(){
        wp_register_style('bbg_custom_bootstrap_register', BBG_PLUGIN_URL . 'assets/css/bootstrap.min.css', null, time(), 'all');
    }   


    public function enque_scripts(){
        wp_enqueue_style('custom_style', BBG_PLUGIN_URL . 'assets/css/style.css');
        wp_enqueue_script('bbg_print_printthis_script', BBG_PLUGIN_URL . 'assets/js/printThis.js', ['jquery'], time(), true);
        wp_enqueue_script('bbg_print_customjs', BBG_PLUGIN_URL . 'assets/js/print_script.js', ['jquery', 'bbg_print_printthis_script'], time(), true);
        wp_enqueue_script('sweet_alert', BBG_PLUGIN_URL . 'assets/js/sweet_alert.min.js', ['jquery'], time(), true);
        wp_enqueue_script('validate_min', BBG_PLUGIN_URL . 'assets/js/jquery.validate.min.js', ['jquery'], time(), true);
        wp_enqueue_script('custom_js', BBG_PLUGIN_URL . 'assets/js/script.js', ['jquery'], time(), true);

        wp_localize_script('custom_js', 'action_url_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
        
}
