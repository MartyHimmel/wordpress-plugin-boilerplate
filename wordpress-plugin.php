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

class My_Plugin {

	public function __construct() {
		register_activation_hook(__FILE__, [$this, 'activate_plugin']);
		register_deactivation_hook(__FILE__, [$this, 'deactivate_plugin']);

		// Load translation files
		add_action('plugins_loaded', [$this, 'load_translation_files']);

		$this->load_classes();

		if (is_admin()) {
			new \MyPlugin\Admin();
		} else {
			add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
			add_action('wp_enqueue_scripts', [$this, 'register_styles']);
			new \MyPlugin\Shortcode();
		}

		new \MyPlugin\Ajax();
	}

	/**
	 * Set up plugin for use.
	 */
	public function activate_plugin() {
		if (!current_user_can('activate_plugins')) {
			return;
		}

		$db = new \MyPlugin\Database();
		$db->handle_tables();
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
	 * Loads the plugin translation files.
	 */
	public function load_translation_files() {
		load_plugin_textdomain('my-plugin-text', false,
			plugin_basename(dirname(__FILE__)) . '/languages');
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
	 * Register public/front end JavaScript files for use.
	 */
	public function register_scripts() {
		wp_register_script(
			'my_plugin_scripts',
			plugins_url('js/public/scripts.js', __FILE__),
			['jquery', 'another_dependency', 'etc...']
		);

		// This can be moved elsewhere to conditionally load it as needed.
		wp_enqueue_script('my_plugin_scripts');
	}

	/**
	 * Register public/front end CSS stylesheets for use.
	 */
	public function register_styles() {
		wp_register_style(
			'my_plugin_styles',
			plugins_url('css/public/styles.css', __FILE__)
		);

		// This can be moved elsewhere to conditionally load it as needed.
		wp_enqueue_style('my_plugin_styles');
	}
}

new My_Plugin();
