<?php
namespace MyPlugin;

/**
 * Plugin Name: My Plugin
 * Plugin URI: http://www.example.com
 * Description: What the plugin does.
 * Version: 1.0.0
 * Author: Martin Himmel
 * Author URI: http://www.martyhimmel.me
 */

defined('ABSPATH') or die('You shall not pass!');

// Define global constants for use in the plugin
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugins_url('/', __FILE__));
define('MY_DATABASE_TABLE_1', 'my_database_table_1');

class My_Plugin {

	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activate_plugin'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate_plugin'));

		$this->load_classes();

		if (is_admin()) {
			new Admin();
		} else {
			add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
			add_action('wp_enqueue_scripts', array($this, 'add_styles'));
			new Shortcode();
		}

		new Ajax();
	}

	/**
	 * Set up plugin for use.
	 * 
	 * This is a good place to set up any initial options and/or create database tables.
	 */
	public function activate_plugin() {
		if (!current_user_can('activate_plugins')) {
			return;
		}

		// Do something
		$this->create_database_table_1();
	}

	/**
	 * Register and enqueue scripts.
	 */
	public function add_scripts() {
		wp_register_script(
			'my_plugin_scripts',
			plugins_url('js/scripts.js', __FILE__),
			array('dependency1', 'dependency2', 'etc...')
		);
		wp_enqueue_script('my_plugin_scripts');
	}

	/**
	 * Register and enqueue styles.
	 */
	public function add_styles() {
		wp_register_style(
			'my_plugin_styles',
			plugins_url('css/styles.css', __FILE__)
		);
		wp_enqueue_style('my_plugin_styles');
	}

	/**
	 * Creates or updates a database table.
	 */
	public function create_database_table_1() {
		global $wpdb;
		$table_name = $wpdb->prefix . MY_DATABASE_TABLE_1;
		$table_version = 1;
		$version_option_name = $wpdb->prefix . 'my_plugin_table_1_version';
		$charset_collate = $wpdb->get_charset_collate();

		$current_version = get_option($version_option_name);
		
		if ($current_version != $table_version) {
			$sql = "CREATE TABLE $table_name (
				id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
				updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
				PRIMARY KEY  (id)
				) $charset_collate;";

			// Required for dbDelta
			require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

			update_option($version_option_name, $table_version);
		}
	}

	/**
	 * Perform any actions/clean up when deactivating the plugin.
	 */
	public function deactivate_plugin() {
		if (!current_user_can('activate_plugins')) {
			return;
		}
		// Do something
	}

	/**
	 * Load classes for use in the plugin.
	 */
	public function load_classes() {
		$files = glob(MY_PLUGIN_PATH . 'classes/*.class.php');
		foreach ($files as $file) {
			require_once $file;
		}
	}
}

new My_Plugin();
