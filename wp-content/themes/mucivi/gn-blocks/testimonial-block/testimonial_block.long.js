jQuery(document).ready(function($) {
    let owl = {}; // define owl here
    let tesimonials_section = jQuery(".testimonials-section .owl-carousel");
    console.log(tesimonials_section.length);

    if(tesimonials_section.length > 0) {
        $(tesimonials_section).each(function() {
            let id = $(this).data('id');

            owl["testimonials-"+id] = jQuery(this);

            // Trigger Owl Carousel
            owl["testimonials-"+id].owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 500000,
                autoplayHoverPause: true,
                nav: false,
                dots: false,
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:1
                    },
                    1000:{
                        items:1
                    },
                    1200:{
                        items:1
                    }
                }
            });
        });
    }

    // Listen for clicks on the arrow buttons
    $('.owl-nav-button').on('click', function() {
        console.log('clicked');
        // Get action and context from clicked button
        let action = $(this).data('action');
        let context = $(this).data('context');

        // Call 'next' or 'prev' according to the action on the correct owlCarousel instance.
        if (action === 'next' && context in owl) {
            owl[context].trigger('next.owl.carousel');
            console.log("NEXT");
        } else if (action === 'prev' && context in owl) {
            owl[context].trigger('prev.owl.carousel');
        }
    });
});