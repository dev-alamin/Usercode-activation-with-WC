<?php
// Register script 
function bbg_user_reg_enqueue_script()
{
    wp_enqueue_style('bbg_custom_bootstrap_register');
}


// Enqueue Scrip 
add_action('admin_enqueue_scripts', 'bbg_custom_scripts');
function bbg_custom_scripts()
{
    wp_register_style('bbg_custom_bootstrap_register', BBG_PLUGIN_URL . 'assets/css/bootstrap.min.css', null, time(), 'all');
}

add_action('wp_enqueue_scripts', 'awesome_bbg_script');

function awesome_bbg_script()
{
    wp_enqueue_style('custom_style', BBG_PLUGIN_URL . 'assets/css/style.css');
    wp_enqueue_script('bbg_print_printthis_script', BBG_PLUGIN_URL . 'assets/js/printThis.js', ['jquery'], time(), true);
    wp_enqueue_script('bbg_print_customjs', BBG_PLUGIN_URL . 'assets/js/print_script.js', ['jquery', 'bbg_print_printthis_script'], time(), true);
    wp_enqueue_script('sweet_alert', BBG_PLUGIN_URL . 'assets/js/sweet_alert.min.js', ['jquery'], time(), true);
    wp_enqueue_script('validate_min', BBG_PLUGIN_URL . 'assets/js/jquery.validate.min.js', ['jquery'], time(), true);
    wp_enqueue_script('custom_js', BBG_PLUGIN_URL . 'assets/js/script.js', ['jquery'], time(), true);



		wp_localize_script('custom_js', 'action_url_ajax', [
			'ajax_url' => admin_url('admin-ajax.php'),
		]);



    // // Localize the script with new data
    // $script_data_array = array(
    //     'ajaxurl' => admin_url('admin-ajax.php'),
    //     'security' => wp_create_nonce('bbg_urcode'),
    // );
    // wp_localize_script('custom_js', 'bbgUserInput', $script_data_array);
}
