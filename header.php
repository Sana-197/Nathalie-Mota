<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="my-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
           <?php if ( function_exists( 'the_custom_logo' ) ) {
               the_custom_logo();
           } else { ?>
               <h1><?php bloginfo('name'); ?></h1>
           <?php } ?>
        </a>
        
        <!-- Menu burger -->
             <div class="menu-mobile-burger" id="menu-burger-fullscreen">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <?php 
            wp_nav_menu( array( 
                'theme_location' => 'menu-principal', 
                'container' => false, 
                'menu_class' => 'menu', 
                'menu_id' => 'menu-principal-mobile', 
            ) ); 
        ?>
         
    </header>
</body>
</html>
