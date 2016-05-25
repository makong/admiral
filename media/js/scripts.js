jQuery(document).ready(function ($) {
    
    var $container = $("#gallery .gallery .row");
    
    $container.isotope({
        itemSelector: '.item',
        transitionDuration: '0.7s'
    });
    
    $container.imagesLoaded().progress(function () {
        $container.isotope('layout');
    });
    
    /*$('#gallery .gallery_nav ul li').first().addClass('active');*/
    
    $(".gallery_switcher").on('click', function () {
            $(this).toggleClass('active');
            var $container_wrapper = $('#gallery');
            $container_wrapper.find('.gallery').toggleClass('container');
            $container.isotope('layout');
            return false;
    });

    $(".fancybox").fancybox({
        openEffect: 'elastic',
        closeEffect: 'elastic'
    });
});