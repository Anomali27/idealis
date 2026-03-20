<?php
// Admin Dashboard - Clean Version
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = Session::getFlash('error');
$success = Session::getFlash('success');

$activityStats = $data['activityStats'] ?? [];
$totalUsers = $data['totalUsers'] ?? 0;
$pendingSuggestions = $data['pendingSuggestions'] ?? 0;
$recentActivities = $data['recentActivities'] ?? [];
$recentVolunteers = $data['recentVolunteers'] ?? [];
$recentDonations = $data['recentDonations'] ?? [];
$totalDonations = $data['totalDonations'] ?? 0;
$totalVolunteers = $data['totalVolunteers'] ?? 0;
$userName = $data['userName'] ?? '';
?>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
            <p class="text-xl text-gray-600">Welcome back, <?= htmlspecialchars($userName) ?>!</p>
        </div>

        <!-- Alerts -->
        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg mb-8">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-8">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900"><?= number_format($totalUsers) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                <div class="flex items-center">
                    <div class="p-3 bg-emerald-100 rounded-lg">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Events</p>
                        <p class="text-3xl font-bold text-gray-900"><?= $activityStats['total'] ?? 0 ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Volunteers</p>
                        <p class="text-3xl font-bold text-gray-900"><?= number_format($totalVolunteers) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-lg">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08 .402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Donations</p>
                        <p class="text-3xl font-bold text-gray-900">Rp <?= number_format($totalDonations) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="/activities/create" class="group p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-dashed border-blue-200 hover:border-blue-300 hover:shadow-lg transition-all text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">New Activity</h3>
                    <p class="text-gray-600">Create a new event or volunteer opportunity</p>
                </a>

                <a href="/admin/users" class="group p-6 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border-2 border-dashed border-emerald-200 hover:border-emerald-300 hover:shadow-lg transition-all text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-200 transition-colors">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Manage Users</h3>
                    <p class="text-gray-600">View and manage all registered users</p>
                </a>

                <a href="/suggestions" class="group p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-2 border-dashed border-purple-200 hover:border-purple-300 hover:shadow-lg transition-all text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Suggestions</h3>
                    <p class="text-gray-600"><?= $pendingSuggestions ?> pending</p>
                </a>
            </div>
        </div>

        <!-- Recent Items Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Activities -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Recent Activities
                </h3>
                <div class="space-y-3">
                    <?php if (empty($recentActivities)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p>No recent activities</p>
                        </div>
                    <?php else: ?>
                        <?php foreach (array_slice($recentActivities, 0, 5) as $activity): ?>
                            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div>
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars(substr($activity['title'], 0, 30)) ?>...</p>
                                    <p class="text-sm text-gray-500"><?= date('M j', strtotime($activity['activity_date'])) ?></p>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                    <?= ucfirst($activity['status'] ?? 'unknown') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Volunteers -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Recent Volunteers
                </h3>
                <div class="space-y-3">
                    <?php if (empty($recentVolunteers)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p>No volunteers yet</p>
                        </div>
                    <?php else: ?>
                        <?php foreach (array_slice($recentVolunteers, 0, 5) as $volunteer): ?>
                            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div>
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars(substr($volunteer['user_name'], 0, 25)) ?></p>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars(substr($volunteer['activity_title'] ?? '', 0, 25)) ?>...</p>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded-full">
                                    <?= ucfirst($volunteer['status'] ?? 'pending') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Donations -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Recent Donations
                </h3>
                <div class="space-y-3">
                    <?php if (empty($recentDonations)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            <p>No donations yet</p>
                        </div>
                    <?php else: ?>
                        <?php foreach (array_slice($recentDonations, 0, 5) as $donation): ?>
                            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div>
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars(substr($donation['donor_name'], 0, 20)) ?></p>
                                    <p class="text-sm text-gray-500">Rp <?= number_format($donation['amount'] ?? 0) ?></p>
                                </div>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full">
                                    <?= ucfirst($donation['status'] ?? 'pending') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>

