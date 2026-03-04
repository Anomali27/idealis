<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$donations = $data['donations'] ?? [];
$totalDonated = $data['totalDonated'] ?? 0;
$userName = \App\Core\Session::getUserName();
?>

<!-- Donation History Page -->
<div class="page-header">
    <div class="container">
        <h1>My Donations</h1>
        <p>Thank you for your generosity, <?= htmlspecialchars($userName ?? '') ?>!</p>
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
                <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Donated</span>
            <span class="stat-value">Rp <?= number_format($totalDonated, 0, ',', '.') ?></span>
        </div>
    </div>

    <!-- Donations List -->
    <div class="donations-section">
        <h2>Your Donation History</h2>
        
        <?php if (empty($donations)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                    </svg>
                </div>
                <h3>No Donations Yet</h3>
                <p>You haven't made any donations yet. Start making a difference today!</p>
                <a href="/donations/create" class="btn btn-primary">Make a Donation</a>
            </div>
        <?php else: ?>
            <div class="donations-list">
                <?php foreach ($donations as $donation): ?>
                    <div class="donation-card">
                        <div class="donation-status">
                            <span class="status-badge status-<?= $donation['status'] ?>">
                                <?= ucfirst($donation['status']) ?>
                            </span>
                        </div>
                        <div class="donation-content">
                            <div class="donation-amount">
                                Rp <?= number_format($donation['amount'], 0, ',', '.') ?>
                            </div>
                            <h3>
                                <?= $donation['activity_title'] ? htmlspecialchars($donation['activity_title']) : 'General Donation' ?>
                            </h3>
                            <div class="donation-meta">
                                <span>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                    </svg>
                                    <?= ucfirst(str_replace('_', ' ', $donation['payment_method'])) ?>
                                </span>
                                <span>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    <?= date('d M Y', strtotime($donation['donated_at'])) ?>
                                </span>
                            </div>
                            <?php if ($donation['message']): ?>
                                <p class="donation-message">"<?= htmlspecialchars($donation['message']) ?>"</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="action-row">
            <a href="/donations/create" class="btn btn-primary">Make Another Donation</a>
        </div>
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

.donations-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 60px;
}

.donations-section h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 22px;
    color: #043460;
    margin-bottom: 25px;
}

.donations-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.donation-card {
    display: flex;
    gap: 20px;
    padding: 20px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.donation-card:hover {
    border-color: #CA9F37;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.donation-status {
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

.status-pending { background: #FEF3C7; color: #D97706; }
.status-completed { background: #D1FAE5; color: #059669; }
.status-rejected { background: #FEE2E2; color: #DC2626; }
.status-cancelled { background: #F3F4F6; color: #6B7280; }

.donation-content {
    flex: 1;
}

.donation-amount {
    font-family: 'Kameron', serif;
    font-size: 24px;
    font-weight: bold;
    color: #CA9F37;
    margin-bottom: 5px;
}

.donation-content h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 16px;
    color: #043460;
    margin-bottom: 10px;
}

.donation-meta {
    display: flex;
    gap: 20px;
}

.donation-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
}

.donation-meta svg {
    color: #CA9F37;
}

.donation-message {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
    font-style: italic;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #E2E8F0;
}

.action-row {
    margin-top: 30px;
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 12px 30px;
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
