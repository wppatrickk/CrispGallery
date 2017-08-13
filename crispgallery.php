<?php
/**
 * Plugin Name: Crisp Gallery
 * Description: Free responsive WordPress gallery plugin where you can display images in a grid layout.
 * Plugin URI: https://www.crispthemes.com/crispgallery-free-responsive-wordpress-gallery-plugin/
 * Author: Crisp Themes
 * Author URI: https://www.crispthemes.com/
 * Version: 1.0
 * Text Domain: crispgallery
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 3, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Get some constants ready for paths when your plugin grows 
 * 
 */

define( 'CRISPGALLERY_VERSION', '1.0' );
define( 'CRISPGALLERY_PATH', dirname( __FILE__ ) );
define( 'CRISPGALLERY_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'CRISPGALLERY_FOLDER', basename( CRISPGALLERY_PATH ) );
define( 'CRISPGALLERY_URL', plugins_url() . '/' . CRISPGALLERY_FOLDER );
define( 'CRISPGALLERY_URL_INCLUDES', CRISPGALLERY_URL . '/inc' );


/**
 * 
 * The plugin base class - the root of all WP goods!
 * 
 * @author nofearinc
 *
 */
class Crispgallery_Plugin_Base {
	
	/**
	 * 
	 * Assign everything as a call from within the constructor
	 */
	public function __construct() {
		// add scripts and styles only available for frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'crispgallery_add_CSS' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'crispgallery_add_JS' ) );
		
		// add scripts and styles only available in admin
		add_action( 'admin_enqueue_scripts', array( $this, 'crispgallery_add_admin_JS' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'crispgallery_add_admin_CSS' ) );
		
		// Register init
		add_action( 'init', array( $this, 'crispgallery_post_type' ), 5 );
		add_action( 'init', array( $this, 'crispgallery_metabox' ), 6 );
		add_action( 'init', array( $this, 'crispgallery_short_metabox' ), 7 );
		
		// Register activation and deactivation hooks
		register_activation_hook( __FILE__, 'crispgallery_on_activate_callback' );
		register_deactivation_hook( __FILE__, 'crispgallery_on_deactivate_callback' );
		
		// Translation-ready
		add_action( 'plugins_loaded', array( $this, 'crispgallery_add_textdomain' ) );

		// Add the shortcode
		add_action( 'init', array( $this, 'crispgallery_shortcode' ) );
	}

	/**
	 * 
	 * Add JS Scripts
	 * 
	 */
	public function crispgallery_add_JS() {
		wp_register_script( 'crispgallery-lightbox', plugins_url( '/js/lightbox.min.js' , __FILE__ ), array('jquery'), '2.9.0', true );
		wp_register_script( 'crispgallery-script', plugins_url( '/js/crispgallery-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
	}
	
	/**
	 *
	 * Adding JavaScript scripts for the admin pages only
	 *
	 * Loading existing scripts from wp-includes or adding custom ones
	 *
	 */
	public function crispgallery_add_admin_JS( $hook ) {
		$screen = get_current_screen();
	    if ( $screen->post_type == 'crispgallery' ) {
	    	wp_enqueue_script( 'jquery' );
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('iris');
			wp_enqueue_media();
			wp_register_script( 'crispgallery-admin-script', plugins_url( '/js/admin/crispgallery-admin-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
			wp_enqueue_script('crispgallery-admin-script');
		}
	}
	
	/**
	 * 
	 * Add CSS styles
	 * 
	 */
	public function crispgallery_add_CSS() {
		wp_register_style( 'crispgallery-lightbox', plugins_url( '/css/lightbox.min.css', __FILE__ ), array(), '2.9.0', 'screen' );
		wp_register_style( 'crispgallery-style', plugins_url( '/css/crispgallery-style.css', __FILE__ ), array(), '1.0.0', 'screen' );
	}
	
	/**
	 *
	 * Add admin CSS styles - available only on admin
	 *
	 */
	public function crispgallery_add_admin_CSS( $hook ) {
		$screen = get_current_screen();
	    if ( $screen->post_type == 'crispgallery' ) {
	    	wp_register_style( 'crispgallery-style-admin', plugins_url( '/css/admin/crispgallery-style-admin.css', __FILE__ ), array(), '1.0', 'screen' );
			wp_enqueue_style( 'crispgallery-style-admin' );
		}
	}

	/**
	 * Register Grid CPT
     *
	 */
	public function crispgallery_post_type() {
		register_post_type( 'crispgallery', array(
			'labels' => array(
				'name' => __("Gallery", 'crispgallery'),
				'singular_name' => __("Gallery", 'crispgallery'),
				'add_new' => _x("Add New", 'crispgallery', 'crispgallery' ),
				'add_new_item' => __("Add New Gallery", 'crispgallery' ),
				'edit_item' => __("Edit Gallery", 'crispgallery' ),
				'new_item' => __("New Gallery", 'crispgallery' ),
				'view_item' => __("View Gallery", 'crispgallery' ),
				'search_items' => __("Search Gallery", 'crispgallery' ),
				'not_found' =>  __("No gallery found", 'crispgallery' ),
				'not_found_in_trash' => __("No gallery found in Trash", 'crispgallery' ),
			),
			'public' => false,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'has_archive' => false,
			'show_in_menu' => true,
			'menu_position' => 25,
			'supports' => array(
				'title'
			)
		));	
	}
	
	/**
	 * 
	 *  Gallery Shortcode Metabox
	 *   
	 */
	public function crispgallery_short_metabox() {
		include_once CRISPGALLERY_PATH_INCLUDES . '/crispgallery-metabox.php';
	}

	/**
	 * 
	 *  Gallery Images Metabox
	 *   
	 */
	public function crispgallery_metabox() {
		include_once CRISPGALLERY_PATH_INCLUDES . '/gallery.php';
	}
	
	
	/**
	 * Register the shortcode for slider
	 * 
	 */
	public function crispgallery_shortcode() {
		include_once CRISPGALLERY_PATH_INCLUDES . '/crispgallery-shortcode.php';
	}
	
	/**
	 * Add textdomain for plugin
	 */
	public function crispgallery_add_textdomain() {
		load_plugin_textdomain( 'crispgallery', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}	
}


/**
 * Register activation hook
 *
 */
function crispgallery_on_activate_callback() {
	// do something on activation
}

/**
 * Register deactivation hook
 *
 */
function crispgallery_on_deactivate_callback() {
	// do something when deactivated
}

// Initialize everything
$crispgallery_plugin_base = new Crispgallery_Plugin_Base();
