<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$history = $data['history'] ?? [];
$totalActivities = $data['totalActivities'] ?? 0;
$completedActivities = $data['completedActivities'] ?? 0;
$userName = \App\Core\Session::getUserName();
?>

<!-- Volunteer History Page -->
<div class="page-header">
    <div class="container">
        <h1>My Volunteer History</h1>
        <p>Welcome back, <?= htmlspecialchars($userName ?? 'Student') ?>!</p>
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

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm3.78-9.72a.751.751 0 0 1-.018-1.042.751.751 0 0 1 1.042-.018L12 11.94l1.258-1.258a.75.75 0 1 1 1.06 1.06l-1.768 1.768a.75.75 0 0 1-1.06 0l-2.122-2.122a.75.75 0 0 1 .018-1.042z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?= $totalActivities ?></span>
                <span class="stat-label">Total Activities</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?= $completedActivities ?></span>
                <span class="stat-label">Completed</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon pending">
                <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 4a4 4 0 1 1 0 8 4 4 0 0 1 0-8zm0 1.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM8 0a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V.75A.75.75 0 0 1 8 0zm0 13a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 8 13zM2.343 8a.75.75 0 0 1 .055-.976l1.5-1.5a.75.75 0 1 1 1.084 1.024L4.197 8l.985.984a.75.75 0 0 1-.024 1.02l-1.5 1.5A.75.75 0 0 1 2.343 8zm11.314 0a.75.75 0 0 1 .024-1.02l1.5-1.5a.75.75 0 1 1 1.084 1.024L11.803 8l.985.984a.75.75 0 0 1-.024 1.02l-1.5 1.5a.75.75 0 0 1-1.084-1.024z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?= $totalActivities - $completedActivities ?></span>
                <span class="stat-label">Pending/Ongoing</span>
            </div>
        </div>
    </div>

    <!-- History List -->
    <div class="history-section">
        <h2>Activity History</h2>
        
        <?php if (empty($history)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm3.78-9.72a.751.751 0 0 1-.018-1.042.751.751 0 0 1 1.042-.018L12 11.94l1.258-1.258a.75.75 0 1 1 1.06 1.06l-1.768 1.768a.75.75 0 0 1-1.06 0l-2.122-2.122a.75.75 0 0 1 .018-1.042z"/>
                    </svg>
                </div>
                <h3>No Activities Yet</h3>
                <p>You haven't registered for any social activities yet.</p>
                <a href="/activities" class="btn btn-primary">Browse Activities</a>
            </div>
        <?php else: ?>
            <div class="history-list">
                <?php foreach ($history as $item): ?>
                    <div class="history-card">
                        <div class="history-status">
                            <span class="status-badge status-<?= $item['volunteer_status'] ?>">
                                <?= ucfirst($item['volunteer_status']) ?>
                            </span>
                        </div>
                        <div class="history-content">
                            <h3><?= htmlspecialchars($item['activity_title']) ?></h3>
                            <div class="history-meta">
                                <span>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    <?= date('d M Y', strtotime($item['activity_date'])) ?>
                                </span>
                                <span>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                    <?= htmlspecialchars($item['location']) ?>
                                </span>
                            </div>
                            <div class="history-actions">
                                <a href="/activities/<?= $item['activity_id'] ?>" class="btn btn-sm btn-outline">View Details</a>
                                <?php if (in_array($item['volunteer_status'], ['registered', 'confirmed'])): ?>
                                    <form action="/volunteers/<?= $item['id'] ?>/cancel" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel?')">Cancel</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
    color: white;
    padding: 50px 0;
    text-align: center;
}

.page-header h1 {
    font-family: 'Kameron', serif;
    font-size: 32px;
    margin-bottom: 10px;
}

.page-header p {
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    opacity: 0.9;
}

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
    background: #F5F7FA;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #043460;
}

.stat-icon.success {
    background: #ECFDF5;
    color: #10B981;
}

.stat-icon.pending {
    background: #FFFBEB;
    color: #F59E0B;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-family: 'Kameron', serif;
    font-size: 28px;
    font-weight: bold;
    color: #043460;
}

.stat-label {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
}

.history-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 60px;
}

.history-section h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 22px;
    color: #043460;
    margin-bottom: 25px;
}

.history-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.history-card {
    display: flex;
    gap: 20px;
    padding: 20px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.history-card:hover {
    border-color: #CA9F37;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.history-status {
    display: flex;
    align-items: flex-start;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-family: 'Kanit', sans-serif;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-registered { background: #DBEAFE; color: #2563EB; }
.status-confirmed { background: #FEF3C7; color: #D97706; }
.status-completed { background: #D1FAE5; color: #059669; }
.status-cancelled { background: #FEE2E2; color: #DC2626; }
.status-rejected { background: #F3F4F6; color: #6B7280; }

.history-content {
    flex: 1;
}

.history-content h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 18px;
    color: #043460;
    margin-bottom: 10px;
}

.history-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.history-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
}

.history-meta svg {
    color: #CA9F37;
}

.history-actions {
    display: flex;
    gap: 10px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: #CA9F37;
    color: white;
}

.btn-primary:hover {
    background: #D8B25A;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 13px;
}

.btn-outline {
    border: 2px solid #043460;
    background: transparent;
    color: #043460;
}

.btn-outline:hover {
    background: #043460;
    color: white;
}

.btn-danger {
    background: #EF4444;
    color: white;
}

.btn-danger:hover {
    background: #DC2626;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    color: #CA9F37;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    font-family: 'Kanit', sans-serif;
    color: #043460;
    margin-bottom: 10px;
}

.empty-state p {
    font-family: 'Crimson Pro', serif;
    color: #64748B;
    margin-bottom: 25px;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-family: 'Crimson Pro', serif;
}

.alert-error {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #DC2626;
}

.alert-success {
    background: #F0FDF4;
    border: 1px solid #BBF7D0;
    color: #16A34A;
}
</style>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
