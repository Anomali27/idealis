<?php // app/views/news/show.php ?>

<!-- News Detail Hero -->
<section class="relative pt-20">
    <div class="relative h-[40vh] md:h-[50vh] overflow-hidden">
        <img src="<?= htmlspecialchars($news['image_url'] ?? '/assets/images/latest/national-robotic-championship.png') ?>" 
             alt="<?= htmlspecialchars($news['title']) ?>" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    <span class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-full shadow-md">
                        <?= htmlspecialchars($news['category'] ?? 'News') ?>
                    </span>
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full border border-white/30">
                        <?= date('l, d F Y', strtotime($news['date'])) ?>
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-white font-poppins leading-tight">
                    <?= htmlspecialchars($news['title']) ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- News Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
<?= htmlspecialchars($news['description'] ?? '') ?>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Home
            </a>
            
            <!-- Optional Social Share Buttons could go here -->
        </div>

    </div>
</section>
