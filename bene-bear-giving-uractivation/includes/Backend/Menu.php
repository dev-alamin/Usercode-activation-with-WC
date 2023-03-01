<?php
namespace Benebear\Backend;

class Menu{
    public function __construct(){
        add_action('admin_menu', [ $this, 'bbg_user_reg_menus' ] );
    }

    public function bbg_user_reg_menus(){
        $hooks = add_menu_page(
            __('User Activation', 'bbg'), 
            __('User Activation', 'bbg'), 
            'manage_options', 'bbg-user-activation', 
            [ $this, 'bbg_user_activation_page'], 
            'dashicons-book', 
            77
        );

        $register = new \Benebear\Assets();

        add_action('admin_head-' . $hooks . '', [ $register, 'register' ] );
    }

    
    public function bbg_user_activation_page(){ ?>
    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Assing a unique code to user</h2>
                    <form id="bbg-reg-form" action="" method="POST" class="mt-3 mb-5">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name">
                        </div>
                        <!-- // Get all the product -->
                        <?php
                        function get_all_product()
                        {
                            global $wpdb;
                            $table = $wpdb->prefix . 'posts';
                            $sql = "SELECT * FROM $table WHERE post_type = 'product' AND post_status='publish'";
                            $result = $wpdb->get_results($sql);

                            return $result;
                        }


                        ?>
                        <select name="bear" class="form-select form-control mt-3">
                            <option selected="selected" disabled="disabled">Select Bear</option>
                            <?php
                            foreach (get_all_product() as $product) {
                                echo '<option value="' . $product->ID . '">' . $product->post_title . '</option>';
                            }
                            ?>
                        </select>
                        <!-- Get all code  -->
                        <?php
                        function get_all_unique_codes()
                        {
                            global $wpdb;
                            $table = $wpdb->prefix . 'bbg_user_registrations';
                            $sql = "SELECT * FROM $table WHERE status = '0' LIMIT 20";
                            $result = $wpdb->get_results($sql);

                            return $result;
                        }

                        get_all_unique_codes();
                        ?>
                        <select name="code" class="form-select form-control mt-3 form-control-lg">
                            <option selected="selected" disabled="disabled">Select Unique Code</option>
                            <?php
                            foreach (get_all_unique_codes() as $code) {
                                echo '<option value="' . $code->code . '">' . $code->code . '</option>';
                            }
                            ?>
                        </select>
                        <p class="mt-3"></p>

                        <?php
                        wp_nonce_field('new-code');
                        //submit_button(__('Assign Code', 'bbg'), 'primary', 'submit_reg_code') 
                        ?>
                        <button class="btn btn-primary" type="submit" name="submit_reg_code">Assign Code</button>
                    </form>


                    <h2>User list assigned with code</h2>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Code</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            function get_all_assigned_code_with_user()
                            {
                                global $wpdb;
                                $table = $wpdb->prefix . 'bbg_user_list';
                                $sql = "SELECT * FROM $table ORDER BY created_at DESC LIMIT 20";
                                $result = $wpdb->get_results($sql);

                                return $result;
                            }
                            ?>

                            <?php
                            $sn = 1;

                            foreach (get_all_assigned_code_with_user() as $user) : ?>
                                <tr>
                                    <th scope="row"><?php echo $sn++; ?></th>
                                    <td><?php echo $user->name; ?></td>
                                    <td><?php echo $user->code; ?></td>
                                    <td><a href="#">example@gmail.com</a></td>
                                    <td><?php echo date('F j, Y', strtotime($user->created_at)); ?></td>
                                    <td><?php echo 'Active' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
<?php
}

}
