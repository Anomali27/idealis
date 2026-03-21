<?php // app/views/landing/index.php ?>
<!-- This file is rendered within the main layout, so only section content is needed -->

<!-- HERO SECTION -->
<section class="hero-section relative h-screen min-h-[600px]">
    <!-- Hero Background Image -->
    <div class="absolute inset-0">
        <img src="/assets/images/school/school_hallway.png" 
             alt="Pontianak International College Building" 
             class="w-full h-full object-cover">
        <!-- Blue Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary/90 to-primary/60"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 flex items-center justify-center h-full px-4">
        <div class="text-center text-white max-w-4xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Welcome to Pontianak International College
            </h1>
            <p class="text-lg md:text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
                Empowering students through quality education and social impact. 
                Join us in building a better future through learning and community service.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="" class="px-8 py-3 bg-white text-primary font-semibold rounded-full hover:bg-gray-100 transition duration-300 shadow-lg">
                    Explore More
                </a>
                <a href="/activities" class="px-8 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-primary transition duration-300">
                    View Events
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- INTRODUCTION SECTION -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Student Image -->
            <div class="relative">
                <img src="/assets/images/school/school_view.png" 
                     alt="Students with books" 
                     class="rounded-2xl shadow-2xl w-full object-cover h-[400px]">
                <!-- Decorative Element -->
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-primary rounded-full opacity-20"></div>
                <div class="absolute -top-6 -left-6 w-24 h-24 bg-primary-light rounded-full opacity-20"></div>
            </div>
            
            <!-- Right Side - Text Box -->
            <div class="relative">
                <div class="bg-primary/90 backdrop-blur-sm rounded-2xl p-8 shadow-xl text-white">
                    <h2 class="text-3xl font-bold mb-6">About PIC</h2>
                    <p class="text-lg leading-relaxed text-gray-100">
                        PIC aims to prepare students for future academic and professional challenges by combining modern teaching methods, character development, and diverse extracurricular activities in a supportive and multicultural school community.
                    </p>
                    <div class="mt-8 flex gap-8 left">
                        <div class="text-left ">
                            <span class="block text-3xl font-bold">500+
                                <span class="text-sm text-gray-300">Students</span>
                            </span> 
                        </div>
                        <div class="text-left">
                            <span class="block text-3xl font-bold">50+
                                <span class="text-sm text-gray-300">Teachers</span>
                            </span>
                        </div>
                        <div class="text-left"></div>
                            <span class="block text-3xl font-bold">20+
                                <span class="text-sm text-gray-300">Events</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NEWS SECTION -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-primary mb-4">Latest News</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Stay updated with the latest activities and events at PIC</p>
        </div>
        
        <!-- News Grid - 2x2 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- News Card 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    <img src="/assets/images/latest/national_robotic_championship.png" 
                         alt="National Robotic Championship" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Victory Celebration: National Robotics Championship Award Ceremony</h3>
                    <p class="text-gray-600">Inspiring the next generation of engineers</p>
                </div>
            </div>
            
            <!-- News Card 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    <img src="/assets/images/latest/repla_brick.png" 
                         alt="Community Service" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">UMKM Empowerment Fair: Supporting Local Businesses Through Digital Innovation</h3>
                    <p class="text-gray-600">Empowering local businesses through modern technology</p>
                </div>
            </div>
            
            <!-- News Card 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    <img src="/assets/images/latest/umkm_empowerment.png" 
                         alt="Sports Day" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Eco-Innovation Showcase: REPLA-BRICK Sustainable Paving Solutions</h3>
                    <p class="text-gray-600">Revolutionizing construction with recycled materials</p>
                </div>
            </div>
            
            <!-- News Card 4 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    <img src="/assets/images/latest/youth_voices_circle.png" 
                         alt="Cultural Festival" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Youth Voices Circle: Forum Diskusi Kesehatan Mental</h3>
                    <p class="text-gray-600">Sharing stories to build emotional resilience</p>
                </div>
            </div>
        </div>
    </div>
</section>

