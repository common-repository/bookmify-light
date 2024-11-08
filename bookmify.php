<?php
/**
 * Plugin Name: Bookmify Light
 * Plugin URI:  https://codecanyon.net/item/bookmify-appointment-booking-wordpress-plugin/23837899
 * Description: Online reservation and availability checking service for your site.
 * Version:     1.0.5
 * Author:      Frenify
 * Author URI:  https://codecanyon.net/user/frenify/portfolio
 * Text Domain: bookmify
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages/
 */

// Exit if accessed directly. 
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'BOOKMIFY_VERSION', '1.0.5' );
define( 'BOOKMIFY_MENU', 'bookmify' );

define( 'BOOKMIFY__FILE__', __FILE__ );
define( 'BOOKMIFY_PLUGIN_BASE', plugin_basename( BOOKMIFY__FILE__ ) );
define( 'BOOKMIFY_PATH', plugin_dir_path( BOOKMIFY__FILE__ ) );
define( 'BOOKMIFY_URL', plugins_url( '/', BOOKMIFY__FILE__ ) );
define( 'BOOKMIFY_ASSETS_URL', BOOKMIFY_URL . 'backend/assets/' );
define( 'BOOKMIFY_FE_ASSETS_URL', BOOKMIFY_URL . 'frontend/assets/' );
define( 'BOOKMIFY_CRON_URL', BOOKMIFY_URL . 'backend/inc/cron-note.php' );
define( 'BOOKMIFY_CALENDAR_ASSETS_URL', BOOKMIFY_URL . 'backend/inc/calendar/assets/' );
define( 'BOOKMIFY_SITE_URL', get_site_url());

function bookmifyTranslation(){
	load_plugin_textdomain('bookmify', false, plugin_basename(__DIR__) . '/languages/');
}



// Test PHP Version and Load Plugin
if ( version_compare( PHP_VERSION, '5.3.7', '<' ) ) 
{
	
    function bookmify_fn_fail_php_version()
    {
        echo '<div class="updated"><h3>Bookmify</h3><p>To install the plugin - <strong>PHP 5.3.7</strong> or higher is required.</p></div>';
    }
    add_action( is_network_admin() ? 'network_admin_notices' : 'admin_notices', 'bookmify_fn_fail_php_version' );
	
} 
else
{
	
	add_action('plugins_loaded', 'bookmifyTranslation');
	
	include_once ( BOOKMIFY_PATH . 'backend/inc/tables.php' );
	register_activation_hook( BOOKMIFY__FILE__, array('Bookmify\DatabaseTables', 'add_tables') );
	

	include_once ( BOOKMIFY_PATH . 'inc/plugin.php' );
	
}