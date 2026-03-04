<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$activity = $data['activity'] ?? [];
$csrf_token = $data['csrf_token'] ?? '';
$userName = \App\Core\Session::getUserName();
?>

<!-- Volunteer Registration Page -->
<div class="page-header">
    <div class="container">
        <h1>Register as Volunteer</h1>
        <p>Join us in making a difference!</p>
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

    <div class="registration-container">
        <!-- Activity Info -->
        <div class="activity-info-card">
            <h2><?= htmlspecialchars($activity['title'] ?? '') ?></h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                    <div>
                        <span class="info-label">Date</span>
                        <span class="info-value"><?= date('l, d F Y', strtotime($activity['activity_date'] ?? '')) ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                    </svg>
                    <div>
                        <span class="info-label">Time</span>
                        <span class="info-value"><?= date('H:i', strtotime($activity['activity_time'] ?? '')) ?> WIB</span>
                    </div>
                </div>

                <div class="info-item">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                    <div>
                        <span class="info-label">Location</span>
                        <span class="info-value"><?= htmlspecialchars($activity['location'] ?? '') ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022z"/>
                    </svg>
                    <div>
                        <span class="info-label">Volunteers</span>
                        <span class="info-value">
                            <?= $activity['volunteer_count'] ?? 0 ?> / <?= $activity['max_volunteers'] ?: '∞' ?> registered
                        </span>
                    </div>
                </div>
            </div>

            <?php if ($activity['description']): ?>
                <div class="activity-description">
                    <h3>About This Activity</h3>
                    <p><?= nl2br(htmlspecialchars($activity['description'])) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($activity['requirements']): ?>
                <div class="activity-requirements">
                    <h3>Requirements</h3>
                    <p><?= nl2br(htmlspecialchars($activity['requirements'])) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Registration Form -->
        <div class="registration-form-card">
            <h2>Registration Form</h2>
            
            <form action="/volunteers/store" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="form-value"><?= htmlspecialchars($userName ?? '') ?></div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes" class="form-input" rows="4"
                              placeholder="Any additional information you'd like to share..."></textarea>
                </div>

                <div class="form-info">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <p>By registering, you agree to participate in this activity and follow all guidelines provided.</p>
                </div>

                <div class="form-actions">
                    <a href="/activities/<?= $activity['id'] ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Confirm Registration</button>
                </div>
            </form>
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

.registration-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 30px;
    margin: 40px 0 60px;
}

.activity-info-card,
.registration-form-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.activity-info-card h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 24px;
    color: #043460;
    margin-bottom: 25px;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.info-item svg {
    color: #CA9F37;
    margin-top: 2px;
}

.info-item div {
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
}

.activity-description,
.activity-requirements {
    padding-top: 20px;
    border-top: 1px solid #E2E8F0;
    margin-top: 20px;
}

.activity-description h3,
.activity-requirements h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 16px;
    color: #043460;
    margin-bottom: 10px;
}

.activity-description p,
.activity-requirements p {
    font-family: 'Crimson Pro', serif;
    font-size: 15px;
    line-height: 1.7;
    color: #1E293B;
}

.registration-form-card h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 22px;
    color: #043460;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1E293B;
    margin-bottom: 8px;
}

.form-value {
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    color: #64748B;
    padding: 12px 16px;
    background: #F5F7FA;
    border-radius: 8px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #E2E8F0;
    border-radius: 8px;
    font-family: 'Crimson Pro', serif;
    font-size: 15px;
    color: #1E293B;
    background: #F5F7FA;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #043460;
    background: white;
}

.form-info {
    display: flex;
    gap: 12px;
    padding: 15px;
    background: #FFFBEB;
    border-radius: 8px;
    margin-bottom: 25px;
}

.form-info svg {
    color: #F59E0B;
    flex-shrink: 0;
}

.form-info p {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #92400E;
    margin: 0;
}

.form-actions {
    display: flex;
    gap: 15px;
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
}

.btn-primary {
    background: #CA9F37;
    color: white;
    flex: 1;
}

.btn-primary:hover {
    background: #D8B25A;
}

.btn-secondary {
    background: #6B7280;
    color: white;
}

.btn-secondary:hover {
    background: #4B5563;
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
    .registration-container {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
