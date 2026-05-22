<?php
// app/views/layouts/partials/modal_system.php
?>

<!-- Toast Notification -->
<div id="global-toast" class="fixed top-24 right-6 z-[1000] transform translate-x-full opacity-0 transition-all duration-300 font-poppins">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-center gap-3 min-w-[300px]">
        <div id="toast-icon" class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"></div>
        <p id="toast-message" class="text-sm font-medium text-gray-700"></p>
    </div>
</div>

<!-- Global Action/Status Modal (Loading/Success/Error) -->
<div id="global-action-modal" class="fixed inset-0 z-[999] hidden font-poppins">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="action-modal-backdrop"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl relative transform transition-all scale-95 opacity-0" id="action-modal-content">
            <div class="text-center" id="action-modal-inner">
                <!-- Content injected via JS -->
            </div>
            <div class="mt-6 text-center hidden" id="action-modal-close-container">
                <button onclick="closeActionModal()" class="py-2.5 px-6 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Global Confirmation Modal -->
<div id="global-confirm-modal" class="fixed inset-0 z-[999] hidden font-poppins">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative transform transition-all scale-95 opacity-0" id="confirm-modal-content">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" id="confirm-icon-container">
                    <svg class="w-8 h-8" id="confirm-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.07 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2" id="confirm-modal-title">Confirm Action</h3>
                <p class="text-gray-500 mb-6" id="confirm-modal-message">Are you sure?</p>
                <div class="flex gap-3">
                    <button onclick="closeConfirmModal()" class="flex-1 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all" id="confirm-modal-cancel-btn">Cancel</button>
                    <button onclick="executeConfirmAction()" class="flex-1 py-3 text-white font-semibold rounded-xl transition-all" id="confirm-modal-submit-btn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// --- TOAST SYSTEM ---
function showToast(message, type = 'info') {
    const toast = document.getElementById('global-toast');
    const icon = document.getElementById('toast-icon');
    const msg = document.getElementById('toast-message');

    msg.textContent = message;
    
    if(window.toastTimeout) clearTimeout(window.toastTimeout);
    if(window.toastHideTimeout) clearTimeout(window.toastHideTimeout);

    if (type === 'success') {
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600';
        icon.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
    } else if (type === 'error') {
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-red-100 text-red-600';
        icon.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
    } else if (type === 'warning') {
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-100 text-amber-600';
        icon.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
    } else {
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-100 text-blue-600';
        icon.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>';
    }

    toast.classList.remove('hidden');
    toast.classList.remove('translate-x-full', 'opacity-0');
    toast.classList.add('translate-x-0', 'opacity-100');

    window.toastTimeout = setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        toast.classList.remove('translate-x-0', 'opacity-100');
        window.toastHideTimeout = setTimeout(() => {
            // hidden after transition
        }, 300);
    }, 4000);
}

// --- ACTION MODAL SYSTEM (Loading/Success/Error Popup) ---
function showActionModal(type, message) {
    const modal = document.getElementById('global-action-modal');
    const content = document.getElementById('action-modal-content');
    const inner = document.getElementById('action-modal-inner');
    const closeBtn = document.getElementById('action-modal-close-container');
    const backdrop = document.getElementById('action-modal-backdrop');

    modal.classList.remove('hidden');
    
    // Animate in if closed
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);

    if (type === 'loading') {
        backdrop.onclick = null; // Prevent closing while loading
        closeBtn.classList.add('hidden');
        inner.innerHTML = `
            <div class="w-16 h-16 mx-auto mb-4 relative">
                <div class="absolute inset-0 rounded-full border-4 border-slate-100"></div>
                <div class="absolute inset-0 rounded-full border-4 border-primary border-t-transparent animate-spin"></div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">Please wait</h3>
            <p class="text-gray-500">${message}</p>
        `;
    } else if (type === 'success') {
        backdrop.onclick = closeActionModal;
        closeBtn.classList.remove('hidden');
        inner.innerHTML = `
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">Success</h3>
            <p class="text-gray-500">${message}</p>
        `;
    } else if (type === 'error') {
        backdrop.onclick = closeActionModal;
        closeBtn.classList.remove('hidden');
        inner.innerHTML = `
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">Error</h3>
            <p class="text-gray-500">${message}</p>
        `;
    }
}

function closeActionModal() {
    const content = document.getElementById('action-modal-content');
    content.classList.add('scale-95', 'opacity-0');
    content.classList.remove('scale-100', 'opacity-100');
    setTimeout(() => {
        document.getElementById('global-action-modal').classList.add('hidden');
    }, 200);
}


// --- CONFIRMATION MODAL SYSTEM ---
let globalConfirmCallback = null;

function showConfirmModal(title, message, onConfirm, type = 'danger', confirmText = 'Confirm') {
    globalConfirmCallback = onConfirm;

    const modal = document.getElementById('global-confirm-modal');
    const content = document.getElementById('confirm-modal-content');
    
    document.getElementById('confirm-modal-title').innerHTML = title;
    document.getElementById('confirm-modal-message').innerHTML = message;
    
    const submitBtn = document.getElementById('confirm-modal-submit-btn');
    submitBtn.textContent = confirmText;
    
    const iconContainer = document.getElementById('confirm-icon-container');
    const icon = document.getElementById('confirm-icon');

    // Reset classes
    submitBtn.className = 'flex-1 py-3 text-white font-semibold rounded-xl transition-all';
    iconContainer.className = 'w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4';

    if (type === 'danger') {
        submitBtn.classList.add('bg-red-600', 'hover:bg-red-700');
        iconContainer.classList.add('bg-red-100');
        icon.classList.value = 'w-8 h-8 text-red-600';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.07 16.5c-.77.833.192 2.5 1.732 2.5z"/>';
    } else if (type === 'warning') {
        submitBtn.classList.add('bg-amber-500', 'hover:bg-amber-600');
        iconContainer.classList.add('bg-amber-100');
        icon.classList.value = 'w-8 h-8 text-amber-600';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.07 16.5c-.77.833.192 2.5 1.732 2.5z"/>';
    } else {
        submitBtn.classList.add('bg-primary', 'hover:bg-primary-dark');
        iconContainer.classList.add('bg-blue-100');
        icon.classList.value = 'w-8 h-8 text-primary';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
    }

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeConfirmModal() {
    const content = document.getElementById('confirm-modal-content');
    content.classList.add('scale-95', 'opacity-0');
    content.classList.remove('scale-100', 'opacity-100');
    setTimeout(() => {
        document.getElementById('global-confirm-modal').classList.add('hidden');
        globalConfirmCallback = null;
    }, 200);
}

function executeConfirmAction() {
    if (globalConfirmCallback) {
        globalConfirmCallback();
    }
    closeConfirmModal();
}

// Global binding for forms with data-confirm attribute
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-confirm');
            const title = this.getAttribute('data-confirm-title') || 'Confirm Action';
            const type = this.getAttribute('data-confirm-type') || 'danger';
            const btnText = this.getAttribute('data-confirm-btn') || 'Confirm';
            
            showConfirmModal(title, message, () => {
                this.submit();
            }, type, btnText);
        });
    });
});
</script>
