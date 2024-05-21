// LIGHTBOX//

jQuery(document).ready(function($) {
    let photos = [];
    let currentPhotoIndex = 0;

    // Initialisation des photos
    function initPhotos() {
        photos = [];
        $('.related-photo-img-accueil, .related-photo-img').each(function() {
            let photoUrl = $(this).find('img').attr('src');// Récupère l'URL de la photo à partir de l'attribut 'src' de l'image//
            let reference = $(this).find('.photo-info-left p').text();
            let category = $(this).find('.photo-info-right p').text();
            photos.push({ url: photoUrl, reference: reference, category: category });// Ajoute un objet contenant l'URL, la référence et la catégorie à l'array photo//
        });
    }
    
    initPhotos();// Appel de la fonction pour initialiser les photos//

    // Gestion de l'ouverture de la lightbox au clic sur l'icône Full Screen//

    $(document).on('click', '.fullscreen-icon', function(e) {
        e.preventDefault();// Empêche le comportement par défaut du lien//
        let index = $('.fullscreen-icon').index(this); // Index de l'icône sur laquelle l'utilisateur a cliqué//
        currentPhotoIndex = index;// Met à jour l'index de la photo actuelle//
        updateLightboxPhoto(currentPhotoIndex);// Met à jour la photo affichée dans la lightbox avec la photo actuelle//
        $('#lightbox-overlay').addClass('active'); // Ajoute la classe 'active' pour afficher la lightbox//
    });

    // Fermeture de la lightbox//
    $('.lightbox-close').click(function() {
        $('#lightbox-overlay').removeClass('active'); // Retire la classe 'active' pour masquer la lightbox//
    });

    // Navigation//
    $('.lightbox-prev').click(function() {
        currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;// Décrémente l'index de la photo actuelle//
        updateLightboxPhoto(currentPhotoIndex);// Met à jour la photo affichée dans la lightbox//
    });

    $('.lightbox-next').click(function() {
        currentPhotoIndex = (currentPhotoIndex + 1) % photos.length; // Incrémente l'index de la photo actuelle//
        updateLightboxPhoto(currentPhotoIndex);// Met à jour la photo affichée dans la lightbox//
    });

    function updateLightboxPhoto(index) {// Fonction pour mettre à jour la photo affichée dans la lightbox//
        $('#lightbox-photo').attr('src', photos[index].url);
        $('#lightbox-reference').text(photos[index].reference);
        $('#lightbox-category').text(photos[index].category);
    }
});

