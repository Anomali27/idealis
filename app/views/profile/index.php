<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

<div class="pt-20 md:pt-24 pb-12 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Profile Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-24 h-24 md:w-32 md:h-32 bg-gradient-to-r from-primary to-primary-dark rounded-full shadow-2xl mb-6">
                <span class="text-3xl md:text-4xl font-bold text-white">
                    <?php 
                    $words = preg_split('/\\s+/', trim($user['name'] ?? ''));
                    echo strtoupper(($words[0][0] ?? '') . ($words[1][0] ?? '?'));
                    ?>
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($user['name'] ?? ''); ?></h1>
            <p class="text-xl text-gray-600 mb-1"><?php echo htmlspecialchars($user['role'] ?? ''); ?> • <?php echo htmlspecialchars($this->data['roleLabel'] ?? User::getRoleLabel($user['role'] ?? '')); ?></p>
            <p class="text-lg text-primary font-semibold"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
        </div>

        <!-- Profile Info Card -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-xl border border-white/50">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-8 h-8 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Identitas Lengkap
                </h2>
                <div class="space-y-4">
                    <?php if (!empty($user['nis'])): ?>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">NIS</span>
                        <span class="font-semibold"><?php echo htmlspecialchars($user['nis']); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($user['class'])): ?>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Kelas</span>
                        <span class="font-semibold"><?php echo htmlspecialchars($user['class']); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($user['phone'])): ?>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Telepon</span>
                        <span class="font-semibold"><?php echo htmlspecialchars($user['phone']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-xl border border-white/50">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Event History</h2>
                <p class="text-gray-600 mb-6">Event yang pernah diikuti dan berpartisipasi sebagai panitia</p>
                <div class="space-y-2">
                    <?php foreach (array_slice($activities ?? [], 0, 5) as $activity): ?>
                    <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 line-clamp-1"><?php echo htmlspecialchars($activity['title'] ?? ''); ?></p>
                            <p class="text-sm text-gray-500"><?php echo date('d M Y', strtotime($activity['activity_date'] ?? '')); ?></p>
                        </div>
                        <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full font-medium">
                            <?php echo htmlspecialchars($activity['status'] ?? ''); ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($activities)): ?>
                    <p class="text-gray-500 text-center py-8">Belum ada history event</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Event Tables -->
        <div class="grid lg:grid-cols-2 gap-8">
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-xl border border-white/50">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Sebagai Participant</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 font-semibold text-gray-900">Event</th>
                                <th class="text-left py-3 font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-3 font-semibold text-gray-900">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($activities ?? [], 0, 3) as $activity): ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 font-medium"><?php echo htmlspecialchars(substr($activity['title'] ?? '', 0, 30) . '...'); ?></td>
                                <td class="py-3"><?php echo date('d M Y', strtotime($activity['activity_date'] ?? '')); ?></td>
                                <td><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800"><?php echo htmlspecialchars($activity['status'] ?? ''); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (count($activities ?? []) == 0): ?>
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-500">No events yet</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-8 shadow-xl border border-white/50">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Sebagai Panitia</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 font-semibold text-gray-900">Event</th>
                                <th class="text-left py-3 font-semibold text-gray-900">Tanggal</th>
                                <th class="text-left py-3 font-semibold text-gray-900">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($activities ?? [], 3, 3) as $activity): ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 font-medium"><?php echo htmlspecialchars(substr($activity['title'] ?? '', 0, 30) . '...'); ?></td>
                                <td class="py-3"><?php echo date('d M Y', strtotime($activity['activity_date'] ?? '')); ?></td>
                                <td><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800"><?php echo htmlspecialchars($activity['status'] ?? ''); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (count($activities ?? []) <= 3): ?>
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-500">No panitia events yet</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="/" class="inline-flex items-center px-8 py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Home
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

