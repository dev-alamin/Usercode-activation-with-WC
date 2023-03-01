<?php 
 function activated_item_list(){
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
<table>
    <thead>
        <th>#</th>
        <th>Activation Code</th>
        <th>Activation date</th>
        <th style="text-align: center">Certificate</th>
    </thead>
    <tbody>
        <?php
        $p_sn = 1;
        // Kick the query
        foreach (activated_item_list() as $item) :
            global $wpdb;
            $table = $wpdb->prefix . 'posts';
            $user_id = get_current_user_id();
        ?>
            <tr>
                <td><?php echo $p_sn++; ?></td>
                <td><?php echo $item->code ?> </td>
                <td><?php echo date('F j, Y', strtotime($item->created_at)); ?></td>
                <td style="text-align: center">
                    <?php
                    $user_info =  $user_info = get_userdata($user_id);
                    $username = $user_info->user_login;
                    $first_name = $user_info->first_name;
                    $last_name = $user_info->last_name;
                    $name = '';

                    if (!empty($first_name) || !empty($last_name)) {
                        $name = $first_name . ' ' . $last_name;
                    } else {
                        $name = $username;
                    }

                    ?>

                  
                    <a class="btn_print_preview" href="/wp/testing-plugin-page-template/?certificate=<?php echo $item->code; ?>" target="_blank">
                        Print view
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>


    </tbody>
</table>