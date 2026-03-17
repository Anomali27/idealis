<?php use App\Core\Session; ?>
<!-- Fixed Navigation Bar with States -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-primary/95 backdrop-blur-md shadow-lg border-b border-white/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo (Fixed Aspect) -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <img src="/assets/images/logo_white.png" alt="PIC Logo" class="h-30 md:h-36 w-auto object-contain">
                </a>
            </div>
            
            <!-- Desktop Center Menu (Dynamic States) -->
            <div class="hidden md:flex items-center space-x-2">
                <?php 
                $menuItems = ['Home'];
                $links = ['/'];
                
                if (Session::isLoggedIn()) {
                    $menuItems[] = 'Events';
                    $links[] = '/activities';
                    $menuItems[] = 'History';
                    $links[] = '/volunteers/history'; // student/teacher
                    if (Session::getUserRole() === 'admin') {
                        $menuItems[] = 'Dashboard';
                        $links[] = '/admin/dashboard';
                    }
                } else {
                    $menuItems[] = 'Events';
                    $links[] = '/activities';
                }
                
                foreach($menuItems as $index => $item): 
                ?>
                    <a href="<?php echo htmlspecialchars($links[$index]); ?>" class="px-4 md:px-5 py-2 rounded-full font-medium transition-all duration-300 <?php echo ($item === 'Home') ? 'bg-primary-dark/90 text-white hover:bg-primary-dark' : 'text-white/90 hover:bg-white/20 hover:text-white'; ?>">
                        <?php echo htmlspecialchars($item); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <!-- Right Side (Dynamic) -->
            <div class="flex items-center space-x-2 md:space-x-3">
                <?php if (!Session::isLoggedIn()): ?>
                    <!-- Guest: Login -->
                    <a href="/auth/login" class="px-4 md:px-5 py-2 rounded-full bg-white text-primary font-medium text-sm md:text-base transition-all duration-300 hover:bg-gray-100 shadow-sm">
                        Login
                    </a>
                <?php else: 
                    $userName = Session::getUserName();
                    $role = Session::getUserRole();
                    $displayName = ($role === 'admin') ? 'admin' : $userName;
                    $initials = strtoupper(substr($displayName, 0, 2)); // First 2 uppercase
                ?>
                    <!-- Logged In: Name + Avatar Dropdown -->
                    <div class="flex items-center space-x-2">
                        <span class="text-white/90 font-medium text-sm md:text-base hidden lg:block"><?php echo htmlspecialchars($displayName); ?></span>
                        <div class="relative" onmouseenter="showDropdown()" onmouseleave="hideDropdown()">
                            <button class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all duration-300 text-white font-semibold text-sm md:text-base">
                                <?php echo htmlspecialchars($initials); ?>
                            </button>
                            <!-- Dropdown -->
                            <div id="dropdown-menu" class="absolute right-0 md:right-2 top-full mt-2 w-48 bg-white/90 backdrop-blur-md shadow-xl rounded-xl py-2 opacity-0 invisible transform scale-95 transition-all duration-200 origin-top-right z-50 hidden">
                                <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded-lg font-medium transition-colors">Settings</a>
                                <a href="/logout" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded-lg font-medium transition-colors">Logout</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
    
    <!-- Mobile Menu (Simplified Dynamic) -->
    <div id="mobile-menu" class="hidden md:hidden bg-primary-dark/95 backdrop-blur-sm">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 rounded-md bg-primary-light text-white font-medium">Home</a>
            <a href="/activities" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Events</a>
            <?php if (Session::isLoggedIn()): ?>
                <a href="/volunteers/history" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">History</a>
                <?php if (Session::getUserRole() === 'admin'): ?>
                    <a href="/admin/dashboard" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Dashboard</a>
                <?php endif; ?>
                <a href="/profile" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium"><?php echo htmlspecialchars($userName ?? 'Profile'); ?></a>
                <a href="/logout" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Logout</a>
            <?php else: ?>
                <a href="/auth/login" class="block px-3 py-2 rounded-md text-white hover:bg-white/10 font-medium">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

function showDropdown() {
    document.getElementById('dropdown-menu').classList.remove('opacity-0', 'invisible', 'scale-95', 'hidden');
    document.getElementById('dropdown-menu').classList.add('opacity-100', 'visible', 'scale-100');
}

function hideDropdown() {
    document.getElementById('dropdown-menu').classList.add('opacity-0', 'invisible', 'scale-95', 'hidden');
}
</script>
