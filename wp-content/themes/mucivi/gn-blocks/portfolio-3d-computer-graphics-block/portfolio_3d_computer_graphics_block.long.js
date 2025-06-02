jQuery(document).ready(function ($) {

    let currentPage = 1; // Current page for pagination
    let currentFilter = 'all'; // Default filter
    let isLoading = false; // Track loading state
    const $loadMoreBtn = $('.load-more-button'); // Load more button
    const $showLessBtn = $('.show-less-button'); // Show less button
    const $portfolioGrid = $('.portfolio-grid'); // Portfolio grid
    const $filterLinks = $('.filter-nav .nav-link-gn'); // Filter links

    // Mobile Menu Toggle
    $('#toggleButton').on('click', function () {
        var menu = $('#portfolioFilterMenu');
        $(this).toggleClass('opened'); // Toggle icon
        menu.toggle(); // Toggle menu visibility
    });

    // Close menu on filter link click (mobile only)
    $('.filter-nav .nav-link').on('click', function () {
        if ($(window).width() < 992) {
            $('#portfolioFilterMenu').hide(); // Hide menu
            $('#toggleButton').removeClass('opened'); // Reset icon
        }
    });

    // Filter Link Click Handler
    $filterLinks.on('click', function (e) {
        e.preventDefault();
        $filterLinks.removeClass('active'); // Remove active class
        $(this).addClass('active'); // Add to clicked filter
        currentFilter = $(this).data('filter'); // Set filter
        currentPage = 1; // Reset to first page
        loadPortfolioItems(true); // Load items
    });

    // Load More Button Handler
    $loadMoreBtn.on('click', function () {
        currentPage++; // Increment page
        loadPortfolioItems(false); // Load next items
    });

    // Show Less Button Handler
    $showLessBtn.on('click', function () {
        currentPage = 1; // Reset to first page
        loadPortfolioItems(true); // Reload items
        $showLessBtn.hide(); // Hide button
    });

    // AJAX to Load Portfolio Items
    function loadPortfolioItems(reset) {
        if (isLoading) return; // Prevent multiple requests
        isLoading = true; // Set loading flag

        $.ajax({
            url: gn_portfolio3dcg_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'gn_filter_portfolio_3dcg',
                filter: currentFilter,
                page: currentPage,
                security: gn_portfolio3dcg_ajax.nonce
            },
            beforeSend: function () {
                if (reset) {
                    $portfolioGrid.html('<div class="col-12 text-center py-5"><div class="spinner-border text-danger" role="status"></div></div>'); // Show spinner
                }
                // $loadMoreBtn.html('<span class="btn-danger">Loading...</span>'); // Change button text
            },
            success: function (response) {
                if (response.success) {
                    if (reset) {
                        $portfolioGrid.html(response.data.html); // First load or reset
                        $('#button-container').removeClass('button-margin');
                    } else {
                        const $html = $('<div>').html(response.data.html); // Wrap raw HTML
                        const $newItems = $html.find('li.hex'); // Extract only <li>
                        $('#hexGrid').append($newItems); // Append to existing <ul>
                        $('#button-container').addClass('button-margin');
                    }

                    if (currentPage > 1) {
                        $showLessBtn.show();
                    } else {
                        $showLessBtn.hide();
                    }

                    if (!response.data.has_more) {
                        $loadMoreBtn.hide();
                    } else {
                        $loadMoreBtn.show();
                    }

                    initializeLightbox(); // Re-init modal
                }
            },



            complete: function () {
                isLoading = false; // Reset loading flag
            }
        });
    }

    // Lightbox Initialization
    function initializeLightbox() {
        $('.portfolio-image').off('click').on('click', function (e) {
            if ($(this).attr('href') === '#') {
                e.preventDefault(); // Prevent default behavior

                const clickedImage = $(this).data('image');
                const clickedTitle = $(this).data('title');
                const clickedDescription = $(this).data('description');
                const allImages = [];

                // Collect all portfolio image data
                $('.portfolio-image').each(function () {
                    allImages.push({
                        image: $(this).data('image'),
                        title: $(this).data('title'),
                        description: $(this).data('description')
                    });
                });

                // Clear and append images to the carousel
                $('#lightboxCarouselContent').empty();
                $('.modal-content-description').remove();
                allImages.forEach((item, index) => {
                    const isActive = (item.image === clickedImage) ? 'active' : '';
                    $('#lightboxCarouselContent').append(`
                        <div class="carousel-item ${isActive}" data-title="${item.title}" data-description="${item.description}">
                            <img src="${item.image}" class="d-block w-100 lightbox-img" alt="${item.title}">
                        </div>
                    `);
                });

                // Initialize carousel
                if (!$('#lightboxCarousel').hasClass('carousel')) {
                    $('#lightboxCarousel').addClass('carousel').carousel();
                }

                // Add title and description
                $('#lightboxModal .modal-body').append(`
                    <div class="modal-content-description">
                        <h2 class="gn-h3 hex-modal-title">${clickedTitle}</h2>
                        <p class="hex-modal-description">${clickedDescription}</p>
                    </div>
                `);

                $('#lightboxModal').modal('show'); // Show modal

                // Update title/description on carousel slide change
                $('#lightboxModal').off('slid.bs.carousel').on('slid.bs.carousel', function () {
                    const $activeSlide = $('#lightboxCarouselContent .carousel-item.active');
                    const newTitle = $activeSlide.data('title');
                    const newDescription = $activeSlide.data('description');
                    $('#lightboxModal .hex-modal-title').text(newTitle);
                    $('#lightboxModal .hex-modal-description').text(newDescription);
                });
            }
        });
    }

    // Initialize Portfolio Items
    loadPortfolioItems(true); // Load items on page load
});
