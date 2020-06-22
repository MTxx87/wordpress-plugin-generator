<?php
/**
 * Plugin Name: Blank Plugin
 * Plugin URI: *Plugin URI*
 * Description: //[[DESCRIPTION]]//
 * Version: 0.0.1
 * Author: *Plugin Author*
 * Text Domain: blank-plugin
 * Domain Path: /languages
 * Author URI:  *Plugin Author URI*
 * License: GPL2
 */

//If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}

//[[UPDATER]]//

class Blank_Plugin {

  static $assets_folder;
  static $templates_folder;
  static $includes_folder;

  static $settings;

  private static $instance;

  public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

  function __construct() {

     self::$assets_folder = plugin_dir_url( __FILE__ ) . "assets" ;
     self::$templates_folder =  plugin_dir_path( __FILE__ ) . "templates";
     self::$includes_folder =  plugin_dir_path( __FILE__ ) . "includes";

     require_once('includes/blank-plugin-settings.php');
     $setting_instance = new  Blank_Plugin_Settings();
     self::$settings = $setting_instance->get_blank_plugin_options();

     add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

  }

  public function enqueue_scripts() {

    wp_register_script('blankplugin-js', self::$assets_folder . '/js/blankplugin.main.js', array('jquery'), null, true);
    wp_register_style('blankplugin-css', self::$assets_folder . '/css/blankplugin.main.css', array(), false, 'all');

    if (wp_script_is('blankplugin-js','registered')) {
       wp_enqueue_script('blankplugin-js');
     }

     if (wp_style_is('blankplugin-css','registered')) {
       wp_enqueue_style('blankplugin-css');
     }

  }

}

function blank_plugin_init () {
  Blank_Plugin::get_instance();
}

add_action("plugins_loaded", "blank_plugin_init");

function blank_plugin_load_textdomain() {
    $plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages'; /* Relative to WP_PLUGIN_DIR */
    load_plugin_textdomain( 'blank-plugin', false, $plugin_rel_path );
}
add_action('plugins_loaded', 'blank_plugin_load_textdomain');


?>
