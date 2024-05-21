
// effet d'apparition header et footer//
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("header").classList.add("active");
    document.querySelector("footer").classList.add("active");
});


// BOUTON DE CONTACT DU HEADER ET DE LA PAGE SINGLE-PHOTOS //

jQuery(document).ready(function($) {
    // Pour le bouton de contact dans le single-photos.php//

    $('.single-photo-contact-button').click(function(event) {
        event.preventDefault();

        
        var referencePhoto = $(this).attr('data-reference');// Récupérer la référence photo depuis l'attribut data-reference du bouton//
        
        
        $('#modal-contact input[name="your-subject"]').val(referencePhoto);// Remplir le champ de référence photo dans le formulaire de Contact Form 7//

        
        $('#modal-contact').show();
    });

    // Pour le lien de contact dans le header//
    
    $('a[href="#modal-contact"]').click(function(event) {
        event.preventDefault();

        
        $('#modal-contact input[name="your-subject"]').val('');// Vérifier que le champ de référence photo est vide//

        
        $('#modal-contact').show();
    });

    
    $('.close').click(function() {// Fermeture de la modale//
        $('#modal-contact').hide();
    });
});

// MENU BURGER MOBILE//


jQuery(document).ready(function($) {
    
    $('.menu-mobile-burger').click(function() {
        $(this).toggleClass('active'); // Basculer sur la classe "active"//
        
        if ($(this).hasClass('active')) { // Si le menu est ouvert//
            if (window.matchMedia("(max-width: 430px)").matches) { // Vérifie si l'écran est de taille mobile 430px//
                $('#menu-principal-mobile').show(); // Si oui il affiche le menu principal sur mobile seulement//
            }
        } else {
            if (window.matchMedia("(max-width: 430px)").matches) { // Vérifie si l'écran est de taille mobile 430px//
                $('#menu-principal-mobile').hide(); // Si oui il cache le menu principal sur mobile seulement//
            }
        }
    });

    $('#menu-principal-mobile li a').click(function() { 
        $('.menu-mobile-burger').removeClass('active'); 
        if (window.matchMedia("(max-width: 430px)").matches) { 
            $('#menu-principal-mobile').hide(); // Cacher le menu principal sur mobile seulement//
        }
    });
});

// menu navigation photo single-photos//

jQuery(document).ready(function($) {
    
    // Vérifier si l'élément .thumbnail-wrapper existe sur la page//
    if ($('.thumbnail-wrapper').length) {
        function updateThumbnail(thumbnailUrl) {// Fonction pour la mise à jour la miniature//
            $('.thumbnail-wrapper').css('background-image', 'url(' + thumbnailUrl + ')');
        }

        // Au chargement de la page, afficher la miniature de la photo actuelle//
        let currentThumbnailUrl = $('.thumbnail-wrapper').css('background-image').replace(/url\(['"]?(.*?)['"]?\)/,'$1');
        updateThumbnail(currentThumbnailUrl);

        
        $('.prev-link').mouseenter(function() {// Gestionnaire d'événements pour le survol de la flèche précédente gauche)//
            let prevThumbnail = $(this).data('thumbnail');
            updateThumbnail(prevThumbnail);
        });

        
        $('.next-link').mouseenter(function() {// Gestionnaire d'événements pour le survol de la flèche suivante droite//
            let nextThumbnail = $(this).data('thumbnail');
            updateThumbnail(nextThumbnail);
        });

        
        $('.navigation-photo').mouseleave(function() { //met à jour la miniature affichée avec l'image de la photo actuelle sur la page//
            updateThumbnail(currentThumbnailUrl);
        });

        // Gestionnaire d'événements pour le clic sur la flèche précédente gauche//
        $('.prev-link').click(function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien//
            window.location.href = $(this).attr('href'); // Redirige vers le lien précédent//
        });

        // Gestionnaire d'événements pour le clic sur la flèche suivante droite//
        $('.next-link').click(function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien//
            window.location.href = $(this).attr('href'); // Redirige vers le lien suivant//
        });
    }
});

//FILTRES PAGE D ACCUEIL // 

jQuery(document).ready(function($) {
    function loadPhotos() { // récupère  les valeurs des filtres//
        let categorie = $('#categorie-select').val();
        let format = $('#format-select').val();
        let tri = $('#tri-select').val();

        let data = { // prépare les données à envoyer avec la requête ajax//
            action: 'filter_photos',
            categorie: categorie,
            format: format,
            tri: tri,
            page: 1 
        };

        $.ajax({ // Effectuer la requête ajax pour filtrer les photos//
            url: ajax_object.ajax_url, // l'url de l'API d'ajax définie dans wordpress//
            data: data, // données à envoyer avec la requête//
            type: 'POST', // type de requête//
            success: function(response) { 
                $('.related-photo-block-accueil').html(response);// Mettre à jour le contenu avec la réponse de la requête//
            }
        });
    }

    $('#categorie-select, #format-select, #tri-select').change(function() { 
        loadPhotos();// appelez la fonction load photos lorsque les filtres changes//
    });
});




// BOUTON CHARGEMENT PAGE D ACCUEIL //

jQuery(document).ready(function($) {
    // Variable pour suivre le numéro de la page
    let pageActuelle = 1;

    // Écouter le clic sur le bouton "Charger plus"//
    $('#load-more-button').on('click', function () {
        pageActuelle++; // Incrémenter le numéro de la page//
        ajaxRequest(); // Appeler la fonction AJAX//
    });

    // Fonction pour effectuer la requête AJAX//
    function ajaxRequest() {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url, // URL de l'API Ajax de WordPress//
            dataType: 'html',
            data: {
                action: 'load_more_photos', // Action à exécuter dans WordPress//
                page: pageActuelle, // Numéro de la page actuelle//
            },
            success: function (response) {
                // Traiter la réponse et l'ajouter à la galerie de photos//
                $('.related-photo-block-accueil').append(response);
            },
            error: function (error) {
                console.error('Erreur lors de la requête AJAX:', error);// ou alors messagae d'erreur//
            },
        });
    }
});









