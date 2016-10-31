<?php
namespace MyPlugin;

/**
 * Plugin Name: My Plugin
 * Plugin URI: http://www.example.com
 * Description: What the plugin does.
 * Version: 0.1.0
 * Author: Martin Himmel
 * Author URI: http://www.martyhimmel.me
 * Text Domain: my-plugin-text
 * Domain Path: /languages
 */

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

// Define global path and URL for use in the plugin
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugins_url('/', __FILE__));

// Define database tables
define('MY_DATABASE_TABLE_1', 'my_database_table_1');

class My_Plugin {

	// Define constants for database table versioning - an option name and the version number
	const MY_DATABASE_TABLE_VERSION_NAME = 'my_database_table_version';
	const MY_DATABASE_TABLE_VERSION = 1;

	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activate_plugin'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate_plugin'));

		// Load translation files
		add_action('plugins_loaded', array($this, 'load_translation_files'));
		
		$this->load_classes();

		if (is_admin()) {
			new Admin();
		} else {
			add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
			add_action('wp_enqueue_scripts', array($this, 'register_styles'));
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

		// Required for dbDelta
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

		// Get current versions of tables
		$current_database_table_version = get_option(self::MY_DATABASE_TABLE_VERSION_NAME);

		// Create or update database tables
		if ($current_assessment_table_version != self::ASSESSMENTS_TABLE_VERSION) {
			$this->database_table_1();
		}
	}

	/**
	 * Creates or updates a database table.
	 */
	public function database_table_1() {
		global $wpdb;
		$table_name = $wpdb->prefix . MY_DATABASE_TABLE_1;
		$charset_collate = $wpdb->get_charset_collate();

		$current_version = get_option($version_option_name);
		
		$sql = "CREATE TABLE $table_name (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id)
			) $charset_collate;";

		dbDelta($sql);

		update_option(self::MY_DATABASE_TABLE_VERSION_NAME, self::MY_DATABASE_TABLE_VERSION);
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

	/**
	 * Loads the plugin translation files.
	 */
	public function load_translation_files() {
		load_plugin_textdomain('my-plugin-text', false,
			plugin_basename(dirname(__FILE__)) . '/languages');
	}

	/**
	 * Register JavaScript files for use.
	 */
	public function register_scripts() {
		wp_register_script(
			'my_plugin_scripts',
			plugins_url('js/scripts.js', __FILE__),
			array('dependency1', 'dependency2', 'etc...')
		);

		// This can be moved elsewhere to conditionally load it as needed.
		wp_enqueue_script('my_plugin_scripts');
	}

	/**
	 * Register CSS stylesheets for use.
	 */
	public function register_styles() {
		wp_register_style(
			'my_plugin_styles',
			plugins_url('css/styles.css', __FILE__)
		);

		// This can be moved elsewhere to conditionally load it as needed.
		wp_enqueue_style('my_plugin_styles');
	}
}

new My_Plugin();
