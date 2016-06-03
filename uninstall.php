<?php
// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

// Remove plugin database tables, plugin options, etc.
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . MY_DATABASE_TABLE_1);
delete_option($wpdb->prefix . 'my_plugin_table_1_version');
?>