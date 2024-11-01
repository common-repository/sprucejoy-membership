<?php
/**
 * SpruceJoy Membership Installation Functions
 *
 * Functions to install and upgrade SpruceJoy Membership.
 * 
 * This file is part of the SpruceJoy Membership plugin by SpruceJoy
 * You can find out more about this plugin at https://sprucejoy.com
 * Copyright (c) 2020-2021  SpruceJoy
 * SpruceJoy Membership(tm) is a trademark of sprucejoy.com
 *
 * @package SpruceJoy Membership
 * @author SpruceJoy
 * @copyright 2020-2021
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Installs or upgrades the plugin.
 *
 *
 * @return array $wpsjmembership_settings
 */
function wpsjmembership_do_install() {

	/*
	 * If you need to force an install, set $chk_force = true.
	 *
	 * Important notes:
	 *
	 * 1. This will override any settings you already have for any of the plugin settings.
	 * 2. This will not effect any WP settings or registered users.
	 */

	$chk_force = false;

	$existing_settings = get_option( 'wpsjmembership_settings' );
	
	if ( false === $existing_settings || $chk_force == true ) {
		// New install.
		update_option('wpsjmembership_settings', 1 );
		update_option('wpsjmembership_site_id', '');
		update_option('wpsjmembership_integration_state', 0);
	} 
}


// End of file.