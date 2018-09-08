<?php
/**
 * Plugin Name:       Feedier
 * Description:       Feedback matters, do it well!
 * Version:           1.2.0
 * Author:            Feedier team
 * Author URI:        https://feedier.com
 * Text Domain:       feedier
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/2Fwebd/feedier-wordpress
 */

/*
 * Plugin constants
 */
if(!defined('FEEDIER_PLUGIN_VERSION'))
	define('FEEDIER_PLUGIN_VERSION', '1.2.0');
if(!defined('FEEDIER_URL'))
	define('FEEDIER_URL', plugin_dir_url( __FILE__ ));
if(!defined('FEEDIER_PATH'))
	define('FEEDIER_PATH', plugin_dir_path( __FILE__ ));
if(!defined('FEEDIER_ENDPOINT'))
	define('FEEDIER_ENDPOINT', 'feedier.com');
if(!defined('FEEDIER_PROTOCOL'))
	define('FEEDIER_PROTOCOL', 'https');

require_once FEEDIER_PATH . 'Feedier/Main.php';
require_once FEEDIER_PATH . 'Feedier/Admin/Engager.php';
require_once FEEDIER_PATH . 'Feedier/Admin/Settings.php';
require_once FEEDIER_PATH . 'Feedier/Admin/WooCommerce.php';
require_once FEEDIER_PATH . 'Feedier/Admin.php';
require_once FEEDIER_PATH . 'Feedier/Engager.php';
require_once FEEDIER_PATH . 'Feedier/WooCommerce.php';

/*
 * Main class
 */
new \Feedier\Admin();
new \Feedier\Engager();
new \Feedier\WooCommerce();


