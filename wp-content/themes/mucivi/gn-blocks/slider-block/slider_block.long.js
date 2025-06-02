//native on dom ready
domRdy(function () {

// SliderBlock - Main Slider
    let main_slider = jQuery(".main-slider");
    if (main_slider.length > 0)
    {
        main_slider.slick({

            autoplay: true,
            autoplaySpeed: 6500,
            slidesToShow: 1,
            slidesToScroll: 1,
            lazyLoad: 'ondemand',
            draggable: true,
            arrows: true,
            dots: true,
            infinite: true,
            mobileFirst: true,
            pauseOnDotsHover: true,
            dotsClass : 'slick-dots container',


            fade: true,
            cssEase: 'linear',
            speed: 500, // transition speed in ms
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }]
        });
    }
// END - SliderBlock - Main Slider

});
