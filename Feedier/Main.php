<?php
namespace Feedier;

/**
 * Class Main
 *
 * This is the base parent class
 *
 * @package Feedier
 */
class Main
{

	/**
	 * The security nonce
	 *
	 * @var string
	 */
	public $_nonce = 'feedier_admin';

	/**
	 * The option name
	 *
	 * @var string
	 */
	public $option_name = 'feedier_data';


	/**
	 * Returns the saved options data as an array
	 *
	 * @return array
	 */
	public function getData()
	{
		return get_option($this->option_name, array());
	}

}
