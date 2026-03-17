<?php
// Event Detail Page - Modern Tailwind w/ Donations
require_once dirname(__DIR__) . '/layouts/header.php';
use App\Core\Session;

$activity = $data['activity'] ?? [];
$isRegistered = $data['isRegistered'] ?? false;
$isLoggedIn = Session::isLoggedIn();
$userRole = Session::getUserRole();
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Back + Title -->
        <div class="flex items-start justify-between mb-12">
            <a href="/activities" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary font-medium transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Events
            </a>
            <span class="px-4 py-2 bg-white/80 backdrop-blur-sm rounded-2xl text-sm font-semibold text-gray-800 shadow-md border px-6">
                <?= ucfirst($activity['status'] ?? 'Draft') ?>
            </span>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Event Title -->
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-4">
                        <?= htmlspecialchars($activity['title'] ?? 'Event Title') ?>
                    </h1>
                    <p class="text-xl text-gray-600">Organized by PIC Committee</p>
                </div>

                <!-- Banner Image -->
                <div class="bg-gradient-to-r from-gray-100 to-slate-100 rounded-3xl overflow-hidden shadow-xl">
                    <img src="<?= htmlspecialchars($activity['cover_image'] ?? '/assets/images/school_view.png') ?>" 
                         alt="<?= htmlspecialchars($activity['title']) ?>"
                         class="w-full h-96 object-cover">
                </div>

                <!-- Description Section -->
                <div class="bg-white rounded-3xl p-8 shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 9a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1z"/>
                        </svg>
                        Description
                    </h2>
                    <div class="space-y-4">
                        <div id="description-short" class="text-lg text-gray-700 leading-relaxed line-clamp-3 prose max-w-none">
                            <?= htmlspecialchars(substr($activity['description'] ?? 'Pontianak International College students join local community for mangrove restoration project. Participants will plant mangrove trees along the coastal area to support environmental conservation efforts.', 0, 200)) ?>...
                        </div>
                        <div id="description-full" class="text-lg text-gray-700 leading-relaxed prose max-w-none hidden">
                            <?= nl2br(htmlspecialchars($activity['description'] ?? 'Pontianak International College students join local community for mangrove restoration project. Participants will plant mangrove trees along the coastal area to support environmental conservation efforts. This activity aims to raise environmental awareness among students while contributing to local ecosystem restoration. No prior experience required - training provided on site.')) ?>
                        </div>
                        <button id="read-more" class="text-primary font-semibold hover:text-primary-dark transition-colors flex items-center gap-2">
                            See more <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <button id="read-less" class="text-primary font-semibold hover:text-primary-dark transition-colors flex items-center gap-2 hidden">
                            See less <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Participants Table -->
                <div class="bg-white rounded-3xl p-8 shadow-xl overflow-hidden">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Participants</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gradient-to-r from-primary/5 to-primary-dark/5">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-900">#</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Name</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Affiliation</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-900">Role</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">1</td>
                                    <td class="px-6 py-4">Dimas Sukin</td>
                                    <td class="px-6 py-4 text-gray-600">XII-B</td>
                                    <td class="px-6 py-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Organizer</span></td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">2</td>
                                    <td class="px-6 py-4">Wong Fei Hung</td>
                                    <td class="px-6 py-4 text-gray-600">XI-D</td>
                                    <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">Staff</span></td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">3</td>
                                    <td class="px-6 py-4">Daniel Kim</td>
                                    <td class="px-6 py-4 text-gray-600">X-E</td>
                                    <td class="px-6 py-4"><span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-medium">Member</span></td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">4</td>
                                    <td class="px-6 py-4">Michelle Zhang</td>
                                    <td class="px-6 py-4 text-gray-600">Teacher</td>
                                    <td class="px-6 py-4"><span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">Staff</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Donations -->
            <div class="space-y-6 lg:sticky lg:top-12 lg:h-screen lg:overflow-y-auto">
                <!-- Donate Card -->
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                        <svg class="w-9 h-9 bg-gradient-to-br from-green-400 to-emerald-500 text-white rounded-2xl p-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 0 1-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.363.242.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 0 1-.567.267zM8 5.5a1.5 1.5 0 1 1 3 0V6h4v2H8V5.5zM8.5 10a1.5 1.5 0 0 1 1.5-1.5h5V7h-6.5A1.5 1.5 0 0 1 8 5.5V7h1.5V8.5H9.5a1.5 1.5 0 0 1-1.5 1.5H8v1.5h1.5V12H8v1.5h6.5A1.5 1.5 0 0 1 16 13.5v-3a1.5 1.5 0 0 1-1.5-1.5h-5V10h5v1.5H14.5A1.5 1.5 0 0 1 13 13v3a1.5 1.5 0 0 1-1.5 1.5H8V13h1.5V11.5z"/>
                        </svg>
                        Donate
                    </h3>

                    <!-- Donation Amounts -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                        <button class="donation-btn" data-amount="5000">Rp 5.000</button>
                        <button class="donation-btn" data-amount="10000">Rp 10.000</button>
                        <button class="donation-btn" data-amount="20000">Rp 20.000</button>
                        <button class="donation-btn" data-amount="50000">Rp 50.000</button>
                        <button class="donation-btn" data-amount="100000">Rp 100.000</button>
                        <button class="donation-btn" data-amount="200000">Rp 200.000</button>
                    </div>

                    <!-- Message -->
                    <textarea placeholder="Write your message..." 
                              class="w-full p-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent resize-vertical mb-4" 
                              rows="3"></textarea>

                    <button class="w-full bg-gradient-to-r from-emerald-500 to-green-600 text-white py-4 px-6 rounded-2xl font-bold hover:from-emerald-600 hover:to-green-700 shadow-xl hover:shadow-2xl transition-all duration-300 text-lg">
                        Send Donation
                    </button>
                </div>

                <!-- Total Donation Card -->
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Total Donation</h4>
                    <div class="mb-4">
                        <div class="text-2xl font-bold text-green-600 mb-2">Rp 250.000</div>
                        <div class="text-sm text-gray-600 mb-3">/ Rp 1.000.000</div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-emerald-500 to-green-600 h-3 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">25% of goal reached</p>
                </div>

                <!-- Top Donators -->
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-6">Top Donators</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition-all" onclick="alert('Michelle: Thank you for the mangrove restoration! 🌱')">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center text-white font-semibold">MZ</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Michelle Zhang</div>
                                    <div class="text-sm text-gray-500">Rp 100.000</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.03 9 8z"/>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition-all" onclick="alert('Leon: Great cause! Keep it up! 👍')">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center text-white font-semibold">LK</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Leon Kuniardi</div>
                                    <div class="text-sm text-gray-500">Rp 50.000</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.03 9 8z"/>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition-all" onclick="alert('Evan: Supporting student initiatives! 🎉')">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-yellow-500 rounded-2xl flex items-center justify-center text-white font-semibold">EB</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Evan Burger</div>
                                    <div class="text-sm text-gray-500">Rp 40.000</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.03 9 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Participate Button -->
                <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-3xl shadow-2xl hover:shadow-3xl hover:scale-[1.02] transition-all duration-300 cursor-pointer text-center font-bold text-xl">
                    <a href="/participate" class="block">Participate Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Read More/Less Toggle
    const readMoreBtn = document.getElementById('read-more');
    const readLessBtn = document.getElementById('read-less');
    const shortDesc = document.getElementById('description-short');
    const fullDesc = document.getElementById('description-full');

    readMoreBtn?.addEventListener('click', () => {
        shortDesc.classList.add('hidden');
        fullDesc.classList.remove('hidden');
        readMoreBtn.classList.add('hidden');
        readLessBtn.classList.remove('hidden');
    });

    readLessBtn?.addEventListener('click', () => {
        shortDesc.classList.remove('hidden');
        fullDesc.classList.add('hidden');
        readMoreBtn.classList.remove('hidden');
        readLessBtn.classList.add('hidden');
    });

    // Donation Buttons
    document.querySelectorAll('.donation-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.donation-btn').forEach(b => b.classList.remove('bg-primary', 'text-white', 'shadow-md', 'ring-2', 'ring-primary'));
            this.classList.add('bg-primary', 'text-white', 'shadow-md', 'ring-2', 'ring-primary');
        });
    });
</script>

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

