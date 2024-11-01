<?php

/**
 * SpruceJoy Membership Uninstall
 *
 * Removes all settings SpruceJoy Membership added to the WP options table
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
if (!defined('ABSPATH')) {
	exit();
}

// If uninstall is not called from WordPress, kill the uninstall.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die('invalid uninstall');
}

// Uninstall process removes SpruceJoy Membership settings from the WordPress database (_options table).
if (WP_UNINSTALL_PLUGIN) {
	wpsjmembership_uninstall_options();
}

/**
 * Compartmentalizes uninstall
 *
 */
function wpsjmembership_uninstall_options()
{
	delete_option('wpsjmembership_settings');
	delete_option('wpsjmembership_site_id');
	delete_option('wpsjmembership_integration_state');
}

// End of file.