<?php
/**
 * Admin Dashboard - Complete Tabbed Interface
 * PIC Social Activity & Volunteer Management System
 */
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

// Extract data from controller
$activityStats = $data['activityStats'] ?? [];
$totalUsers = $data['totalUsers'] ?? 0;
$pendingSuggestions = $data['pendingSuggestions'] ?? 0;
$recentActivities = $data['recentActivities'] ?? [];
$recentVolunteers = $data['recentVolunteers'] ?? [];
$recentDonations = $data['recentDonations'] ?? [];
$totalDonations = $data['totalDonations'] ?? 0;
$totalVolunteers = $data['totalVolunteers'] ?? 0;
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Header with Stats -->
    <div class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-20 z-50 shadow-sm mt-4">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-slate-700 bg-clip-text text-transparent">
                        Admin Dashboard</h1>
                    <p class="text-lg text-slate-600 mt-1">Manage your school's social activities & volunteers</p>
                </div>
                <!-- Top 4 Stat Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 min-w-[320px]">
                    <!-- Total Users -->
                    <div
                        class="group bg-gradient-to-br from-blue-500 to-blue-600 text-white p-4 rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                        <div class="flex items-center">
                            <div class="p-2 bg-white/20 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm opacity-90">Total Users</p>
                                <p class="text-2xl font-bold"><?= number_format($totalUsers) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Events -->
                    <div
                        class="group bg-gradient-to-br from-emerald-500 to-emerald-600 text-white p-4 rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                        <div class="flex items-center">
                            <div class="p-2 bg-white/20 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm opacity-90">Total Events</p>
                                <p class="text-2xl font-bold"><?= $activityStats['total'] ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Events Done -->
                    <div
                        class="group bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-4 rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                        <div class="flex items-center">
                            <div class="p-2 bg-white/20 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm opacity-90">Events Done</p>
                                <p class="text-2xl font-bold"><?= $activityStats['completed'] ?? 0 ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approvals -->
                    <div
                        class="group bg-gradient-to-br from-orange-500 to-orange-600 text-white p-4 rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                        <div class="flex items-center">
                            <div class="p-2 bg-white/20 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm opacity-90">Pending Volunteers</p>
                                <p class="text-2xl font-bold"><?= $totalVolunteers ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pt-32 pb-8 lg:pt-40">
        <div class="flex gap-8">
            <!-- Sidebar Navigation -->
            <div
                class="w-64 flex-shrink-0 hidden lg:block bg-white/70 backdrop-blur-md rounded-2xl shadow-lg border border-white/50 p-6 sticky top-28 h-fit">
                <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-4">Quick Navigation</h3>
                <nav class="space-y-2">
                    <button onclick="showSection('events')"
                        class="w-full flex items-center p-4 rounded-xl hover:bg-blue-50 hover:text-blue-600 font-medium transition-all <?php echo ($_GET['tab'] ?? 'events') == 'events' ? 'bg-blue-50 text-blue-600 border-2 border-blue-200 shadow-md' : ''; ?>">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Events
                    </button>
                    <button onclick="showSection('users')"
                        class="w-full flex items-center p-4 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all <?php echo ($_GET['tab'] ?? '') == 'users' ? 'bg-indigo-50 text-indigo-600 border-2 border-indigo-200 shadow-md' : ''; ?>">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </button>
                    <button onclick="showSection('fundraisers')"
                        class="w-full flex items-center p-4 rounded-xl hover:bg-green-50 hover:text-green-600 font-medium transition-all <?php echo ($_GET['tab'] ?? '') == 'fundraisers' ? 'bg-green-50 text-green-600 border-2 border-green-200 shadow-md' : ''; ?>">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                        Fundraisers
                    </button>
                    <button onclick="showSection('forms')"
                        class="w-full flex items-center p-4 rounded-xl hover:bg-purple-50 hover:text-purple-600 font-medium transition-all <?php echo ($_GET['tab'] ?? '') == 'forms' ? 'bg-purple-50 text-purple-600 border-2 border-purple-200 shadow-md' : ''; ?>">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Forms
                    </button>
                    <button onclick="showSection('volunteers')"
                        class="w-full flex items-center p-4 rounded-xl hover:bg-orange-50 hover:text-orange-600 font-medium transition-all <?php echo ($_GET['tab'] ?? '') == 'volunteers' ? 'bg-orange-50 text-orange-600 border-2 border-orange-200 shadow-md' : ''; ?>">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 01 5.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Volunteers
                    </button>
                </nav>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1">
                <!-- EVENTS SECTION (DEFAULT TAB) -->
                <section id="events" class="section-content">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">Events Management</h2>
                            <p class="text-lg text-slate-600 mt-1">Manage all school social activities and volunteer
                                events</p>
                        </div>
                        <a href="/activities/create"
                            class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg hover:shadow-xl hover:from-emerald-600 hover:to-emerald-700 transition-all text-lg">
                            + Create New Event
                        </a>
                    </div>

                    <!-- Events Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <!-- PHP LOOP STARTS HERE -->
                        <?php if (empty($recentActivities)): ?>
                            <div class="col-span-full text-center py-16">
                                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477. .947 7.5 7.5 13.5s3.332 2.023 5 2.023S13.5 13.477 15 11.5c1.053-2.023.523-4.477.947-6.5" />
                                </svg>
                                <h3 class="text-2xl font-semibold text-gray-900 mb-2">No events yet</h3>
                                <p class="text-gray-500">Get started by creating your first school event.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recentActivities as $activity): ?>
                                <div
                                    class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all hover:-translate-y-2 border border-gray-100">
                                    <!-- Event Image -->
                                    <div class="h-48 bg-gradient-to-br from-blue-400 to-indigo-500 relative overflow-hidden">
                                        <img src="/assets/images/event/<?= htmlspecialchars($activity['cover_image'] ?? 'default.jpg') ?>"
                                            alt="<?= htmlspecialchars($activity['title']) ?>"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                        <div class="absolute top-4 right-4">
                                            <span class="px-4 py-2 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm shadow-lg <?php
                                            if ($activity['status'] == 'completed') {
                                                echo 'text-green-700 bg-green-100';
                                            } elseif ($activity['status'] == 'ongoing') {
                                                echo 'text-orange-700 bg-orange-100';
                                            } else {
                                                echo 'text-blue-700 bg-blue-100';
                                            }
                                            ?>">
                                                <?= ucfirst($activity['status']) ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Event Content -->
                                    <div class="p-8">
                                        <h3
                                            class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                            <?= htmlspecialchars($activity['title']) ?>
                                        </h3>
                                        <p class="text-slate-600 mb-6 line-clamp-2">
                                            <?= htmlspecialchars(substr($activity['description'] ?? '', 0, 100)) ?>...
                                        </p>
                                        <div class="flex flex-wrap gap-2 mb-6 text-sm text-slate-500">
                                            <span>📍 <?= htmlspecialchars($activity['location']) ?></span>
                                            <span>📅 <?= date('M d, Y', strtotime($activity['activity_date'])) ?></span>
                                        </div>
                                        <div class="flex gap-3">
                                            <a href="/activities/<?= $activity['id'] ?>/edit"
                                                class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-6 rounded-xl font-semibold text-center hover:shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all">
                                                Edit Event
                                            </a>
                                            <?php if ($activity['status'] == 'completed'): ?>
                                                <form method="POST" action="/activities/<?= $activity['id'] ?>/delete"
                                                    class="flex-0">
                                                    <button type="submit"
                                                        class="bg-gradient-to-r from-red-500 to-red-600 text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg hover:from-red-600 hover:to-red-700 transition-all"
                                                        onclick="return confirm('Delete this completed event?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- PHP LOOP ENDS HERE -->
                    </div>
                </section>

                <!-- OTHER SECTIONS (hidden by default) -->
                <section id="users" class="section-content hidden">
                    <!-- Users table with filters will go here -->
                    <div class="text-center py-20">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Users Management</h2>
                        <p class="text-gray-500">Users table with role filters + Add/Edit/Delete (pagination included)
                        </p>
                    </div>
                </section>

                <section id="fundraisers" class="section-content hidden">
                    <!-- Fundraiser cards with progress bars -->
                    <div class="text-center py-20">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Fundraisers</h2>
                        <p class="text-gray-500">Event cards w/ donation progress bars (collected/target %)</p>
                    </div>
                </section>

                <section id="forms" class="section-content hidden">
                    <!-- Suggestions/Forms list -->
                    <div class="text-center py-20">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Forms & Suggestions</h2>
                        <p class="text-gray-500">(<?= $pendingSuggestions ?>) pending - Mark as reviewed</p>
                    </div>
                </section>

                <section id="volunteers" class="section-content hidden">
                    <!-- Pending approvals table + summary -->
                    <div class="text-center py-20">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Volunteers Management</h2>
                        <p class="text-gray-500">Pending approvals + event volunteer summary</p>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>

<script>
    function showSection(section) {
        // 1. Sembunyikan semua section
        document.querySelectorAll('.section-content').forEach(s => s.classList.add('hidden'));

        // 2. Tampilkan section yang dipilih
        document.getElementById(section).classList.remove('hidden');

        // 3. Reset style di semua tombol (hapus style aktif)
        document.querySelectorAll('nav button').forEach(btn => {
            // Hapus border & shadow
            btn.classList.remove('border-2', 'shadow-md');
            // Hapus background color khusus tab (blue/indigo/green/dsb)
            btn.classList.forEach(className => {
                if (className.startsWith('bg-') && className.endsWith('-50')) {
                    btn.classList.remove(className);
                }
                if (className.startsWith('text-') && className.endsWith('-600')) {
                    btn.classList.remove(className);
                }
            });
        });

        // 4. Tambahkan style aktif ke tombol yang di-klik
        // (Mencari tombol berdasarkan isi parameternya)
        const activeBtn = document.querySelector(`button[onclick="showSection('${section}')"]`);
        if (activeBtn) {
            activeBtn.classList.add('border-2', 'shadow-md');

            // Sesuaikan warna berdasarkan tab
            if (section === 'events') activeBtn.classList.add('bg-blue-50', 'text-blue-600', 'border-blue-200');
            if (section === 'users') activeBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'border-indigo-200');
            if (section === 'fundraisers') activeBtn.classList.add('bg-green-50', 'text-green-600', 'border-green-200');
            if (section === 'forms') activeBtn.classList.add('bg-purple-50', 'text-purple-600', 'border-purple-200');
            if (section === 'volunteers') activeBtn.classList.add('bg-orange-50', 'text-orange-600', 'border-orange-200');
        }

        // 5. Update URL tanpa reload
        window.history.pushState({}, '', `?tab=${section}`);
    }
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>