<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

<div class="pt-20 md:pt-24 pb-12 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- Profile Header -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-12 gap-6 bg-white/80 backdrop-blur-md p-6 rounded-3xl shadow-xl border border-white/50">
            <div class="flex items-center gap-6">
                <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-gradient-to-r from-primary to-primary-dark rounded-full shadow-lg">
                    <span class="text-2xl md:text-3xl font-bold text-white">
                        <?php 
                        $words = preg_split('/\\s+/', trim($user['name'] ?? ''));
                        echo strtoupper(($words[0][0] ?? '') . ($words[1][0] ?? '?'));
                        ?>
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($user['name'] ?? ''); ?></h1>
                    <p class="text-gray-600"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                    <div class="mt-2 inline-block px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full">
                        <?php echo htmlspecialchars($this->data['roleLabel'] ?? User::getRoleLabel($user['role'] ?? '')); ?>
                    </div>
                </div>
            </div>
            
            <a href="/" class="inline-flex items-center px-6 py-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-xl shadow-sm transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Summary Stats: Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-center items-center text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-gray-500 font-medium mb-1">Total Events</h3>
                <p class="text-3xl font-bold text-gray-900"><?php echo number_format($this->data['totalEvents'] ?? 0); ?></p>
            </div>
            
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-center items-center text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-gray-500 font-medium mb-1">Total Volunteer Hours</h3>
                <p class="text-3xl font-bold text-gray-900"><?php echo number_format($this->data['totalVolunteerHours'] ?? 0); ?> <span class="text-lg font-normal text-gray-500">hrs</span></p>
            </div>

            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-white/50 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-center items-center text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-gray-500 font-medium mb-1">Total Donations</h3>
                <p class="text-3xl font-bold text-gray-900"><span class="text-lg font-normal text-gray-500">Rp</span> <?php echo number_format($this->data['totalDonations'] ?? 0, 0, ',', '.'); ?></p>
            </div>
        </div>

        <!-- Interactive Tabs -->
        <div class="mb-8 border-b border-gray-200">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button onclick="switchTab('events')" id="tab-events" class="tab-btn border-primary text-primary whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                    My Events
                </button>
                <button onclick="switchTab('donations')" id="tab-donations" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg transition-colors">
                    My Donations
                </button>
            </nav>
        </div>

        <!-- Tab Content: My Events -->
        <div id="content-events" class="tab-content block">
            <?php if (empty($this->data['events'])): ?>
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-12 text-center shadow-xl border border-white/50">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No history found</h3>
                    <p class="text-gray-500 mb-6">You haven't participated in any events yet.</p>
                    <a href="/events" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        Find Available Activities
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    $today = date('Y-m-d');
                    foreach ($this->data['events'] as $event): 
                        if ($event['date'] < $today) {
                            $status = 'Completed';
                            $statusClass = 'bg-green-100 text-green-800';
                        } elseif ($event['date'] == $today) {
                            $status = 'Ongoing';
                            $statusClass = 'bg-blue-100 text-blue-800';
                        } else {
                            $status = 'Upcoming';
                            $statusClass = 'bg-yellow-100 text-yellow-800';
                        }
                    ?>
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl overflow-hidden shadow-xl border border-white/50 transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                        <?php if(!empty($event['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Event Image" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gradient-to-r from-gray-200 to-gray-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $statusClass; ?>">
                                    <?php echo $status; ?>
                                </span>
                                <span class="text-sm text-gray-500 font-medium">
                                    <?php echo date('d M Y', strtotime($event['date'])); ?>
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2"><?php echo htmlspecialchars($event['name']); ?></h3>
                            <p class="text-gray-600 text-sm mb-6 line-clamp-3 flex-1"><?php echo htmlspecialchars(strip_tags($event['description'] ?? '')); ?></p>
                            
                            <div class="flex flex-col gap-3 mt-auto">
                                <a href="/events/<?php echo $event['id']; ?>" class="w-full text-center px-4 py-2 border border-primary text-primary hover:bg-primary hover:text-white font-medium rounded-lg transition-colors">
                                    View Details
                                </a>
                                <?php if ($status === 'Completed'): ?>
                                <button onclick="alert('Downloading Certificate for <?php echo htmlspecialchars(addslashes($event['name'])); ?>...')" class="w-full flex items-center justify-center px-4 py-2 bg-gradient-to-r from-primary to-primary-dark text-white font-medium rounded-lg transition-colors hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download Certificate
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tab Content: My Donations -->
        <div id="content-donations" class="tab-content hidden">
            <?php if (empty($this->data['donations'])): ?>
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-12 text-center shadow-xl border border-white/50">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No history found</h3>
                    <p class="text-gray-500 mb-6">You haven't made any donations yet.</p>
                    <a href="/events" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        Find Available Activities
                    </a>
                </div>
            <?php else: ?>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="py-4 px-6 font-semibold text-gray-900">Event Name</th>
                                    <th class="py-4 px-6 font-semibold text-gray-900">Date</th>
                                    <th class="py-4 px-6 font-semibold text-gray-900">Amount</th>
                                    <th class="py-4 px-6 font-semibold text-gray-900">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($this->data['donations'] as $donation): ?>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900"><?php echo htmlspecialchars($donation['event_name'] ?? 'Unknown Event'); ?></div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600">
                                        <?php 
                                        echo isset($donation['created_at']) ? date('d M Y, H:i', strtotime($donation['created_at'])) : '-'; 
                                        ?>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900">
                                        Rp <?php echo number_format($donation['amount'] ?? 0, 0, ',', '.'); ?>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                            Verified
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
function switchTab(tabId) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
        el.classList.remove('block');
    });
    
    // Reset all tabs
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('border-primary', 'text-primary');
        el.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected content
    document.getElementById('content-' + tabId).classList.remove('hidden');
    document.getElementById('content-' + tabId).classList.add('block');
    
    // Highlight selected tab
    document.getElementById('tab-' + tabId).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tabId).classList.add('border-primary', 'text-primary');
    
    // Update URL without reload
    const url = new URL(window.location);
    url.searchParams.set('tab', tabId);
    window.history.pushState({}, '', url);
}

// Initial tab based on URL param
document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');
    if (tab === 'donations') {
        switchTab('donations');
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
