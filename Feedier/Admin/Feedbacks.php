<?php
namespace Feedier\Admin;

use Feedier\Libraries\WP_List_Table;

/**
 * Class Feedbacks
 *
 * @package Feedier\Admin
 */
class Feedbacks extends WP_List_Table
{

	public function get_columns()
	{
		return array(
			'satisfaction_ratio'	=> __('Satisfaction Ratio', 'feedier'),
			'time'                  => __('Time', 'feedier'),
			'reward'		        => __('Reward', 'feedier'),
			'engagement'		    => __('Engagement', 'feedier'),
			'email'		            => __('Email', 'feedier'),
			'feedback_carrier'	    => __('Feedback Carrier', 'feedier'),
			'date'                  => __('Date', 'feedier'),
			'answers'		        => __('Answers', 'feedier'),
		);
	}

	public function no_items() {
		_e('No feedback entries available.', 'feedier');
	}

	public function prepare_items()
	{

		$data = get_option('feedier_data', array());

		if (!isset($data['private_key']))
			return null;

		$response = wp_remote_get(FEEDIER_PROTOCOL. '://api.'. FEEDIER_ENDPOINT .'/v1/feedbacks/?api_key='. $data['private_key'] .'&page='. $this->get_pagenum());

		if (!is_array($response) || is_wp_error($response))
			return null;

		$body = json_decode($response['body'], true);

		$feedbacks = array();

		if ($body['type'] === 'error')
			return $body['message'];

		foreach ($body['data'] as $entry) {
			array_push($feedbacks, array(
				'satisfaction_ratio'	=> '<b>'. $entry['satisfaction_ratio'] . '%</b>',
				'feedback_carrier'	    => '<a href="'. $entry['carrier']['url'] .'" target="_blank">'. $entry['carrier']['name'] .'</a>',
				'date'                  => '<i>' . mysql2date('F j, Y g:i a', $entry['created_at']) . '</i>',
				'time'                  => ($entry['completion_time'] / 1000) . 'sec',
				'email'		            => ($entry['email']) ? '<b>'. $entry['email'] .'</b>' : 'N/A',
				'reward'		        => ($entry['reward']) ? '<b>'. $entry['reward']['name'] .'</b>' : 'N/A',
				'engagement'		    => ($entry['engagement']) ? '<b>'. $entry['engagement'] .'</b>' : 'N/A',
				'answers'		        => '<a href="'. FEEDIER_PROTOCOL .'://dashboard.'. FEEDIER_ENDPOINT .'/#/feedback/'. $entry['id'] .'" class="button button-primary" target="_blank">'. __('Report') .' #'. $entry['id'] .'</a>',
			));
		}

		$this->_column_headers = $this->get_column_info();
		$this->items = $feedbacks;
		$this->set_pagination_args( array (
			'total_items' => $body['total'],
			'per_page'    => $body['per_page'],
			'total_pages' => ceil( $body['total'] / $body['per_page'] )
		) );
	}

	public function column_default($item, $column_name) {
		return $item[$column_name];
	}

	/**
	 * Return the tab title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return __('Feedback entries', 'feedier');
	}

	/**
	 * Whether the page is ready or not
	 *
	 * @param boolean $not_ready
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
	 * @param boolean   $has_wc - whether WC is enabled or not
	 * @param array     $data - the current options data
	 * @param array     $api_response
	 *
	 * @return void
	 */
	public function writeMarkup($has_wc, $data, $api_response)
	{
		$this->prepare_items();
		$this->display();
	}

}