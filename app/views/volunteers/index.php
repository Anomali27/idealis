<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$volunteers = $data['volunteers'] ?? [];
$activities = $data['activities'] ?? [];
$filters = $data['filters'] ?? [];
$statuses = $data['statuses'] ?? [];
?>

<!-- Volunteers Management Page -->
<div class="page-header">
    <div class="container">
        <h1>Volunteer Management</h1>
        <p>Manage all volunteer registrations for PIC activities</p>
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
        <form method="GET" action="/volunteers" class="filters-form">
            <div class="filter-group">
                <select name="activity_id" class="form-input">
                    <option value="">All Activities</option>
                    <?php foreach ($activities as $activity): ?>
                        <option value="<?= $activity['id'] ?>" <?= ($filters['activity_id'] ?? '') == $activity['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($activity['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
                <input type="text" name="search" placeholder="Search by name or NIS..." 
                       value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="form-input">
            </div>
            <div class="filter-group">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/volunteers" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Volunteers Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Volunteer</th>
                    <th>Activity</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($volunteers)): ?>
                    <tr>
                        <td colspan="7" class="empty-cell">No volunteers found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($volunteers as $index => $volunteer): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name"><?= htmlspecialchars($volunteer['user_name']) ?></span>
                                    <span class="user-detail"><?= htmlspecialchars($volunteer['nis'] ?? '') ?> - <?= htmlspecialchars($volunteer['class'] ?? '') ?></span>
                                </div>
                            </td>
                            <td>
                                <a href="/activities/<?= $volunteer['activity_id'] ?>" class="activity-link">
                                    <?= htmlspecialchars($volunteer['activity_title']) ?>
                                </a>
                            </td>
                            <td><?= date('d M Y', strtotime($volunteer['activity_date'])) ?></td>
                            <td>
                                <span class="status-badge status-<?= $volunteer['status'] ?>">
                                    <?= ucfirst($volunteer['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y H:i', strtotime($volunteer['registered_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($volunteer['status'] === 'registered'): ?>
                                        <a href="/volunteers/<?= $volunteer['id'] ?>/confirm?activity_id=<?= $filters['activity_id'] ?? '' ?>" 
                                           class="btn btn-sm btn-success" onclick="return confirm('Confirm this volunteer?')">Confirm</a>
                                    <?php endif; ?>
                                    
                                    <?php if (in_array($volunteer['status'], ['registered', 'confirmed'])): ?>
                                        <a href="/volunteers/<?= $volunteer['id'] ?>/complete?activity_id=<?= $filters['activity_id'] ?? '' ?>" 
                                           class="btn btn-sm btn-primary" onclick="return confirm('Mark as completed?')">Complete</a>
                                    <?php endif; ?>
                                    
                                    <?php if ($volunteer['status'] === 'registered'): ?>
                                        <a href="/volunteers/<?= $volunteer['id'] ?>/reject?activity_id=<?= $filters['activity_id'] ?? '' ?>" 
                                           class="btn btn-sm btn-danger" onclick="return confirm('Reject this volunteer?')">Reject</a>
                                    <?php endif; ?>
                                    
                                    <form action="/volunteers/<?= $volunteer['id'] ?>/delete" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-sm btn-danger-outline" 
                                                onclick="return confirm('Delete this record?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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

.filters-section {
    margin: 30px 0;
}

.filters-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-group input,
.filter-group select {
    min-width: 180px;
}

.table-container {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 15px 20px;
    text-align: left;
    border-bottom: 1px solid #E2E8F0;
}

.data-table th {
    background: #F5F7FA;
    font-family: 'Kanit', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.data-table tbody tr:hover {
    background: #F8FAFC;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    color: #1E293B;
    font-weight: 600;
}

.user-detail {
    font-family: 'Crimson Pro', serif;
    font-size: 13px;
    color: #64748B;
}

.activity-link {
    color: #043460;
    text-decoration: none;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
}

.activity-link:hover {
    color: #CA9F37;
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

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-family: 'Kanit', sans-serif;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 11px;
}

.btn-primary {
    background: #043460;
    color: white;
}

.btn-success {
    background: #10B981;
    color: white;
}

.btn-danger {
    background: #EF4444;
    color: white;
}

.btn-danger-outline {
    background: transparent;
    border: 1px solid #EF4444;
    color: #EF4444;
}

.btn-secondary {
    background: #6B7280;
    color: white;
}

.empty-cell {
    text-align: center;
    padding: 40px !important;
    font-family: 'Crimson Pro', serif;
    color: #64748B;
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

@media (max-width: 1024px) {
    .data-table {
        display: block;
        overflow-x: auto;
    }
}
</style>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
