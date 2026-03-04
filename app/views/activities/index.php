<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';
use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$activities = $data['activities'] ?? [];
$filters = $data['filters'] ?? [];
$statuses = $data['statuses'] ?? [];
$isLoggedIn = \App\Core\Session::isLoggedIn();
$userRole = \App\Core\Session::getUserRole();
?>

<!-- Activities Page -->
<div class="page-header">
    <div class="container">
        <h1>Social Activities</h1>
        <p>Browse and join social activities at Pontianak International College</p>
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

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="/activities" class="filters-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search activities..." 
                       value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="form-input">
            </div>
            <div class="filter-group">
                <select name="status" class="form-input">
                    <option value="">All Status</option>
                    <?php foreach ($statuses as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($filters['status'] ?? '') === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/activities" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        
        <?php if (in_array($userRole, ['admin', 'committee'])): ?>
            <div class="action-buttons">
                <a href="/activities/create" class="btn btn-primary">+ Create Activity</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Activities Grid -->
    <?php if (empty($activities)): ?>
        <div class="empty-state">
            <h3>No activities found</h3>
            <p>There are no activities matching your criteria.</p>
        </div>
    <?php else: ?>
        <div class="activities-grid">
            <?php foreach ($activities as $activity): ?>
                <div class="activity-card">
                    <div class="activity-image">
                        <?php if ($activity['cover_image']): ?>
                            <img src="<?= htmlspecialchars($activity['cover_image']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>">
                        <?php else: ?>
                            <div class="activity-placeholder">
                                <span>PIC</span>
                            </div>
                        <?php endif; ?>
                        <span class="activity-status status-<?= $activity['status'] ?>">
                            <?= ucfirst($activity['status']) ?>
                        </span>
                    </div>
                    <div class="activity-content">
                        <h3><?= htmlspecialchars($activity['title']) ?></h3>
                        <p class="activity-description">
                            <?= htmlspecialchars(substr($activity['description'] ?? '', 0, 100)) ?>
                            <?php if (strlen($activity['description'] ?? '') > 100): ?>...<?php endif; ?>
                        </p>
                        <div class="activity-meta">
                            <div class="meta-item">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                </svg>
                                <?= date('d M Y', strtotime($activity['activity_date'])) ?>
                            </div>
                            <div class="meta-item">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg>
                                <?= date('H:i', strtotime($activity['activity_time'])) ?>
                            </div>
                            <div class="meta-item">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <?= htmlspecialchars($activity['location']) ?>
                            </div>
                        </div>
                        <div class="activity-volunteers">
                            <span class="volunteer-count">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                                <?= $activity['volunteer_count'] ?? 0 ?> / <?= $activity['max_volunteers'] ?: '∞' ?> volunteers
                            </span>
                        </div>
                        <a href="/activities/<?= $activity['id'] ?>" class="btn btn-outline">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
}

.page-header h1 {
    font-family: 'Kameron', serif;
    font-size: 36px;
    margin-bottom: 10px;
}

.page-header p {
    font-family: 'Crimson Pro', serif;
    font-size: 18px;
    opacity: 0.9;
}

.filters-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 30px 0;
    flex-wrap: wrap;
    gap: 20px;
}

.filters-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-group input,
.filter-group select {
    min-width: 200px;
}

.activities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.activity-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.activity-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.activity-image {
    height: 180px;
    background: #f0f0f0;
    position: relative;
}

.activity-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.activity-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
    color: white;
    font-family: 'Kameron', serif;
    font-size: 32px;
    font-weight: bold;
}

.activity-status {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    font-family: 'Kanit', sans-serif;
    text-transform: uppercase;
}

.status-upcoming { background: #10B981; color: white; }
.status-ongoing { background: #F59E0B; color: white; }
.status-completed { background: #6B7280; color: white; }
.status-draft { background: #9CA3AF; color: white; }
.status-cancelled { background: #EF4444; color: white; }

.activity-content {
    padding: 20px;
}

.activity-content h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 20px;
    color: #043460;
    margin-bottom: 10px;
}

.activity-description {
    font-family: 'Crimson Pro', serif;
    color: #64748B;
    font-size: 15px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.activity-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 15px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
}

.meta-item svg {
    color: #CA9F37;
}

.activity-volunteers {
    margin-bottom: 15px;
}

.volunteer-count {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    color: #043460;
}

.volunteer-count svg {
    color: #CA9F37;
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

.btn-secondary {
    background: #6B7280;
    color: white;
}

.btn-outline {
    width: 100%;
    text-align: center;
    border: 2px solid #043460;
    color: #043460;
    background: transparent;
}

.btn-outline:hover {
    background: #043460;
    color: white;
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

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state h3 {
    font-family: 'Kanit', sans-serif;
    color: #64748B;
    margin-bottom: 10px;
}

.empty-state p {
    font-family: 'Crimson Pro', serif;
    color: #9CA3AF;
}
</style>

<?php
// Include footer
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
