<?php // app/views/layouts/navbar.php ?>

<!-- Floating Navigation Bar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-primary/95 backdrop-blur-sm shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <span class="text-primary font-bold text-lg">PIC</span>
                    </div>
                    <span class="text-white font-semibold text-sm hidden md:block">Pontianak International College</span>
                </a>
            </div>
            
            <!-- Centered Navigation Menu -->
            <div class="hidden md:block">
                <div class="flex items-center space-x-2">
                    <a href="#" class="px-5 py-2 rounded-full bg-primary-dark text-white font-medium transition-all duration-300 hover:bg-primary-light">
                        Home
                    </a>
                    <a href="#" class="px-5 py-2 rounded-full bg-white/10 text-white font-medium transition-all duration-300 hover:bg-white/20">
                        Events
                    </a>
                    <a href="#" class="px-5 py-2 rounded-full bg-white/10 text-white font-medium transition-all duration-300 hover:bg-white/20">
                        History
                    </a>
                    <a href="#" class="px-5 py-2 rounded-full bg-white/10 text-white font-medium transition-all duration-300 hover:bg-white/20">
                        Profile
                    </a>
                </div>
            </div>
            
            <!-- Right Side Buttons -->
            <div class="flex items-center space-x-3">
                <a href="/auth/login" class="px-5 py-2 rounded-full bg-white text-primary font-medium transition-all duration-300 hover:bg-gray-100">
                    Login
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center transition-all duration-300 hover:bg-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-primary-dark">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#" class="block px-3 py-2 rounded-md bg-primary-light text-white font-medium">Home</a>
            <a href="#" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Events</a>
            <a href="#" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">History</a>
            <a href="#" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Profile</a>
            <a href="/auth/login" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Login</a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>

