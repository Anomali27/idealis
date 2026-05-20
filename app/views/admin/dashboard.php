<?php
/**
 * Admin Dashboard - Complete Modernized Tabular Interface
 * PIC Social Activity & Volunteer Management System
 */
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

// Extract data from controller
$recentEvents = $allEvents ?? [];
$totalEvents = $totalEvents ?? count($recentEvents);
$totalUsers = $totalUsers ?? 0;
$totalSuggestions = $totalSuggestions ?? 0;
$pendingSuggestions = $pendingSuggestions ?? 0;

$allUsers = $allUsers ?? [];
$allSuggestions = $allSuggestions ?? [];
$volunteers = $volunteers ?? [];
$donations = $donations ?? [];
?>

<!-- Main Layout Container (pt clears fixed navbar on all screen sizes, font matches landing page base) -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 pt-16 lg:pt-20 font-crimson antialiased">
    
    <!-- Header with Stats (Sticky header top-16/top-20 and z-30 resolves profile dropdown overlay z-50) -->
    <div class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-16 lg:top-20 z-30 shadow-sm transition-all duration-300">
        <div class="max-w-[1600px] mx-auto px-6 py-6 lg:pl-28">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 to-slate-700 bg-clip-text text-transparent font-poppins tracking-tight">
                        Admin Dashboard
                    </h1>
                    <p class="text-base text-slate-600 mt-1 font-crimson text-lg">Manage your school's social activities & volunteers</p>
                </div>
                <!-- Top Stat Cards Bento Grid (Poppins metrics) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 min-w-[320px] lg:min-w-[550px]">
                    <!-- Total Users -->
                    <div class="group bg-gradient-to-br from-blue-500 to-blue-600 text-white p-4 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                        <div class="p-2 bg-white/20 rounded-xl shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-[10px] uppercase font-bold tracking-wider opacity-80 font-poppins">Users</p>
                            <p class="text-xl font-black font-poppins"><?= number_format($totalUsers) ?></p>
                        </div>
                    </div>

                    <!-- Total Events -->
                    <div class="group bg-gradient-to-br from-emerald-500 to-emerald-600 text-white p-4 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                        <div class="p-2 bg-white/20 rounded-xl shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-[10px] uppercase font-bold tracking-wider opacity-80 font-poppins">Events</p>
                            <p class="text-xl font-black font-poppins"><?= $totalEvents ?></p>
                        </div>
                    </div>

                    <!-- Suggestions -->
                    <div class="group bg-gradient-to-br from-purple-500 to-purple-600 text-white p-4 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                        <div class="p-2 bg-white/20 rounded-xl shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5A1 1 0 117.868 6.5 3 3 0 0113 9c0 .93-.78 1.58-1.318 2.03-.54.457-.682.717-.682.97a1 1 0 11-2 0c0-1.05.66-1.74 1.32-2.3.45-.38.68-.625.68-.7c0-.55-.45-1-1-1zM9 15a1 1 0 112 0 1 1 0 01-2 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-[10px] uppercase font-bold tracking-wider opacity-80 font-poppins">Ideas Box</p>
                            <p class="text-xl font-black font-poppins"><?= $totalSuggestions ?></p>
                        </div>
                    </div>

                    <!-- Pending Suggestions -->
                    <div class="group bg-gradient-to-br from-orange-500 to-orange-600 text-white p-4 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                        <div class="p-2 bg-white/20 rounded-xl shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.924 2.617a.997.997 0 00-.215-.322l-.004-.004A.997.997 0 0017 2h-4a1 1 0 100 2h1.586l-4.793 4.793a1 1 0 101.414 1.414L16 5.414V7a1 1 0 102 0V3a.997.997 0 00-.076-.383z" />
                                <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm8-3a1 1 0 00-.867.5A1 1 0 117.868 6.5 3 3 0 0113 9c0 .93-.78 1.58-1.318 2.03-.54.457-.682.717-.682.97a1 1 0 11-2 0c0-1.05.66-1.74 1.32-2.3.45-.38.68-.625.68-.7c0-.55-.45-1-1-1zM9 15a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-[10px] uppercase font-bold tracking-wider opacity-80 font-poppins">Pending</p>
                            <p class="text-xl font-black font-poppins"><?= $pendingSuggestions ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container with left padding to align content with stats header (perfectly centering the layouts) -->
    <div class="max-w-[1600px] mx-auto px-6 py-10 lg:pl-28 flex flex-col justify-center">
        <div class="relative w-full">
            
            <!-- Sidebar Navigation (Fixed Far-Left, Collapses to Icons, Expands smoothly on Hover) -->
            <aside class="fixed left-0 top-16 lg:top-20 bottom-0 z-40 bg-white/90 backdrop-blur-md border-r border-slate-200 shadow-xl w-16 lg:w-20 hover:w-64 transition-all duration-300 ease-in-out group flex flex-col py-8 px-3 lg:px-4 space-y-2 hidden lg:flex">
                <div class="px-2 mb-6 border-b border-slate-100 pb-4 overflow-hidden shrink-0">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 font-poppins">Quick Navigation</h3>
                </div>
                <nav class="space-y-1.5 flex-1">
                    <!-- Events Button -->
                    <button onclick="showSection('events')"
                        class="w-full flex items-center p-3 rounded-xl hover:bg-blue-50 text-slate-500 hover:text-blue-600 font-medium transition-all group-hover:px-4 cursor-pointer outline-none <?php echo ($_GET['tab'] ?? 'events') == 'events' ? 'bg-blue-50 text-blue-600 border border-blue-200 shadow-sm font-semibold' : ''; ?>">
                        <svg class="w-6 h-6 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-poppins text-sm">Events</span>
                    </button>

                    <!-- Users Button -->
                    <button onclick="showSection('users')"
                        class="w-full flex items-center p-3 rounded-xl hover:bg-indigo-50 text-slate-500 hover:text-indigo-600 font-medium transition-all group-hover:px-4 cursor-pointer outline-none <?php echo ($_GET['tab'] ?? '') == 'users' ? 'bg-indigo-50 text-indigo-600 border border-indigo-200 shadow-sm font-semibold' : ''; ?>">
                        <svg class="w-6 h-6 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-poppins text-sm">Users</span>
                    </button>

                    <!-- Suggestions Button -->
                    <button onclick="showSection('forms')"
                        class="w-full flex items-center p-3 rounded-xl hover:bg-purple-50 text-slate-500 hover:text-purple-600 font-medium transition-all group-hover:px-4 cursor-pointer outline-none <?php echo ($_GET['tab'] ?? '') == 'forms' ? 'bg-purple-50 text-purple-600 border border-purple-200 shadow-sm font-semibold' : ''; ?>">
                        <svg class="w-6 h-6 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <span class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-poppins text-sm">Suggestions</span>
                    </button>

                    <!-- Fundraisers Button -->
                    <button onclick="showSection('fundraisers')"
                        class="w-full flex items-center p-3 rounded-xl hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 font-medium transition-all group-hover:px-4 cursor-pointer outline-none <?php echo ($_GET['tab'] ?? '') == 'fundraisers' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200 shadow-sm font-semibold' : ''; ?>">
                        <svg class="w-6 h-6 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-poppins text-sm">Fundraisers</span>
                    </button>

                    <!-- Volunteers Button -->
                    <button onclick="showSection('volunteers')"
                        class="w-full flex items-center p-3 rounded-xl hover:bg-orange-50 text-slate-500 hover:text-orange-600 font-medium transition-all group-hover:px-4 cursor-pointer outline-none <?php echo ($_GET['tab'] ?? '') == 'volunteers' ? 'bg-orange-50 text-orange-600 border border-orange-200 shadow-sm font-semibold' : ''; ?>">
                        <svg class="w-6 h-6 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-poppins text-sm">Volunteers</span>
                    </button>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 w-full min-w-0 transition-all duration-300">
                
                <!-- EVENTS SECTION (CARDS VIEW WITH CRUD) -->
                <section id="events" class="section-content animate-fadeIn">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 font-poppins">Events Management</h3>
                            <p class="text-xs text-slate-500 mt-0.5 font-crimson text-base">Organize, track, and audit school volunteer events, outreach programs, and fundraisers.</p>
                        </div>
                        <a href="/events/create" class="bg-primary hover:bg-primary-light text-white px-5 py-2.5 rounded-xl text-xs font-bold font-poppins transition-all shadow-md text-center inline-block">
                            + Create New Event
                        </a>
                    </div>
                    
                    <?php if (empty($recentEvents)): ?>
                        <div class="bg-white rounded-3xl p-12 text-center text-slate-400 font-crimson text-lg border border-slate-100 shadow-sm">
                            No events created yet. Click "+ Create New Event" to get started!
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <?php foreach ($recentEvents as $event): ?>
                                <?php 
                                    $target = (float)($event['target_donation'] ?? 0);
                                    $collected = (float)($event['collected_donation'] ?? 0);
                                    $percent = $target > 0 ? min(100, round(($collected / $target) * 100)) : 0;
                                ?>
                                <div class="bg-white rounded-3xl border border-slate-100 shadow-md hover:shadow-xl hover:border-primary/20 transition-all duration-300 flex flex-col h-full group overflow-hidden relative">
                                    <!-- Event Image Header -->
                                    <div class="relative h-48 w-full overflow-hidden shrink-0 bg-slate-100">
                                        <?php if (!empty($event['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($event['image_url']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-gradient-to-br from-primary/10 to-primary-light/5 flex items-center justify-center font-bold text-primary font-poppins text-3xl">
                                                PIC EVENT
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Top tags / badge overlay -->
                                        <div class="absolute top-4 left-4 right-4 flex justify-between items-center pointer-events-none">
                                            <?php if ($target > 0): ?>
                                                <span class="px-2.5 py-1 bg-emerald-500/90 backdrop-blur-sm text-white text-[9px] font-extrabold rounded-lg tracking-wider uppercase font-poppins">
                                                    Fundraiser
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2.5 py-1 bg-blue-500/90 backdrop-blur-sm text-white text-[9px] font-extrabold rounded-lg tracking-wider uppercase font-poppins">
                                                    Volunteering
                                                </span>
                                            <?php endif; ?>
                                            
                                            <span class="px-2.5 py-1 bg-white/95 backdrop-blur-sm text-slate-800 text-[10px] font-bold rounded-lg font-poppins shadow-sm">
                                                <?= date('d M Y', strtotime($event['date'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Content area -->
                                    <div class="p-6 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-lg font-bold text-slate-900 font-poppins group-hover:text-primary transition-colors mb-2 leading-snug">
                                                <?= htmlspecialchars($event['name']) ?>
                                            </h4>
                                            
                                            <p class="text-slate-500 text-sm leading-relaxed mb-6 font-crimson text-base line-clamp-3">
                                                <?= htmlspecialchars($event['description'] ?? 'No description provided for this social activity event.') ?>
                                            </p>
                                        </div>
                                        
                                        <div class="space-y-4">
                                            <!-- Stats line (volunteers + target) -->
                                            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 font-poppins">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-base">🧑‍🤝‍🧑</span>
                                                    <span><?= $event['volunteer_count'] ?> Volunteers</span>
                                                </div>
                                                <?php if ($target > 0): ?>
                                                    <div class="text-right">
                                                        <span class="block text-[10px] text-slate-400 font-medium font-poppins">Target goal</span>
                                                        <span class="font-extrabold text-slate-800">Rp<?= number_format($target, 0, ',', '.') ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Progress Bar (for fundraising campaigns) -->
                                            <?php if ($target > 0): ?>
                                                <div class="space-y-1.5 font-poppins">
                                                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-600">
                                                        <span>Raised: Rp<?= number_format($collected, 0, ',', '.') ?></span>
                                                        <span class="text-emerald-600"><?= $percent ?>%</span>
                                                    </div>
                                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden border border-slate-50">
                                                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full transition-all duration-500" style="width: <?= $percent ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- CRUD Action Footer Grid -->
                                    <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between gap-2 shrink-0 font-poppins">
                                        <!-- View / Manage -->
                                        <a href="/events/<?= $event['id'] ?>" class="flex-1 px-3 py-2 bg-white border border-slate-200 hover:border-primary text-slate-600 hover:text-primary text-xs font-bold rounded-xl transition-all shadow-sm flex items-center justify-center gap-1.5 text-center">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        
                                        <!-- Edit -->
                                        <a href="/events/<?= $event['id'] ?>/edit" class="flex-1 px-3 py-2 bg-white border border-slate-200 hover:border-amber-500 text-slate-600 hover:text-amber-600 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center justify-center gap-1.5 text-center">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        <!-- Delete -->
                                        <form action="/events/<?= $event['id'] ?>/delete" method="POST" class="flex-1 inline-block" onsubmit="return confirm('Are you sure you want to permanently delete event \'<?= htmlspecialchars($event['name']) ?>\'?')">
                                            <button type="submit" class="w-full px-3 py-2 bg-white border border-slate-200 hover:border-red-500 text-slate-500 hover:text-red-600 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center justify-center gap-1.5 text-center cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- USERS SECTION (TABULAR VIEW) -->
                <section id="users" class="section-content hidden animate-fadeIn">
                    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 font-poppins">Users Directory</h3>
                                <p class="text-xs text-slate-500 mt-0.5 font-crimson text-base">Filter, audit, and manage roles for students, teachers, committee members, and administrator accounts.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="/admin/users/create" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2.5 rounded-xl text-xs font-bold font-poppins transition-all shadow-md">
                                    + Create User
                                </a>
                                <a href="/admin/users" class="bg-primary hover:bg-primary-light text-white px-4 py-2.5 rounded-xl text-xs font-bold font-poppins transition-all shadow-md">
                                    Open Full Manager
                                </a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 font-poppins">
                                        <th class="px-8 py-4">Account Name</th>
                                        <th class="px-6 py-4">Email Address</th>
                                        <th class="px-6 py-4">Account Role</th>
                                        <th class="px-6 py-4">NIS / Class Details</th>
                                        <th class="px-6 py-4">Account Status</th>
                                        <th class="px-6 py-4">Registration Date</th>
                                        <th class="px-8 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-poppins">
                                    <?php foreach ($allUsers as $user): ?>
                                        <?php 
                                            $role = strtolower($user['role'] ?? 'student');
                                            $roleClass = 'bg-blue-50 text-blue-600 border-blue-100';
                                            if ($role === 'admin') $roleClass = 'bg-red-50 text-red-600 border-red-100';
                                            if ($role === 'committee') $roleClass = 'bg-amber-50 text-amber-600 border-amber-100';
                                            if ($role === 'teacher') $roleClass = 'bg-indigo-50 text-indigo-600 border-indigo-100';

                                            $isActive = $user['is_active'] ?? true;
                                            $statusClass = $isActive ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600';
                                        ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-8 py-4 font-bold text-slate-900">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-primary font-poppins shrink-0">
                                                        <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                                                    </div>
                                                    <span class="font-poppins"><?= htmlspecialchars($user['name']) ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-xs font-semibold text-slate-500 font-poppins"><?= htmlspecialchars($user['email']) ?></td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-0.5 text-[10px] font-bold border rounded uppercase tracking-wider font-poppins <?= $roleClass ?>">
                                                    <?= htmlspecialchars($user['role']) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-xs font-semibold text-slate-700 font-poppins">
                                                <?= $user['nis'] ? htmlspecialchars($user['nis']) : '-' ?> 
                                                <span class="text-[10px] text-slate-400 font-normal block font-crimson"><?= $user['class'] ? htmlspecialchars($user['class']) : '' ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded uppercase tracking-wider font-poppins <?= $statusClass ?>">
                                                    <?= $isActive ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-slate-400 font-poppins">
                                                <?= date('d M Y', strtotime($user['created_at'])) ?>
                                            </td>
                                            <td class="px-8 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- Edit Action -->
                                                    <a href="/admin/users/<?= $user['id'] ?>/edit" class="p-1.5 border border-slate-200 hover:border-amber-500 text-slate-500 hover:text-amber-600 rounded-lg transition-all bg-white" title="Edit User">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <!-- Delete Action -->
                                                    <?php if ($user['id'] !== Session::getUserId()): ?>
                                                        <form action="/admin/users/<?= $user['id'] ?>/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete user \'<?= htmlspecialchars($user['name']) ?>\'?')">
                                                            <button type="submit" class="p-1.5 border border-slate-200 hover:border-red-500 text-slate-500 hover:text-red-600 rounded-lg transition-all bg-white cursor-pointer" title="Delete User">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- SUGGESTIONS SECTION (CARDS VIEW WITH FULL DATABASE ACTIONS) -->
                <section id="forms" class="section-content hidden animate-fadeIn">
                    <?php
                    // Calculate stats for Suggestions Bento Grid inside Dashboard
                    $totalCount = count($allSuggestions);
                    $pendingCount = 0;
                    $reviewedCount = 0;
                    $implementedCount = 0;

                    foreach ($allSuggestions as $s) {
                        $st = strtolower($s['status']);
                        if ($st === 'pending') $pendingCount++;
                        if ($st === 'reviewed' || $st === 'responded') $reviewedCount++;
                        if ($st === 'implemented') $implementedCount++;
                    }
                    ?>
                    
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 font-poppins">Suggestions & Ideas Box</h3>
                        <p class="text-xs text-slate-500 mt-0.5 font-crimson text-base">Review, audit, and respond to activity requests submitted by students and school members.</p>
                    </div>

                    <!-- Statistics Bento Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10 font-poppins">
                        <!-- Total Stats -->
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-primary/20 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-gray-400 uppercase">Total Ideas</span>
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold text-gray-900"><?= $totalCount ?></h3>
                                <p class="text-xs text-gray-500 mt-1">Submitted suggestions</p>
                            </div>
                        </div>

                        <!-- Pending Stats -->
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-amber-400/30 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-gray-400 uppercase">Pending Review</span>
                                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold text-amber-600"><?= $pendingCount ?></h3>
                                <p class="text-xs text-gray-500 mt-1">Requires responses</p>
                            </div>
                        </div>

                        <!-- Reviewed Stats -->
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-indigo-400/30 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-gray-400 uppercase">Reviewed</span>
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold text-indigo-600"><?= $reviewedCount ?></h3>
                                <p class="text-xs text-gray-500 mt-1">Responded by Admin</p>
                            </div>
                        </div>

                        <!-- Implemented Stats -->
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-md border border-gray-100 hover:shadow-xl hover:border-emerald-400/30 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-gray-400 uppercase">Implemented</span>
                                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold text-emerald-600"><?= $implementedCount ?></h3>
                                <p class="text-xs text-gray-500 mt-1">Active / Finished activities</p>
                            </div>
                        </div>
                    </div>

                    <!-- Suggestions Cards Grid -->
                    <?php if (empty($allSuggestions)): ?>
                        <div class="text-center py-20 px-4 bg-white rounded-3xl shadow-sm border border-gray-100 max-w-4xl mx-auto">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">No Suggestions Found</h3>
                            <p class="text-gray-500 max-w-md mx-auto">No suggestions match the current filters. Adjust your search or filters to explore others.</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($allSuggestions as $suggestion): ?>
                                <?php 
                                    $status = strtolower($suggestion['status']);
                                    $statusClass = 'bg-gray-100 text-gray-700';
                                    if ($status === 'pending') $statusClass = 'bg-amber-100 text-amber-700';
                                    if ($status === 'reviewed' || $status === 'responded') $statusClass = 'bg-blue-100 text-blue-700';
                                    if ($status === 'implemented') $statusClass = 'bg-emerald-100 text-emerald-700';
                                    if ($status === 'rejected') $statusClass = 'bg-red-100 text-red-700';
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
                                    <div id="respond-form-<?= $suggestion['id'] ?>" class="hidden border-t border-gray-100 pt-4 mt-2 animate-fadeIn font-poppins">
                                        <form action="/suggestions/<?= $suggestion['id'] ?>/respond" method="POST" class="space-y-3">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-700 mb-1">Write Response</label>
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
                                    <div class="flex items-center gap-2 mt-auto pt-4 border-t border-gray-50 font-poppins">
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
                </section>

                <!-- FUNDRAISERS SECTION (CARDS VIEW) -->
                <section id="fundraisers" class="section-content hidden animate-fadeIn">
                    <div class="space-y-8 font-poppins">
                        <!-- Active Campaigns (Cards View) -->
                        <div>
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-gray-900 font-poppins">Active Fundraiser Campaigns</h3>
                                <p class="text-xs text-slate-500 mt-0.5 font-crimson text-base">Monitor target goals, collection rates, and real-time donation progress for active school fundraiser programs.</p>
                            </div>
                            
                            <?php $fundraiserCount = 0; ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php foreach ($recentEvents as $event): ?>
                                    <?php if (!empty($event['target_donation']) && $event['target_donation'] > 0): ?>
                                        <?php 
                                            $target = (float)$event['target_donation'];
                                            $collected = (float)$event['collected_donation'];
                                            $percent = $target > 0 ? min(100, round(($collected / $target) * 100)) : 0;
                                            $fundraiserCount++;
                                        ?>
                                        <div class="bg-white rounded-3xl border border-slate-100 shadow-md hover:shadow-xl hover:border-emerald-500/20 transition-all duration-300 flex flex-col justify-between overflow-hidden p-6 group">
                                            <div>
                                                <!-- Card Header with status badge -->
                                                <div class="flex justify-between items-center mb-4">
                                                    <span class="px-2.5 py-1 text-[9px] font-extrabold rounded-md uppercase tracking-wider font-poppins <?= $percent >= 100 ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600 animate-pulse' ?>">
                                                        <?= $percent >= 100 ? 'Completed' : 'Active' ?>
                                                    </span>
                                                    <span class="text-xs font-semibold text-slate-400 font-poppins">
                                                        Target Campaign
                                                    </span>
                                                </div>
                                                
                                                <!-- Campaign Title -->
                                                <h4 class="text-lg font-bold text-slate-900 font-poppins group-hover:text-emerald-600 transition-colors mb-3 leading-snug">
                                                    <?= htmlspecialchars($event['name']) ?>
                                                </h4>
                                                
                                                <!-- Description snippet -->
                                                <p class="text-slate-500 text-sm leading-relaxed mb-6 font-crimson text-base line-clamp-2">
                                                    <?= htmlspecialchars($event['description'] ?? 'No description provided for this fundraising event.') ?>
                                                </p>
                                            </div>
                                            
                                            <div class="space-y-4">
                                                <!-- Progress Stats -->
                                                <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-4 font-poppins">
                                                    <div>
                                                        <span class="block text-[10px] text-slate-400 font-medium uppercase font-poppins">Amount Raised</span>
                                                        <span class="text-lg font-black text-emerald-600">Rp<?= number_format($collected, 0, ',', '.') ?></span>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="block text-[10px] text-slate-400 font-medium uppercase font-poppins">Target Goal</span>
                                                        <span class="text-lg font-black text-slate-800">Rp<?= number_format($target, 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Horizontal Progress Bar -->
                                                <div class="space-y-1.5 font-poppins">
                                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden border border-slate-50">
                                                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full transition-all duration-500" style="width: <?= $percent ?>%"></div>
                                                    </div>
                                                    <div class="flex items-center justify-between text-xs font-bold text-slate-600">
                                                        <span>Progress</span>
                                                        <span class="text-emerald-600"><?= $percent ?>%</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Audit Button -->
                                                <a href="/events/<?= $event['id'] ?>" class="w-full py-2.5 bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 text-slate-600 hover:text-emerald-700 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center justify-center gap-1.5 text-center font-poppins cursor-pointer">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                    Audit Campaign
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            
                            <?php if ($fundraiserCount === 0): ?>
                                <div class="bg-white rounded-3xl p-12 text-center text-slate-400 font-crimson text-lg border border-slate-100 shadow-sm">
                                    No active event fundraisers currently.
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Donations Attempts Log Table (Tabular View) -->
                        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
                            <div class="px-8 py-6 border-b border-slate-100">
                                <h3 class="text-xl font-bold text-gray-900 font-poppins">Donation Transaction Log</h3>
                                <p class="text-xs text-slate-500 mt-0.5 font-crimson text-base">Track, audit, and verify direct financial contributions submitted for public events.</p>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse whitespace-nowrap">
                                    <thead>
                                        <tr class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 font-poppins">
                                            <th class="px-8 py-4">Donor Name</th>
                                            <th class="px-6 py-4">Target Campaign</th>
                                            <th class="px-6 py-4">Donation Amount</th>
                                            <th class="px-6 py-4">Payment Channel</th>
                                            <th class="px-6 py-4">Verification Status</th>
                                            <th class="px-8 py-4 text-right">Transaction Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-poppins">
                                        <?php if (empty($donations)): ?>
                                            <tr><td colspan="6" class="px-8 py-12 text-center text-slate-400 font-crimson text-lg">No donations registered in the system yet.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($donations as $don): ?>
                                                <?php 
                                                    $status = strtolower($don['status']);
                                                    $statusClass = 'bg-amber-50 text-amber-600';
                                                    if ($status === 'verified') $statusClass = 'bg-emerald-50 text-emerald-600';
                                                    if ($status === 'rejected') $statusClass = 'bg-rose-50 text-rose-600';
                                                ?>
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-8 py-4 font-bold text-slate-900 font-poppins">
                                                        <?= htmlspecialchars($don['donor_name'] ?: 'Anonymous Donor') ?>
                                                        <span class="block text-[10px] text-slate-400 font-normal font-crimson italic mt-0.5"><?= htmlspecialchars($don['message'] ?? '') ?></span>
                                                    </td>
                                                    <td class="px-6 py-4 text-xs font-semibold text-slate-700 font-poppins"><?= htmlspecialchars($don['event_name'] ?: 'General Fundraiser') ?></td>
                                                    <td class="px-6 py-4 font-black text-slate-900 text-xs font-poppins">Rp<?= number_format($don['amount'], 0, ',', '.') ?></td>
                                                    <td class="px-6 py-4">
                                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-slate-100 text-slate-600 rounded uppercase font-poppins">
                                                            <?= htmlspecialchars($don['payment_method']) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="px-2 py-0.5 text-[10px] font-extrabold rounded uppercase tracking-wider font-poppins <?= $statusClass ?>">
                                                            <?= htmlspecialchars($don['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-4 text-right text-xs text-slate-400 font-poppins">
                                                        <?= date('d M Y H:i', strtotime($don['donated_at'])) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- VOLUNTEERS SECTION (TABULAR VIEW) -->
                <section id="volunteers" class="section-content hidden animate-fadeIn">
                    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden font-poppins">
                        <div class="px-8 py-6 border-b border-slate-100">
                            <h3 class="text-xl font-bold text-gray-900 font-poppins">Volunteer Registrations Log</h3>
                            <p class="text-xs text-slate-500 mt-0.5 font-crimson text-base">Track, coordinate, and review student and teacher registrations for school social activities.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 font-poppins">
                                        <th class="px-8 py-4">Volunteer Name</th>
                                        <th class="px-6 py-4">Email Address</th>
                                        <th class="px-6 py-4">Account Role</th>
                                        <th class="px-6 py-4">Registered Event Name</th>
                                        <th class="px-8 py-4 text-right">Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm text-slate-600 font-poppins">
                                    <?php if (empty($volunteers)): ?>
                                        <tr>
                                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-crimson text-lg">
                                                No volunteer registrations registered in the database.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($volunteers as $vol): ?>
                                            <?php 
                                                $role = strtolower($vol['user_role'] ?? 'student');
                                                $roleClass = 'bg-blue-50 text-blue-600 border-blue-100';
                                                if ($role === 'admin') $roleClass = 'bg-red-50 text-red-600 border-red-100';
                                                if ($role === 'committee') $roleClass = 'bg-amber-50 text-amber-600 border-amber-100';
                                                if ($role === 'teacher') $roleClass = 'bg-indigo-50 text-indigo-600 border-indigo-100';
                                            ?>
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-8 py-4 font-bold text-slate-900 font-poppins">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center font-bold text-primary shrink-0">
                                                            <?= strtoupper(substr($vol['user_name'] ?? 'V', 0, 1)) ?>
                                                        </div>
                                                        <span><?= htmlspecialchars($vol['user_name']) ?></span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-xs font-semibold text-slate-500 font-poppins"><?= htmlspecialchars($vol['user_email']) ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-0.5 text-[10px] font-bold border rounded uppercase tracking-wider font-poppins <?= $roleClass ?>">
                                                        <?= htmlspecialchars($vol['user_role']) ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-xs font-bold text-slate-700 hover:text-primary font-poppins">
                                                    <a href="/events/<?= $vol['event_id'] ?>"><?= htmlspecialchars($vol['event_name']) ?></a>
                                                    <span class="text-[9px] text-slate-400 block font-normal font-crimson mt-0.5">Event Date: <?= date('d M Y', strtotime($vol['event_date'])) ?></span>
                                                </td>
                                                <td class="px-8 py-4 text-right text-xs text-slate-400 font-poppins">
                                                    <?= date('d M Y H:i', strtotime($vol['created_at'])) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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
            btn.classList.remove('border', 'border-blue-200', 'border-indigo-200', 'border-purple-200', 'border-emerald-200', 'border-orange-200', 'shadow-sm', 'font-semibold');
            btn.classList.add('text-slate-500');
            // Hapus background color khusus tab
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
        const activeBtn = document.querySelector(`button[onclick="showSection('${section}')"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-500');
            activeBtn.classList.add('shadow-sm', 'font-semibold');

            // Sesuaikan warna berdasarkan tab
            if (section === 'events') activeBtn.classList.add('bg-blue-50', 'text-blue-600', 'border', 'border-blue-200');
            if (section === 'users') activeBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'border', 'border-indigo-200');
            if (section === 'forms') activeBtn.classList.add('bg-purple-50', 'text-purple-600', 'border', 'border-purple-200');
            if (section === 'fundraisers') activeBtn.classList.add('bg-emerald-50', 'text-emerald-600', 'border', 'border-emerald-200');
            if (section === 'volunteers') activeBtn.classList.add('bg-orange-50', 'text-orange-600', 'border', 'border-orange-200');
        }

        // 5. Update URL tanpa reload
        window.history.pushState({}, '', `?tab=${section}`);
    }

    // Initialize active tab from URL query parameter
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'events';
        showSection(activeTab);
    });

    // Toggle response form for suggestions box
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

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.25s ease-out forwards;
    }
</style>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>