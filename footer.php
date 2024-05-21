<footer>
    <nav>
        <?php
            wp_nav_menu(array(
                'theme_location' => 'menu-pied-de-page',
                'container' => false,
                'menu_class' => 'menu-pied-de-page',
                
            ));
        ?>
    </nav>
    <?php get_template_part('templates-part/modal-contact'); ?>
    <?php get_template_part('templates-part/lightbox'); ?>

</footer>

<?php wp_footer(); ?>
</body>
</html>
