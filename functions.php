<?php

// This function enqueues the Normalize.css for use. The first parameter is a name for the stylesheet, the second is the URL. Here we
// use an online version of the css file.
function add_normalize_CSS() {
    wp_enqueue_style( 'normalize-styles', "https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css");
}

//register menus//
function register_my_menus() {
    register_nav_menus( array(
        'menu-principal' => __( 'Menu Principal', 'TextDomain' ),
        'menu-pied-de-page' => __( 'Menu Pied de Page', 'TextDomain' ),
    ) );
}
add_action( 'after_setup_theme', 'register_my_menus' );
