<?php // app/views/events/edit.php ?>
<?php use App\Core\Session; ?>

<section class="pt-28 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/events/<?= $event['id'] ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Event
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins">Edit Event</h1>
            <p class="text-gray-500 mt-2">Update event details below. All changes will be saved to the database.</p>
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

        <!-- Edit Form -->
        <form action="/events/<?= $event['id'] ?>/update" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Current Image Preview -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Current Image</label>
                <div class="relative h-48 rounded-2xl overflow-hidden bg-gray-100 mb-4">
                    <img src="<?= htmlspecialchars($event['image_url'] ?? '/assets/images/event/eco-exploration-project.png') ?>" 
                         alt="Current" class="w-full h-full object-cover" id="image-preview">
                </div>
                <label class="block">
                    <span class="text-sm text-gray-500 mb-1 block">Upload New Image (optional)</span>
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/5 file:text-primary hover:file:bg-primary/10 transition-all cursor-pointer">
                </label>
            </div>

            <!-- Event Name -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Event Name *</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($event['name'] ?? '') ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 font-medium">
            </div>

            <!-- Date -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Event Date *</label>
                <input type="date" name="date" id="date" value="<?= htmlspecialchars($event['date'] ?? '') ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
            </div>

            <!-- Description -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="10"
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 leading-relaxed resize-y"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
            </div>

            <!-- Target Donation -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <label for="target_donation" class="block text-sm font-semibold text-gray-700 mb-2">Target Donation (Rp)</label>
                <input type="number" name="target_donation" id="target_donation" value="<?= htmlspecialchars($event['target_donation'] ?? '') ?>" min="0" step="1000"
                       placeholder="Leave empty if no donation target"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
                <p class="text-xs text-gray-400 mt-2">Current total donation: <strong class="text-primary">Rp <?= number_format($event['total_donation'] ?? 0, 0, ',', '.') ?></strong></p>
            </div>

            <!-- Top Donors (Read-only info) -->
            <?php if (!empty($topDonors)): ?>
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Current Top Donors (computed dynamically)</h3>
                <div class="space-y-2">
                    <?php foreach ($topDonors as $i => $donor): ?>
                    <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-xl text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center"><?= $i + 1 ?></span>
                            <span class="font-medium text-gray-700"><?= htmlspecialchars($donor['donor_name']) ?></span>
                            <span class="text-gray-400"><?= htmlspecialchars($donor['donor_class'] ?? '') ?></span>
                        </div>
                        <span class="font-bold text-primary">Rp <?= number_format($donor['amount'], 0, ',', '.') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-xs text-gray-400 mt-3 italic">Note: Top donors are computed dynamically from the donations table and cannot be edited directly here.</p>
            </div>
            <?php endif; ?>

            <!-- Submit -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-grow py-3.5 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
                <a href="/events/<?= $event['id'] ?>" class="px-8 py-3.5 bg-white text-gray-700 border border-gray-200 font-semibold rounded-xl hover:bg-gray-50 transition-all text-center">
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
            document.getElementById('image-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
