<?php
namespace Feedier\Admin;

/**
 * Class WooCommerce
 *
 * @package Feedier\Admin
 */
class WooCommerce
{

	/**
	 * Return the tab title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return __('WooCommerce', 'feedier');
	}

	/**
	 * Whether the page is ready or not
	 *
	 * @param boolean $not_ready
	 * @param array   $data
	 *
	 * @return boolean
	 */
	public function isActive($not_ready, $data)
	{
		return !$not_ready && class_exists('WooCommerce') && isset($data['wc_content']);
	}

	/**
	 * Write the tab markup
	 *
	 * @param boolean   $has_wc - whether WC is enabled or not
	 * @param array     $data - the current options data
	 * @param array     $api_response
	 *
	 * @return void
	 */
	public function writeMarkup($has_wc, $data, $api_response)
	{

		?>

		<p>
			<?php _e('If enabled, an email footer not will be included when the order is completed to ask the customer to give his feedback. You can customize the content below.', 'feedier'); ?>
		</p>

		<?php if ($has_wc): ?>

			<table class="form-table">
				<tbody>
				<tr>
					<td scope="row">
						<label><?php _e( 'Feedback Carrier', 'feedier' ); ?></label>
					</td>
					<td>
						<select name="feedier_wc_carrier_id"
						        id="feedier_wc_carrier_id">
							<?php foreach ($api_response['data'] as $survey) : ?>
								<option value="<?php echo $survey['id']; ?>" <?php echo ($survey['id'] === (int) $data['wc_carrier_id']) ? 'selected' : '' ?>>
									<?php echo $survey['name']; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label>
							<?php _e( 'Enabled', 'feedier' ); ?>
						</label>
					</td>
					<td>
						<input name="feedier_wc_enabled"
						       id="feedier_wc_enabled"
						       type="checkbox"
							<?php echo (isset($data['wc_enabled']) && $data['wc_enabled']) ? 'checked' : ''; ?>/>
					</td>
				</tr>
				<tr>
					<td scope="row">
						<label>
							<?php _e( 'Content', 'feedier' ); ?>
							<br>
							<small><?php _e( '(sent with the complete order email)', 'feedier' ); ?></small>
						</label>
					</td>
					<td>
                        <textarea name="feedier_wc_content"
                                  rows="4"
                                  cols="50"
                                  id="feedier_wc_content"><?php echo (isset($data['wc_content'])) ? esc_html__($data['wc_content']) : __( 'Your feedback matters. Please take 2 minutes to give us your feedback on your experience here: {URL}', 'feedier' ); ?>
                        </textarea>
					</td>
				</tr>
				</tbody>
			</table>

		<?php else: ?>
			<p>
				<?php _e('WooCommerce is not installed or active.', 'feedier'); ?>
			</p>
		<?php endif; ?>

		<?php

	}

}