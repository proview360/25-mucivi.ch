domRdy(function () {
    document.querySelectorAll('.bgHexagon').forEach(hex => {
        hex.addEventListener('mouseenter', () => {
            hex.classList.add('hovered');

            // Hiqe pas 500ms
            setTimeout(() => {
                hex.classList.remove('hovered');
            }, 500);
        });
    });
});
