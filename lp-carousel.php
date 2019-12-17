<?php
/**
* Plugin Name: Carousel LP
* Plugin URI: https://virson.wordpress.com/
* Description: A wordpress extension plugin to Listing Pro plugin for showing carousel sliders on selected listings. Read more the <a href="https://github.com/ebillov/lp-carousel" target="_blank">guide</a> on how to use this plugin.
* Version: 0.0.1b
* Author: Virson Ebillo
* Author URI: https://virson.wordpress.com/
*/

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Deactivate if WooCommerce Core plugin is not activated
if(function_exists('is_plugin_active')){
	//Check if WooCommerce Core plugin is activated
	if( !is_plugin_active('listingpro-plugin/plugin.php') ){
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die('Error on activating <b>Carousel LP</b> plugin:<br />Please enable/activate <b>ListingPro</b> plugin before using this plugin. <a href="' . admin_url() . '">Go back.</a>');
	}
}

//Define our constants
define('CAROUSEL_LP_DIR_URL', plugin_dir_url( __FILE__ ));

/**
 * Begin printing our scripts
 */
add_action('wp_head', function(){
	
	//Get the current post object
	global $post;
	
	//Detect if the shortcode is placed in the content
	if( has_shortcode( $post->post_content, 'carousel_lp' ) ){
		wp_enqueue_script('jquery');
		wp_enqueue_style(
			'carousel-lp',
			CAROUSEL_LP_DIR_URL . '/includes/slick/slick.css',
			array(),
			'0.0.1b'
        );
		wp_enqueue_style(
			'carousel-lp-theme',
			CAROUSEL_LP_DIR_URL . '/includes/slick/slick-theme.css',
			array(),
			'0.0.1b'
        );
        
	}
	
});

add_action('wp_footer', function(){

	//Get the current post object
	global $post;
	
	//Detect if the shortcode is placed in the content
	if( has_shortcode( $post->post_content, 'carousel_lp' ) ){
        wp_enqueue_script(
            'carousel-lp-script',
            CAROUSEL_LP_DIR_URL . '/includes/slick/slick.min.js',
			array(),
			'0.0.1b'
        );
    }
    
});

//Our shortcode
add_shortcode('carousel_lp', function($atts){

	//Define shortcode attributes (defaults)
    $atts = shortcode_atts( array(
        'listing_ids' => [],
        'plan_ids' => []
    ), $atts );

    //Begin object buffer
    ob_start();

    //Include the default template
    include('includes/front-end-script.php');

    //Get object buffer, clean and return it
    return ob_get_clean();

});