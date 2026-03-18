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

// Profile dropdown toggle (global for navbar)
let dropdownOpen = false;

function toggleDropdown(event) {
    event.stopPropagation();
    const dropdown = document.getElementById('dropdown-menu');
    const btn = document.getElementById('profile-btn');
    
    if (dropdownOpen) {
        dropdown.classList.add('opacity-0', 'invisible', 'scale-95', 'hidden');
        dropdownOpen = false;
    } else {
        dropdown.classList.remove('opacity-0', 'invisible', 'scale-95', 'hidden');
        dropdown.classList.add('opacity-100', 'visible', 'scale-100');
        dropdownOpen = true;
    }
}

// Close dropdown on outside click
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdown-menu');
    const btn = document.getElementById('profile-btn');
    if (dropdownOpen && dropdown && btn && !btn.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('opacity-0', 'invisible', 'scale-95', 'hidden');
        dropdownOpen = false;
    }
});
