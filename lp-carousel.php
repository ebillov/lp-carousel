<?php
/**
* Plugin Name: Carousel LP
* Plugin URI: https://virson.wordpress.com/
* Description: A wordpress extension plugin to Listing Pro plugin for showing carousel sliders on selected listings. Read the <a href="https://github.com/ebillov/lp-carousel">guide</a> on how to use this plugin.
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

//Our shortcode
add_shortcode('carousel_lp', function($atts){

    //Define defaults
    $listing_ids = [];
    $plan_ids = [];

	//Define shortcode attributes (defaults)
    $atts = shortcode_atts( array(
        'listing_ids' => $listing_ids,
        'plan_ids' => $plan_ids
    ), $atts );

    //Get the attributes
    $listing_ids = (!empty($atts['listing_ids'])) ? explode(',', $atts['listing_ids']) : $listing_ids;
    $plan_ids = (!empty($atts['plan_ids'])) ? explode(',', $atts['plan_ids']) : $plan_ids;
	
	//Define invalid characters
	$invalid_chars_attr = array( "@", "/", "!", "=", "+", "$", "%", "^", "&", "(", ")", ".", "#", "*", ":", ";", "'", '"', "|", "?", "{", "}", "[", "]", "`", "~", "<", ">", " " );
	
	//Replace invalid characters
	$listing_ids = str_replace( $invalid_chars_attr, array(), $listing_ids );
    $plan_ids = str_replace( $invalid_chars_attr, array(), $plan_ids );

    //Begin get posts
    $args = array(
        'numberposts' => -1,
        'orderby' => 'date',
        'order' => 'rand',
        'post_type' => 'listing',
        'include' => $listing_ids,
        'post_status' => 'publish',
        'suppress_filters' => true,
    );

    //Get all the posts by the args
    $listings = get_posts($args);

    //Do this to filter the listings by plan ids
    if(!empty($plan_ids)){

        //Container for our posts
        $filtered_ids = [];

        //Loop through each listing
        foreach($listings as $listing){

            //Get the custom meta field
            $custom_field = get_post_meta($listing->ID, 'lp_listingpro_options', true);

            //Only get the posts with Plan_id values
            if(!empty($custom_field['Plan_id'])){

                //Check if the plan id is within the defined array
                if(in_array($custom_field['Plan_id'], $plan_ids)){
                    $filtered_ids[] = $listing;
                }

            }

        }

        //Redefine it
        $listings = $filtered_ids;

    }

    //Check if it was empty
    if(empty($listings)){
        return '<p>No listings found.</p>';
    }

    //Begin object buffer
    ob_start();

    //Include the default template
    include('templates/default.php');

    //Get object buffer, clean and return it
    return ob_get_clean();

});