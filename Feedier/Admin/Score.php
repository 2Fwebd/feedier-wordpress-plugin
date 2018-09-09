<?php
namespace Feedier\Admin;

/**
 * Class Score
 *
 * @package Feedier\Admin
 */
class Score
{

	/**
	 * Return the tab title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return __('Score widget options', 'feedier');
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
	 * @param boolean   $not_ready - whether the API settings are correct or no
	 * @param array     $data - the current options data
	 * @param array     $api_response
	 *
	 * @return void
	 */
	public function writeMarkup($not_ready, $data, $api_response)
	{

		?>

		<p><?php _e('Please use the following shortcode in any page to display the widget.'); ?></p>

		<hr>

		<table class="form-table">
			<tbody>
			<?php foreach ($api_response['data'] as $carrier) : ?>
				<tr>
					<td scope="row">
						<b><?php echo $carrier['name']; ?></b>
					</td>
					<td>
						<pre>[feedier_score carrier_id="<?php echo $carrier['id']; ?>"]</pre>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>

		</table>

		<?php

	}

}