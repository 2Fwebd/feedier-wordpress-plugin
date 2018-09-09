<?php
namespace Feedier;

/**
 * Class Score
 *
 * @package Feedier
 */
class Score extends Main
{

	/**
	 * Widget constructor.
	 *
	 */
	public function __construct()
	{
		add_shortcode('feedier_score', array($this, 'shortcode'));
	}

	/**
	 * The shortcode's call back
	 *
	 * @param $atts array
	 *
	 * @return string
	 */
	public function shortcode($atts)
	{
		$data = $this->getData();

		if (!isset($data['public_key']))
			return __('Please set your Feedier public API key first', 'feedier');

		$a = shortcode_atts( array(
			'carrier_id' => '0',
		), $atts );

		return '<div class="feedier-widget" data-type="score-carrier" data-carrier-id="'. $a['carrier_id'] .'" data-key="'. $data['public_key'] .'"></div>';
	}


}