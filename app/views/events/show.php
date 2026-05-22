<?php // app/views/events/show.php ?>
<?php use App\Core\Session; ?>
<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>
<?php require_once dirname(__DIR__) . '/layouts/navbar.php'; ?>

<!-- Event Detail Hero -->
<section class="relative pt-20">
    <!-- Back Button Overlay -->
    <div class="absolute top-24 left-4 sm:left-8 lg:left-12 z-20">
        <a href="/events" class="inline-flex items-center gap-2 px-4 py-2 bg-black/40 hover:bg-black/60 backdrop-blur-md border border-white/20 text-white font-medium rounded-xl transition-all shadow-lg text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
    </div>

    <div class="relative h-[40vh] md:h-[50vh] overflow-hidden">
        <img src="<?= htmlspecialchars($event['image_url'] ?? '/assets/images/event/eco-exploration-project.png') ?>" 
             alt="<?= htmlspecialchars($event['name']) ?>" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full border border-white/30">
                        <?= date('l, d F Y', strtotime($event['date'])) ?>
                    </span>
                    <?php if (($event['total_donation'] ?? 0) > 0): ?>
                    <span class="px-4 py-1.5 bg-emerald-500/80 backdrop-blur-sm text-white text-sm font-semibold rounded-full">
                        💰 Rp <?= number_format($event['total_donation'], 0, ',', '.') ?> raised
                    </span>
                    <?php endif; ?>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-white font-poppins leading-tight max-w-4xl">
                    <?= htmlspecialchars($event['name']) ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- Event Content -->
<section class="pt-12 pb-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Main Content (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Date</p>
                        <p class="text-sm font-bold text-gray-900"><?= date('d M Y', strtotime($event['date'])) ?></p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Participants</p>
                        <p class="text-sm font-bold text-gray-900"><?= $event['participant_count'] ?? 0 ?> joined</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Organizer</p>
                        <p class="text-sm font-bold text-gray-900"><?= htmlspecialchars($event['creator_name'] ?? 'PIC Committee') ?></p>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6 flex items-center gap-3">
                        <div class="w-1 h-8 bg-primary rounded-full"></div>
                        About This Event
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
<?= htmlspecialchars($event['description'] ?? '') ?>
                    </div>
                </div>

                <!-- Participants List -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-6 flex items-center gap-3">
                        <div class="w-1 h-8 bg-primary rounded-full"></div>
                        Participants
                    </h2>
                    
                    <?php if (!empty($participants)): ?>
                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-gray-900 font-semibold uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 rounded-tl-xl whitespace-nowrap">Name</th>
                                        <th class="px-6 py-4 whitespace-nowrap">Donation Amount</th>
                                        <th class="px-6 py-4 rounded-tr-xl whitespace-nowrap">Class</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($participants as $participant): ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold flex-shrink-0">
                                                    <?= htmlspecialchars(substr($participant['name'], 0, 1)) ?>
                                                </div>
                                                <span class="font-medium text-gray-900"><?= htmlspecialchars($participant['name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php if (($participant['donation_amount'] ?? 0) > 0): ?>
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-medium text-xs border border-emerald-100">
                                                    Rp <?= number_format($participant['donation_amount'], 0, ',', '.') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-gray-400 italic text-xs">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 font-medium text-sm whitespace-nowrap">
                                            <?= htmlspecialchars($participant['class'] ?? 'N/A') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <p class="text-gray-500 font-medium">No participants yet.</p>
                            <p class="text-sm text-gray-400 mt-1">Be the first to join this event!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Admin Actions -->
                <?php if ($isAdmin ?? false): ?>
                <div class="flex gap-3">
                    <a href="/events/<?= $event['id'] ?>/edit" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-amber-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Event
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar (1/3) -->
            <div class="space-y-6">
                <!-- Donation Progress Card -->
                <?php if (!empty($event['target_donation']) && $event['target_donation'] > 0): ?>
                <?php $progress = min(100, ($event['total_donation'] / $event['target_donation']) * 100); ?>
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 font-poppins mb-4 flex items-center gap-2">
                        <span class="text-2xl">💰</span> Donation Progress
                    </h3>
                    <div class="text-center mb-4">
                        <p class="text-3xl font-bold text-primary font-poppins">Rp <?= number_format($event['total_donation'], 0, ',', '.') ?></p>
                        <p class="text-sm text-gray-400 mt-1">of Rp <?= number_format($event['target_donation'], 0, ',', '.') ?> target</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden mb-2">
                        <div class="h-full rounded-full bg-gradient-to-r from-primary to-emerald-500 transition-all duration-1000 relative" style="width: <?= $progress ?>%">
                            <div class="absolute inset-0 bg-white/30 animate-pulse rounded-full"></div>
                        </div>
                    </div>
                    <p class="text-right text-sm font-semibold text-primary mb-5"><?= number_format($progress, 1) ?>% reached</p>
                    
                    <!-- Donate Button -->
                    <?php if ($isLoggedIn ?? false): ?>
                        <button onclick="document.getElementById('donation-modal').classList.remove('hidden')" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Donate Now
                        </button>
                    <?php else: ?>
                        <a href="/auth/login" class="w-full py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                            Login to Donate
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Top Donors -->
                <?php if (!empty($topDonors)): ?>
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 font-poppins mb-5 flex items-center gap-2">
                        <span class="text-2xl">🏆</span> Top Donors
                    </h3>
                    <div class="space-y-4">
                        <?php foreach ($topDonors as $i => $donor): ?>
                        <div class="flex items-start gap-3 p-3 rounded-xl <?= $i === 0 ? 'bg-amber-50 border border-amber-100' : 'bg-gray-50' ?> transition-all hover:scale-[1.02]">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm
                                <?php if ($i === 0): ?> bg-amber-400 text-white
                                <?php elseif ($i === 1): ?> bg-gray-300 text-white
                                <?php elseif ($i === 2): ?> bg-amber-700 text-white
                                <?php else: ?> bg-gray-200 text-gray-600
                                <?php endif; ?>">
                                <?= $i + 1 ?>
                            </div>
                            <div class="min-w-0 flex-grow">
                                <p class="font-semibold text-gray-900 text-sm truncate"><?= htmlspecialchars($donor['donor_name']) ?></p>
                                <p class="text-xs text-gray-400"><?= htmlspecialchars($donor['donor_class'] ?? '') ?></p>
                                <p class="text-sm font-bold text-primary mt-1">Rp <?= number_format($donor['amount'], 0, ',', '.') ?></p>
                                <?php if (!empty($donor['message'])): ?>
                                <p class="text-xs text-gray-500 mt-1 italic line-clamp-2">"<?= htmlspecialchars($donor['message']) ?>"</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<!-- Sticky CTA Footer -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="hidden sm:block">
            <p class="font-bold text-gray-900"><?= htmlspecialchars($event['name']) ?></p>
            <p class="text-sm text-gray-500 font-medium"><span class="text-primary font-bold"><?= $event['participant_count'] ?? 0 ?></span> currently participating</p>
        </div>
        <div class="flex-grow sm:flex-grow-0 flex justify-center sm:justify-end">
            <?php if (!($isLoggedIn ?? false)): ?>
                <a href="/auth/login" class="w-full sm:w-auto px-8 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20 text-center flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Login to Participate
                </a>
            <?php elseif ($isParticipant ?? false): ?>
                <button disabled class="w-full sm:w-auto px-8 py-3.5 bg-emerald-50 text-emerald-700 font-semibold rounded-xl border border-emerald-200 cursor-not-allowed text-center flex items-center justify-center gap-2 transition-all">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    You are participating
                </button>
            <?php else: ?>
                <form action="/events/<?= $event['id'] ?>/join" method="POST" class="w-full sm:w-auto"
                      data-confirm="Are you sure you want to participate in this event?"
                      data-confirm-title="Confirm Participation"
                      data-confirm-btn="Confirm">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Participate Now
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Donation Modal -->
<?php if (($isLoggedIn ?? false) && !empty($event['target_donation']) && $event['target_donation'] > 0): ?>
<div id="donation-modal" class="fixed inset-0 z-[999] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('donation-modal').classList.add('hidden')"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 font-poppins flex items-center gap-2">
                    <span class="text-2xl">💖</span> Make a Donation
                </h3>
                <button onclick="document.getElementById('donation-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form action="/events/<?= $event['id'] ?>/donate" method="POST" class="space-y-4"
                  data-confirm="Are you sure you want to submit this donation?"
                  data-confirm-title="Confirm Donation"
                  data-confirm-btn="Confirm">
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-1">Amount (Rp) *</label>
                    <input type="number" name="amount" id="amount" min="1000" step="1000" required placeholder="Example: 50000"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-gray-900 font-medium">
                </div>
                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Message (Optional)</label>
                    <textarea name="message" id="message" rows="3" placeholder="Leave a message of support..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-gray-900 resize-none"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                        Confirm Donation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
