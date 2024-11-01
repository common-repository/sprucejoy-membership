<?php

/**
 * SpruceJoy Membership Admin functions
 *
 * Static functions to manage the plugin options tab.
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

class WP_Sprucejoy_Membership_Admin_Tab_Options
{

	/**
	 * Creates the tab.
	 *
	 */
	static function do_tab($tab)
	{
		if ($tab == 'options' || !$tab) {
			// Render the about tab.
			return self::build_settings();
		} else {
			return false;
		}
	}

	/**
	 * Builds the settings panel.
	 *
	 */
	static function build_settings()
	{

		global $wpsjmembership;
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');


		$options = [
			'wpsjmembership_site_id',
			'wpsjmembership_integration_state',
		];

		foreach ($options as $key => $val) {
			$wpsjmembership->{$val} = get_option($val);
		}
?>
		<div class="metabox-holder has-right-sidebar">

			<div class="inner-sidebar">
				<?php wpsjmembership_a_meta_box(); ?>

			</div> <!-- .inner-sidebar -->

			<div id="post-body">
				<div id="post-body-content">
					<div class="postbox" style="padding:10px;background-color: #EFEFEF;">
						<div class="title">SpruceJoy Membership</div>
						<div class="inside" style="font-size: 16px;letter-spacing: -0.408px;">
							<form name="updatesettings" id="updatesettings" method="post" action="<?php echo wpsjmembership_admin_form_post_url(); ?>">
								<div style="padding-top:10px;">
									<?php
									if ($wpsjmembership->wpsjmembership_integration_state==1) {
									?>
										<div style="color:#37A000"><span style="font-size:28px;line-height: 13px;padding-right:8px;">●</span> <span>Integration Active.</span></div>
									<?php } else { ?>
										<div style="color:red"><span style="font-size:28px;line-height: 13px;padding-right:8px;">●</span> <span>Integration Failed.</span></div>
									<?php } ?>
								</div>
								<div style="border: 1px solid #A1A1A1;padding: 8px;margin: 12px 0px;">
								You'll need a SpruceJoy account.
								</br></br>
								
								<a target="_blank" href="https://sprucejoy.com">Register for a free SpruceJoy account</a> and start selling your membership.
								</div>

							
								<ul>
									<li><label>Site ID</label>
										<span><input name="wpsjmembership_site_id" type="text" size="20" value="<?php echo  $wpsjmembership->wpsjmembership_site_id ? $wpsjmembership->wpsjmembership_site_id : '' ?>" placeholder="Enter Site ID" /></span>
									</li>
								</ul>
								<ul>
									<input type="hidden" name="wpsjmembership_admin_a" value="update_settings">
									<?php submit_button(__('Update Settings', 'wp-sprucejoy-membership')); ?>
								</ul>
							</form>
						</div><!-- .inside -->
					</div>
				</div><!-- #post-body-content -->
			</div><!-- #post-body -->
		</div><!-- .metabox-holder -->

<?php
	}

	/**
	 * Updates the plugin options.
	 *
	 */
	static function update($action)
	{
		global $wpsjmembership;
		// ( isset( $_POST['wpsjmembership_enable'] ) ) ? sanitize_text_field( $_POST[ 'wpsjmembership_enable' ] ) : '';
		update_option('wpsjmembership_site_id', ( isset( $_POST['wpsjmembership_site_id'] ) ) ? sanitize_text_field( $_POST[ 'wpsjmembership_site_id' ] ) : '');
		$url = WPSJRUCEJOY_MEM_SJ_PATH . "api/site/check-script?id=".sanitize_text_field( $_POST[ 'wpsjmembership_site_id' ] );
		$request  = wp_remote_get( $url );
		$response = wp_remote_retrieve_body( $request );
		if($response == "1"){
			update_option('wpsjmembership_integration_state', 1);
		}else{
			update_option('wpsjmembership_integration_state', 0);
		}
		// dd($url);
		return __('SpruceJoy Membership settings were updated', 'wp-sprucejoy-membership');
	}

} // End of file.