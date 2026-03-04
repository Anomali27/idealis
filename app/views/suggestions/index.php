<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$suggestions = $data['suggestions'] ?? [];
$filters = $data['filters'] ?? [];
$statuses = $data['statuses'] ?? [];
$categories = $data['categories'] ?? [];
$pendingCount = $data['pendingCount'] ?? 0;
?>

<!-- Suggestions Management Page -->
<div class="page-header">
    <div class="container">
        <h1>Suggestion Management</h1>
        <p>Review and manage suggestions from students and teachers</p>
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
            <div class="stat-icon pending">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-value"><?= $pendingCount ?></span>
                <span class="stat-label">Pending</span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="/suggestions" class="filters-form">
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
                <select name="category" class="form-input">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($filters['category'] ?? '') === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search..." 
                       value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="form-input">
            </div>
            <div class="filter-group">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/suggestions" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Suggestions Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($suggestions)): ?>
                    <tr>
                        <td colspan="7" class="empty-cell">No suggestions found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($suggestions as $index => $suggestion): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><span class="category-badge"><?= ucfirst($suggestion['category']) ?></span></td>
                            <td>
                                <div class="title-cell">
                                    <strong><?= htmlspecialchars(substr($suggestion['title'], 0, 50)) ?></strong>
                                    <p><?= htmlspecialchars(substr($suggestion['description'], 0, 80)) ?>...</p>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($suggestion['user_name'] ?? 'Anonymous') ?></td>
                            <td>
                                <span class="status-badge status-<?= $suggestion['status'] ?>">
                                    <?= ucfirst($suggestion['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($suggestion['created_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($suggestion['status'] === 'pending'): ?>
                                        <a href="/suggestions/<?= $suggestion['id'] ?>/respond" class="btn btn-sm btn-primary">Respond</a>
                                        <a href="/suggestions/<?= $suggestion['id'] ?>/implement" class="btn btn-sm btn-success">Implement</a>
                                        <a href="/suggestions/<?= $suggestion['id'] ?>/reject" class="btn btn-sm btn-danger" onclick="return confirm('Reject this suggestion?')">Reject</a>
                                    <?php endif; ?>
                                    <form action="/suggestions/<?= $suggestion['id'] ?>/delete" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-sm btn-danger-outline" onclick="return confirm('Delete?')">Delete</button>
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

.page-header h1 { font-family: 'Kameron', serif; font-size: 32px; margin-bottom: 10px; }
.page-header p { font-family: 'Crimson Pro', serif; font-size: 16px; opacity: 0.9; }

.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; margin: 30px 0; }

.stat-card {
    background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.stat-icon {
    width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
}

.stat-icon.pending { background: #FEF3C7; color: #D97706; }
.stat-info { display: flex; flex-direction: column; }
.stat-value { font-family: 'Kameron', serif; font-size: 28px; font-weight: bold; color: #043460; }
.stat-label { font-family: 'Crimson Pro', serif; font-size: 14px; color: #64748B; }

.filters-section { margin: 30px 0; }
.filters-form { display: flex; gap: 15px; flex-wrap: wrap; }

.table-container { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th, .data-table td { padding: 15px; text-align: left; border-bottom: 1px solid #E2E8F0; }
.data-table th { background: #F5F7FA; font-family: 'Kanit', sans-serif; font-size: 13px; color: #64748B; text-transform: uppercase; }
.data-table tbody tr:hover { background: #F8FAFC; }

.title-cell strong { font-family: 'Kanit', sans-serif; font-size: 14px; color: #043460; display: block; margin-bottom: 4px; }
.title-cell p { font-family: 'Crimson Pro', serif; font-size: 13px; color: #64748B; margin: 0; }

.category-badge { padding: 4px 10px; border-radius: 12px; background: #F5F7FA; color: #64748B; font-family: 'Kanit', sans-serif; font-size: 12px; }

.status-badge { padding: 6px 12px; border-radius: 20px; font-family: 'Kanit', sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; }
.status-pending { background: #FEF3C7; color: #D97706; }
.status-responded { background: #DBEAFE; color: #2563EB; }
.status-implemented { background: #D1FAE5; color: #059669; }
.status-rejected { background: #FEE2E2; color: #DC2626; }

.action-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
.btn { display: inline-block; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-family: 'Kanit', sans-serif; font-size: 12px; font-weight: 600; transition: all 0.3s ease; cursor: pointer; border: none; }
.btn-sm { padding: 6px 10px; font-size: 11px; }
.btn-primary { background: #043460; color: white; }
.btn-success { background: #10B981; color: white; }
.btn-danger { background: #EF4444; color: white; }
.btn-danger-outline { background: transparent; border: 1px solid #EF4444; color: #EF4444; }
.btn-secondary { background: #6B7280; color: white; }

.empty-cell { text-align: center; padding: 40px !important; font-family: 'Crimson Pro', serif; color: #64748B; }

.alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-family: 'Crimson Pro', serif; }
.alert-error { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; }
.alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #16A34A; }
</style>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
