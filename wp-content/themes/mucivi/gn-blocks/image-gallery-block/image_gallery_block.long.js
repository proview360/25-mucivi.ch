jQuery(document).ready(function($) {
	var owl = $(".slider-carousel");
	owl.owlCarousel({
		loop: true,
		margin: 0,
		autoplay: true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true,
		nav: false,  // Disable default navigation
		dots: false,
		responsive:{
			0:{
				items:1
			},
			768:{
				items:2
			},
			1000:{
				items:3
			},
			1200:{
				items:3
			}
		}
	});
	
	if (typeof Fancybox !== 'undefined') {
		Fancybox.bind(".slider-carousel .owl-item:not(.cloned) a[data-fancybox='gallery']", {});
	}
});