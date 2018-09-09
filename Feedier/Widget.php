<?php
namespace Feedier;

/**
 * Class Widget
 *
 * @package Feedier
 */
class Widget extends Main
{

	/**
	 * Widget constructor.
	 *
	 */
	public function __construct()
	{
		add_action('wp_footer', array($this, 'addFooterCode'));
	}

	/**
	 * Add the API call at the page's bottom
	 */
	public function addFooterCode()
	{
		echo '<script src="'. FEEDIER_PROTOCOL .'://' . FEEDIER_ENDPOINT .'/js/widgets/widgets.min.js" type="text/javascript" async></script>';
	}


}