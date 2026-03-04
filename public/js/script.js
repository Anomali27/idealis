window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");

    if (window.scrollY > 50) {
        navbar.style.background = "#043460";
        navbar.style.position = "fixed";
    } else {
        navbar.style.background = "transparent";
        navbar.style.position = "absolute";
    }
});