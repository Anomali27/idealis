<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$categories = $data['categories'] ?? [];

?>

<!-- Header Section -->
<section class="relative bg-gradient-to-br from-primary via-primary-dark to-primary pt-28 pb-16 overflow-hidden font-poppins">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm text-white/90 text-sm font-semibold rounded-full border border-white/20 mb-6">
            💡 We Value Your Ideas
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
            Submit a <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-amber-200">Suggestion</span>
        </h1>
        <p class="text-lg text-white/80 max-w-2xl mx-auto">
            Help us improve PIC social activities with your ideas for new events or feedback on our current programs.
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Alerts -->
        <?php if ($error): ?>
            <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3 text-red-600 font-medium">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-600 font-medium">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
            <!-- Form Card (Left/Main) -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-8">Share Your Thoughts</h2>
                    
                    <form action="/suggestions/store" method="POST" class="space-y-6">

                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" required placeholder="Brief title of your suggestion"
                                   class="block w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors text-gray-900 placeholder-gray-400">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                            <textarea id="description" name="description" rows="5" required
                                      placeholder="Describe your suggestion in detail. What event would you like to see? How can it benefit the community?"
                                      class="block w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors text-gray-900 placeholder-gray-400 resize-y"></textarea>
                        </div>

                        <div class="bg-blue-50 text-blue-800 p-4 rounded-xl flex gap-3 text-sm">
                            <svg class="w-5 h-5 shrink-0 mt-0.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <p class="leading-relaxed">Your suggestion will be reviewed by our committee team. We appreciate your input in making PIC activities better!</p>
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-8 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 flex-1 md:flex-none text-center">
                                Submit Suggestion
                            </button>
                            <a href="/events" class="px-8 py-3.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all flex-1 md:flex-none text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card (Right/Sidebar) -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl p-8 sm:p-10 shadow-xl shadow-gray-200/50 border border-gray-100 h-full">
                    <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6">What can you suggest?</h2>
                    
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">New Event Ideas</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Propose new social activities, community services, or workshops that could benefit our school.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">System Improvements</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Suggest ways to improve our volunteer management and event registration process.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Feedback</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Share your thoughts about past activities, organizers, or any general feedback.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
