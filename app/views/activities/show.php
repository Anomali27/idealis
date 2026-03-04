<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$activity = $data['activity'] ?? [];
$isRegistered = $data['isRegistered'] ?? false;
$isLoggedIn = $data['isLoggedIn'] ?? false;
$userRole = \App\Core\Session::getUserRole();

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
?>

<!-- Activity Detail Page -->
<div class="activity-detail-page">
    <!-- Hero Section -->
    <div class="activity-hero">
        <div class="container">
            <a href="/activities" class="back-link">← Back to Activities</a>
            <span class="activity-status status-<?= $activity['status'] ?>">
                <?= ucfirst($activity['status']) ?>
            </span>
            <h1><?= htmlspecialchars($activity['title']) ?></h1>
            <p class="activity-organizer">Organized by <?= htmlspecialchars($activity['creator_name'] ?? 'PIC') ?></p>
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

        <div class="activity-detail-grid">
            <!-- Main Content -->
            <div class="activity-main">
                <!-- Cover Image -->
                <div class="activity-cover">
                    <?php if ($activity['cover_image']): ?>
                        <img src="<?= htmlspecialchars($activity['cover_image']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>">
                    <?php else: ?>
                        <div class="cover-placeholder">
                            <span>PIC</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="activity-section">
                    <h2>About This Activity</h2>
                    <div class="activity-description">
                        <?= nl2br(htmlspecialchars($activity['description'] ?? 'No description available.')) ?>
                    </div>
                </div>

                <!-- Requirements -->
                <?php if ($activity['requirements']): ?>
                    <div class="activity-section">
                        <h2>Requirements</h2>
                        <div class="activity-requirements">
                            <?= nl2br(htmlspecialchars($activity['requirements'])) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="activity-sidebar">
                <!-- Event Info Card -->
                <div class="info-card">
                    <h3>Event Details</h3>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Date</span>
                            <span class="info-value"><?= date('l, d F Y', strtotime($activity['activity_date'])) ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Time</span>
                            <span class="info-value"><?= date('H:i', strtotime($activity['activity_time'])) ?> WIB</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Location</span>
                            <span class="info-value"><?= htmlspecialchars($activity['location']) ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Volunteers</span>
                            <span class="info-value">
                                <?= $activity['volunteer_count'] ?? 0 ?> / <?= $activity['max_volunteers'] ?: '∞' ?> registered
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="action-card">
                    <?php if ($activity['status'] === 'cancelled'): ?>
                        <div class="action-message error">
                            This activity has been cancelled.
                        </div>
                    <?php elseif ($activity['status'] === 'completed'): ?>
                        <div class="action-message">
                            This activity has been completed.
                        </div>
                    <?php elseif ($isRegistered): ?>
                        <div class="action-message success">
                            ✓ You are registered as a volunteer!
                        </div>
                        <a href="/volunteers/history" class="btn btn-outline">View My Activities</a>
                    <?php elseif (!$isLoggedIn): ?>
                        <p class="login-prompt">Please login to register as a volunteer.</p>
                        <a href="/auth/login" class="btn btn-primary btn-full">Login to Register</a>
                    <?php else: ?>
                        <a href="/volunteers/register/<?= $activity['id'] ?>" class="btn btn-primary btn-full">Register as Volunteer</a>
                    <?php endif; ?>
                </div>

                <!-- Admin Actions -->
                <?php if (in_array($userRole, ['admin', 'committee'])): ?>
                    <div class="admin-card">
                        <h3>Admin Actions</h3>
                        <div class="admin-buttons">
                            <a href="/activities/<?= $activity['id'] ?>/edit" class="btn btn-secondary">Edit Activity</a>
                            <?php if ($userRole === 'admin'): ?>
                                <form action="/activities/<?= $activity['id'] ?>/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this activity?')">
                                    <button type="submit" class="btn btn-danger">Delete Activity</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.activity-detail-page {
    background: #F5F7FA;
    min-height: 100vh;
}

.activity-hero {
    background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
    padding: 40px 0 60px;
    color: white;
}

.activity-hero .container {
    position: relative;
}

.back-link {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    transition: color 0.3s;
}

.back-link:hover {
    color: white;
}

.activity-hero .activity-status {
    position: absolute;
    top: 0;
    right: 0;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Kanit', sans-serif;
    text-transform: uppercase;
}

.activity-hero h1 {
    font-family: 'Kameron', serif;
    font-size: 36px;
    margin: 20px 0 10px;
}

.activity-organizer {
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    opacity: 0.9;
}

.activity-detail-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
    margin-top: -30px;
}

.activity-main {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.activity-cover {
    height: 300px;
    background: #f0f0f0;
}

.activity-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
    color: white;
    font-family: 'Kameron', serif;
    font-size: 48px;
    font-weight: bold;
}

.activity-section {
    padding: 30px;
    border-bottom: 1px solid #E2E8F0;
}

.activity-section:last-child {
    border-bottom: none;
}

.activity-section h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 20px;
    color: #043460;
    margin-bottom: 15px;
}

.activity-description,
.activity-requirements {
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    line-height: 1.8;
    color: #1E293B;
}

.activity-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-card,
.action-card,
.admin-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.info-card h3,
.admin-card h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 18px;
    color: #043460;
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 20px;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: #F5F7FA;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #CA9F37;
}

.info-content {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-family: 'Kanit', sans-serif;
    font-size: 12px;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-family: 'Crimson Pro', serif;
    font-size: 15px;
    color: #1E293B;
    margin-top: 2px;
}

.action-card {
    text-align: center;
}

.action-message {
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    color: #043460;
    margin-bottom: 20px;
}

.action-message.success {
    color: #10B981;
}

.action-message.error {
    color: #EF4444;
}

.login-prompt {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
    margin-bottom: 15px;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    width: 100%;
}

.btn-primary {
    background: #CA9F37;
    color: white;
}

.btn-primary:hover {
    background: #D8B25A;
}

.btn-secondary {
    background: #043460;
    color: white;
}

.btn-outline {
    background: transparent;
    border: 2px solid #043460;
    color: #043460;
    margin-top: 10px;
}

.btn-outline:hover {
    background: #043460;
    color: white;
}

.btn-danger {
    background: #EF4444;
    color: white;
    width: 100%;
    margin-top: 10px;
}

.btn-full {
    width: 100%;
}

.admin-card {
    border: 2px solid #CA9F37;
}

.admin-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
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

@media (max-width: 768px) {
    .activity-detail-grid {
        grid-template-columns: 1fr;
    }
    
    .activity-hero h1 {
        font-size: 28px;
    }
}
</style>

<?php
// Include footer
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
