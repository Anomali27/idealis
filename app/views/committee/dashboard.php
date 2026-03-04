<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');

$myActivities = $data['myActivities'] ?? [];
$totalActivities = $data['totalActivities'] ?? 0;
$upcomingActivities = $data['upcomingActivities'] ?? 0;
$totalVolunteers = $data['totalVolunteers'] ?? 0;
$totalDonations = $data['totalDonations'] ?? 0;
$volunteers = $data['volunteers'] ?? [];
$userName = $data['userName'] ?? '';
$isAdmin = $data['isAdmin'] ?? false;
?>

<!-- Committee Dashboard -->
<div class="dashboard-header">
    <div class="container">
        <h1>Committee Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($userName) ?>! Manage your activities here.</p>
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
                <span class="stat-value"><?= $totalActivities ?></span>
                <span class="stat-label">My Activities</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $upcomingActivities ?></span>
                <span class="stat-label">Upcoming</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
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
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="/activities/create" class="action-btn">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                <span>Create Activity</span>
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
                <span>View Donations</span>
            </a>
            <?php if ($isAdmin): ?>
                <a href="/admin/dashboard" class="action-btn admin-link">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7A2 2 0 0 1 2.19 3h3.982a2 2 0 0 0 1.414-.586l.828-.828A2 2 0 0 1 9.828 1h0a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 13.164 3h3.982a2 2 0 0 0 1.414-.586l.828-.828A2 2 0 0 0 16.172 3H13.164zM2.19 3a1 1 0 0 0-.996 1.09l.637 7A1 1 0 0 0 2.826 11h10.348a1 1 0 0 0 .996-1.09l.637-7A1 1 0 0 0 13.81 3H2.19z"/>
                    </svg>
                    <span>Admin Panel</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- My Activities -->
    <div class="activities-section">
        <div class="section-header">
            <h2>My Activities</h2>
            <a href="/activities/create" class="btn btn-primary">+ New Activity</a>
        </div>

        <?php if (empty($myActivities)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2z"/>
                    </svg>
                </div>
                <h3>No Activities Yet</h3>
                <p>Create your first social activity!</p>
                <a href="/activities/create" class="btn btn-primary">Create Activity</a>
            </div>
        <?php else: ?>
            <div class="activities-grid">
                <?php foreach ($myActivities as $activity): ?>
                    <div class="activity-card">
                        <div class="activity-header">
                            <span class="status-badge status-<?= $activity['status'] ?>"><?= ucfirst($activity['status']) ?></span>
                            <span class="date"><?= date('d M Y', strtotime($activity['activity_date'])) ?></span>
                        </div>
                        <h3><?= htmlspecialchars($activity['title']) ?></h3>
                        <p><?= htmlspecialchars(substr($activity['description'] ?? '', 0, 100)) ?>...</p>
                        <div class="activity-stats">
                            <span><?= $activity['volunteer_count'] ?? 0 ?> volunteers</span>
                            <span><?= htmlspecialchars($activity['location']) ?></span>
                        </div>
                        <div class="activity-actions">
                            <a href="/activities/<?= $activity['id'] ?>" class="btn btn-sm btn-outline">View</a>
                            <a href="/activities/<?= $activity['id'] ?>/edit" class="btn btn-sm btn-secondary">Edit</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

.action-btn:hover { background: #CA9F37; color: white; transform: translateY(-2px); }
.action-btn svg { color: #CA9F37; }
.action-btn:hover svg { color: white; }
.action-btn.admin-link { background: #043460; color: white; }
.action-btn.admin-link:hover { background: #0A4A80; }
.action-btn.admin-link svg { color: #CA9F37; }

.activities-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 60px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.section-header h2 { font-family: 'Kanit', sans-serif; font-size: 20px; color: #043460; margin: 0; }

.activities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }

.activity-card {
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
}

.activity-card:hover { border-color: #CA9F37; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

.activity-header { display: flex; justify-content: space-between; margin-bottom: 10px; }

.date { font-family: 'Crimson Pro', serif; font-size: 13px; color: #64748B; }

.activity-card h3 { font-family: 'Kanit', sans-serif; font-size: 16px; color: #043460; margin-bottom: 8px; }

.activity-card p { font-family: 'Crimson Pro', serif; font-size: 14px; color: #64748B; line-height: 1.5; margin-bottom: 15px; }

.activity-stats { display: flex; gap: 15px; margin-bottom: 15px; }
.activity-stats span { font-family: 'Kanit', sans-serif; font-size: 13px; color: #64748B; }

.activity-actions { display: flex; gap: 10px; }

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-family: 'Kanit', sans-serif;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-upcoming { background: #D1FAE5; color: #059669; }
.status-ongoing { background: #FEF3C7; color: #D97706; }
.status-completed { background: #DBEAFE; color: #2563EB; }

.btn { display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-family: 'Kanit', sans-serif; font-size: 14px; font-weight: 600; transition: all 0.3s ease; cursor: pointer; border: none; }
.btn-primary { background: #CA9F37; color: white; }
.btn-primary:hover { background: #D8B25A; }
.btn-secondary { background: #043460; color: white; }
.btn-sm { padding: 8px 16px; font-size: 13px; }
.btn-outline { border: 2px solid #043460; background: transparent; color: #043460; }
.btn-outline:hover { background: #043460; color: white; }

.empty-state { text-align: center; padding: 60px 20px; }
.empty-icon { color: #CA9F37; opacity: 0.5; margin-bottom: 20px; }
.empty-state h3 { font-family: 'Kanit', sans-serif; color: #043460; margin-bottom: 10px; }
.empty-state p { font-family: 'Crimson Pro', serif; color: #64748B; margin-bottom: 20px; }

.alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-family: 'Crimson Pro', serif; }
.alert-error { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; }
.alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #16A34A; }
</style>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
