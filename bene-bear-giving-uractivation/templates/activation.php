<div class="bbg-activation-wrapper">
    <?php
    if (isset($_POST['submit_urcode'])) {
        $key = $_POST['urcode'] ?? '';
        $user_id = $_POST['user_id'] ?? '';

        $key = trim($key);
        $key = strip_tags($key);



        global $wpdb;
        $table = $wpdb->prefix . 'bbg_user_registration';
        $user_email = get_user_by('id', $user_id);

        if (!empty($key)) {

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
                )
            );

            // Set the status 'active'

            if (0 == $update_code_list_status) {
                echo '<script>alert("Sorry, the activation code seems wrong!");</script>';
            } else {
                echo '<script>alert("Awesome! You have activated your new Bene Bear.");</script>';
            }
        }
    }
    ?>

    <form action="" method="POST">
        <p>
            <label for="code">Place you code you have been provided during purchase</label>
        </p>
        <p>
            <?php
            $user = get_current_user_id();
            ?>
            <input type="hidden" name="user_id" value="<?php echo sanitize_text_field($user); ?>">
            <input type="text" name="urcode" placeholder="Input your registration code" style="display: inline-block;">
            <button class="btn_submit_urcode" type="submit" name="submit_urcode">Activate</button>
        </p>
    </form>


    <!-- Show all activated item list  -->
    <?php
    function get_activated_item_list()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'bbg_user_registration';
        $user_id = get_current_user_id();

        if (null == $user_id) {
            return;
        }

        if (!empty($user_id)) {
            $sql = "SELECT * FROM $table WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 20";
            $result = $wpdb->get_results($sql);
        }

        return $result;
    }
    ?>

    <h2>Activated Bear List</h2>
    <p>You have <?php echo (get_activated_item_list() ? count(get_activated_item_list()) : '0'); ?> activated bears right now</p>

    <!-- If any item? show or hide the table  -->
    <?php if (count(get_activated_item_list()) > 0) : ?>
        <!-- // Active Item list  -->
        <?php include BBG_PLUGIN_PATH . '/templates/active_item.php'; ?>
        <!-- Certificate table  -->
        <?php include BBG_PLUGIN_PATH . '/templates/certificate.php'; ?>
    <?php else : ?>
        <p>You don't have any activation. Put your registration key to activate.</p>
        <a class="woocommerce-Button button" href="<?php site_url(); ?>/shop/">Browse products</a>

    <?php endif; ?>
</div>
