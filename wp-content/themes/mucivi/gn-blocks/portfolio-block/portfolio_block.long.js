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
    $('.filter-nav').on('click', function () {
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
            url: gn_portfolio_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'gn_filter_portfolio',
                filter: currentFilter,
                page: currentPage,
                security: gn_portfolio_ajax.nonce
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
        $('.portfolio-image[data-portfolio-type="post"]')
            .removeAttr('data-bs-toggle data-bs-target');

        $('.portfolio-image').off('click').on('click', function (e) {
            const type = $(this).data('portfolio-type');
            if (type === 'post') {
                e.preventDefault();
                e.stopImmediatePropagation();
                window.location.href = $(this).data('link') || $(this).attr('href');
                return;
            }

            e.preventDefault();

            // 1) Compute which thumbnail index was clicked
            const $thumbs       = $('.portfolio-image');
            const clickedIndex  = $thumbs.index(this);

            // 2) Gather all items
            const allImages = [];
            $thumbs.each(function () {
                allImages.push({
                    image:       $(this).data('image'),
                    title:       $(this).data('title'),
                    description: $(this).data('description'),
                    type:        $(this).data('portfolio-type'),
                    link:        $(this).data('link') || $(this).attr('href'),
                    video:       $(this).data('video'),
                });
            });

            // 3) Build slides, marking only the clicked index as active
            $('#lightboxCarouselContent').empty();
            allImages.forEach((item, index) => {
                const isActive = index === clickedIndex ? 'active' : '';

                let contentHtml = '';
                if (item.type === 'video') {
                    const m = item.video.match(/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:watch\?v=|embed\/|v\/))([^"&?\/ ]{11})/);
                    const vid = m ? m[1] : '';
                    const embedUrl = vid
                        ? `https://www.youtube.com/embed/${vid}?autoplay=0&mute=0&controls=1&rel=0`
                        : '';

                    contentHtml = `
                      <div class="mb-3">
                        <div class="video-wrapper" style="position: relative;">
                          <div class="video-loader glass-loader" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 2;">
                            <div class="spinner" style="width: 30px; height: 30px; border: 4px solid var(--mucivi-white); border-top-color: var(--mucivi-primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
                          </div>
                          <div class="ratio ratio-16x9">
                          <iframe
                              class="embed-responsive-item"
                              src="${embedUrl}"
                              frameborder="0"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                              allowfullscreen
                              onload="this.parentElement.previousElementSibling.style.display='none';">
                          </iframe>

                          </div>
                        </div>
                      </div>
                      <div class="modal-content-description" style="margin-bottom: 30px"">
                        <h2 class="gn-h3 hex-modal-title">${item.title}</h2>
                        <p class="hex-modal-description">${item.description}</p>
                      </div>
                    `;
                }


                else if (item.type === 'post') {
                    contentHtml = `
                      <img src="${item.image}" class="d-block w-100 lightbox-img" alt="${item.title}">
                      <div class="modal-content-description">
                        <h2 class="gn-h3 hex-modal-title">${item.title}</h2>
                        <p class="hex-modal-description mb-5">${item.description}</p>
                        <a href="${item.link}" class="btn-full btn-full-red mt-3" target="_blank">View Post</a>
                      </div>
                    `;
                }
                else {
                    contentHtml = `
                      <img src="${item.image}" class="d-block w-100 lightbox-img" alt="${item.title}">
                      <div class="modal-content-description">
                        <h2 class="gn-h3 hex-modal-title">${item.title}</h2>
                        <p class="hex-modal-description">${item.description}</p>
                      </div>
                    `;
                }

                $('#lightboxCarouselContent').append(`
                    <div class="carousel-item ${isActive}"
                         data-title="${item.title}"
                         data-description="${item.description}">
                      ${contentHtml}
                    </div>
                  `);
            });

            // 4) Show modal
            if (!$('#lightboxCarousel').hasClass('carousel')) {
                $('#lightboxCarousel').addClass('carousel').carousel();
            }
            $('#lightboxModal').modal('show');

            // 5) Update captions on slide change
            $('#lightboxModal').off('slid.bs.carousel').on('slid.bs.carousel', function () {
                const $items = $('#lightboxCarouselContent .carousel-item');

                $items.each(function () {
                    const $iframe = $(this).find('iframe');
                    if ($iframe.length) {
                        const $parent = $(this);
                        if (!$parent.hasClass('active')) {
                            const src = $iframe.attr('src');
                            $iframe.attr('src', ''); // clear src
                            $iframe.attr('src', src); // restore src, resets video
                        }
                    }
                });

                const $active = $('#lightboxCarouselContent .carousel-item.active');
                $('#lightboxModal .hex-modal-title').text($active.data('title'));
                $('#lightboxModal .hex-modal-description').text($active.data('description'));
            });

            // Stop video on modal close
            $('#lightboxModal').off('hide.bs.modal').on('hide.bs.modal', function () {
                $('#lightboxCarouselContent iframe').each(function () {
                    const src = $(this).attr('src');
                    $(this).attr('src', '');     // clear src to stop playback
                    $(this).attr('src', src);    // restore src if modal is reopened later
                });
            });

        });
    }

    // Initialize Portfolio Items
    loadPortfolioItems(true); // Load items on page load
});
