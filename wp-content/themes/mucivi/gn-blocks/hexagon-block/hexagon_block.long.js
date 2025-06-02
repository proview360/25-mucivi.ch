function dom_rdy(callback_fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        setTimeout(callback_fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", callback_fn);
    }
}

dom_rdy(function () {
    const honeycomb = document.querySelector(".honeycomb-small");
    if (!honeycomb) return;

    honeycomb.style.scrollbarWidth = "none"; // Firefox
    honeycomb.style.msOverflowStyle = "none"; // IE

    // 🛡️ Disable drag on anchors, divs, and images
    document.querySelectorAll('a, .hexagon-small, .hexagon-small img').forEach((el) => {
        el.setAttribute('draggable', 'false');
        el.addEventListener('dragstart', (e) => e.preventDefault());
    });

    let is_dragging = false;
    let start_x;
    let scroll_left;
    const scroll_step = 1;

    function scroll_loop() {
        if (!is_dragging) {
            honeycomb.scrollLeft += scroll_step;

            if (honeycomb.scrollLeft >= honeycomb.scrollWidth - honeycomb.clientWidth) {
                honeycomb.scrollLeft = 0;
            }
        }

        requestAnimationFrame(scroll_loop);
    }

    scroll_loop();

    // ✅ Drag-to-scroll
    honeycomb.addEventListener("mousedown", (e) => {
        is_dragging = true;
        start_x = e.pageX - honeycomb.offsetLeft;
        scroll_left = honeycomb.scrollLeft;
        honeycomb.classList.add("active");
    });

    honeycomb.addEventListener("mouseup", () => {
        is_dragging = false;
        honeycomb.classList.remove("active");
    });

    honeycomb.addEventListener("mouseleave", () => {
        is_dragging = false;
        honeycomb.classList.remove("active");
    });

    honeycomb.addEventListener("mousemove", (e) => {
        if (!is_dragging) return;
        e.preventDefault();
        const x = e.pageX - honeycomb.offsetLeft;
        const walk = (x - start_x) * 1.5;
        honeycomb.scrollLeft = scroll_left - walk;
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const hexes = document.querySelectorAll('.hexIn');

    // 1. Fshi të gjitha klasat .active (për çdo rast)
    hexes.forEach(h => h.classList.remove('active'));

    // 2. Zgjidh 3 random .hexIn
    const hexesArray = Array.from(hexes);
    const shuffled = hexesArray.sort(() => 0.5 - Math.random());
    const selected = shuffled.slice(0, 2);

    // 3. Vendos klasën .active tek ato 3
    selected.forEach(hex => hex.classList.add('active'));

    // 4. Kur klikon një hexIn, hiq active nga të gjithë dhe vendos tek ai
    hexes.forEach(function(hex) {
        hex.addEventListener('click', function(e) {
            if (e.target.tagName !== 'A') {  // Check if the clicked element is not an anchor tag
                e.preventDefault(); // Prevent anchor tag behavior only if it's not a link
                hexes.forEach(h => h.classList.remove('active'));
                hex.classList.add('active');
            }
        });
    });
});



