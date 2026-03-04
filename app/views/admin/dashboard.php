<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');

$activityStats = $data['activityStats'] ?? [];
$totalUsers = $data['totalUsers'] ?? 0;
$pendingSuggestions = $data['pendingSuggestions'] ?? 0;
$recentActivities = $data['recentActivities'] ?? [];
$recentVolunteers = $data['recentVolunteers'] ?? [];
$recentDonations = $data['recentDonations'] ?? [];
$totalDonations = $data['totalDonations'] ?? 0;
$totalVolunteers = $data['totalVolunteers'] ?? 0;
$userName = $data['userName'] ?? '';
?>

<!-- Admin Dashboard -->
<div class="dashboard-header">
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, <?= htmlspecialchars($userName) ?>! Manage your PIC Social Activities here.</p>
    </div>
</div>

<div class="container">
    <!-- Alerts -->
    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $activityStats['total'] ?? 0 ?></span>
                <span class="stat-label">Total Activities</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $totalVolunteers ?></span>
                <span class="stat-label">Total Volunteers</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon gold">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">Rp <?= number_format($totalDonations, 0, ',', '.') ?></span>
                <span class="stat-label">Total Donations</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $totalUsers ?></span>
                <span class="stat-label">Total Users</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="/activities/create" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                <span>New Activity</span>
            </a>
            <a href="/admin/users/create" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path d="M8 0a.5.5 0 0 1 .5.5v.93a5.99 5.99 0 0 1-.986 2.91l-.894 1.337a.5.5 0 0 1-.635.228l-1.218-.812a.5.5 0 0 1-.195-.595l.894-1.337a5.99 5.99 0 0 1-.986-2.91V.5A.5.5 0 0 1 8 0z"/>
                    <path d="M3 4v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4H3z"/>
                </svg>
                <span>Add User</span>
            </a>
            <a href="/volunteers" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022z"/>
                </svg>
                <span>Manage Volunteers</span>
            </a>
            <a href="/donations" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4z"/>
                </svg>
                <span>Manage Donations</span>
            </a>
            <a href="/suggestions" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span>Suggestions <?php if($pendingSuggestions > 0): ?>(<?= $pendingSuggestions ?>)<?php endif; ?></span>
            </a>
            <a href="/admin/users" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z"/>
                </svg>
                <span>Manage Users</span>
            </a>
        </div>
    </div>

    <!-- Recent Data Grid -->
    <div class="recent-grid">
        <!-- Recent Activities -->
        <div class="recent-card">
            <div class="card-header">
                <h3>Recent Activities</h3>
                <a href="/activities" class="view-all">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentActivities)): ?>
                    <p class="empty">No activities yet</p>
                <?php else: ?>
                    <ul class="recent-list">
                        <?php foreach ($recentActivities as $activity): ?>
                            <li>
                                <div class="list-content">
                                    <strong><?= htmlspecialchars($activity['title']) ?></strong>
                                    <span><?= date('d M Y', strtotime($activity['activity_date'])) ?> - <?= htmlspecialchars($activity['location']) ?></span>
                                </div>
                                <span class="status-badge status-<?= $activity['status'] ?>"><?= ucfirst($activity['status']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Volunteers -->
        <div class="recent-card">
            <div class="card-header">
                <h3>Recent Volunteers</h3>
                <a href="/volunteers" class="view-all">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentVolunteers)): ?>
                    <p class="empty">No volunteers yet</p>
                <?php else: ?>
                    <ul class="recent-list">
                        <?php foreach ($recentVolunteers as $volunteer): ?>
                            <li>
                                <div class="list-content">
                                    <strong><?= htmlspecialchars($volunteer['user_name']) ?></strong>
                                    <span><?= htmlspecialchars($volunteer['activity_title']) ?></span>
                                </div>
                                <span class="status-badge status-<?= $volunteer['status'] ?>"><?= ucfirst($volunteer['status']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="recent-card">
            <div class="card-header">
                <h3>Recent Donations</h3>
                <a href="/donations" class="view-all">View All</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentDonations)): ?>
                    <p class="empty">No donations yet</p>
                <?php else: ?>
                    <ul class="recent-list">
                        <?php foreach ($recentDonations as $donation): ?>
                            <li>
                                <div class="list-content">
                                    <strong><?= htmlspecialchars($donation['donor_name']) ?></strong>
                                    <span>Rp <?= number_format($donation['amount'], 0, ',', '.') ?></span>
                                </div>
                                <span class="status-badge status-<?= $donation['status'] ?>"><?= ucfirst($donation['status']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-header {
    background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
    color: white;
    padding: 50px 0;
    text-align: center;
}

.dashboard-header h1 { font-family: 'Kameron', serif; font-size: 32px; margin-bottom: 10px; }
.dashboard-header p { font-family: 'Crimson Pro', serif; font-size: 16px; opacity: 0.9; }

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-icon.blue { background: #043460; }
.stat-icon.green { background: #10B981; }
.stat-icon.gold { background: #CA9F37; }
.stat-icon.purple { background: #8B5CF6; }

.stat-content { display: flex; flex-direction: column; }
.stat-value { font-family: 'Kameron', serif; font-size: 26px; font-weight: bold; color: #043460; }
.stat-label { font-family: 'Crimson Pro', serif; font-size: 14px; color: #64748B; }

.quick-actions {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.quick-actions h2 { font-family: 'Kanit', sans-serif; font-size: 20px; color: #043460; margin-bottom: 20px; }

.action-buttons { display: flex; gap: 15px; flex-wrap: wrap; }

.action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 25px;
    background: #F5F7FA;
    border-radius: 10px;
    text-decoration: none;
    color: #043460;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: #CA9F37;
    color: white;
    transform: translateY(-2px);
}

.action-btn svg { color: #CA9F37; }
.action-btn:hover svg { color: white; }

.recent-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 60px;
}

.recent-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #E2E8F0;
}

.card-header h3 { font-family: 'Kanit', sans-serif; font-size: 16px; color: #043460; margin: 0; }

.view-all {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #CA9F37;
    text-decoration: none;
}

.view-all:hover { text-decoration: underline; }

.card-body { padding: 15px; }

.recent-list { list-style: none; padding: 0; margin: 0; }

.recent-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #F1F5F9;
}

.recent-list li:last-child { border-bottom: none; }

.list-content { display: flex; flex-direction: column; }
.list-content strong { font-family: 'Kanit', sans-serif; font-size: 14px; color: #1E293B; }
.list-content span { font-family: 'Crimson Pro', serif; font-size: 13px; color: #64748B; }

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-family: 'Kanit', sans-serif;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-upcoming { background: #D1FAE5; color: #059669; }
.status-pending { background: #FEF3C7; color: #D97706; }
.status-completed { background: #DBEAFE; color: #2563EB; }
.status-registered { background: #E0E7FF; color: #4F46E5; }

.empty { font-family: 'Crimson Pro', serif; color: #94A3B8; text-align: center; padding: 30px; }

.alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-family: 'Crimson Pro', serif; }
.alert-error { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; }
.alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #16A34A; }
</style>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
