<?php
namespace MyPlugin;

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

class Utils {

	/**
	 * Displays an admin panel styled message.
	 * @param  string $class		CSS class. Either "updated" or "error".
	 * @param  string $message		Message to be displayed
	 */
	public static function display_admin_message($class, $message) {
		echo "<div class='{$class}'><p>{$message}</p></div>";
	}

	/**
	 * Creates a random alphanumeric string.
	 * @param  integer $length Desired length of string.
	 * @return string          Randomized string.
	 */
	public static function random_string($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $characters_length = strlen($characters);
	    $random_string = '';
	    for ($i = 0; $i < $length; $i++) {
	        $random_string .= $characters[rand(0, $characters_length - 1)];
	    }
	    return $random_string;
	}

	/**
	 * Checks if a nonce has been submitted and verifies it.
	 * @param  string|null $nonce	Nonce value or null if it hasn't been submitted.
	 * @param  string $nonce_name	Name of the nonce.
	 * @return bool|null			Verification pass/fail or null if a nonce hasn't been submitted.
	 */
	public static function verify_form_nonce($nonce, $nonce_name) {
		if (isset($nonce)) {
			if (!wp_verify_nonce($nonce, $nonce_name)) {
				return false;
			} else if (wp_verify_nonce($nonce, $nonce_name)) {
				return true;
			}
		}
		return null;
	}
}