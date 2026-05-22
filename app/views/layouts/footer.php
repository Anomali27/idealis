<?php // Modern Tailwind Footer ?>

<footer class="bg-gradient-to-b from-primary to-primary-dark text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16 mb-12">
            <!-- Brand -->
            <a href="/" class="flex items-center">
                <img src="/assets/images/logo/logo-white.png" alt="PIC Logo" class="h-30 md:h-36 w-auto object-contain">
            </a>

            <!-- Quick Links -->
            <div>
                <h4 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Links
                </h4>
                <ul class="space-y-3">
                    <li><a href="/"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 0 0 1 1h3m10-11l2 2m-2-2v10a1 1 0 0 1-1 1h-3m-6 0a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1m0 0V9a1 1 0 0 0 1-1h2a1 1 0 0 0 1 1v9a1 1 0 0 1-1 1h-2a1 1 0 0 0-1 1m0 0V9a1 1 0 0 1-1-1H8a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1z" />
                            </svg>
                            Home
                        </a></li>
                    <li><a href="/events"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z" />
                            </svg>
                            Events
                        </a></li>
                    <li><a href="/history"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            History
                        </a></li>
                    <li><a href="/suggestion"
                            class="group flex items-center gap-3 text-gray-300 hover:text-white hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Suggestion
                        </a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Contact
                </h4>
                <div class="space-y-3 text-gray-300">
                    <p>Pontianak, West Kalimantan</p>
                    <p>📧 info@pic.ac.id</p>
                    <p>📱 +62 561 123 4567</p>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/20 pt-8 mt-12 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-300 text-sm">© 2026 PIC Social Activity System. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Global Modal & Notification System -->
<?php require_once __DIR__ . '/partials/modal_system.php'; ?>

<!-- Scripts -->
<script src="/js/script.js"></script>
</body>

</html>