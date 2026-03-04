<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$donations = $data['donations'] ?? [];
$activities = $data['activities'] ?? [];
$filters = $data['filters'] ?? [];
$statuses = $data['statuses'] ?? [];
$totalAmount = $data['totalAmount'] ?? 0;
$totalDonations = $data['totalDonations'] ?? 0;
?>

<!-- Donations Management Page -->
<div class="page-header">
    <div class="container">
        <h1>Donation Management</h1>
        <p>Manage all donations for PIC activities</p>
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

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value">Rp <?= number_format($totalAmount, 0, ',', '.') ?></span>
                <span class="stat-label">Total Donations</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?= $totalDonations ?></span>
                <span class="stat-label">Total Transactions</span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="/donations" class="filters-form">
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
                <input type="text" name="search" placeholder="Search by name..." 
                       value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="form-input">
            </div>
            <div class="filter-group">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/donations" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Donations Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Donor</th>
                    <th>Activity</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donations)): ?>
                    <tr>
                        <td colspan="8" class="empty-cell">No donations found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($donations as $index => $donation): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name"><?= htmlspecialchars($donation['donor_name']) ?></span>
                                    <span class="user-detail"><?= htmlspecialchars($donation['donor_email'] ?? '') ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if ($donation['activity_id']): ?>
                                    <a href="/activities/<?= $donation['activity_id'] ?>" class="activity-link">
                                        <?= htmlspecialchars($donation['activity_title'] ?? 'N/A') ?>
                                    </a>
                                <?php else: ?>
                                    <span>General Donation</span>
                                <?php endif; ?>
                            </td>
                            <td class="amount-cell">Rp <?= number_format($donation['amount'], 0, ',', '.') ?></td>
                            <td><?= ucfirst(str_replace('_', ' ', $donation['payment_method'])) ?></td>
                            <td>
                                <span class="status-badge status-<?= $donation['status'] ?>">
                                    <?= ucfirst($donation['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($donation['donated_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($donation['status'] === 'pending'): ?>
                                        <a href="/donations/<?= $donation['id'] ?>/confirm" 
                                           class="btn btn-sm btn-success" onclick="return confirm('Confirm this donation?')">Confirm</a>
                                        <a href="/donations/<?= $donation['id'] ?>/reject" 
                                           class="btn btn-sm btn-danger" onclick="return confirm('Reject this donation?')">Reject</a>
                                    <?php endif; ?>
                                    <form action="/donations/<?= $donation['id'] ?>/delete" method="POST" style="display:inline;">
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
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: #F5F7FA;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #CA9F37;
}

.stat-icon.success {
    background: #ECFDF5;
    color: #10B981;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-family: 'Kameron', serif;
    font-size: 24px;
    font-weight: bold;
    color: #043460;
}

.stat-label {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
}

.filters-section {
    margin: 30px 0;
}

.filters-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
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
}

.data-table tbody tr:hover {
    background: #F8FAFC;
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

.amount-cell {
    font-family: 'Kanit', sans-serif;
    font-weight: 600;
    color: #CA9F37;
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

.status-pending { background: #FEF3C7; color: #D97706; }
.status-completed { background: #D1FAE5; color: #059669; }
.status-rejected { background: #FEE2E2; color: #DC2626; }
.status-cancelled { background: #F3F4F6; color: #6B7280; }

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

.btn-primary {
    background: #043460;
    color: white;
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
</style>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
