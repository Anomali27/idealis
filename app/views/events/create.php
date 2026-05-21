<?php // app/views/events/create.php ?>
<?php use App\Core\Session; ?>
<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>
<?php require_once dirname(__DIR__) . '/layouts/navbar.php'; ?>

<section class="pt-28 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/admin/dashboard?tab=events" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins">Create New Event</h1>
            <p class="text-gray-500 mt-2">Publish a new school volunteer event or fundraiser campaign.</p>
        </div>

        <!-- Flash Messages -->
        <?php $flash = Session::getFlash(); ?>
        <?php if (!empty($flash['success'])): ?>
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <?= $flash['success'] ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($flash['error'])): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <?= $flash['error'] ?>
        </div>
        <?php endif; ?>

        <!-- Create Form -->
        <form action="/events/store" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Image Upload Preview -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Event Banner Image</label>
                <div class="relative h-48 rounded-2xl overflow-hidden bg-gray-100 mb-4 border border-dashed border-gray-300 flex items-center justify-center">
                    <img src="" alt="Banner Preview" class="w-full h-full object-cover hidden" id="image-preview">
                    <div class="text-center p-6" id="upload-placeholder">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-1 text-sm text-gray-600">Click below to upload a banner photo</p>
                    </div>
                </div>
                <label class="block">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)" required
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/5 file:text-primary hover:file:bg-primary/10 transition-all cursor-pointer">
                </label>
            </div>

            <!-- Event Name -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Event Name *</label>
                <input type="text" name="name" id="name" required placeholder="e.g. Tree Planting and Eco Exploration Day"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 font-medium">
            </div>

            <!-- Date -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Event Date *</label>
                <input type="date" name="date" id="date" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
            </div>

            <!-- Description -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="8" placeholder="Provide background, agenda, and requirements for the volunteer activity..."
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 leading-relaxed resize-y"></textarea>
            </div>

            <!-- Target Donation -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="target_donation" class="block text-sm font-semibold text-gray-700 mb-2">Target Donation (Rp)</label>
                <input type="number" name="target_donation" id="target_donation" min="0" step="1000"
                       placeholder="e.g. 5000000 (leave empty if event does not accept donations)"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
                <p class="text-xs text-gray-400 mt-2">If left empty, this event will be treated as a standard volunteer event without a fundraising progress bar.</p>
            </div>

            <!-- Submit -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-grow py-3.5 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Publish Event
                </button>
                <a href="/admin/dashboard?tab=events" class="px-8 py-3.5 bg-white text-gray-700 border border-gray-200 font-semibold rounded-xl hover:bg-gray-50 transition-all text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</section>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
