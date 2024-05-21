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

// Ajout du support des images mises en avant//
add_theme_support('post-thumbnails');

//lightbox script// 

function enqueue_lightbox_script() {
    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/Assets/Js/lightbox.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_script');



// Js/ ajax script//
function my_enqueue_scripts() {
    wp_enqueue_script('jquery');
    // Enqueue custom script
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/Assets/Js/script.js', array('jquery'), null, true);
    // Localize the AJAX URL for use in script.js
    wp_localize_script('custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');


// Fonction pour charger les huit photos supplémentaires quand on clique sur le bouton charger plus
function load_more_photos() {
    $paged = $_POST['page']; // Récupérer le numéro de la page à partir de la requête AJAX
    $args = array(
        'post_type'      => 'photos', 
        'posts_per_page' => 8, 
        'orderby'        => 'date', 
        'order'          => 'DESC', 
        'paged'          => $paged, 
    );

    // Exécuter la requête//
    $query = new WP_Query($args);

    // Vérifier si des photos sont trouvées//
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        // Afficher la photo avec le contenu supplémentaire
        echo '<div class="related-photo-img-accueil">';
        echo '<a href="' . get_permalink() . '">';

        // Ajouter la classe photo-overlay//
        echo '<div class="photo-overlay">';
        echo '<img class="fullscreen-icon" src="' . get_template_directory_uri() . '/Assets/Images/Icon_fullscreen.png" alt="fullscreen icon">';
        echo '<img class="eye-icon" src="' . get_template_directory_uri() . '/Assets/Images/Icon_eye.png" alt="eye icon">';
        echo '</div>'; // Fermeture de photo-overlay//

        // Afficher la photo//
        if (has_post_thumbnail()) {
            the_post_thumbnail('large');
        }
        
        // Fermer la balise a//
        echo '</a>';

        // Afficher la div pour les informations supplémentaires//
        echo '<div class="photo-information">';
        echo '<div class="photo-info-left">';
        echo '<p>' . get_the_title() . '</p>'; // Afficher le titre de la photo//
        echo '</div>'; // Fermeture de photo-info-left//
        
        // Récupérer les termes de la taxonomie "categorie"//
        $categories = get_the_terms(get_the_ID(), 'categorie');
        if ($categories && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                echo '<div class="photo-info-right">';
                echo '<p>' . $category->name . '</p>'; // Afficher le nom de la catégorie de la photo//
                echo '</div>'; // Fermeture de photo-info-right//
            }
        }
        
        echo '</div>'; // Fermeture de photo-information//
        
        echo '</div>'; // Fermeture de related-photo-img-accueil//

    endwhile;
endif;


    
      wp_die(); // Arrêter l'exécution du script après avoir renvoyé les données//
}

// Ajouter une action pour gérer la requête AJAX//
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos'); // Pour les utilisateurs non connectés//



//FONCTION FILTRES PAGE D ACCUEIL//

function filter_photos() {
    $paged = $_POST['page'];
    $args = array(
        'post_type'      => 'photos',
        'posts_per_page' => 8,
        'paged'          => $paged,
    );

    if (!empty($_POST['categorie'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $_POST['categorie'],
        );
    }

    if (!empty($_POST['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $_POST['format'],
        );
    }

    if (!empty($_POST['tri'])) {
        if ($_POST['tri'] == 'recentes') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ($_POST['tri'] == 'anciennes') {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // le même code HTML que pour charger les photos se trouvant sur la page d'accueil //
            echo '<div class="related-photo-img-accueil">';
            echo '<a href="' . get_permalink() . '">';
            echo '<div class="photo-overlay">';
            echo '<img class="fullscreen-icon" src="' . get_template_directory_uri() . '/Assets/Images/Icon_fullscreen.png" alt="fullscreen icon">';
            echo '<img class="eye-icon" src="' . get_template_directory_uri() . '/Assets/Images/Icon_eye.png" alt="eye icon">';
            echo '</div>';
            if (has_post_thumbnail()) {
                the_post_thumbnail('large');
            }
            echo '</a>';
            echo '<div class="photo-information">';
            echo '<div class="photo-info-left">';
            echo '<p>' . get_the_title() . '</p>';
            echo '</div>';
            $categories = get_the_terms(get_the_ID(), 'categorie');
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    echo '<div class="photo-info-right">';
                    echo '<p>' . $category->name . '</p>';
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '</div>';
        endwhile;
    endif;

    wp_die();
}

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
