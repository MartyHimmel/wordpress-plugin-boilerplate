<?php
namespace MyPlugin;

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

class Ajax {

	/**
	 * Nonce name for AJAX calls.
	 */
	const NONCE = 'my_plugin_nonce';

	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'send_data'));
		add_action('wp_enqueue_scripts', array($this, 'send_data'));

		// List of AJAX actions
		add_action('wp_ajax_my_plugin_ajax_action', array($this, 'ajax_action'));
		add_action('wp_ajax_nopriv_my_plugin_ajax_action', array($this, 'ajax_action'));
	}

	public function ajax_action() {
		$this->verify_nonce();

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

	public function verify_nonce() {
		if (!check_ajax_referer(self::NONCE, 'nonce')) {
			wp_send_json_error(array(
				'message' => __('Verification failed. Reload the page and try again.', 'my-plugin-text')
			));
		}
	}
}
