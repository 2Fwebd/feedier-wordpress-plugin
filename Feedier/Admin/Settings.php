<?php
namespace Feedier\Admin;

/**
 * Class Settings
 *
 * @package Feedier\Admin
 */
class Settings
{

	/**
	 * Return the tab title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return __('Feedier API Settings', 'feedier');
	}

	/**
	 * Whether the page is ready or not
	 *
	 * @param $not_ready
	 *
	 * @return boolean
	 */
	public function isActive($not_ready)
	{
		return !$not_ready;
	}

	/**
	 * Write the tab markup
	 *
	 * @param boolean   $not_ready - whether the Api settings are correct and set or not
	 * @param array     $data - the current options data
	 *
	 * @return void
	 */
	public function writeMarkup($not_ready, $data)
	{

		?>

		<?php if ($not_ready): ?>
			<p>
				<?php _e('Make sure you have a Feedier account first, it\'s free! 👍', 'feedier'); ?>
				<?php _e('You can <a href="https://feedier.com" target="_blank">create an account here</a>.', 'feedier'); ?>
				<br>
				<?php _e('If so you can find your api keys from your <a href="https://dashboard.feedier.com/#/integrations" target="_blank">integrations page</a>.', 'feedier'); ?>
				<br>
				<br>
				<?php _e('Once the keys set and saved, if you do not see any option, please reload the page. Thank you, you rock 🤘', 'feedier'); ?>
			</p>
		<?php else: ?>
				<?php _e('Access your <a href="https://dashboard.feedier.com" target="_blank">Feedier dashboard here</a>.', 'feedier'); ?>
		<?php endif; ?>

		<table class="form-table">
			<tbody>
			<tr>
				<td scope="row">
					<label><?php _e( 'Public key', 'feedier' ); ?></label>
				</td>
				<td>
					<input name="feedier_public_key"
					       id="feedier_public_key"
					       class="regular-text"
					       type="text"
					       value="<?php echo (isset($data['public_key'])) ? $data['public_key'] : ''; ?>"/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label><?php _e( 'Private key', 'feedier' ); ?></label>
				</td>
				<td>
					<input name="feedier_private_key"
					       id="feedier_private_key"
					       class="regular-text"
					       type="text"
					       value="<?php echo (isset($data['private_key'])) ? $data['private_key'] : ''; ?>"/>
				</td>
			</tr>
			</tbody>
		</table>

		<?php

	}

}