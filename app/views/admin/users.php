<?php // app/views/admin/users.php ?>
<?php use App\Core\Session; ?>

<section class="pt-28 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins mb-2">User Management</h1>
                <p class="text-gray-500 text-lg">Manage user accounts and roles</p>
            </div>
            <a href="/admin/users/create" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add User
            </a>
        </div>

        <!-- Flash Messages -->
        <?php $flash = Session::getFlash(); ?>
        <?php if (!empty($flash['success'])): ?>
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl"><?= $flash['success'] ?></div>
        <?php endif; ?>
        <?php if (!empty($flash['error'])): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl"><?= $flash['error'] ?></div>
        <?php endif; ?>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm mb-6">
            <form method="GET" action="/admin/users" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" placeholder="Search by name, email..."
                       class="flex-grow px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm">
                <select name="role" class="px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary outline-none text-sm bg-white">
                    <option value="">All Roles</option>
                    <?php foreach ($roles ?? [] as $key => $label): ?>
                    <option value="<?= $key ?>" <?= ($filters['role'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl font-medium text-sm hover:bg-primary-dark transition-all">Search</button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full" id="users-table">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Major</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if (!empty($users['data'])): ?>
                            <?php foreach ($users['data'] as $user): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors" id="user-row-<?= $user['id'] ?>">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                        </div>
                                        <span class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($user['name']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($user['class'] ?? '-') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($user['major'] ?? '-') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                                <td class="px-6 py-4">
                                    <select onchange="confirmRoleChange(<?= $user['id'] ?>, '<?= htmlspecialchars($user['name']) ?>', '<?= $user['role'] ?>', this.value, this)"
                                            class="role-select px-3 py-1.5 rounded-lg border text-sm font-medium outline-none cursor-pointer transition-all
                                            <?php if ($user['role'] === 'admin'): ?> bg-red-50 border-red-200 text-red-700
                                            <?php elseif ($user['role'] === 'teacher'): ?> bg-purple-50 border-purple-200 text-purple-700
                                            <?php else: ?> bg-blue-50 border-blue-200 text-blue-700
                                            <?php endif; ?>">
                                        <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>User</option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="/admin/users/<?= $user['id'] ?>/edit" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (($users['totalPages'] ?? 1) > 1): ?>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-sm text-gray-500">Showing page <?= $users['page'] ?> of <?= $users['totalPages'] ?> (<?= $users['total'] ?> total)</p>
                <div class="flex gap-1">
                    <?php for ($p = 1; $p <= $users['totalPages']; $p++): ?>
                    <a href="/admin/users?page=<?= $p ?>&role=<?= urlencode($filters['role'] ?? '') ?>&search=<?= urlencode($filters['search'] ?? '') ?>"
                       class="px-3 py-1.5 rounded-lg text-sm font-medium <?= $p === $users['page'] ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?> transition-all">
                        <?= $p ?>
                    </a>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Confirmation Modal -->
<div id="role-modal" class="fixed inset-0 z-[999] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative transform transition-all scale-95 opacity-0" id="modal-content">
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.07 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">Confirm Role Change</h3>
                <p class="text-gray-500 mb-6" id="modal-message">Are you sure?</p>
                <div class="flex gap-3">
                    <button onclick="closeModal()" class="flex-1 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">Cancel</button>
                    <button onclick="executeRoleChange()" class="flex-1 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all" id="modal-confirm">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-24 right-6 z-[1000] transform translate-x-full opacity-0 transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-center gap-3 min-w-[300px]">
        <div id="toast-icon" class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"></div>
        <p id="toast-message" class="text-sm font-medium text-gray-700"></p>
    </div>
</div>

<script>
let pendingChange = null;

function confirmRoleChange(userId, userName, oldRole, newRole, selectEl) {
    if (oldRole === newRole) return;

    pendingChange = { userId, userName, oldRole, newRole, selectEl };

    const roleLabels = { student: 'User', admin: 'Admin', teacher: 'Teacher' };
    document.getElementById('modal-message').innerHTML = 
        `Change <strong>${userName}</strong>'s role from <strong>${roleLabels[oldRole] || oldRole}</strong> to <strong>${roleLabels[newRole] || newRole}</strong>?`;

    const modal = document.getElementById('role-modal');
    const content = document.getElementById('modal-content');
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const content = document.getElementById('modal-content');
    content.classList.add('scale-95', 'opacity-0');
    content.classList.remove('scale-100', 'opacity-100');
    setTimeout(() => {
        document.getElementById('role-modal').classList.add('hidden');
        // Revert select
        if (pendingChange) {
            pendingChange.selectEl.value = pendingChange.oldRole;
            pendingChange = null;
        }
    }, 200);
}

function executeRoleChange() {
    if (!pendingChange) return;

    const btn = document.getElementById('modal-confirm');
    btn.textContent = 'Saving...';
    btn.disabled = true;

    fetch(`/api/users/${pendingChange.userId}/role`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ role: pendingChange.newRole })
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = 'Confirm';
        btn.disabled = false;

        const content = document.getElementById('modal-content');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => document.getElementById('role-modal').classList.add('hidden'), 200);

        if (data.success) {
            showToast(data.message, 'success');
            // Update select styling
            updateSelectStyle(pendingChange.selectEl, pendingChange.newRole);
        } else {
            showToast(data.message, 'error');
            pendingChange.selectEl.value = pendingChange.oldRole;
        }
        pendingChange = null;
    })
    .catch(() => {
        btn.textContent = 'Confirm';
        btn.disabled = false;
        showToast('Network error. Please try again.', 'error');
        if (pendingChange) {
            pendingChange.selectEl.value = pendingChange.oldRole;
            pendingChange = null;
        }
    });
}

function updateSelectStyle(el, role) {
    el.className = 'role-select px-3 py-1.5 rounded-lg border text-sm font-medium outline-none cursor-pointer transition-all ';
    if (role === 'admin') el.className += 'bg-red-50 border-red-200 text-red-700';
    else if (role === 'teacher') el.className += 'bg-purple-50 border-purple-200 text-purple-700';
    else el.className += 'bg-blue-50 border-blue-200 text-blue-700';
}

function showToast(message, type) {
    const toast = document.getElementById('toast');
    const icon = document.getElementById('toast-icon');
    const msg = document.getElementById('toast-message');

    msg.textContent = message;
    if (type === 'success') {
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600';
        icon.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
    } else {
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-red-100 text-red-600';
        icon.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
    }

    toast.classList.remove('translate-x-full', 'opacity-0');
    toast.classList.add('translate-x-0', 'opacity-100');

    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        toast.classList.remove('translate-x-0', 'opacity-100');
    }, 4000);
}
</script>
