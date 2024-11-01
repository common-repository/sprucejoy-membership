<?php
/**
 * SpruceJoy Membership Admin API Functions
 * 
 * This file is part of the SpruceJoy Membership plugin by SpruceJoy
 * You can find out more about this plugin at https://sprucejoy.com
 * Copyright (c) 2020-2021  SpruceJoy
 * SpruceJoy Membership(tm) is a trademark of sprucejoy.com
 *
 * @package SpruceJoy Membership
 * @author SpruceJoy
 * @copyright 2020-2021
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}


/**
 * Wrapper for form_post_url().
 *
 * @global object $wpsj The WP_Sprucejoy_Membership Object.
 * @param  string $tab   The plugin tab being displayed.
 * @param  mixed  $args  Array of additional arguments|boolean. Default: false.
 * @return string $url
 */
function wpsjmembership_admin_form_post_url( $args = false ) {
	global $wpsjmembership;
	return $wpsjmembership->admin->form_post_url( $args );
}
