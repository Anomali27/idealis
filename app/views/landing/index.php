<?php // app/views/landing/index.php ?>
<!-- Modern Landing Page Redesign -->

<!-- HERO SECTION: Asymmetrical Layout -->
<section class="relative min-h-screen bg-gray-50 overflow-hidden flex items-center pt-20 lg:pt-0">
    <!-- Decorative subtle gradient background -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-primary/10"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-primary-light/10 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Left Content: Typography & CTAs -->
            <div class="text-left font-poppins order-2 lg:order-1">
                <span class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary font-semibold text-sm mb-6 border border-primary/20 backdrop-blur-sm">
                    Welcome to PIC
                </span>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 text-gray-900 leading-tight">
                    Ignite Your <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-light">Social Impact</span>
                </h1>
                <p class="text-lg md:text-xl mb-10 text-gray-600 max-w-lg leading-relaxed">
                    Empowering students through quality education and active community service. Join us in building a better future together.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/activities" class="px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark hover:-translate-y-1 transition-all duration-300 shadow-lg shadow-primary/30 text-center flex items-center justify-center gap-2">
                        Find Activities
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                    <a href="/dashboard" class="px-8 py-4 bg-white text-gray-800 font-semibold rounded-xl border border-gray-200 hover:border-primary hover:text-primary hover:-translate-y-1 transition-all duration-300 shadow-sm text-center">
                        My Dashboard
                    </a>
                    <?php else: ?>
                    <a href="/auth/login" class="px-8 py-4 bg-white text-gray-800 font-semibold rounded-xl border border-gray-200 hover:border-primary hover:text-primary hover:-translate-y-1 transition-all duration-300 shadow-sm text-center">
                        Join Us Now
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Content: Organic Collage -->
            <div class="relative order-1 lg:order-2 h-[400px] md:h-[500px] lg:h-[600px] flex justify-center items-center">
                <!-- Main Image -->
                <div class="absolute w-3/4 h-3/4 right-0 top-0 overflow-hidden rounded-[40px] rounded-bl-[100px] shadow-2xl z-10 transform hover:scale-105 transition-transform duration-700">
                    <img src="/assets/images/school/school-view.png" alt="Students engaging" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
                </div>
                <!-- Secondary Image -->
                <div class="absolute w-1/2 h-1/2 left-0 bottom-10 overflow-hidden rounded-[30px] rounded-tr-[60px] shadow-xl z-20 border-4 border-white transform -rotate-3 hover:rotate-0 transition-transform duration-500">
                    <img src="/assets/images/school/school-hallway.png" alt="School Activity" class="w-full h-full object-cover">
                </div>
                <!-- Glassmorphism Floating Badge -->
                <div class="absolute bottom-20 right-10 z-30 bg-white/70 backdrop-blur-md border border-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Active Volunteers</p>
                        <p class="text-xl font-bold text-gray-800"><?php echo number_format($stats['total_students'] ?? 500); ?>+</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- IMPACT STATS (Bento Grid) -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center md:text-left">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins mb-4">Our Impact in Numbers</h2>
            <p class="text-gray-600 max-w-2xl text-lg">A glance at the growing community and the positive change we're driving.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 auto-rows-[200px]">
            
            <!-- Main About Box (Spans 2 cols, 2 rows) -->
            <div class="md:col-span-2 md:row-span-2 bg-gradient-to-br from-primary to-primary-dark rounded-3xl p-8 lg:p-12 text-white relative overflow-hidden group shadow-xl">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
                <h3 class="text-3xl font-bold mb-6 font-poppins relative z-10">About PIC</h3>
                <p class="text-lg text-gray-100 leading-relaxed relative z-10">
                    PIC aims to prepare students for future academic and professional challenges by combining modern teaching methods, character development, and diverse extracurricular activities in a supportive and multicultural school community.
                </p>
                <div class="mt-8 relative z-10">
                    <a href="/about" class="inline-flex items-center gap-2 text-white font-semibold hover:text-gray-200 transition-colors border-b border-transparent hover:border-white pb-1">
                        Read Our Story <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Stats Boxes -->
            <div class="bg-blue-50 rounded-3xl p-8 flex flex-col justify-center items-center text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-md">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-4xl font-bold text-gray-900 font-poppins mb-1"><?php echo number_format($stats['total_students'] ?? 500); ?>+</span>
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Students</span>
            </div>

            <div class="bg-indigo-50 rounded-3xl p-8 flex flex-col justify-center items-center text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-md">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-4xl font-bold text-gray-900 font-poppins mb-1"><?php echo number_format($stats['total_teachers'] ?? 50); ?>+</span>
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Teachers</span>
            </div>

            <div class="bg-emerald-50 rounded-3xl p-8 flex flex-col justify-center items-center text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-md">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-4xl font-bold text-gray-900 font-poppins mb-1"><?php echo number_format($stats['total_events'] ?? 20); ?>+</span>
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Events Hosted</span>
            </div>

            <!-- New: Volunteer Hours -->
            <div class="bg-orange-50 rounded-3xl p-8 flex flex-col justify-center items-center text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-md relative overflow-hidden">
                <div class="absolute right-0 bottom-0 text-orange-200/50 transform translate-x-1/4 translate-y-1/4">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-4 relative z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-4xl font-bold text-gray-900 font-poppins mb-1 relative z-10"><?php echo number_format($stats['total_hours'] ?? 5000); ?>+</span>
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider relative z-10">Volunteer Hours</span>
            </div>

        </div>
    </div>
</section>

<!-- HOW IT WORKS (New Section) -->
<section class="py-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins mb-4">How It Works</h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">Your journey to making a difference is simple.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden md:block absolute top-1/2 left-[16%] right-[16%] h-0.5 bg-gray-200 border-t-2 border-dashed border-gray-300 -translate-y-1/2 z-0"></div>

            <!-- Step 1 -->
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-6 transform rotate-3 hover:rotate-0 transition-transform border border-gray-100">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">1. Choose Activity</h3>
                <p class="text-gray-600">Browse through our upcoming social events and pick what matches your passion.</p>
            </div>

            <!-- Step 2 -->
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-primary text-white rounded-2xl shadow-xl shadow-primary/30 flex items-center justify-center mb-6 transform -rotate-3 hover:rotate-0 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">2. Register & Join</h3>
                <p class="text-gray-600">Secure your spot quickly, show up, and work alongside the community.</p>
            </div>

            <!-- Step 3 -->
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-6 transform rotate-3 hover:rotate-0 transition-transform border border-gray-100">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 font-poppins mb-2">3. Earn Certificates</h3>
                <p class="text-gray-600">Get recognized for your efforts, earn social points, and collect certificates.</p>
            </div>
        </div>
    </div>
</section>

<!-- UPCOMING SOCIAL ACTIVITIES -->
<section class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins mb-4">Upcoming Activities</h2>
                <p class="text-gray-600 max-w-2xl text-lg">Opportunities to make a tangible impact this month.</p>
            </div>
            <a href="/activities" class="mt-4 md:mt-0 text-primary font-semibold hover:text-primary-dark transition-colors flex items-center gap-2 group">
                View All Events <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($activities)): ?>
                <?php $count = 0; ?>
                <?php foreach ($activities as $activity): ?>
                    <?php if ($count >= 3) break; // Display only 3 on landing page ?>
                    <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-300">
                        <!-- Card Image Header -->
                        <div class="h-48 bg-gray-200 relative overflow-hidden">
                            <!-- Placeholder image, ideally from DB if dynamic images are stored -->
                            <img src="/assets/images/event/eco-exploration-project.png" alt="<?= htmlspecialchars($activity['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary shadow-sm">
                                <?= date('d M Y', strtotime($activity['activity_date'])) ?>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 font-poppins mb-3 line-clamp-2"><?= htmlspecialchars($activity['title']) ?></h3>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <?= htmlspecialchars($activity['location'] ?? 'Location TBA') ?>
                                </div>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span class="font-medium text-gray-800"><?= $activity['volunteer_count'] ?? 0 ?></span> &nbsp;Volunteers Joined
                                </div>
                            </div>

                            <a href="/activities/<?= $activity['id'] ?>" class="block w-full py-3 bg-gray-50 hover:bg-primary text-primary hover:text-white border border-gray-200 hover:border-primary font-semibold rounded-xl text-center transition-colors duration-300">
                                Join Activity
                            </a>
                        </div>
                    </div>
                    <?php $count++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-12 text-center text-gray-500">
                    <p>No upcoming activities at the moment. Please check back later!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- LATEST NEWS -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-poppins mb-4">Latest Highlights</h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">Catch up with the latest events and achievements at PIC.</p>
        </div>
        
        <!-- Modern Staggered Grid for News -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- News Card 1 -->
            <div class="group cursor-pointer">
                <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg mb-6">
                    <img src="/assets/images/latest/national-robotic-championship.png" alt="National Robotic Championship" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-block px-3 py-1 bg-primary text-white text-xs font-bold rounded-full mb-3 shadow-md">Achievement</span>
                        <h3 class="text-2xl font-bold text-white font-poppins mb-2 group-hover:text-primary-light transition-colors">National Robotics Championship Award</h3>
                    </div>
                </div>
                <p class="text-gray-600 px-2 line-clamp-2">Inspiring the next generation of engineers through rigorous competition and dedication.</p>
            </div>
            
            <!-- News Card 2 -->
            <div class="group cursor-pointer md:mt-12">
                <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg mb-6">
                    <img src="/assets/images/latest/umkm-empowerment.png" alt="UMKM Empowerment" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-block px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full mb-3 shadow-md">Community</span>
                        <h3 class="text-2xl font-bold text-white font-poppins mb-2 group-hover:text-emerald-300 transition-colors">UMKM Empowerment Fair</h3>
                    </div>
                </div>
                <p class="text-gray-600 px-2 line-clamp-2">Supporting local businesses through digital innovation and student-led initiatives.</p>
            </div>

            <!-- News Card 3 -->
            <div class="group cursor-pointer">
                <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg mb-6">
                    <img src="/assets/images/latest/repla-brick.png" alt="Eco Innovation" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-block px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full mb-3 shadow-md">Environment</span>
                        <h3 class="text-2xl font-bold text-white font-poppins mb-2 group-hover:text-blue-300 transition-colors">Eco-Innovation: REPLA-BRICK</h3>
                    </div>
                </div>
                <p class="text-gray-600 px-2 line-clamp-2">Revolutionizing construction with recycled materials for a sustainable future.</p>
            </div>

            <!-- News Card 4 -->
            <div class="group cursor-pointer md:mt-12">
                <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg mb-6">
                    <img src="/assets/images/latest/youth-voices-circle.png" alt="Mental Health Forum" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-block px-3 py-1 bg-indigo-500 text-white text-xs font-bold rounded-full mb-3 shadow-md">Social</span>
                        <h3 class="text-2xl font-bold text-white font-poppins mb-2 group-hover:text-indigo-300 transition-colors">Youth Voices Circle: Mental Health</h3>
                    </div>
                </div>
                <p class="text-gray-600 px-2 line-clamp-2">Sharing stories to build emotional resilience and foster open communication among peers.</p>
            </div>

        </div>
    </div>
</section>
