<?php
namespace MyPlugin;

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

class Database {

    /**
     * Each custom table name should be declared as its own `const`.
     * Access the table name where needed as `\MyPlugin\Database::NAME_OF_TABLE`.
     */
    const NAME_OF_TABLE = 'my_custom_table';

    /**
     * Entry point to handle any tables being created or updated.
     */
    public function handle_tables() {
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        $this->handle_custom_table();
    }

    private function handle_custom_table() {
        $table_version_name = 'my_custom_table_version';
        $table_version = 1;
        $current_version = get_option($table_version_name, 0);

        if (version_compare($current_version, $table_version, '<')) {
            $this->create_employee_notes_table();
            update_option($table_version_name, $table_version);
        }
    }

    private function create_employee_notes_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::NOTES_TABLE;
        $charset_collate = $wpdb->get_charset_collate();
        dbDelta("CREATE TABLE IF NOT EXISTS $table_name (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            int_column int(11) UNSIGNED NOT NULL,
            text_column text NOT NULL,
            bool_column tinyint(1) NOT NULL DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;");
    }
}
