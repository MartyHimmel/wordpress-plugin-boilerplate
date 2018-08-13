<?php
defined('ABSPATH') or die(__('You shall not pass!', 'my-plugin-text'));
?>

<div class="wrap">
	<h2><?php _e('Admin Page 1', 'my-plugin-text'); ?></h2>

    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th><?php _e('Section 1', 'my-plugin-text'); ?></th>
                <td>
                    <input type="text" name="my_input_text">
                </td>
            </tr>

            <tr>
                <th><?php _e('Section 2', 'my-plugin-text'); ?></th>
                <td>
                    <textarea name="my_textarea"></textarea>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <?php submit_button(); ?>
                </td>
            </tr>
        </table>
    </form>
</div>
