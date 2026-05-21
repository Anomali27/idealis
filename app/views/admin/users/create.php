<?php // app/views/admin/users/create.php ?>
<?php use App\Core\Session; ?>
<?php require_once dirname(dirname(__DIR__)) . '/layouts/header.php'; ?>
<?php require_once dirname(dirname(__DIR__)) . '/layouts/navbar.php'; ?>

<section class="pt-28 pb-16 bg-gray-50 min-h-screen font-poppins">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/admin/dashboard?tab=users" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins">Create New User</h1>
            <p class="text-gray-500 mt-2">Add a student, teacher, committee member, or administrator account.</p>
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

        <!-- Form Card -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl">
            <form action="/admin/users/store" method="POST" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" id="name" required placeholder="e.g. John Doe"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 font-medium">
                    </div>
                    
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" id="email" required placeholder="e.g. johndoe@school.com"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                        <input type="password" name="password" id="password" required placeholder="Minimum 6 characters"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
                    </div>
                    
                    <!-- Account Role -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Account Role *</label>
                        <select name="role" id="role"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 font-medium">
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="committee">Committee Member</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <!-- Student specific fields -->
                <div id="student-fields" class="grid grid-cols-1 md:grid-cols-3 gap-6 p-5 bg-slate-50 rounded-2xl border border-slate-100 transition-all">
                    <div>
                        <label for="nis" class="block text-xs font-bold text-gray-600 uppercase mb-2">NIS (Student Number)</label>
                        <input type="text" name="nis" id="nis" placeholder="e.g. 10928374"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white outline-none transition-all text-gray-900 font-medium">
                    </div>
                    <div>
                        <label for="class" class="block text-xs font-bold text-gray-600 uppercase mb-2">Class Details</label>
                        <input type="text" name="class" id="class" placeholder="e.g. Class 12 Science A"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white outline-none transition-all text-gray-900 font-medium">
                    </div>
                    <div>
                        <label for="major" class="block text-xs font-bold text-gray-600 uppercase mb-2">Major / Department</label>
                        <input type="text" name="major" id="major" placeholder="e.g. Software Eng."
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white outline-none transition-all text-gray-900 font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" placeholder="e.g. +62 812 3456 789"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900">
                    </div>

                    <!-- Account Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">Account Status *</label>
                        <select name="is_active" id="is_active"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-gray-900 font-medium">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Submit buttons -->
                <div class="flex gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="flex-grow py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl transition-all shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Create User Account
                    </button>
                    <a href="/admin/dashboard?tab=users" class="px-8 py-3.5 bg-white text-gray-700 border border-gray-200 font-semibold rounded-xl hover:bg-gray-50 transition-all text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const studentFields = document.getElementById('student-fields');

    if (!roleSelect || !studentFields) return;

    function toggleStudentFields() {
        if (roleSelect.value === 'student') {
            studentFields.style.display = 'grid';
            // Trigger reflow to let CSS transitions work
            studentFields.offsetHeight;
            studentFields.style.opacity = '1';
            studentFields.style.transform = 'translateY(0)';
        } else {
            studentFields.style.opacity = '0';
            studentFields.style.transform = 'translateY(-10px)';
            // Hide after the animation finishes
            setTimeout(() => {
                if (roleSelect.value !== 'student') {
                    studentFields.style.display = 'none';
                }
            }, 300);
        }
    }

    // Set dynamic animation properties
    studentFields.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

    // Set initial state
    if (roleSelect.value === 'student') {
        studentFields.style.display = 'grid';
        studentFields.style.opacity = '1';
        studentFields.style.transform = 'translateY(0)';
    } else {
        studentFields.style.display = 'none';
        studentFields.style.opacity = '0';
        studentFields.style.transform = 'translateY(-10px)';
    }

    roleSelect.addEventListener('change', toggleStudentFields);
});
</script>

<?php require_once dirname(dirname(__DIR__)) . '/layouts/footer.php'; ?>
