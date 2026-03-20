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
        <div class="text-left mb-12 pt-24">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-kanit">Events</h1>
            <p class="text-xl text-gray-600 max-w-2xl">Discover upcoming social activities at Pontianak International College</p>
        </div>


    <!-- Create Button -->
    <div class="mb-12 flex justify-end">
        <?php if (in_array($userRole, ['admin', 'committee'])): ?>
            <a href="/activities/create" class="bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-dark transition-all duration-300 shadow-lg hover:shadow-xl font-kanit">
                + Create Event
            </a>
        <?php endif; ?>
    </div>

    <!-- Tabs -->

    <div class="flex bg-white rounded-2xl p-1 shadow-xl mb-8 max-w-2xl mx-auto sticky top-24 z-10 backdrop-blur-sm bg-white/80">
        <button class="tab-btn flex-1 py-4 px-6 rounded-xl font-semibold text-gray-700 bg-white font-kanit hover:bg-gray-100 transition-all duration-300 data-[active=true]:bg-blue-900 data-[active=true]:text-white data-[active=true]:shadow-md" data-tab="all" data-active="true">All Events</button>
        <button class="tab-btn flex-1 py-4 px-6 rounded-xl font-medium text-gray-600 bg-white font-kanit hover:bg-gray-100 transition-all duration-300 data-[active=true]:bg-blue-900 data-[active=true]:text-white data-[active=true]:shadow-md" data-tab="ongoing">Ongoing</button>
        <button class="tab-btn flex-1 py-4 px-6 rounded-xl font-medium text-gray-600 bg-white font-kanit hover:bg-gray-100 transition-all duration-300 data-[active=true]:bg-blue-900 data-[active=true]:text-white data-[active=true]:shadow-md" data-tab="upcoming">Upcoming</button>
        <button class="tab-btn flex-1 py-4 px-6 rounded-xl font-medium text-gray-600 bg-white font-kanit hover:bg-gray-100 transition-all duration-300 data-[active=true]:bg-blue-900 data-[active=true]:text-white data-[active=true]:shadow-md" data-tab="completed">Completed</button>
    </div>



<!-- Events Content - All Tab -->

<?php
$sampleEvents = [
    ['id' => 1, 'title' => 'Eco Exploration Project', 'status' => 'ongoing', 'date' => '15 Dec 2024', 'location' => 'Campus Field', 'desc' => 'Interactive environmental workshop...', 'image' => '/assets/images/event/eco_exploration_project.png', 'volunteers' => 25],
    ['id' => 2, 'title' => 'Electronics & E-Waste Drive', 'status' => 'ongoing', 'date' => '18 Dec 2024', 'location' => 'Lab 2A', 'desc' => 'Sustainable tech recycling initiative...', 'image' => '/assets/images/event/electronics_and_e-waste.png', 'volunteers' => 12],
    ['id' => 3, 'title' => 'Flood Relief Mission', 'status' => 'upcoming', 'date' => '25 Dec 2024', 'location' => 'Pontianak City', 'desc' => 'Community aid for flood victims...', 'image' => '/assets/images/event/flood_relief_mission.png', 'volunteers' => 45],
    ['id' => 4, 'title' => 'Kalimantan Tech Facility', 'status' => 'upcoming', 'date' => '5 Jan 2025', 'location' => 'Tech Park', 'desc' => 'STEM innovation showcase...', 'image' => '/assets/images/event/kalimantan_tech_facility.png', 'volunteers' => 30],
    ['id' => 5, 'title' => 'Kunjungan Kasih & Berbagi', 'status' => 'upcoming', 'date' => '12 Jan 2025', 'location' => 'Local Orphanage', 'desc' => 'Holiday gift distribution...', 'image' => '/assets/images/event/kunjungan_kasih_and_berbagi.png', 'volunteers' => 20],
    ['id' => 6, 'title' => 'Mangrove Restoration', 'status' => 'upcoming', 'date' => '20 Jan 2025', 'location' => 'Coastal Area', 'desc' => 'Planting drive for ecosystem...', 'image' => '/assets/images/event/mangrove_restoration_project.png', 'volunteers' => 35],
    ['id' => 7, 'title' => 'Pulse Career Expo', 'status' => 'completed', 'date' => '10 Nov 2024', 'location' => 'Auditorium', 'desc' => 'Job fair and career counseling...', 'image' => '/assets/images/event/pulse_career_and_job_expo.png', 'volunteers' => 18],
    ['id' => 8, 'title' => 'Dr. Sophia Seminar', 'status' => 'completed', 'date' => '5 Nov 2024', 'location' => 'Lecture Hall', 'desc' => 'Leadership and innovation talk...', 'image' => '/assets/images/event/seminar_by_Dr.Sophia.png', 'volunteers' => 22],
    ['id' => 9, 'title' => 'Senior Care Home Visit', 'status' => 'completed', 'date' => '1 Nov 2024', 'location' => 'Sunshine Home', 'desc' => 'Intergenerational activities...', 'image' => '/assets/images/event/senior_care_home.png', 'volunteers' => 28],
    ['id' => 10, 'title' => 'Summer Enrichment Program', 'status' => 'ongoing', 'date' => '20 Dec 2024', 'location' => 'Library', 'desc' => 'Skill-building workshops...', 'image' => '/assets/images/event/summer_enrichment_program.png', 'volunteers' => 15]
];
$tabData = ['all' => $sampleEvents, 'ongoing' => array_filter($sampleEvents, fn($e) => $e['status'] == 'ongoing'), 'upcoming' => array_filter($sampleEvents, fn($e) => $e['status'] == 'upcoming'), 'completed' => array_filter($sampleEvents, fn($e) => $e['status'] == 'completed')];
?>

<div id="tab-content-all" class="tab-content">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php foreach($tabData['all'] as $activity): ?>
        <a href="/activities/<?= $activity['id'] ?>" class="group">
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-gray-100 hover:border-primary/30 font-kameron">
                <div class="h-48 md:h-56 relative overflow-hidden">
                    <img src="<?= $activity['image'] ?>" alt="<?= $activity['title'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 right-4 px-4 py-2 bg-white/90 backdrop-blur-sm rounded-full text-sm font-semibold text-gray-800 shadow-lg border font-kanit"><?= ucfirst($activity['status']) ?></span>
                </div>
                <div class="p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors font-kanit"><?= htmlspecialchars($activity['title']) ?></h3>
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4 font-kameron">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 00-1 1v3a1 1 0 011 1h8a1 1 0 011-1V8a1 1 0 00-1-1H6z"/></svg>
                            <span><?= $activity['date'] ?></span>
                        </div>
                        <span><?= $activity['location'] ?></span>
                    </div>
                    <p class="text-gray-600 leading-relaxed line-clamp-3 mb-6"><?= htmlspecialchars(substr($activity['desc'], 0, 120)) ?>...</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-700 font-kameron">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span><?= $activity['volunteers'] ?> volunteers</span>
                        </div>
                        <span class="text-primary font-semibold text-sm bg-primary/10 px-3 py-1 rounded-full font-kanit">View Details →</span>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<div id="tab-content-ongoing" class="tab-content hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php foreach($tabData['ongoing'] as $activity): ?>
        <!-- Same card structure as above -->
        <?php endforeach; ?>
    </div>
</div>

<div id="tab-content-upcoming" class="tab-content hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php foreach($tabData['upcoming'] as $activity): ?>
        <!-- Same card structure as above -->
        <?php endforeach; ?>
    </div>
</div>

<div id="tab-content-completed" class="tab-content hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php foreach($tabData['completed'] as $activity): ?>
        <!-- Same card structure as above -->
        <?php endforeach; ?>
    </div>
</div>


    </div>
</div>

<!-- Floating Action Button -->
<div class="fixed bottom-8 right-8 z-50">

    <a href="/community-forum" class="min-w-[200px] h-14 bg-blue-900 hover:bg-blue-800 text-white rounded-2xl shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 flex items-center justify-center font-bold text-sm px-6">
        Community Forum
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
                },
                fontFamily: {
                    kanit: ['Kanit', 'sans-serif'],
                    kameron: ['Kameron', 'serif'],
                }
            }
        }
    }
</script>

<!-- Fonts Preload -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700&family=Kameron:wght@400;700&display=swap" rel="stylesheet">

<script>
// Tab functionality - Fixed for blue-900 active styling
document.addEventListener('DOMContentLoaded', function() {
    // Set All Events as default active
    const allBtn = document.querySelector('[data-tab="all"]');
    if (allBtn) {
        allBtn.dataset.active = 'true';
    }
    
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetTab = btn.dataset.tab;
            
            // Remove active from all tabs
            tabBtns.forEach(b => {
                b.dataset.active = 'false';
                b.classList.remove('bg-blue-900', 'text-white', 'shadow-md');
                b.classList.add('text-gray-600', 'bg-white', 'hover:bg-gray-100');
            });
            
            // Set clicked tab active
            btn.dataset.active = 'true';
            btn.classList.add('bg-blue-900', 'text-white', 'shadow-md');
            btn.classList.remove('text-gray-600', 'hover:bg-gray-100');
            
            // Show content
            tabContents.forEach(content => content.classList.add('hidden'));
            document.getElementById(`tab-content-${targetTab}`).classList.remove('hidden');
        });
    });
});
</script>


<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
