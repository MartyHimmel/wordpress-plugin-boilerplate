<?php
namespace MyPlugin;

defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));

class Shortcode {

	public function __construct() {
		add_shortcode('my_shortcode', array($this, 'shortcode'));
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
		// include 'views/somehtmlfile.php';
		// $html = ob_get_clean();
		// return $html;
		return $content;
	}

}
