<div class="bbg-activation-wrapper">
    <div id="awesome_form_message"></div>
    <form id="awesome_form" action="" method="POST">
        <div class="load-state"></div>
        <p><label for="code"><?php _e('Place the code you have been provided during purchase', 'woomc') ?></label></p>
        <p class="form-wrapper">
            <?php
            $user = get_current_user_id();
            ?>
            <input type="hidden" name="user_id" value="<?php echo sanitize_text_field($user); ?>">
            <input id="ursubmit_input" type="text" name="urcode" placeholder="Input your registration code" style="display: inline-block;">
            <button id="urcode_submitbtn" class="btn_submit_urcode" type="submit" name="submit_urcode"><?php _e('Activate', 'woomc'); ?> </button>
            <span id="loader" class="bbg_awesome_loader loader"><img src="<?php echo WOOMC_PLUGIN_URL . '/assets/image/loader.gif'; ?>" alt=""></span>
        </p>
    </form>

    <!-- Show all activated item list  -->
    <h2><?php _e('Activated Item List', 'woomc'); ?> </h2>
    <p>
        You have 
        <?php echo ( woomc_activated_item_list() ? count( woomc_activated_item_list()) : '0'); ?> 
        activated 
        <?php echo (count( woomc_activated_item_list()) > 1 ? 'bears' : 'bear'); ?> 
        right now
    </p>


    <!-- If any item? show or hide the table  -->
    <?php if (count( woomc_activated_item_list()) > 0) : ?>
        <!-- // Active Item list  -->
        <?php include WOOMC_PLUGIN_PATH . '/templates/active_item.php' ?>
        <!-- Certificate table  -->
    <?php endif; ?>
</div>

    