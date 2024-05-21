<?php
/*
Template Name: Page d'accueil personnalisée pour le site de Nathalie Mota
Author: Sana-197
*/
?>

<?php get_header(); ?>

<main class="wrap">
    <!-- Section du héros -->
    <section class="hero">
        <!-- Chemin de l'image pour PC et tablettes et mobile -->
        <div class="titre-image-hero">
            <img class="hero-title-pc" src="<?php echo get_template_directory_uri(); ?>/assets/images/titre-accueil.png" alt="Image du héros pour PC et tablettes">
            <img class="hero-title-mobile" src="<?php echo get_template_directory_uri(); ?>/assets/images/titre-accueil-mobile.png" alt="Image du héros pour mobile">
        </div>

        <!-- Image du héros chargée aléatoirement depuis le catalogue -->
        <?php
        $random_image = new WP_Query(array(
            'post_type' => 'photos',
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => 'paysage',
                ),
            ),
            'orderby' => 'rand',
            'posts_per_page' => '1'
        ));
        if ($random_image->have_posts()) {
            while ($random_image->have_posts()) {
                $random_image->the_post();
                echo '<img class="hero-image" src="' . esc_url(get_the_post_thumbnail_url()) . '" alt="Image héro" />';
            }
        }
        
        wp_reset_postdata();
        ?>  
     </section>
    
  

    <!-- Filtre par catégorie -->
    <section class="filtres">
    
    <?php
    $categories = get_terms('categorie');
    echo '<select id="categorie-select">';
    echo '<option value="" >CATÉGORIES</option>';
    foreach ($categories as $categorie) {
        echo '<option value="' . $categorie->slug . '">' . $categorie->name . '</option>';
    }
    echo '</select>';
    ?>

    <!-- Filtre par format -->
    <?php
    $formats = get_terms('format');
    echo '<select id="format-select">';
    echo '<option value="">FORMATS</option>';
    foreach ($formats as $format) {
        echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
    }
    echo '</select>';
    ?>

    <!-- Sélecteur de tri par date -->
    <select id="tri-select">
        <option value="" >TRIER PAR</option>
        <option value="recentes">Du plus récent au plus ancien</option>
        <option value="anciennes">Du plus ancien au plus récent</option>
    </select>
</section>



     <!-- Ajout du block photo -->
    <div class="images-container"></div>
    <?php get_template_part('templates-part/photos-block'); ?>
    
    <div class="load-more-wrapper">
            <button id="load-more-button">Charger plus</button>
        </div>

</main>

<?php get_footer(); ?>



