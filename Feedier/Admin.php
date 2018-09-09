<?php
namespace Feedier;

use Feedier\Admin\Feedbacks;

/**
 * Class Admin
 *
 * @package Feedier
 */
class Admin extends Main
{



	/**
	 * Feedier constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct()
	{
		add_action('admin_menu',                array($this, 'addAdminMenu'));
		add_action('wp_ajax_store_admin_data',  array($this, 'storeAdminData'));
		add_action('admin_enqueue_scripts',     array($this, 'addAdminScripts'));
	}

	/**
	 * Callback for the Ajax request
	 *
	 * Updates the options data
	 *
	 * @return void
	 */
	public function storeAdminData()
	{

		if (wp_verify_nonce($_POST['security'], $this->_nonce ) === false)
			die('Invalid Request! Reload your page please.');

		$data = $this->getData();

		foreach ($_POST as $field=>$value) {

			if (substr($field, 0, 8) !== "feedier_")
				continue;

			if (empty($value))
				unset($data[$field]);

			// We remove the feedier_ prefix to clean things up
			$field = substr($field, 8);

			$data[$field] = esc_attr__($value);

		}

		update_option($this->option_name, $data);

		echo __('Saved!', 'feedier');
		die();

	}

	/**
	 * Adds Admin Scripts for the Ajax call
	 */
	public function addAdminScripts()
	{
		wp_enqueue_style('feedier-admin', FEEDIER_URL. 'assets/css/admin.css', false, 1.0);
		wp_enqueue_script('feedier-admin', FEEDIER_URL. 'assets/js/admin.js', array(), 1.0);

		$admin_options = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'_nonce'   => wp_create_nonce( $this->_nonce ),
		);

		wp_localize_script('feedier-admin', 'feedier_exchanger', $admin_options);
	}

	/**
	 * Adds the Feedier label to the WordPress Admin Sidebar Menu
     *
     * It also initiates the Feedback class to fire the WP list table at the right time
	 */
	public function addAdminMenu()
	{
		$page_hook = add_menu_page(
			__( 'Feedback', 'feedier' ),
			__( 'Feedback', 'feedier' ),
			'manage_options',
			'feedier',
			array($this, 'adminLayout'),
			'dashicons-testimonial'
		);

		add_action('load-'.$page_hook, function () {
			$arguments = array(
				'label'		=>	__( 'Feedbacks Per Page', 'feedier'),
				'default'	=>	30,
				'option'	=>	'feedbacks_per_page'
			);
			add_screen_option( 'per_page', $arguments);
			new Feedbacks('feedier');
        });
	}

	/**
	 * Make an API call to the Feedier API and returns the response
	 *
	 * @param $private_key string
	 * @param $carrier_id int|null
	 *
	 *
	 * @return array
	 */
	private function getCarriers($private_key, $carrier_id = null)
	{
		$data = array();

		$carrier_id = ($carrier_id) ? '&carrier_id='. $carrier_id : '';

		$response = wp_remote_get(FEEDIER_PROTOCOL. '://api.'. FEEDIER_ENDPOINT .'/v1/carriers/?api_key='. $private_key . $carrier_id);

		if (is_array($response) && !is_wp_error($response)) {
			$data = json_decode($response['body'], true);
		}

		return $data;
	}

	/**
	 * Get a Dashicon for a given status
	 *
	 * @param $valid boolean
	 *
	 * @return string
	 */
	private function getStatusIcon($valid)
	{

		return ($valid) ? '<span class="dashicons dashicons-yes success-message"></span>' : '<span class="dashicons dashicons-no-alt error-message"></span>';

	}

	/**
	 * Outputs the Admin Dashboard layout containing the form with all its options
	 *
	 * @return void
	 */
	public function adminLayout()
	{

		$data                   = $this->getData();
		$api_response           = $this->getCarriers($data['private_key']);
		$not_ready              = (empty($data['public_key']) || empty($api_response) || isset($api_response['error']));
		$has_engager_preview    = (isset($_GET['feedier-demo-engager']) && $_GET['feedier-demo-engager'] === 'go');
		$has_wc                 = (class_exists('WooCommerce'));
		$nav_tab                = (isset($_GET['tab'])) ? $_GET['tab'] : false;
		$tabs                   = array(
			'feedier-settings'      => __('Settings', 'feedier'),
			'feedier-engager'       => __('Engager widget', 'feedier'),
			'feedier-score'         => __('Score widget', 'feedier'),
			'feedier-feedback'      => __('Feedback Entries', 'feedier'),
			'feedier-woocommerce'   => __('WooCommerce', 'feedier'),
		);

		if ($nav_tab === 'feedier-engager') {
			$tab_class = new Admin\Engager();
		} else if ($nav_tab === 'feedier-woocommerce') {
			$tab_class = new Admin\WooCommerce();
		} else if ($nav_tab === 'feedier-feedback') {
			$tab_class = new Admin\Feedbacks();
		} else if ($nav_tab === 'feedier-score') {
			$tab_class = new Admin\Score();
		} else {
			$tab_class = new Admin\Settings();
			$nav_tab = 'feedier-settings';
		}

		?>

		<div class="wrap">

			<h1><?php _e('Feedier Settings - start collecting real Feedback!', 'feedier'); ?></h1>

			<h2 class="nav-tab-wrapper">
				<?php foreach ($tabs as $key=>$tab) { ?>
					<?php if (!$has_wc && $key === 'feedier-woocommerce') {
						continue;
					} ?>
					<a href="?page=feedier&tab=<?php echo $key; ?>" class="nav-tab <?php echo ($nav_tab && $nav_tab === $key) ? 'nav-tab-active' : ''; ?>">
						<?php echo $tab; ?>
					</a>
				<?php } ?>
			</h2>

			<?php if ($has_engager_preview) { ?>
				<?php $widget_Engager = new Engager();
				$widget_Engager->addFooterCode(true); ?>
				<p class="notice notice-warning p-10">
					<?php _e( 'The demo engager is enabled. You will see the widget, exactly as it will be displayed on your site.<br> The only difference is that until the preview is turned off it will always come back compared to the live version.', 'feedier' ); ?>
				</p>
			<?php } ?>


			<form id="feedier-admin-form" class="postbox">

				<div class="form-group inside">

					<h3>
						<?php echo $this->getStatusIcon($tab_class->isActive($not_ready, $data)); ?>
						<?php echo $tab_class->getTitle(); ?>
					</h3>

                    <?php
                    // If we have an error returned by the API
                    if (isset($api_response['type']) && $api_response['type'] === 'error'): ?>

                        <p class="notice notice-error">
                            <?php echo $api_response['message']; ?>
                        </p>

                    <?php endif; ?>

		            <?php $tab_class->writeMarkup($not_ready, $data, $api_response); ?>

				</div>

				<hr>

				<div class="inside">

					<button class="button button-primary" id="feedier-admin-save" type="submit">
						<?php _e( 'Save', 'feedier' ); ?>
					</button>

					<?php if (!$not_ready && $nav_tab === 'feedier-engager'): ?>

						<?php if ($has_engager_preview): ?>
							<a href="<?php echo admin_url('admin.php?page=feedier'); ?>" class="button">
								<?php _e( 'Stop engager widget', 'feedier' ); ?>
							</a>
						<?php else: ?>
							<a href="<?php echo add_query_arg('feedier-demo-engager','go'); ?>" class="button">
								<?php _e( 'Preview engager widget', 'feedier' ); ?>
							</a>
						<?php endif; ?>

					<?php endif; ?>

				</div>

			</form>

		</div>

		<?php

	}

}