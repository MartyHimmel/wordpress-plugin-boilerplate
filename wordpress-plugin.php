<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI: http://www.example.com
 * Description: What the plugin does.
 * Version: 1.0.0
 * Author: Martin Himmel
 * Author URI: http://www.martyhimmel.me
 */

defined('ABSPATH') or die('You shall not pass!');

if (!class_exists('My_Plugin')) {

	class My_Plugin {

		public function __construct() {
			add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
			add_action('wp_enqueue_scripts', array($this, 'add_styles'));
			add_shortcode('my_shortcode', array($this, 'shortcode'));
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
			wp_register_style('my_plugin_styles', plugins_url('css/styles.css', __FILE__));
			wp_enqueue_style('my_plugin_styles');
		}

		/**
		 * Run the shortcode
		 * @param  array $atts			Array of attributes.
		 * @param  string $content		Content enclosed in the shortcode.
		 * @return string
		 */
		public function shortcode($atts, $content = '') {
			// If including HTML or a separate file, use something like this:
			// ob_start();
			// echo '<div>Lorem ipsum</div>';
			// include 'includes/somefile.php';
			// $html = ob_get_clean();
			// return $html;
			return $content;
		}
	}

	$my_plugin = new My_Plugin();
}