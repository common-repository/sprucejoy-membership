<?php
/*
Plugin Name: SpruceJoy Membership
Plugin URI:  https://sprucejoy.com/resources/cookie-consent-gdpr/
Description: SpruceJoy is the #1 membership app for ad-free experience, content restriction, user registration & login, payments, member directories and more.
Version:     1.0.0
Author:      SpruceJoy
Author URI:  https://sprucejoy.com/
Text Domain: wp-sprucejoy-membership
Domain Path: /i18n/languages/
License:     GPLv2
*/

/*  
	Copyright (c) 2020-2021  SpruceJoy

	The name SpruceJoy Membership(tm) is a trademark of sprucejoy.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	You may also view the license here:
	http://www.gnu.org/licenses/gpl.html
*/

/*
	A NOTE ABOUT LICENSE:

	While this plugin is freely available and open-source under the GPL2
	license, that does not mean it is "public domain." You are free to modify
	and redistribute as long as you comply with the license. Any derivative 
	work MUST be GPL licensed and available as open source.  You also MUST give 
	proper attribution to the original author, copyright holder, and trademark
	owner.  This means you cannot change two lines of code and claim copyright 
	of the entire work as your own.  The GPL2 license requires that if you
	modify this code, you must clearly indicate what section(s) you have
	modified and you may only claim copyright of your modifications and not
	the body of work.  If you are unsure or have questions about how a 
	derivative work you are developing complies with the license, copyright, 
	trademark, or if you do not understand the difference between
	open source and public domain, contact the original author at:
	https://sprucejoy.com/contact/.


	INSTALLATION PROCEDURE:
	
	For complete installation and usage instructions,
	visit https://sprucejoy.com
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

// Initialize constants.
define( 'WPSJRUCEJOY_MEM_VERSION',    '1.0.0' );
define( 'WPSJRUCEJOY_MEM_DB_VERSION', '1.0.0' );
define( 'WPSJRUCEJOY_MEM_SJ_PATH', 'https://dev.sprucejoy.com/' );
define( 'WPSJRUCEJOY_MEM_PATH', plugin_dir_path( __FILE__ ) );

// Initialize the plugin.
add_action( 'after_setup_theme', 'wpsjmembership_init', 10 );

// Install the plugin.
register_activation_hook( __FILE__, 'wpsjmembership_install' );

/**
 * Initialize SpruceJoy Membership.
 *
 * The initialization function contains much of what was previously just
 * loaded in the main plugin file. It has been moved into this function
 * in order to allow action hooks for loading the plugin and initializing
 * its features and options.
 *
 *
 * @global object $wpsj The SpruceJoy Membership object class.
 */
function wpsjmembership_init() {

	// Set the object as global.
	global $wpsjmembership;

	/**
	 * Fires before initialization of plugin options.
	 *
	 */
	do_action( 'wpsjmembership_pre_init' );

	/**
	 * Load the WP_Sprucejoy_Membership class.
	 */
	require_once( 'includes/class-wp-sprucejoy-membership.php' );
	
	// Invoke the WP_Sprucejoy_Membership class.
	$wpsjmembership = new WP_Sprucejoy_Membership();

	/**
	 * Fires after initialization of plugin options.
	 *
	 */
	do_action( 'wpsjmembership_after_init' );

	$options = [
		'wpsjmembership_enable',
		'wpsjmembership_site_id'];

	foreach ($options as $key => $val) {
		$wpsjmembership->{$val} = get_option($val);
	}

	add_action('wp_enqueue_scripts', 'wpsjmembership_init_scripts');
}

function wpsjmembership_init_scripts() {
	global $wpsjmembership;
	?>
    <script>
      window.__SJMEMBERSHIP_SITE_ID__ = "<?php echo $wpsjmembership->wpsjmembership_site_id; ?>";
    </script>
	<?php	
	if($wpsjmembership->wpsjmembership_site_id){
		$script_path = 'https://es.sprucejoy.com/s/'.$wpsjmembership->wpsjmembership_site_id.'.js';
		wp_enqueue_script( 'script', $script_path,'', $wpsjmembership->version);
	}else{
		
	}
}

/**
 * Adds the plugin options page and JavaScript.
 *
 */
function wpsjmembership_admin_options() {
	global $wpsjmembership;
	if ( ! is_multisite() || ( is_multisite() && current_user_can( 'edit_theme_options' ) ) ) {
		$plugin_page = add_options_page ( 'SpruceJoy Membership', 'SpruceJoy Membership', 'manage_options', 'wpsjmembership-settings', 'wpsjmembership_admin' );
	}
}


/**
 * Install the plugin options.
 *
 * @param 
 */
function wpsjmembership_install() {

	/**
	 * Load the install file.
	 */
	require_once( 'includes/install.php' );
	wpsjmembership_do_install();
}

// End of file.