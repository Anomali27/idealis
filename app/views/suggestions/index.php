<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$suggestions = $suggestions ?? [];
$filters = $filters ?? [];
$statuses = $statuses ?? [];
$categories = $categories ?? [];

// Calculate stats for Bento Grid
$totalCount = count($suggestions);
$pendingCount = 0;
$reviewedCount = 0;
$implementedCount = 0;

foreach ($suggestions as $s) {
    $st = strtolower($s['status']);
    if ($st === 'pending') $pendingCount++;
    if ($st === 'reviewed' || $st === 'responded') $reviewedCount++;
    if ($st === 'implemented') $implementedCount++;
}
?>

<!-- Header Section (Consistent with User Suggestion Page) -->
<section class="relative bg-gradient-to-br from-primary via-primary-dark to-primary pt-28 pb-16 overflow-hidden font-poppins shadow-md">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm text-white/90 text-sm font-semibold rounded-full border border-white/20 mb-6">
            💡 Admin & Committee Control
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
            Suggestions <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-amber-200">Management</span>
        </h1>
        <p class="text-lg text-white/80 max-w-2xl mx-auto">
            Review and manage volunteer events and activity suggestions submitted by students and teachers.
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Alerts -->
        <?php if ($error): ?>
            <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3 text-red-600 font-medium animate-fadeIn">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-600 font-medium animate-fadeIn">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Bento Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
            <!-- Total Stats -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-primary/20 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase font-poppins">Total Ideas</span>
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-gray-900 font-poppins"><?= $totalCount ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Submitted suggestions</p>
                </div>
            </div>

            <!-- Pending Stats -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-amber-400/30 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase font-poppins">Pending Review</span>
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-amber-600 font-poppins"><?= $pendingCount ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Requires responses</p>
                </div>
            </div>

            <!-- Reviewed Stats -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-indigo-400/30 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase font-poppins">Reviewed</span>
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-indigo-600 font-poppins"><?= $reviewedCount ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Responded by Admin</p>
                </div>
            </div>

            <!-- Implemented Stats -->
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-emerald-400/30 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase font-poppins">Implemented</span>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-emerald-600 font-poppins"><?= $implementedCount ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Active / Finished activities</p>
                </div>
            </div>
        </div>



        <!-- Suggestions Cards Grid -->
        <?php if (empty($suggestions)): ?>
            <div class="text-center py-20 px-4 bg-white rounded-3xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">No Suggestions Found</h3>
                <p class="text-gray-500 max-w-md mx-auto">No suggestions match the current filters. Adjust your search or filters to explore others.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($suggestions as $suggestion): ?>
                    <?php 
                        $status = strtolower($suggestion['status']);
                        $statusClass = 'bg-gray-100 text-gray-700';
                        if ($status === 'pending') $statusClass = 'bg-amber-100 text-amber-700';
                        if ($status === 'reviewed' || $status === 'responded') $statusClass = 'bg-blue-100 text-blue-700';
                        if ($status === 'implemented') $statusClass = 'bg-emerald-100 text-emerald-700';
                        if ($status === 'rejected') $statusClass = 'bg-red-100 text-red-700';

                        // Display category label nicely
                        $catLabel = $categories[$suggestion['category']] ?? ucfirst($suggestion['category']);
                    ?>
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-md hover:border-primary/20 hover:shadow-xl transition-all duration-300 flex flex-col h-full group relative" id="card-<?= $suggestion['id'] ?>">
                        <!-- Header badge elements -->
                        <div class="flex justify-end items-start mb-4 gap-2">
                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-lg <?= $statusClass ?>">
                                <?= htmlspecialchars($status === 'reviewed' ? 'Reviewed' : ucfirst($status)) ?>
                            </span>
                        </div>
                        
                        <!-- Suggestion Title -->
                        <h3 class="text-lg font-bold text-gray-900 font-poppins mb-3 group-hover:text-primary transition-colors leading-snug">
                            <?= htmlspecialchars($suggestion['title']) ?>
                        </h3>
                        
                        <!-- Suggestion Description -->
                        <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1 font-crimson text-base">
                            <?= htmlspecialchars($suggestion['description']) ?>
                        </p>
                        
                        <!-- Author Metadata section -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs text-gray-400 gap-3 border-t border-gray-100 pt-4 mb-4 font-poppins">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-primary/10 text-primary font-bold rounded-full flex items-center justify-center shrink-0">
                                    <?= strtoupper(substr($suggestion['user_name'] ?? 'A', 0, 1)) ?>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-gray-700 leading-tight"><?= htmlspecialchars($suggestion['user_name'] ?? 'Anonymous') ?></span>
                                    <span class="text-[10px] text-gray-400"><?= htmlspecialchars($suggestion['user_email'] ?? 'No email') ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span><?= date('d M Y', strtotime($suggestion['created_at'])) ?></span>
                            </div>
                        </div>

                        <!-- Existing response if present -->
                        <?php if (!empty($suggestion['response'])): ?>
                            <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-4 mb-4">
                                <div class="flex items-center gap-2 text-blue-800 font-bold text-xs mb-1.5 font-poppins">
                                    <svg class="w-4 h-4 shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    Admin Response
                                </div>
                                <p class="text-blue-900/80 text-xs italic font-crimson text-sm leading-relaxed">
                                    "<?= htmlspecialchars($suggestion['response']) ?>"
                                </p>
                            </div>
                        <?php endif; ?>

                        <!-- Interactive response expand form -->
                        <div id="respond-form-<?= $suggestion['id'] ?>" class="hidden border-t border-gray-100 pt-4 mt-2 animate-fadeIn">
                            <form action="/suggestions/<?= $suggestion['id'] ?>/respond" method="POST" class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 font-poppins">Write Response</label>
                                    <textarea name="response" rows="3" required placeholder="Type your response to the volunteer suggestion..."
                                              class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-xs text-gray-800 placeholder-gray-400 transition-all resize-none"></textarea>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="toggleResponseForm(<?= $suggestion['id'] ?>)" class="px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition-all font-poppins">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-1.5 bg-primary hover:bg-primary-dark text-white text-xs font-semibold rounded-lg transition-all shadow-md shadow-primary/20 font-poppins">
                                        Submit Response
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Action controls -->
                        <div class="flex items-center gap-2 mt-auto pt-4 border-t border-gray-50">
                            <?php if ($suggestion['status'] === 'pending'): ?>
                                <button onclick="toggleResponseForm(<?= $suggestion['id'] ?>)" class="px-3 py-2 bg-primary/10 hover:bg-primary/20 text-primary font-bold text-[10px] md:text-xs uppercase tracking-wider rounded-xl transition-all flex-1 text-center font-poppins">
                                    💬 Respond
                                </button>
                                <a href="/suggestions/<?= $suggestion['id'] ?>/implement" class="px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-100 font-bold text-[10px] md:text-xs uppercase tracking-wider rounded-xl transition-all flex-1 text-center font-poppins" onclick="return confirm('Mark this suggestion as implemented?')">
                                    ✅ Implement
                                </a>
                                <a href="/suggestions/<?= $suggestion['id'] ?>/reject" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 font-bold text-[10px] md:text-xs uppercase tracking-wider rounded-xl transition-all flex-1 text-center font-poppins" onclick="return confirm('Reject this suggestion?')">
                                    ❌ Reject
                                </a>
                            <?php endif; ?>
                            <form action="/suggestions/<?= $suggestion['id'] ?>/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this suggestion?')">
                                <button type="submit" class="p-2 bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-600 rounded-xl transition-all cursor-pointer" title="Delete Suggestion">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Inline Javascript for toggling and animations -->
<script>
function toggleResponseForm(id) {
    const form = document.getElementById('respond-form-' + id);
    if (form.classList.contains('hidden')) {
        // Hide all other active response forms first
        document.querySelectorAll('[id^="respond-form-"]').forEach(el => el.classList.add('hidden'));
        form.classList.remove('hidden');
        form.querySelector('textarea').focus();
    } else {
        form.classList.add('hidden');
    }
}
</script>

<!-- Add fading animations -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.25s ease-out forwards;
}
</style>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
