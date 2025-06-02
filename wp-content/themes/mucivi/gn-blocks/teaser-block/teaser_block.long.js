// modal function
function open_modal(id) {
    let modalElement = document.getElementById("my-modal-" + id)
    if(modalElement !== null){
        modalElement.style.display = "block";
        document.body.style.overflow = "hidden";
    }
}

function close_modal(id) {
    let modalElement = document.getElementById("my-modal-" + id)
    if(modalElement !== null){
        modalElement.style.display = "none";
        document.body.style.overflow = "auto";
    }
}
function plus_slides(id, n) {
    show_slides(id, slide_index[id] += n);
}

function current_slide(id, n) {
    show_slides(id, slide_index[id] = n);
}

function show_slides(id, n) {
    let i;
    let slides = document.querySelectorAll("#my-modal-" + id + " .mySlides");

    if (slides.length) {
        if (n > slides.length) {
            slide_index[id] = 1;
        }
        if (n < 1) {
            slide_index[id] = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            slides[i].querySelector('img').style.transform = "translate(-50%, -50%)"; // Reset transform
            slides[i].querySelector('img').style.transition = "transform 0.2s"; // Ensure transition effect
        }
        slides[slide_index[id] - 1].style.display = "block";
    }
}

// Initialize slide index for each unique ID
let slide_index = {};
document.addEventListener("DOMContentLoaded", function () {
    const modals = document.querySelectorAll("[id^='my-modal-']");
    modals.forEach(modal => {
        const id = modal.id.replace("my-modal-", "");
        slide_index[id] = 1;
        show_slides(id, slide_index[id]);

        // Limit touch event listeners to the .images-slider element
        const slides = modal.querySelectorAll(".images-slider");

        // Add touch event listeners for swipe functionality
        let touch_start_x = 0;
        let touch_end_x = 0;
        let is_swiping = false;

        slides.forEach(slide => {
            slide.addEventListener('touchstart', function (event) {
                touch_start_x = event.changedTouches[0].screenX;
                is_swiping = true;
            });

            slide.addEventListener('touchmove', function (event) {
                if (!is_swiping) return;
                event.stopPropagation();  // Add this to stop event propagation

                touch_end_x = event.changedTouches[0].screenX;
                const delta_x = touch_end_x - touch_start_x;

                // Apply the visual swipe effect only to the current slide
                slide.style.transform = `translate(${delta_x}px, -50%)`;
                slide.style.transition = "transform 0s"; // No transition during swipe
            });

            slide.addEventListener('touchend', function () {
                if (!is_swiping) return;

                const delta_x = touch_end_x - touch_start_x;

                // Reset transform with transitions
                slide.style.transform = "translateX(0px)";
                slide.style.transition = "transform 0.2s ease-out";

                handle_swipe(id, delta_x);
                is_swiping = false;
            });
        });

        function handle_swipe(id, delta_x) {
            if (delta_x < -30) { // Threshold for swipe detection
                plus_slides(id, 1); // Swipe left
            } else if (delta_x > 30) { // Threshold for swipe detection
                plus_slides(id, -1); // Swipe right
            }
        }
    });
});