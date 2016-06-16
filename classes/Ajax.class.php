<?php
namespace MyPlugin;

defined('ABSPATH') or die('You shall not pass!');

class Ajax {

	/**
	 * Nonce name for AJAX calls.
	 */
	const NONCE = 'my_plugin_nonce';

	public function __construct() {
		$this->send_data();

		// List of AJAX actions
		add_action('wp_ajax_my_plugin_ajax_action', array($this, 'ajax_action'));
		add_action('wp_ajax_nopriv_my_plugin_ajax_action', array($this, 'ajax_action'));
	}

	public function ajax_action() {
		if (!check_ajax_referer(self::NONCE, 'nonce')) {
			wp_send_json_error(array(
				'message' => 'Verification failed. Reload the page and try again.'
			));
		}

		// Do something
	}

	public function send_data() {
		$send_data = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce(self::NONCE)
		);

		if (is_admin()) {
			wp_localize_script('my_plugin_admin_scripts', 'my_plugin_ajax', $send_data);
		} else {
			wp_localize_script('my_plugin_scripts', 'my_plugin_ajax', $send_data);
		}
	}
}
