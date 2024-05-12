
// effet d'apparition header et footer//
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("header").classList.add("active");
    document.querySelector("footer").classList.add("active");
});



//modale de contact//

jQuery(document).ready(function($) {
    
    $('a[href="#modal-contact"]').click(function(event) {
       
        event.preventDefault();
        
        $('#modal-contact').show();
    });

    
    $('.close').click(function() {
        
        $('#modal-contact').hide();
    });
});



// Menu Burger mobile //

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











