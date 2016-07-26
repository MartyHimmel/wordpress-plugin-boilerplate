<?php
namespace MyPlugin;

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

class Admin {

	public function __construct() {
		add_action('admin_menu', array($this, 'create_admin_menu'));
		add_action('admin_enqueue_scripts', array($this, 'add_admin_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'add_admin_styles'));
	}

	/**
	 * Register and enqueue admin scripts.
	 */
	public function add_admin_scripts() {
		wp_register_script(
			'my_plugin_admin_scripts',
			MY_PLUGIN_URL . 'js/admin.js',
			array('dependency1', 'dependency2', 'etc...')
		);
		wp_enqueue_script('my_plugin_admin_scripts');
	}

	/**
	 * Register and enqueue admin styles.
	 */
	public function add_admin_styles() {
		wp_register_style(
			'my_plugin_admin_styles',
			MY_PLUGIN_URL . 'css/admin.css'
		);
		wp_enqueue_style('my_plugin_admin_styles');
	}

	/**
	 * Create the admin menu and submenu items.
	 */
	public function create_admin_menu() {
		add_menu_page(
			'My Plugin Page Title',
			'Admin Menu Text',
			'manage_options',
			'my-plugin-parent-slug',
			array($this, 'menu_item_1')
		);

		add_submenu_page(
			'my-plugin-parent-slug',
			'My Plugin Page Title',
			'Admin Menu Text',
			'manage_options',
			'my-plugin-parent-slug',
			array($this, 'menu_item_1')
		);

		add_submenu_page(
			'my-plugin-parent-slug',
			'My Plugin Page Title (2)',
			'Admin Menu Text',
			'manage_options',
			'my-plugin-second-item-slug',
			array($this, 'menu_item_2')
		);
	}

	/**
	 * Display the page for the first menu item.
	 */
	public function menu_item_1() {
		require_once MY_PLUGIN_PATH . 'views/admin-page-1.php';
	}

	/**
	 * Display the page for the second menu item.
	 */
	public function menu_item_2() {
		require_once MY_PLUGIN_PATH . 'views/admin-page-2.php';
	}
}
