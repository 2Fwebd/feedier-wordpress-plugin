<?php
namespace Feedier;

/**
 * Class WooCommerce
 *
 * @package Feedier
 */
class WooCommerce
{

	/**
	 * WooCommerce constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct()
	{
		add_action('woocommerce_email_footer',  array($this, 'wcFooter'));
	}

	/**
	 * WooCommerce hook to add the Feedier note
	 *
	 * @param $email WC_Email
	 *
	 * @return void
	 */
	public function wcFooter($email)
	{
		if ($email->id !== 'customer_completed_order')
			return;

		$data = $this->getData();

		if (!isset($data['wc_enabled']) || !$data['wc_enabled'] || !isset($data['wc_content']))
			return;

		$content = '';

		$content .= '<div style="display: block; text-align: center; margin-bottom: 10px;">';

		if (isset($data['wc_carrier_id'])) {
			$api_response = $this->getCarriers($data['private_key'], $data['wc_carrier_id']);
			$carrier = (isset($api_response['data'][0]) && !empty($api_response['data'][0])) ? $api_response['data'][0] : null;
			if ($carrier)
				$content .= str_replace('{URL}', '<a href="'. esc_url($carrier['url']) .'?email='. $email->recipient .'">'. esc_url($carrier['url']) .'</a>', esc_html($data['wc_content']));
		} else {
			$content .= $data['wc_content'];
		}

		$content .= '</div>';

		echo $content;
	}

}