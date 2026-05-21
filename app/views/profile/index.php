<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>
<?php require_once dirname(__DIR__) . '/layouts/navbar.php'; ?>

<div class="pt-28 pb-16 bg-gradient-to-br from-slate-50 to-blue-50/35 min-h-screen font-poppins">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- User Profile Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden relative mb-8 group transition-all duration-300 hover:shadow-2xl">
            <!-- Decorative Accent top header -->
            <div class="h-32 bg-gradient-to-r from-primary via-primary-dark to-indigo-600 relative">
                <div class="absolute inset-0 opacity-15 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white via-primary to-black"></div>
            </div>
            
            <div class="px-8 pb-8 relative">
                <!-- Avatar block -->
                <div class="flex flex-col sm:flex-row sm:items-end justify-between -mt-16 mb-6 gap-4">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end gap-5">
                        <div class="w-32 h-32 bg-gradient-to-tr <?= $rankInfo['gradient'] ?> rounded-full p-1.5 shadow-xl relative shrink-0">
                            <div class="w-full h-full bg-white rounded-full flex items-center justify-center font-bold text-3xl text-slate-800">
                                <?php 
                                $words = preg_split('/\s+/', trim($user['name'] ?? 'U'));
                                $initials = strtoupper(($words[0][0] ?? '') . ($words[1][0] ?? ''));
                                if (empty($initials)) $initials = 'U';
                                echo htmlspecialchars($initials);
                                ?>
                            </div>
                            <!-- Small rank bubble badge -->
                            <div class="absolute -bottom-1 -right-1 w-10 h-10 <?= $rankInfo['blob'] ?> border-4 border-white text-white rounded-full flex items-center justify-center text-xs shadow-md" title="<?= htmlspecialchars($rankInfo['name']) ?> Rank">
                                🛡️
                            </div>
                        </div>
                        
                        <div class="text-center sm:text-left">
                            <h1 class="text-3xl font-extrabold text-slate-900 leading-tight tracking-tight">
                                <?= htmlspecialchars($user['name'] ?? '') ?>
                            </h1>
                            <p class="text-slate-500 text-sm mt-0.5"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 justify-center">
                        <span class="px-3.5 py-1.5 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 uppercase font-poppins">
                            <?= htmlspecialchars(ucfirst($user['role'] ?? 'Student')) ?>
                        </span>
                        <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-100 font-poppins flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Active Account
                        </span>
                    </div>
                </div>
                
                <!-- Bento stats -->
                <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-6">
                    <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 hover:bg-slate-50 transition-colors">
                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Social Events Joined</span>
                        <span class="text-2xl font-black text-slate-800"><?= $totalEvents ?></span>
                    </div>
                    <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 hover:bg-slate-50 transition-colors">
                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Donated</span>
                        <span class="text-2xl font-black text-emerald-600">Rp<?= number_format($totalDonations, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gamified Rank & Badges Panel -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Rank Standing & Achievement</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Participate in activities to scale through student rankings and earn prestige badges.</p>
                </div>
            </div>
            
            <div class="space-y-6">
                <!-- Rank progress bar -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Current Tier</span>
                            <span class="block text-xl font-black text-transparent bg-clip-text bg-gradient-to-r <?= $rankInfo['gradient'] ?> uppercase tracking-wider"><?= htmlspecialchars($rankInfo['name']) ?></span>
                        </div>
                        <span class="text-xs font-bold text-slate-500 font-poppins">Next Milestone: <?= htmlspecialchars($rankInfo['next_threshold']) ?> Events</span>
                    </div>
                    
                    <div class="w-full bg-slate-200 h-3 rounded-full overflow-hidden border border-white shadow-inner">
                        <div class="bg-gradient-to-r <?= $rankInfo['gradient'] ?> h-full rounded-full transition-all duration-500" style="width: <?= $rankInfo['progress'] ?>%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center text-[11px] font-bold text-slate-400 mt-2">
                        <span>Milestone Progress</span>
                        <span><?= round($rankInfo['progress']) ?>%</span>
                    </div>
                    
                    <p class="text-xs text-indigo-600 mt-3 font-semibold flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?= htmlspecialchars($rankInfo['message']) ?>
                    </p>
                </div>
                
                <!-- Rank Standings List -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-wider">Achievements Progression</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                        <div class="p-4 rounded-2xl border <?= $totalEvents >= 1 ? 'bg-amber-50/50 border-amber-200 text-amber-800' : 'bg-slate-50/50 border-slate-100 text-slate-400 opacity-60' ?> transition-all">
                            <span class="block text-2xl mb-1">🥉</span>
                            <span class="block text-xs font-bold uppercase font-poppins">Bronze Badge</span>
                            <span class="text-[9px] block text-slate-400">1 Event Joined</span>
                        </div>
                        <div class="p-4 rounded-2xl border <?= $totalEvents >= 3 ? 'bg-slate-100/50 border-slate-300 text-slate-800' : 'bg-slate-50/50 border-slate-100 text-slate-400 opacity-60' ?> transition-all">
                            <span class="block text-2xl mb-1">🥈</span>
                            <span class="block text-xs font-bold uppercase font-poppins">Silver Badge</span>
                            <span class="text-[9px] block text-slate-400">3 Events Joined</span>
                        </div>
                        <div class="p-4 rounded-2xl border <?= $totalEvents >= 5 ? 'bg-yellow-50/50 border-yellow-200 text-yellow-800' : 'bg-slate-50/50 border-slate-100 text-slate-400 opacity-60' ?> transition-all">
                            <span class="block text-2xl mb-1">🥇</span>
                            <span class="block text-xs font-bold uppercase font-poppins">Gold Badge</span>
                            <span class="text-[9px] block text-slate-400">5 Events Joined</span>
                        </div>
                        <div class="p-4 rounded-2xl border <?= $totalEvents >= 9 ? 'bg-cyan-50/50 border-cyan-200 text-cyan-800' : 'bg-slate-50/50 border-slate-100 text-slate-400 opacity-60' ?> transition-all">
                            <span class="block text-2xl mb-1">💎</span>
                            <span class="block text-xs font-bold uppercase font-poppins">Diamond Badge</span>
                            <span class="text-[9px] block text-slate-400">9+ Events Joined</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
