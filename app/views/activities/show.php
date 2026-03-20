<?php
// Event Detail Page - Modern Tailwind w/ Donations
require_once dirname(__DIR__) . '/layouts/header.php';
use App\Core\Session;

$activity = $data['activity'] ?? [];
$isRegistered = $data['isRegistered'] ?? false;
$isLoggedIn = Session::isLoggedIn();
$userRole = Session::getUserRole();
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100 pt-24 px-4 sm:px-6 lg:px-8 pb-12">

    <div class="max-w-6xl mx-auto">
        <!-- Back + Title -->
        <div class="flex items-start justify-between mb-12">
            <a href="/activities"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-primary font-medium transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <p>
                    Back to Events 
                </p>
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Event Title -->
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-4 font-['Kanit']">
                        Eco Exploration Project: Mangrove Research & Conservation Program
                    </h1>
                    <div class="flex flex-wrap items-center gap-6 text-lg text-gray-600 mb-8">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 1 0-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                            </svg>
                            <span>May 10, 2026</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>PIC Environmental Club in collaboration with Borneo Coastal Research Initiative</span>
                        </div>
                    </div>

                    <!-- Floating Participate CTA -->
                    <a href="/participate"
                        class="fixed bottom-8 right-8 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-4 md:px-10 md:py-5 rounded-2xl shadow-2xl hover:shadow-3xl hover:from-orange-600 hover:to-orange-700 hover:scale-105 active:scale-95 transition-all duration-300 z-40 flex items-center gap-3 font-bold text-base md:text-lg whitespace-nowrap no-underline">
                        Participate Now
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>


                <!-- Banner Image -->
                <div class="bg-gradient-to-r from-gray-100 to-slate-100 rounded-3xl overflow-hidden shadow-xl">
                    <img src="/assets/images/event/eco_exploration_project.png" alt="Eco Exploration Project"
                        class="w-full h-96 object-cover rounded-t-3xl">
                </div>

                <!-- Description Section -->
                <div class="bg-white rounded-3xl p-8 shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 9a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1z" />
                        </svg>
                        Description
                    </h2>
                    <div class="space-y-4">
                        <div id="description-short"
                            class="text-lg text-gray-700 leading-relaxed line-clamp-3 prose max-w-none">
                            The Eco Exploration Project is a hands-on environmental program where students of Pontianak
                            International College (PIC) participate in mangrove research and conservation activities.
                            Set in a coastal ecosystem, students engage in fieldwork such as soil sampling, plant
                            identification, and basic ecological surveys...
                        </div>
                        <div id="description-full"
                            class="text-lg text-gray-700 leading-relaxed prose max-w-none hidden">
                            The Eco Exploration Project is a hands-on environmental program where students of Pontianak
                            International College (PIC) participate in mangrove research and conservation activities.
                            Set in a coastal ecosystem, students engage in fieldwork such as soil sampling, plant
                            identification, and basic ecological surveys. Guided by environmental experts, they learn
                            about the importance of mangroves in protecting coastlines, supporting biodiversity, and
                            combating climate change. Throughout the program, students also take part in mangrove
                            planting initiatives, contributing directly to environmental restoration efforts. The
                            experience not only enhances their scientific understanding but also builds a sense of
                            responsibility toward nature. By combining education with action, this event encourages
                            students to become active contributors to sustainable environmental solutions in their local
                            community.
                        </div>
                        <button id="read-more"
                            class="text-primary font-semibold hover:text-primary-dark transition-colors flex items-center gap-2">
                            See more <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <button id="read-less"
                            class="text-primary font-semibold hover:text-primary-dark transition-colors flex items-center gap-2 hidden">
                            See less <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            </svg>
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
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Organizer</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">2</td>
                                    <td class="px-6 py-4">Wong Fei Hung</td>
                                    <td class="px-6 py-4 text-gray-600">XI-D</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">Staff</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">3</td>
                                    <td class="px-6 py-4">Daniel Kim</td>
                                    <td class="px-6 py-4 text-gray-600">X-E</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-medium">Member</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">4</td>
                                    <td class="px-6 py-4">Michelle Zhang</td>
                                    <td class="px-6 py-4 text-gray-600">Teacher</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">Staff</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Donations -->
            <div class="space-y-6 lg:sticky lg:top-24 self-start w-full lg:w-auto">
                <!-- Donate Card -->
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                        <svg class="w-9 h-9 bg-gradient-to-br from-green-400 to-emerald-500 text-white rounded-2xl p-2"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 0 1-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.363.242.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 0 1-.567.267zM8 5.5a1.5 1.5 0 1 1 3 0V6h4v2H8V5.5zM8.5 10a1.5 1.5 0 0 1 1.5-1.5h5V7h-6.5A1.5 1.5 0 0 1 8 5.5V7h1.5V8.5H9.5a1.5 1.5 0 0 1-1.5 1.5H8v1.5h1.5V12H8v1.5h6.5A1.5 1.5 0 0 1 16 13.5v-3a1.5 1.5 0 0 1-1.5-1.5h-5V10h5v1.5H14.5A1.5 1.5 0 0 1 13 13v3a1.5 1.5 0 0 1-1.5 1.5H8V13h1.5V11.5z" />
                        </svg>
                        Donate
                    </h3>

                    <!-- Donation Amounts -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                        <button
                            class="donation-btn bg-white border-2 border-gray-300 hover:border-gray-400 p-4 rounded-lg font-bold text-lg transition-all duration-200 hover:shadow-md"
                            data-amount="5000">Rp 5.000</button>
                        <button
                            class="donation-btn bg-white border-2 border-gray-300 hover:border-gray-400 p-4 rounded-lg font-bold text-lg transition-all duration-200 hover:shadow-md"
                            data-amount="10000">Rp 10.000</button>
                        <button
                            class="donation-btn bg-white border-2 border-gray-300 hover:border-gray-400 p-4 rounded-lg font-bold text-lg transition-all duration-200 hover:shadow-md"
                            data-amount="20000">Rp 20.000</button>
                        <button
                            class="donation-btn bg-white border-2 border-gray-300 hover:border-gray-400 p-4 rounded-lg font-bold text-lg transition-all duration-200 hover:shadow-md"
                            data-amount="50000">Rp 50.000</button>
                        <button
                            class="donation-btn bg-white border-2 border-gray-300 hover:border-gray-400 p-4 rounded-lg font-bold text-lg transition-all duration-200 hover:shadow-md"
                            data-amount="100000">Rp 100.000</button>
                        <button
                            class="donation-btn bg-white border-2 border-gray-300 hover:border-gray-400 p-4 rounded-lg font-bold text-lg transition-all duration-200 hover:shadow-md"
                            data-amount="200000">Rp 200.000</button>
                    </div>

                    <!-- Message -->
                    <textarea placeholder="Write your message..."
                        class="w-full p-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent resize-vertical mb-4"
                        rows="3"></textarea>

                    <button
                        class="w-full bg-gradient-to-r from-emerald-500 to-green-600 text-white py-4 px-6 rounded-2xl font-bold hover:from-emerald-600 hover:to-green-700 shadow-xl hover:shadow-2xl transition-all duration-300 text-lg">
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
                            <div class="bg-gradient-to-r from-emerald-500 to-green-600 h-3 rounded-full"
                                style="width: 25%"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">25% of goal reached</p>
                </div>

                <!-- Top Donators -->
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-6">Top Donators</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition-all"
                            onclick="alert('Michelle: Thank you for the mangrove restoration! 🌱')">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center text-white font-semibold">
                                    MZ</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Michelle Zhang</div>
                                    <div class="text-sm text-gray-500">Rp 100.000</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.03 9 8z" />
                            </svg>
                        </div>
                        <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition-all"
                            onclick="alert('Leon: Great cause! Keep it up! 👍')">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center text-white font-semibold">
                                    LK</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Leon Kuniardi</div>
                                    <div class="text-sm text-gray-500">Rp 50.000</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.03 9 8z" />
                            </svg>
                        </div>
                        <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition-all"
                            onclick="alert('Evan: Supporting student initiatives! 🎉')">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-orange-400 to-yellow-500 rounded-2xl flex items-center justify-center text-white font-semibold">
                                    EB</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Evan Burger</div>
                                    <div class="text-sm text-gray-500">Rp 40.000</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.03 9 8z" />
                            </svg>
                        </div>
                    </div>
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
        btn.addEventListener('click', function () {
            document.querySelectorAll('.donation-btn').forEach(b => b.classList.remove('bg-primary', 'text-white', 'shadow-md', 'ring-2', 'ring-primary'));
            this.classList.add('bg-primary', 'text-white', 'shadow-md', 'ring-2', 'ring-primary');
        });
    });
</script>



<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>