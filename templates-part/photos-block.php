<section class="related-photo-accueil">
    <div class="related-photo-block-accueil">
        <?php
        // Arguments pour la requête WP_Query//
        $args_related_photos = array(
            'post_type' => 'photos',
            'posts_per_page' => 8, 
            'orderby' => 'rand',
        );

        // Exécuter la requête//
        $related_photos_query = new WP_Query($args_related_photos);

        // Vérifier si des photos sont trouvées//
        if ($related_photos_query->have_posts()) :
            while ($related_photos_query->have_posts()) : $related_photos_query->the_post();
                $categories = get_the_terms(get_the_ID(), 'categorie');
                $category_name = $categories ? $categories[0]->name : '';
        ?>
                <div class="related-photo-img-accueil">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        // Afficher la taille grande de l'image//
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        }
                        ?>
                        <div class="photo-overlay">
                            <img class="eye-icon" src="<?php echo get_template_directory_uri(); ?>/Assets/Images/Icon_eye.png" alt="eye icon">
                            <a href="#" class="fullscreen-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/Assets/Images/Icon_fullscreen.png" alt="fullscreen icon">
                            </a>
                            <div class="photo-information">
                                <div class="photo-info-left">
                                    <p><?php echo get_the_title(); ?></p>
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
