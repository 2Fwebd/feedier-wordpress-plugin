<?php
namespace Feedier;

/**
 * Class Engager
 *
 * @package Feedier
 */
class Engager extends Main
{

	/**
	 * Engager constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct()
	{
		add_action('wp_footer', array($this, 'addFooterCode'));
	}

	/**
	 * Add the web app code to the page's footer
	 *
	 * This contains the widget markup used by the web app and the widget API call on the frontend
	 * We use the options saved from the admin page
	 *
	 * @param $force boolean
	 *
	 * @return void
	 */
	public function addFooterCode($force = false)
	{

		$data = $this->getData();

		// Only if the survey id is selected and saved
		if(empty($data) || !isset($data['widget_carrier_id']))
			return;

		?>
		<div class="feedier-widget"
		     data-type="engager"
		     data-position="<?php echo (isset($data['widget_position'])) ? $data['widget_position'] : 'left'; ?>"
		     data-display-probability="<?php echo (isset($data['widget_display_probability'])) ? $data['widget_display_probability'] : '100'; ?>"
		     data-shake="<?php echo (isset($data['widget_shake'])) ? $data['widget_shake'] : false; ?>"
		     data-in-site="<?php echo (isset($data['widget_in_site'])) ? $data['widget_in_site'] : true; ?>"
		     data-carrier-id="<?php echo (isset($data['widget_carrier_id'])) ? $data['widget_carrier_id'] : '0'; ?>"
		     data-key="<?php echo (isset($data['public_key'])) ? $data['public_key'] : '0'; ?>"
			<?php if (isset($data['widget_title']) && !empty($data['widget_title'])): ?>
				data-widget-title="<?php echo $data['widget_title']; ?>"
			<?php endif; ?>
			<?php if (isset($data['widget_extra_line']) && !empty($data['widget_extra_line'])): ?>
				data-extra-line="<?php echo $data['widget_extra_line']; ?>"
			<?php endif; ?>
			<?php if (isset($data['widget_offset_x']) && !empty($data['widget_offset_x'])): ?>
				data-offset-x="<?php echo $data['widget_offset_x']; ?>"
			<?php endif; ?>
			<?php if (isset($data['widget_offset_y']) && !empty($data['widget_offset_y'])): ?>
				data-offset-y="<?php echo $data['widget_offset_y']; ?>"
			<?php endif; ?>
			<?php if ($force): ?>
				data-force="true"
			<?php endif; ?>
		></div>

		<?php

	}

}