<?php
ob_start();
/*
 * Part 1. Add Link (Tab) to My Account menu
 */
add_filter('woocommerce_account_menu_items', 'bbg_wc_new_menu_myacc', 40);
function bbg_wc_new_menu_myacc($menu_links)
{

    $menu_links = array_slice($menu_links, 0, 5, true)
        + array('bbg-activation' => 'Activation')
        + array_slice($menu_links, 5, NULL, true);

    return $menu_links;
}
/*
 * Part 2. Register Permalink Endpoint
 */
add_action('init', 'bbg_add_myacc_endpoint');
function bbg_add_myacc_endpoint()
{

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint('bbg-activation', EP_PAGES);
}

/*
 * Part 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action('woocommerce_account_bbg-activation_endpoint', 'bbg_my_account_endpoint_content');
function bbg_my_account_endpoint_content()
{

    // Of course, you can print dynamic content here, one of the most useful functions here is get_current_user_id()
?>
    <div class="bbg-activation-wrapper">
        <div id="awesome_form_message"></div>
        <form id="awesome_form" action="" method="POST">
            <div class="load-state"></div>
            <p>
                <label for="code">Place the code you have been provided during purchase</label>
            </p>
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
        <?php
        function get_activated_item_list()
        {
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
        ?>

        <h2>Activated Item List</h2>
        <p>You have <?php echo (get_activated_item_list() ? count(get_activated_item_list()) : '0'); ?> activated <?php echo (count(get_activated_item_list()) > 1 ? 'bears' : 'bear'); ?> right now</p>


        <!-- If any item? show or hide the table  -->
        <?php if (count(get_activated_item_list()) > 0) : ?>
            <!-- // Active Item list  -->
            <?php include BBG_PLUGIN_PATH . '/templates/active_item.php' ?>
            <!-- Certificate table  -->
            <?php include BBG_PLUGIN_PATH . '/templates/certificate.php' ?>
        <?php endif; ?>
    </div>

<?php

}



/**
 * Submit || Update user input data using Ajax 
 * 
 */

function bbg_update_user_via_ajax()
{
    // check_ajax_referer('bbg_urcode', 'security');


    if (isset($_POST['submit_urcode']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $key = isset($_POST['urcode']) ? $_POST['urcode'] : '';
        $user_id = $_POST['user_id'];

        $key = trim($key);
        $key = stripslashes($key);
        $key = htmlspecialchars($key);
        $key = strip_tags($key);



        global $wpdb;
        $table = $wpdb->prefix . 'bbg_user_registrations';
        $user_email = get_user_by('id', $user_id);

        // check if already used
        $used_check = "SELECT * FROM $table WHERE is_used = 'used'";
        $is_already_used = $wpdb->get_results($used_check);

        $all_used_codes = [];
        foreach ($is_already_used as $used) {
            $all_used_codes[] = $used->code;
        }


        if (!empty($key) || isset($key)) {

            if (!in_array($key, $all_used_codes)) {
                $update_code_list_status = $wpdb->update(
                    $table,
                    array(
                        'user_id' => $user_id,
                        'created_at' => current_time('mysql'),
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
                if (1 == $update_code_list_status) {
                    echo '<div class="bbg-notice notice-success" id="notice-success"></div>';
                } elseif (0 == $update_code_list_status) {
                    echo '<div class="bbg-notice notice-error" id="notice-error"></div>';
                }
            } else {
                echo '<div class="bbg-notice notice-info" id="notice-info"></div>';
            }
        } elseif (empty($key)) {
            echo '<div class="bbg-notice notice-key" id="notice-key"></div>';
        }
    }


    wp_die();
}

add_action('wp_ajax_update_bbg_user_code', 'bbg_update_user_via_ajax');
add_action('wp_ajax_nopriv_update_bbg_user_code', 'bbg_update_user_via_ajax');
