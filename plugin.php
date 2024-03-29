<?php
/*
Plugin Name: M4H
Plugin URI: http://moveforhunger.org
Description: Directory management for Move For Hunger
Version: 1.0
Author: Brian Trinh
Author URI: http://briantrinh.com
Author Email: btrinh3612@gmail.com
License:

  Copyright 2012 Brian Trinh (btrinh3612@gmail.com)

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
  
*/

class M4H {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
    $this->init_plugin_const(); 

		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
   
	
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );
		
    add_action( 'admin_menu', array( $this, 'm4h_admin_menu') );
    add_shortcode( 'm4h-search', 'm4h_members_search' );
    //add_shortcode( 'm4h-search', array( $this, 'm4h_members_search' ) );
	} // end constructor
	
  private function init_plugin_const() {
    if( !defined('PLUGIN_NAME') ) {
      define('PLUGIN_NAME', 'm4h'); 
    }
    if( !defined('PLUGIN_SLUG') ) {
      define('PLUGIN_SLUG', 'm4h');    
    }
  }

  function m4h_admin_menu() {
    if( function_exists('add_menu_page') ){
      add_menu_page( 'M4H Directory', 'M4H Directory', 'administrator', 'm4h-admin', 'm4h_view_add_user' );
    }
  }

  /*
  function m4h_members_search() {

  }
  */

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
    require_once ABSPATH.'wp-admin/includes/upgrade.php';
    global $wpdb;
    $sql = '
      CREATE TABLE IF NOT EXISTS '. $wpdb->prefix .'m4h (
        id int(11) NOT NULL auto_increment,
        fname varchar(50) NOT NULL,
        lname varchar(100) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(20) NOT NULL,
        website varchar(255) DEFAULT NULL,
        address1 varchar(255) NOT NULL,
        address2 varchar(255) DEFAULT NULL,
        city varchar(100) NOT NULL,
        state varchar(5) NOT NULL,
        zip varchar(20) NOT NULL,
        lat DECIMAL(10,10) NOT NULL,
        lng DECIMAL(10,10) NOT NULL,
        PRIMARY KEY (id)
      )';
    dbDelta($sql);


	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS $wpdb->prefix"."m4h");
	} // end deactivate
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function uninstall( $network_wide ) {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS $wpdb->prefix"."m4h");
	} // end uninstall

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
	
		// TODO: replace "plugin-name-locale" with a unique value for your plugin
		load_plugin_textdomain( 'plugin-name-locale', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		wp_enqueue_style( PLUGIN_NAME . '-admin-styles', plugins_url( PLUGIN_NAME . '/css/admin.css' ) );
    //wp_enqueue_style( PLUGIN_NAME . '-bootstrap', plugins_url( PLUGIN_NAME . '/css/bootstrap.min.css' ) );	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
		wp_enqueue_script( PLUGIN_NAME . '-admin-script', plugins_url( PLUGIN_NAME . '/js/admin.js' ) );
		wp_enqueue_script( PLUGIN_NAME . '-jquery', plugins_url( PLUGIN_NAME . '/js/jquery-1.8.3.min.js' ) );
		wp_enqueue_script( PLUGIN_NAME . '-bootstrap', plugins_url( PLUGIN_NAME . '/js/bootstrap.min.js' ) );
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
		wp_enqueue_style( PLUGIN_NAME . '-plugin-styles', plugins_url( PLUGIN_NAME . '/css/display.css' ) );
    //wp_enqueue_style( PLUGIN_NAME . '-bootstrap', plugins_url( PLUGIN_NAME . '/css/bootstrap.min.css' ) );	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
		wp_enqueue_script( PLUGIN_NAME . '-jquery', plugins_url( PLUGIN_NAME . '/js/jquery-1.8.3.min.js' ) );
		//wp_enqueue_script( PLUGIN_NAME . '-plugin-script', plugins_url( PLUGIN_NAME . '/js/display.js' ) );
		wp_enqueue_script( PLUGIN_NAME . '-bootstrap', plugins_url( PLUGIN_NAME . '/js/bootstrap.min.js' ) );
	} // end register_plugin_scripts
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**
 	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *		  WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *		  Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 */
	function action_method_name() {
    	// TODO:	Define your action method here
	} // end action_method_name
	
	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *		  WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *		  Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 */
	function filter_method_name() {
	    // TODO:	Define your filter method here
	} // end filter_method_name
  
} // end class

// include views
include_once(WP_PLUGIN_DIR . '/m4h/views/admin.php');
include_once(WP_PLUGIN_DIR . '/m4h/views/display.php');

// include controllers
include_once(WP_PLUGIN_DIR . '/m4h/controllers/admin.php');
include_once(WP_PLUGIN_DIR . '/m4h/controllers/display.php');

$plugin_name = new M4H();
