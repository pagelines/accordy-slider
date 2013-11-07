<?php
/*
	Plugin Name: Accordy Slider
	Demo: http://accordy.ahansson.com
	Description: Accordy Slider is a fully responsive slider that supports up to 10 slides with your custom content or images.
	Version: 1.9.1
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	v3: true
*/
class ah_AccordySlider_Plugin {

	function __construct() {
		add_action( 'init', array( &$this, 'ah_updater_init' ) );
	}

	function ah_updater_init() {

		require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

		$config = array(
			'base'      => plugin_basename( __FILE__ ), 
			'repo_uri'  => 'http://shop.ahansson.com',  
			'repo_slug' => 'accordy-slider',
		);

		new AH_AccordySlider_Plugin_Updater( $config );
	}

}

new ah_AccordySlider_Plugin; 