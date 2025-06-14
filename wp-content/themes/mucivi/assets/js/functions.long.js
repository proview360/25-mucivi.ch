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
        customButton.className = 'wpcf7-submit btn-full btn-full-red';
        customButton.innerHTML = `<span class="svg-icon"></span>${btnText}`;

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


