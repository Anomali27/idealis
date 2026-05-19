<?php // app/views/events/index.php ?>
<?php use App\Core\Session; ?>

<!-- Events Page Hero Banner -->
<section class="relative bg-gradient-to-br from-primary via-primary-dark to-primary pt-28 pb-16 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm text-white/90 text-sm font-semibold rounded-full border border-white/20 mb-6">
                📅 Discover Our Events
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white font-poppins mb-4 leading-tight">
                Events & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-emerald-300">Latest News</span>
            </h1>
            <p class="text-lg text-white/70 max-w-2xl mx-auto">
                Explore our community events, make a difference through donations, and stay updated with the latest highlights from PIC.
            </p>
        </div>
    </div>
</section>

<!-- Events Grid Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins mb-2">All Events</h2>
                <p class="text-gray-500 text-lg">Showing <?= count($events ?? []) ?> events from our community</p>
            </div>
            <?php if ($isAdmin ?? false): ?>
            <a href="/activities/create" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Event
            </a>
            <?php endif; ?>
        </div>

        <!-- 2x5 Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                <div class="group relative bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-1 transition-all duration-500 flex flex-col h-full" id="event-card-<?= $event['id'] ?>">
                    <!-- Full Card Link -->
                    <a href="/events/<?= $event['id'] ?>" class="absolute inset-0 z-0"><span class="sr-only">View Event Details</span></a>

                    <!-- Event Image (Top) -->
                    <div class="block h-52 relative overflow-hidden flex-shrink-0 pointer-events-none">
                        <img src="<?= htmlspecialchars($event['image_url'] ?? '/assets/images/event/eco-exploration-project.png') ?>" 
                             alt="<?= htmlspecialchars($event['name']) ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary shadow-sm">
                            <?= date('d M Y', strtotime($event['date'])) ?>
                        </div>
                    </div>

                    <!-- Event Content (Below Image) -->
                    <div class="p-5 sm:p-6 flex flex-col flex-grow justify-between pointer-events-none">
                        <div>
                            <div class="block mb-2">
                                <h3 class="text-lg font-bold text-gray-900 font-poppins line-clamp-2 group-hover:text-primary transition-colors">
                                    <?= htmlspecialchars($event['name']) ?>
                                </h3>
                            </div>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4 leading-relaxed">
                                <?= htmlspecialchars(mb_substr(strip_tags($event['description'] ?? ''), 0, 120)) ?>...
                            </p>

                            <!-- Stats Row -->
                            <div class="flex items-center gap-4 mb-4 text-sm">
                                <div class="flex items-center gap-1.5 text-gray-500">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <span class="font-medium text-gray-700"><?= $event['participant_count'] ?? 0 ?></span> joined
                                </div>
                                <?php if (($event['total_donation'] ?? 0) > 0): ?>
                                <div class="flex items-center gap-1.5 text-gray-500">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-medium text-gray-700">Rp <?= number_format($event['total_donation'], 0, ',', '.') ?></span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Donation Progress Bar -->
                            <?php if (!empty($event['target_donation']) && $event['target_donation'] > 0): ?>
                            <?php $progress = min(100, ($event['total_donation'] / $event['target_donation']) * 100); ?>
                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                                    <span>Donation Progress</span>
                                    <span class="font-semibold text-primary"><?= number_format($progress, 0) ?>%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-primary to-primary-light transition-all duration-1000" style="width: <?= $progress ?>%"></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex gap-2 pointer-events-auto relative z-10">
                            <a href="/events/<?= $event['id'] ?>" class="flex-grow py-2.5 bg-gray-50 hover:bg-primary text-primary hover:text-white border border-gray-200 hover:border-primary font-semibold rounded-xl text-center text-sm transition-all duration-300">
                                View Details
                            </a>
                            <?php if ($isAdmin ?? false): ?>
                            <a href="/events/<?= $event['id'] ?>/edit" class="px-4 py-2.5 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white border border-amber-200 hover:border-amber-500 font-semibold rounded-xl text-sm transition-all duration-300 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-16 text-center text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-lg font-medium">No events available yet</p>
                    <p class="text-sm mt-1">Check back soon for upcoming events!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Floating Suggestion Button -->
<a href="/suggestion" class="fixed bottom-10 right-8 z-[99] group flex items-center gap-3 bg-white text-primary font-semibold px-5 py-3 md:px-6 md:py-4 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgba(var(--color-primary-rgb),0.3)] hover:-translate-y-1 border border-gray-100 transition-all duration-300 font-poppins">
    <!-- Subtle Glow -->
    <div class="absolute inset-0 bg-primary/20 rounded-full blur-xl group-hover:bg-primary/30 transition-all duration-300 -z-10"></div>
    <div class="relative flex items-center justify-center w-8 h-8 md:w-10 md:h-10 bg-primary/10 rounded-full text-primary group-hover:scale-110 transition-transform duration-300">
        <svg class="w-5 h-5 md:w-6 md:h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path>
        </svg>
    </div>
    <span class="hidden md:block pr-2">Give Suggestion</span>
    <!-- Notification Dot -->
    <span class="absolute top-0 right-0 md:right-2 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
</a>
