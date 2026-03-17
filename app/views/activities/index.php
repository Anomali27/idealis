<?php
// Events Page - Modern Tailwind Design
require_once dirname(__DIR__) . '/layouts/header.php';
use App\Core\Session;

$activities = $data['activities'] ?? [];
$isLoggedIn = Session::isLoggedIn();
$userRole = Session::getUserRole();
?>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Page Title -->
        <div class="text-left mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Events</h1>
            <p class="text-xl text-gray-600">Discover upcoming social activities at Pontianak International College</p>
        </div>

        <!-- Filters (simplified) -->
        <div class="mb-12 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
            <div class="flex flex-col sm:flex-row gap-3 flex-1">
                <input type="text" placeholder="Search events..." 
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                <select class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option>All Status</option>
                    <option>Upcoming</option>
                    <option>Ongoing</option>
                    <option>Completed</option>
                </select>
            </div>
            <?php if (in_array($userRole, ['admin', 'committee'])): ?>
                <a href="/activities/create" class="bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-dark transition-all duration-300 shadow-lg hover:shadow-xl">
                    + Create Event
                </a>
            <?php endif; ?>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-8 mb-20">
            <?php if (empty($activities)): ?>
                <div class="md:col-span-2 text-center py-24">
                    <div class="w-24 h-24 bg-gray-200 rounded-3xl mx-auto mb-6 flex items-center justify-center">
                        <span class="text-2xl text-gray-500">📅</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Events Yet</h3>
                    <p class="text-gray-600 mb-6">No events match your search. Try adjusting your filters.</p>
                    <a href="/activities" class="bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-dark transition-all duration-300">
                        View All Events
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $activity): ?>
                <a href="/activities/<?= $activity['id'] ?>" class="group">
                    <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-gray-100 hover:border-primary/30">
                        <!-- Event Image -->
                        <div class="h-48 md:h-56 relative overflow-hidden bg-gradient-to-br from-primary/10 to-primary-dark/10">
                            <?php if ($activity['cover_image']): ?>
                                <img src="<?= htmlspecialchars($activity['cover_image']) ?>" 
                                     alt="<?= htmlspecialchars($activity['title']) ?>"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 rounded-t-3xl">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-primary-light rounded-2xl flex items-center justify-center text-white font-bold text-xl">
                                        PIC
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Status Badge -->
                            <span class="absolute top-4 right-4 px-4 py-2 bg-white/90 backdrop-blur-sm rounded-full text-sm font-semibold text-gray-800 shadow-lg border">
                                <?= ucfirst($activity['status']) ?>
                            </span>
                        </div>

                        <!-- Event Content -->
                        <div class="p-8">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                                <?= htmlspecialchars($activity['title']) ?>
                            </h3>

                            <!-- Metadata Row -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1zm0 5a1 1 0 0 0-1 1v3a1 1 0 0 1 1 1h8a1 1 0 0 1 1-1V8a1 1 0 0 0-1-1H6z"/>
                                    </svg>
                                    <span><?= date('d M Y', strtotime($activity['activity_date'])) ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 0 1 11.9 11.9l-7.07 7.07a5 5 0 0 1-7.07-7.07l1.41-1.41z"/>
                                    </svg>
                                    <?= htmlspecialchars($activity['location']) ?>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 leading-relaxed line-clamp-3 mb-6">
                                <?= htmlspecialchars(substr($activity['description'] ?? '', 0, 120)) ?><?= strlen($activity['description'] ?? '') > 120 ? '...' : '' ?>
                            </p>

                            <!-- Volunteer Stats -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                    </svg>
                                    <span><?= $activity['volunteer_count'] ?? 0 ?> volunteers</span>
                                </div>
                                <span class="text-primary font-semibold text-sm bg-primary/10 px-3 py-1 rounded-full">
                                    View Details →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<div class="fixed bottom-8 right-8 z-50">
    <a href="/community-forum" class="w-16 h-16 bg-gradient-to-r from-primary to-primary-dark text-white rounded-full shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 flex items-center justify-center text-xl font-bold hover:from-primary-dark hover:to-primary-light">
        💬
    </a>
</div>

<!-- Tailwind Line Clamp -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#043460',
                    'primary-dark': '#032A47',
                    'primary-light': '#0A4A80',
                }
            }
        }
    }
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
