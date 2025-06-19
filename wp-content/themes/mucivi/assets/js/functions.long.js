// native dom ready function
var domRdy = function (fn) {

    //sanity check
    if (typeof fn !== "function") {
        return;
    }

    //if document is already loaded, run method
    if (document.readyState === "complete") {
        return fn();
    }

    //otherwise, wait until document is loaded
    document.addEventListener("DOMContentLoaded", fn, false);
};

//native on dom ready
domRdy(function () {

});

//contact form 7
document.addEventListener("DOMContentLoaded", function () {
    const cf7Btns = document.querySelectorAll('.wpcf7 .wpcf7-submit');

    cf7Btns.forEach(function (cf7Btn) {
        const btnText = cf7Btn.value;
        const customButton = document.createElement('button');
        customButton.type = 'submit';
        customButton.className = 'wpcf7-submit btn-full btn-full-primary';
        customButton.innerHTML = `${btnText}`;

        cf7Btn.parentNode.replaceChild(customButton, cf7Btn);
    });
});

document.addEventListener('DOMContentLoaded', function() {

    /* Search Desktop */
    // var serach_icon_button = document.getElementById('search-icon');
    // var search_form_wrapper = document.getElementById('search-form-wrapper');
    // var close_button = document.getElementById('close-search');
    // var search_form = document.querySelector('.search-form-desktop'); // Updated class
    // var search_input = document.querySelector('.search-field-desktop'); // Updated class
    //
    // serach_icon_button.addEventListener('click', function () {
    //     console.log(serach_icon_button + ' clicked');
    //     serach_icon_button.classList.add('hidden');
    //     search_form_wrapper.classList.add('open');
    //     search_input.focus();
    // });
    //
    // close_button.addEventListener('click', function (event) {
    //     event.preventDefault();
    //     search_form_wrapper.classList.remove('open');
    //     serach_icon_button.classList.remove('hidden');
    // });
    //
    // search_input.addEventListener('keypress', function (event) {
    //     if (event.key === 'Enter') {
    //         event.preventDefault();
    //         search_form.submit();
    //     }
    // });
    //
    // /* Search Mobile */
    // var search_icon_button_mobile = document.getElementById('search-icon-mobile');
    // var search_form_wrapper_mobile = document.getElementById('search-form-wrapper-mobile');
    // var close_button_mobile = document.getElementById('close-search-mobile');
    // var search_form_mobile = document.querySelector('.search-form-mobile'); // Updated class
    // var search_input_mobile = document.querySelector('.search-field-mobile'); // Updated class
    // // var KEYCODE_SEARCH = 84; // Android
    //
    // search_icon_button_mobile.addEventListener('click', function () {
    //     search_icon_button_mobile.classList.add('hidden');
    //     search_form_wrapper_mobile.classList.add('open');
    //     search_input_mobile.focus();
    // });
    //
    // close_button_mobile.addEventListener('click', function (event) {
    //     event.preventDefault();
    //     search_form_wrapper_mobile.classList.remove('open');
    //     search_icon_button_mobile.classList.remove('hidden');
    // });
    //
    // search_input_mobile.addEventListener('keydown', function(event) {
    //     var mobile_submit_keys = ['Enter', 'Go', 'Search', 'Done', 'Next', 'Send'];
    //
    // // || event.keyCode === KEYCODE_SEARCH
    //     if (mobile_submit_keys.includes(event.key) || event.keyCode === 13 ) {
    //         event.preventDefault();
    //         setTimeout(function () {
    //             search_form_mobile.submit();
    //         }, 100);
    //     }
    // });
});

// language switcher
document.addEventListener('DOMContentLoaded', function () {
    const activeLang = document.querySelector('.lang-active');
    const dropdown = document.querySelector('.lang-dropdown');
    
    if (activeLang) {
        activeLang.addEventListener('click', function (e) {
            e.preventDefault();
            dropdown.classList.toggle('show-lang-dropdown');
        });
    }
    
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.lang-switcher')) {
            dropdown.classList.remove('show-lang-dropdown');
        }
    });
});

/*Contact form Opening and closing Tab*/
document.addEventListener('DOMContentLoaded', function() {
    const openMegaMenu = document.getElementById('openMegaMenu');
    const panelLeft = document.getElementById('panelLeft');
    const panelRight = document.getElementById('panelRight');

    openMegaMenu.addEventListener('click', function() {
        console.log('clicke mega menu');
        this.classList.toggle('active');
        panelLeft.classList.toggle('open-left');
        panelRight.classList.toggle('open-right');

        // Optional: toggle background color on activation
        this.style.backgroundColor = this.classList.contains('active') ? '#ffffff' : 'var(--mucivi-primary)';
    });
});

// Wait for DOM
document.addEventListener('DOMContentLoaded', () => {
    // Select all arrow wrappers
    const arrow_wrappers = document.querySelectorAll('.mega-menu-mobile-arrow');

    arrow_wrappers.forEach(arrow_wrapper => {
        // Grab the two arrow images
        const arrow_menu_open = arrow_wrapper.querySelector('.arrow-menu-open');
        const arrow_menu_close = arrow_wrapper.querySelector('.arrow-menu-close');

        // Find the corresponding submenu in the same <li>
        const parent_li = arrow_wrapper.closest('li');
        const sub_menu = parent_li.querySelector('.dropdown-menu.sub-menu.depth_0');

        // Ensure submenu is hidden by default
        sub_menu.classList.add('d-none');

        // Bind click
        arrow_wrapper.addEventListener('click', () => {
            // Toggle open/close icons
            arrow_menu_open.classList.toggle('d-none');
            arrow_menu_close.classList.toggle('d-none');

            // Toggle submenu visibility
            sub_menu.classList.toggle('d-none');
        });
    });
});



// image product gallery
document.addEventListener('DOMContentLoaded', function () {
    let current_index = 0;
    let start_x = 0;
    let is_dragging = false;
    const slides = document.querySelectorAll('.swipe-slide');
    const gallery_wrapper = document.querySelector('.woocommerce-product-gallery__wrapper');
    const prev_button = document.querySelector('.prev-button');
    const next_button = document.querySelector('.next-button');
    
    // Check if there are any swipe slides
    if (slides.length === 0) {
        return;
    }
    
    // Check if elements exist
    if (!gallery_wrapper) {
        console.error('Gallery wrapper not found');
        return;
    }
    if (!prev_button) {
        console.error('Previous button not found');
    }
    if (!next_button) {
        console.error('Next button not found');
    }
    
    // Check if there is only one slide
    if (slides.length <= 1) {
        if (prev_button) prev_button.style.display = 'none';
        if (next_button) next_button.style.display = 'none';
        return; // No need to continue with the rest of the script
    }
    
    if (prev_button) prev_button.addEventListener('click', show_previous);
    if (next_button) next_button.addEventListener('click', show_next);
    
    gallery_wrapper.addEventListener('touchstart', touch_start);
    gallery_wrapper.addEventListener('touchmove', touch_move);
    gallery_wrapper.addEventListener('touchend', touch_end);
    
    function update_buttons() {
        if (prev_button) prev_button.disabled = false;
        if (next_button) next_button.disabled = false;
    }
    
    function set_position_by_index() {
        const translate_x = current_index * -100;
        gallery_wrapper.style.transform = `translateX(${translate_x}%)`;
        update_buttons();
    }
    
    function show_previous() {
        current_index = (current_index - 1 + slides.length) % slides.length;
        set_position_by_index();
    }
    
    function show_next() {
        current_index = (current_index + 1) % slides.length;
        set_position_by_index();
    }
    
    function touch_start(event) {
        start_x = event.touches[0].clientX;
        is_dragging = true;
        gallery_wrapper.style.transition = 'none';
    }
    
    function touch_move(event) {
        if (!is_dragging) return;
        const current_x = event.touches[0].clientX;
        const translate_x = (current_index * -100) + ((current_x - start_x) / window.innerWidth) * 100;
        gallery_wrapper.style.transform = `translateX(${translate_x}%)`;
    }
    
    function touch_end(event) {
        is_dragging = false;
        gallery_wrapper.style.transition = 'transform 0.3s ease-in-out';
        const moved_by = (start_x - event.changedTouches[0].clientX) / window.innerWidth * 100;
        if (moved_by > 10) {
            show_next();
        } else if (moved_by < -10) {
            show_previous();
        } else {
            set_position_by_index();
        }
    }
    
    update_buttons(); // Initialize button states
});



//autoupdate cart number
jQuery(document).ready(function($) {
    function updateCartCount() {
        $.ajax({
            url: wtAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'update_cart_count'
            },
            success: function(response) {
                var count = parseInt(response, 10); // Ensure the response is an integer
                if (!isNaN(count) && count > 0) {
                    $('.menu-basket-items-total').text(count).show();
                    pageReloaded = false; // Reset the flag
                } else {
                    $('.menu-basket-items-total').text(0).hide(); // Ensure it hides and sets the count to 0
                }
            }
        });
    }
    
    // Call updateCartCount function whenever the cart is updated
    $(document.body).on('added_to_cart updated_cart_totals removed_from_cart', function() {
        updateCartCount();
    });
    
    // Initial call to set the cart count when the page loads
    updateCartCount();
});
