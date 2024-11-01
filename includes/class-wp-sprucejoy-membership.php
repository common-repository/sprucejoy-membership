<?php
/**
 * The WP_Sprucejoy_Membership Class.
 *
 * This is the main WP_Sprucejoy_Membership object class. This class contains functions
 * for loading settings, shortcodes, hooks to WP, plugin dropins, constants,
 * and registration fields. It also manages whether content should be blocked.
 *
 * @package SpruceJoy Membership
 * @subpackage WP_Sprucejoy_Membership Object Class
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class WP_Sprucejoy_Membership {
	
	/**
	 * Plugin version.
	 *
	 * @access public
	 * @var    string
	 */
	public $version = WPSJRUCEJOY_MEM_VERSION;
	
	/**
	 * Database version
	 *
	 * @access public
	 * @var    string
	 */
	public $db_version = WPSJRUCEJOY_MEM_DB_VERSION;
	
	/**
	 * Plugin path.
	 *
	 * @access public
	 * @var    string
	 */
	public $path;
	
	/**
	 * Plugin __FILE__.
	 *
	 * @access public
	 * @var    string
	 */
	public $name;
	
	/**
	 * Plugin slug.
	 *
	 * @access public
	 * @var    string
	 */
	public $slug;
	
	/**
	 * Plugin URL.
	 *
	 * @access public
	 * @var    string
	 */
	public $url;
	
		
	/**
	 * Plugin initialization function.
	 */
	function __construct() {
		
		// Constants.
		$this->path = plugin_dir_path( __DIR__ );
		$this->name = $this->path . 'wp-sprucejoy-membership-membership.php';
		$this->slug = substr( basename( $this->name ), 0, -4 );
		$this->url  = plugin_dir_url ( __DIR__ );

		$this->load_dependencies();
		$this->load_hooks();
	}
	
	/**
	 * Plugin initialization function to load hooks.
	 */
	function load_hooks() {
		add_action( 'admin_init',            array( $this, 'load_admin'  ) ); // check user role to load correct dashboard
		add_action( 'admin_menu',            'wpsjmembership_admin_options' ); // adds admin menu
	}

	/**
	 * Load dependent files.
	 */
	function load_dependencies() {
		require_once( $this->path . 'includes/api/api.php' );
	}

	/**
	 * Load admin API and dependencies.
	 *
	 * Determines which scripts to load and actions to use based on the 
	 * current users capabilities.
	 */
	function load_admin() {

		/**
		 * Fires before initialization of admin options.
		 *
		 */
		do_action( 'wpsjmembership_pre_admin_init' );

		/**
		 * Load the admin api class.
		 *
		 */	
		include_once( $this->path . 'includes/admin/class-wp-sprucejoy-membership-admin-api.php' );
		$this->admin = new WP_Sprucejoy_Membership_Admin_API;

		/**
		 * Fires after initialization of admin options.
		 *
		 */
		do_action( 'wpsjmembership_after_admin_init' );
	}
	
} // End of WP_Sprucejoy_Membership class.