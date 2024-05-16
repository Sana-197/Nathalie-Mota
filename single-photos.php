<?php 
/*
Template Name: Single Photo
Template Post Type: post, page, product
*/
?>

<?php get_header(); ?>

<main class="wrap">
    <section class="content-area content-full-width">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="article-full">
                <section class="bloc-photo-colonnes">
                    <div class="bloc-photo-left-content">
                        <div class="bloc-photo__description colonne">
                            <h1><?php the_title(); ?></h1>

                            <?php 
                            
                            // Récupération du champ ACF référence//
                            $reference = get_field('reference');
                            if ($reference) {
                                echo '<p>RÉFÉRENCE: ' . esc_html($reference) . '</p>';
                            } else {
                                echo '<p>RÉFÉRENCE: Non disponible</p>';
                            }

                            // Récupération des termes pour la catégorie//
                            $categorie = get_the_term_list($post->ID, 'categorie');
                            if (!is_wp_error($categorie)) {
                                echo '<p>CATÉGORIE : ' . strip_tags($categorie) . '</p>';
                            } else {
                                echo '<p>CATÉGORIE : Non disponible</p>';
                            }

                            // Récupération des termes pour le format//
                            $format = get_the_term_list($post->ID, 'format');
                            if (!is_wp_error($format)) {
                                echo '<p>FORMAT : ' . strip_tags($format) . '</p>';
                            } else {
                                echo '<p>FORMAT : Non disponible</p>';
                            }

                            // Récupération du champ ACF type//
                            $type = get_field('type');
                            if ($type) {
                                echo '<p>TYPE : ' . esc_html($type) . '</p>';
                            } else {
                                echo '<p>TYPE : Non disponible</p>';
                            }

                            // Affichage de la date//
                            echo '<p>ANNÉE : ' . get_the_date('Y') . '</p>';
                            ?>
                            
                        </div>
                    </div>
                    <img class="bloc-photo__image colonne" src="<?php the_post_thumbnail_url('large'); ?>">
                </section>
                
            </article>
            <div class="zone-contenu">
                <!-- Section Interaction -->
                <section class="interaction-photo">
                    <div class= "zone-contact">
                        <p class="texte">Cette photo vous intéresse ?</p>
                        <!-- Bouton Contact -->
                        <button type="button" class="single-photo-contact-button" data-reference="<?php echo esc_attr($reference); ?>" data-toggle="modal" data-target="#modal-contact">Contact</button>
                    </div>
                </section>
                <!-- Section Navigation -->
                <section class="navigation-photo">
                    <?php
                    // Récupérer l'ID de la publication actuelle.//
                    $current_post_id = get_the_ID();

                    // Récupérer toutes les publications de type 'photo'.//
                    $args = array(
                        'post_type' => 'photo',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                    );
                    $all_photo_posts = get_posts($args);

                    // Trouver l'index de la publication actuelle dans le tableau de toutes les publications de photos.//
                    $current_post_index = array_search($current_post_id, array_column($all_photo_posts, 'ID'));

                    // Récupérer les publications précédentes et suivantes.//
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();

                    // Récupérer les permaliens des poublications précédentes et suivantes//
                    $prev_permalink = get_permalink($prev_post);
                    $next_permalink = get_permalink($next_post);

                    // Récupérer les miniatures des publications précédentes et suivantes.//
                    $prev_thumbnail = get_the_post_thumbnail_url($prev_post, 'thumbnail');
                    $next_thumbnail = get_the_post_thumbnail_url($next_post, 'thumbnail');
                    ?>

                    <!-- Miniature de la photo actuelle -->
                    <div class="thumbnail-wrapper" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url($current_post_id, 'thumbnail')); ?>');"></div>

                    <!-- Liens de navigation pour les photos précédente et suivante -->
                    <div class="arrows-wrapper">
                        <a href="<?php echo esc_url($prev_permalink); ?>" class="nav-link prev-link" data-thumbnail="<?php echo esc_url($prev_thumbnail); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.png" alt="Précédent" class="arrow arrow-gauche" />
                        </a>
                        <a href="<?php echo esc_url($next_permalink); ?>" class="nav-link next-link" data-thumbnail="<?php echo esc_url($next_thumbnail); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.png" alt="Suivant" class="arrow arrow-droite" />
                        </a>
                    </div>
                </section>
            </div>

            <section class="related-photo">
    <h2>Vous aimerez aussi</h2>
    <div class="related-photo-block">
        <?php
        // Récupère la catégorie de la photo courante affichée sur la page//
        $current_photo_categories = get_the_terms(get_the_ID(), 'categorie');
        $current_category_slugs = array();
        if ($current_photo_categories) {
            foreach ($current_photo_categories as $category) {
                $current_category_slugs[] = $category->slug;
            }
        }

        // Arguments pour la requête WP_Query//
        $args_related_photos = array(
            'post_type' => 'photos',
            'posts_per_page' => 2,
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $current_category_slugs, // Utilise le slug de la catégorie de la photo actuelle//
                ),
            ),
        );

        // Exécuter la requête//
        $related_photos_query = new WP_Query($args_related_photos);

        // Vérifier si des photos sont trouvées//
        if ($related_photos_query->have_posts()) :
            while ($related_photos_query->have_posts()) : $related_photos_query->the_post();
                $categories = get_the_terms(get_the_ID(), 'categorie');
                $category_name = $categories ? $categories[0]->name : '';
        ?>
                <div class="related-photo-img">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        // Afficher la taille grande de l'image//
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        }
                        ?>
                        <div class="photo-overlay">
                            <img class="eye-icon" src="<?php echo get_template_directory_uri(); ?>/Assets/Images/Icon_eye.png" alt="eye icon">
                            <img class="fullscreen-icon" src="<?php echo get_template_directory_uri(); ?>/Assets/Images/Icon_fullscreen.png" alt="fullscreen icon">
                            <div class="photo-information">
                                <div class="photo-info-left">
                                    <p><?php the_field('reference'); ?></p>
                                </div>
                                <div class="photo-info-right">
                                    <p><?php echo $category_name; ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php
            endwhile;
            // Réinitialiser la requête//
            wp_reset_postdata();
        else :
            // Si aucune photo n'est trouvée//
        ?>
            <div class="related-photo">
                <p>Désolé, aucun article trouvé!</p>
            </div>
        <?php endif; ?>
    </div>
</section>


        <?php endwhile; else : ?>
            <article>
                <p>Désolé, aucun article trouvé!</p>
            </article>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
