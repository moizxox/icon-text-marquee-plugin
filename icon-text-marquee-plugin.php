<?php
/*
Plugin Name: Icon Text Marquee for Elementor
Description: A custom Elementor widget to display a marquee of icons and text.
Version: 1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function enqueue_icon_text_marquee_styles() {
    wp_enqueue_style( 'icon-text-marquee-style', plugins_url( '/icon-text-marquee-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_icon_text_marquee_styles' );

function register_icon_text_marquee_widget( $widgets_manager ) {
    require_once( __DIR__ . '/icon-text-marquee-widget.php' );
    $widgets_manager->register( new \Elementor\Icon_Text_Marquee_Widget() ); // Add \Elementor\
}

add_action( 'elementor/widgets/register', 'register_icon_text_marquee_widget' );
