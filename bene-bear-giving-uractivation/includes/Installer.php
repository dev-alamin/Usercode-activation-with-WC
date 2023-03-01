<?php
namespace Benebear;

class Installer{
    public function run(){
        $this->add_version();
        $this->create_tables();
    }
    
    public function add_version(){
        $installed = get_option('benebear_giving_version');

        if( ! $installed ) {
            $installed = update_option( 'benebear_giving_version', time() );
        }

        update_option( 'benebear_giving_version', BBG_VERSION );
    }

    
    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables(){
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}bbg_user_registrations` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `code` varchar(20) NOT NULL DEFAULT '',
            `type` varchar(12) DEFAULT NULL,
            `post_id` int(12) DEFAULT NULL,
            `user_id` int(12) DEFAULT NULL,
            `email` varchar(50) DEFAULT NULL,
            `product_id` int(12) DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `is_used` varchar(20) NOT NULL DEFAULT 'unused',
            `status` int(2) DEFAULT '0',
            PRIMARY KEY (`id`)
            ) $charset_collate";

        $user_table_schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}bbg_user_lists` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100),
            `code` varchar(20) NOT NULL DEFAULT '',
            `created_by` int(12),
            `created_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta($schema);
        dbDelta($user_table_schema);
    }


}
