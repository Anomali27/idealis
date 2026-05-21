window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    if (!navbar) return;

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

// ==========================================
// UNIFIED BUTTON AND USER EXPERIENCE ENHANCEMENT
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    let isFormDirty = false;

    // 1. DIRTY STATE CHECKING FOR ALL FORMS
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        // Skip get-only search forms
        if (form.method && form.method.toLowerCase() === 'get') return;

        const inputs = form.querySelectorAll("input, textarea, select");
        inputs.forEach(input => {
            // Track dynamic changes
            input.addEventListener("input", () => { isFormDirty = true; });
            input.addEventListener("change", () => { isFormDirty = true; });
        });

        // Clear dirty state on submit
        form.addEventListener("submit", () => {
            isFormDirty = false;
        });
    });

    // 2. BACK AND CANCEL DIALOG FOR UNSAVED CHANGES
    document.addEventListener("click", function (event) {
        // Find if target is a cancel button or back link
        const target = event.target.closest("a, button");
        if (!target) return;

        const text = target.textContent.trim().toLowerCase();
        const isCancel = text.includes("cancel") || target.classList.contains("btn-cancel");
        const isBack = text.includes("back") || target.classList.contains("btn-back");

        if ((isCancel || isBack) && isFormDirty) {
            const confirmDiscard = confirm("You have unsaved changes. Are you sure you want to discard them and leave this page?");
            if (!confirmDiscard) {
                event.preventDefault();
                event.stopPropagation();
                return;
            }
            // User confirmed, clear dirty state so standard unloading doesn't prompt again
            isFormDirty = false;
        }
    });

    // Standard unload protection for dirty states (e.g. reload or back button clicks)
    window.addEventListener("beforeunload", function (event) {
        if (isFormDirty) {
            event.preventDefault();
            event.returnValue = "You have unsaved changes. Are you sure you want to discard them?";
            return event.returnValue;
        }
    });

    // 3. SECURE DESTRUCTIVE ACTION VERIFICATION
    document.addEventListener("submit", function (event) {
        const form = event.target;
        const submitBtn = form.querySelector("button[type='submit'], input[type='submit']");
        const isDeleteAction = form.action.toLowerCase().includes("delete") || 
                              (submitBtn && submitBtn.textContent.toLowerCase().includes("delete"));

        if (isDeleteAction) {
            // Skip prompting if the form has an explicit inline confirm handler that returns boolean
            const hasInlineConfirm = form.getAttribute("onsubmit") && form.getAttribute("onsubmit").includes("confirm(");
            if (hasInlineConfirm) return;

            // Check if form already confirmed
            if (form.dataset.confirmed === "true") return;

            event.preventDefault();
            event.stopPropagation();

            const deleteText = "Are you sure you want to permanently delete this? This action is destructive and cannot be undone.";
            if (confirm(deleteText)) {
                form.dataset.confirmed = "true";
                if (submitBtn) {
                    setButtonLoading(submitBtn, "Deleting...");
                }
                form.submit();
            }
        }
    });

    // 4. SUBMIT/SAVE DYNAMIC SPINNER & LOADING STATES
    forms.forEach(form => {
        if (form.method && form.method.toLowerCase() === 'get') return;
        
        form.addEventListener("submit", function (event) {
            if (event.defaultPrevented) return;
            
            const submitBtn = form.querySelector("button[type='submit'], input[type='submit']");
            if (submitBtn && form.checkValidity()) {
                const text = submitBtn.textContent.trim().toLowerCase();
                let loadingText = "Processing...";
                if (text.includes("save")) loadingText = "Saving Changes...";
                else if (text.includes("create")) loadingText = "Creating...";
                else if (text.includes("submit")) loadingText = "Submitting...";

                setButtonLoading(submitBtn, loadingText);
            }
        });
    });

    function setButtonLoading(button, text) {
        // Prevent double submit by disabling
        button.disabled = true;
        button.classList.add("opacity-75", "cursor-not-allowed");
        button.style.pointerEvents = "none";

        // Inject beautiful dynamic SVG spinner
        const spinner = `
            <svg class="animate-spin -ml-1 mr-2.5 h-4 w-4 text-current inline-block align-text-bottom" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;
        button.innerHTML = spinner + text;
    }

    // 5. UNIFIED BUTTON STYLING AND HOVER/ACTIVE Micro-animations
    const allButtons = document.querySelectorAll("button, .btn, input[type='submit'], a[href*='dashboard'], a[href*='edit'], a[href*='create'], form button");
    allButtons.forEach(btn => {
        // Skip navigation links and smaller inline toggles unless they look like actions
        if (btn.tagName === 'A' && !btn.className.includes("py-") && !btn.className.includes("btn")) return;
        if (btn.classList.contains("profile-btn") || btn.id === "profile-btn") return;

        // Apply smooth transition defaults
        btn.classList.add("transition-all", "duration-200", "ease-in-out", "active:scale-[0.97]", "focus:outline-none", "focus:ring-2", "focus:ring-offset-2");
        
        // Add dynamic focus ring coloring based on semantic action
        const text = btn.textContent.toLowerCase();
        if (btn.className.includes("emerald") || btn.className.includes("green") || text.includes("save") || text.includes("submit") || text.includes("create")) {
            btn.classList.add("focus:ring-emerald-500/50");
        } else if (btn.className.includes("red") || btn.className.includes("rose") || text.includes("delete")) {
            btn.classList.add("focus:ring-red-500/50");
        } else {
            btn.classList.add("focus:ring-primary/40");
        }
    });
});

