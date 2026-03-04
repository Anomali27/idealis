<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$suggestions = $data['suggestions'] ?? [];
$totalSuggestions = $data['totalSuggestions'] ?? 0;
$userName = \App\Core\Session::getUserName();
?>

<!-- Suggestion History Page -->
<div class="page-header">
    <div class="container">
        <h1>My Suggestions</h1>
        <p>Thank you for helping us improve, <?= htmlspecialchars($userName ?? '') ?>!</p>
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
    <div class="stats-card">
        <div class="stat-icon">
            <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Suggestions</span>
            <span class="stat-value"><?= $totalSuggestions ?></span>
        </div>
    </div>

    <!-- Suggestions List -->
    <div class="suggestions-section">
        <div class="section-header">
            <h2>Your Suggestion History</h2>
            <a href="/suggestions/create" class="btn btn-primary">+ New Suggestion</a>
        </div>
        
        <?php if (empty($suggestions)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                </div>
                <h3>No Suggestions Yet</h3>
                <p>You haven't submitted any suggestions yet. Share your ideas with us!</p>
                <a href="/suggestions/create" class="btn btn-primary">Submit a Suggestion</a>
            </div>
        <?php else: ?>
            <div class="suggestions-list">
                <?php foreach ($suggestions as $suggestion): ?>
                    <div class="suggestion-card">
                        <div class="suggestion-header">
                            <span class="category-badge"><?= ucfirst($suggestion['category']) ?></span>
                            <span class="status-badge status-<?= $suggestion['status'] ?>">
                                <?= ucfirst($suggestion['status']) ?>
                            </span>
                        </div>
                        <h3><?= htmlspecialchars($suggestion['title']) ?></h3>
                        <p><?= htmlspecialchars(substr($suggestion['description'], 0, 150)) ?><?php if (strlen($suggestion['description']) > 150): ?>...<?php endif; ?></p>
                        <div class="suggestion-footer">
                            <span class="date">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                </svg>
                                <?= date('d M Y', strtotime($suggestion['created_at'])) ?>
                            </span>
                        </div>
                        <?php if ($suggestion['response']): ?>
                            <div class="admin-response">
                                <strong>Admin Response:</strong>
                                <p><?= htmlspecialchars($suggestion['response']) ?></p>
                            </div>
                        <?php endif; ?>
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

.stats-card {
    display: flex;
    align-items: center;
    gap: 20px;
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin: 30px 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #CA9F37 0%, #D8B25A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    color: #64748B;
    text-transform: uppercase;
}

.stat-value {
    font-family: 'Kameron', serif;
    font-size: 32px;
    font-weight: bold;
    color: #043460;
}

.suggestions-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 60px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.section-header h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 22px;
    color: #043460;
    margin: 0;
}

.suggestions-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.suggestion-card {
    padding: 20px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.suggestion-card:hover {
    border-color: #CA9F37;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.suggestion-header {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.category-badge {
    padding: 4px 10px;
    border-radius: 12px;
    background: #F5F7FA;
    color: #64748B;
    font-family: 'Kanit', sans-serif;
    font-size: 12px;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-family: 'Kanit', sans-serif;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending { background: #FEF3C7; color: #D97706; }
.status-responded { background: #DBEAFE; color: #2563EB; }
.status-implemented { background: #D1FAE5; color: #059669; }
.status-rejected { background: #FEE2E2; color: #DC2626; }

.suggestion-card h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 18px;
    color: #043460;
    margin-bottom: 10px;
}

.suggestion-card p {
    font-family: 'Crimson Pro', serif;
    font-size: 15px;
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 15px;
}

.suggestion-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Crimson Pro', serif;
    font-size: 13px;
    color: #94A3B8;
}

.date svg {
    color: #CA9F37;
}

.admin-response {
    margin-top: 15px;
    padding: 15px;
    background: #F0F9FF;
    border-left: 3px solid #043460;
    border-radius: 0 8px 8px 0;
}

.admin-response strong {
    font-family: 'Kanit', sans-serif;
    font-size: 13px;
    color: #043460;
    display: block;
    margin-bottom: 5px;
}

.admin-response p {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #1E293B;
    margin: 0;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
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
