<?php

// This function enqueues the Normalize.css for use. The first parameter is a name for the stylesheet, the second is the URL. Here we
// use an online version of the css file.
function add_normalize_CSS() {
    wp_enqueue_style( 'normalize-styles', "https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css");
}

function theme_enqueue_styles() {
    // ERegister and charge the style.css//
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//register menus//
function register_my_menus() {
    register_nav_menus( array(
        'menu-principal' => __( 'Menu Principal', 'TextDomain' ),
        'menu-pied-de-page' => __( 'Menu Pied de Page', 'TextDomain' ),
    ) );
}
add_action( 'after_setup_theme', 'register_my_menus' );

//add logo//
function custom_theme_setup() {
    add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

// Js script //

function nathalie_mota_enqueue_scripts() {
    // Enqueue jQuery//
    wp_enqueue_script('jquery');
   // Enqueue custom script//
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/Assets/Js/script.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_scripts');



