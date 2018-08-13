<?php
// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

// Remove plugin database tables, plugin options, etc.
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . TABLE_NAME);
delete_option('my_custom_table_version');
