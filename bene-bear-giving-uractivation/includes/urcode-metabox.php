<?php
add_action('admin_init', 'bbg_add_urcode_metabox');

function bbg_add_urcode_metabox()
{
    add_meta_box('bbg_urcode', __('UR Code info', 'bbgurcode'), 'bbg_bbg_urcode_metabox_cb', 'urcode', 'advanced', 'high');
}

function bbg_bbg_urcode_metabox_cb()
{
?>
    <table>
        <thead>
            <th>User Email</th>
            <th>User ID</th>
            <th>Status</th>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" value="<?php echo esc_html(get_post_meta(get_the_ID(), 'bbg_urcode_email', true)); ?>" readonly></td>
                <td><input type="text" value="<?php echo esc_html(get_post_meta(get_the_ID(), 'bbg_urcode_uid', true)); ?>" readonly></td>
                <td><input type="text" value="<?php echo get_post_meta(get_the_ID(), 'bbg_urcode_is_used', true); ?>" readonly></td>
            </tr>
        </tbody>
    </table>

<?php
}
