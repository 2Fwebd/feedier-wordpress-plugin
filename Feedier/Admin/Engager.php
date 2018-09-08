<?php
namespace Feedier\Admin;

/**
 * Class Engager
 *
 * @package Feedier\Admin
 */
class Engager
{

	/**
	 * Return the tab title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return __('Engager widget options', 'feedier');
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
		return isset($data['widget_carrier_id']);
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

		<table class="form-table">
			<tbody>

			<tr>
				<td scope="row">
					<label><?php _e( 'Feedback Carrier', 'feedier' ); ?></label>
				</td>
				<td>
					<select name="feedier_widget_carrier_id"
					        id="feedier_widget_carrier_id">
						<?php foreach ($api_response['data'] as $survey) : ?>
							<option value="<?php echo $survey['id']; ?>" <?php echo ($survey['id'] === (int) $data['widget_carrier_id']) ? 'selected' : '' ?>>
								<?php echo $survey['name']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'In-site', 'feedier' ); ?>
						<br>
						<small><?php _e( '(answer in a new tab or not)', 'feedier' ); ?></small>
					</label>
				</td>
				<td>
					<input name="feedier_widget_in_site"
					       id="feedier_widget_in_site"
					       type="checkbox"
						<?php echo (isset($data['widget_in_site']) && $data['widget_in_site']) ? 'checked' : ''; ?>/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'Display probability', 'feedier' ); ?>
						<br>
						<small><?php _e( '(from 0 to 100)', 'feedier' ); ?></small>
					</label>
				</td>
				<td>
					<input name="feedier_widget_display_probability"
					       id="feedier_widget_display_probability"
					       type="text"
					       size="4"
					       class="regular-text"
					       value="<?php echo (isset($data['widget_display_probability'])) ? esc_attr__($data['widget_display_probability']) : '100'; ?>"/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'Shaking effect', 'feedier' ); ?>
						<br>
						<small><?php _e( '(after 10s without any click)', 'feedier' ); ?></small>
					</label>
				</td>
				<td>
					<input name="feedier_widget_shake"
					       id="feedier_widget_shake"
					       type="checkbox"
						<?php echo (isset($data['widget_shake']) && $data['widget_shake']) ? 'checked' : ''; ?>/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label><?php _e( 'Position', 'feedier' ); ?></label>
				</td>
				<td>
					<select name="feedier_widget_position"
					        id="feedier_widget_position">
						<option value="left" <?php echo (!isset($data['widget_position']) || (isset($data['widget_position']) && $data['widget_position'] === 'left')) ? 'selected' : ''; ?>>
							<?php _e( 'Left side', 'feedier' ); ?>
						</option>
						<option value="right" <?php echo (isset($data['widget_position']) && $data['widget_position'] === 'right') ? 'selected' : ''; ?>>
							<?php _e( 'Right side', 'feedier' ); ?>
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'Title', 'feedier' ); ?>
						<br>
						<small><?php _e( '(if no title, reward name will be used)', 'feedier' ); ?></small>
					</label>
				</td>
				<td>
					<input name="feedier_widget_title"
					       id="feedier_widget_title"
					       type="text"
					       class="regular-text"
					       value="<?php echo (isset($data['widget_title'])) ? esc_attr__($data['widget_title']) : ''; ?>"/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'Extra content', 'feedier' ); ?>
						<br>
						<small><?php _e( '(added at the end)', 'feedier' ); ?></small>
					</label>
				</td>
				<td>
					<input name="feedier_widget_extra_line"
					       id="feedier_widget_extra_line"
					       type="text"
					       class="regular-text"
					       value="<?php echo (isset($data['widget_extra_line'])) ? esc_attr__($data['widget_extra_line']) : ''; ?>"/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'X offset', 'feedier' ); ?>
					</label>
				</td>
				<td>
					<input name="feedier_widget_offset_x"
					       id="feedier_widget_offset_x"
					       type="text"
					       size="4"
					       class="regular-text"
					       value="<?php echo (isset($data['widget_offset_x'])) ? esc_attr__($data['widget_offset_x']) : 0; ?>"/>
				</td>
			</tr>
			<tr>
				<td scope="row">
					<label>
						<?php _e( 'Y offset', 'feedier' ); ?>
					</label>
				</td>
				<td>
					<input name="feedier_widget_offset_y"
					       id="feedier_widget_offset_y"
					       type="text"
					       size="4"
					       class="regular-text"
					       value="<?php echo (isset($data['widget_offset_y'])) ? esc_attr__($data['widget_offset_y']) : 0; ?>"/>
				</td>
			</tr>
			</tbody>
		</table>

		<?php

	}

}