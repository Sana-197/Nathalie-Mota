// LIGHTBOX//

jQuery(document).ready(function($) {
    let photos = [];
    let currentPhotoIndex = 0;

    // Initialisation des photos//
    function initPhotos() {
        photos = [];
        $('.related-photo-img-accueil, .related-photo-img').each(function() {// Récupère l'URL de la photo à partir de l'attribut 'src' de l'image//
            let photoUrl = $(this).find('img').attr('src');
            let reference = $(this).find('.photo-info-left p').text();
            let category = $(this).find('.photo-info-right p').text();
            photos.push({ url: photoUrl, reference: reference, category: category });// Ajoute un objet contenant l'URL, la référence et la catégorie à l'array photo//
        });
        console.log("Liens des photos initialisées :");
        photos.forEach(photo => console.log(photo.url));
    }
    function updatePhotos() {
        photos = []; // Vider le tableau des photos existantes
        $('.related-photo-img-accueil, .related-photo-img').each(function() {
            let photoUrlLarge = $(this).find('.fullscreen-icon img').data('large-url'); // Récupérer l'URL de l'image réelle depuis l'attribut data-large-url
            console.log("Lien de l'image réelle :", photoUrlLarge); // Afficher le lien de l'image réelle pour vérification//
            let reference = $(this).find('.photo-info-left p').text();
            let category = $(this).find('.photo-info-right p').text();
            photos.push({ url: photoUrlLarge, reference: reference, category: category }); // Ajouter le lien de l'image réelle//
        });
        console.log("Nombre de photos après mise à jour :", photos.length);
    }
    
    // Gestion de l'ouverture de la lightbox au clic sur l'icône Full Screen//

    $(document).on('click', '.fullscreen-icon', function(e) {
        e.preventDefault();// Empêche le comportement par défaut du lien//
        let index = $(this).closest('.related-photo-img-accueil, .related-photo-img').index();// Index de l'icône sur laquelle l'utilisateur a cliqué//
        currentPhotoIndex = index;// Met à jour l'index de la photo actuelle//
        updateLightboxPhoto(currentPhotoIndex);// Met à jour la photo affichée dans la lightbox avec la photo actuelle//
        $('#lightbox-overlay').addClass('active');// Ajoute la classe 'active' pour afficher la lightbox//
    });

    // Fermeture de la lightbox//
    $('.lightbox-close').click(function() {
        $('#lightbox-overlay').removeClass('active');// Retire la classe 'active' pour masquer la lightbox//
    });

    // Navigation//
    $('.lightbox-prev').click(function() {
        currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;// Décrémente l'index de la photo actuelle//
        updateLightboxPhoto(currentPhotoIndex);// Met à jour la photo affichée dans la lightbox//
    });

    $('.lightbox-next').click(function() {
        currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;// Incrémente l'index de la photo actuelle//
        updateLightboxPhoto(currentPhotoIndex);// Met à jour la photo affichée dans la lightbox//
    });

    function updateLightboxPhoto(index) {
        $('#lightbox-photo').attr('src', photos[index].url);
        $('#lightbox-reference').text(photos[index].reference);
        $('#lightbox-category').text(photos[index].category);
    }

    // Écouter le chargement dynamique de nouvelles photos via AJAX//
    $(document).ajaxComplete(function(event, xhr, settings) { //fonction qui prend trois paramètres : event, qui est l'événement jQuery associé, xhr, qui est l'objet XMLHttpRequest utilisé pour la requête AJAX, et settings, qui contient les paramètres de la requête AJAX//
        if (settings.url === ajax_object.ajax_url) {// Vérifier si la requête AJAX correspond à celle de notre chargement de photos//
            updatePhotos();// Si c'est le cas, appeler la fonction pour mettre à jour les photos//
        }
    });

    // Appel initial pour charger les photos au chargement de la page//
    initPhotos();
});
