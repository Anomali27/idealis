<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$activity = $data['activity'] ?? null;
$activities = $data['activities'] ?? [];
$paymentMethods = $data['paymentMethods'] ?? [];

$isLoggedIn = \App\Core\Session::isLoggedIn();
$userName = \App\Core\Session::getUserName();
$userEmail = \App\Core\Session::getUserEmail();
?>

<!-- Donation Page -->
<div class="page-header">
    <div class="container">
        <h1>Make a Donation</h1>
        <p>Support PIC social activities and make a difference</p>
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

    <div class="donation-container">
        <!-- Info Card -->
        <div class="info-card">
            <h2>Why Donate?</h2>
            <ul class="benefits-list">
                <li>
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Help students in need
                </li>
                <li>
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Support community activities
                </li>
                <li>
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Contribute to education
                </li>
                <li>
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Build a better future together
                </li>
            </ul>

            <div class="contact-info">
                <h3>Questions?</h3>
                <p>Contact us at: admin@pic.edu</p>
            </div>
        </div>

        <!-- Donation Form -->
        <div class="form-card">
            <h2>Donation Form</h2>
            
            <form action="/donations/store" method="POST">
                <?php if (!empty($activities) && count($activities) > 0): ?>
                    <div class="form-group">
                        <label for="activity_id">Select Activity (Optional)</label>
                        <select id="activity_id" name="activity_id" class="form-input">
                            <option value="">General Donation (Unspecified)</option>
                            <?php foreach ($activities as $act): ?>
                                <option value="<?= $act['id'] ?>" <?= ($activity['id'] ?? '') == $act['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($act['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="amount">Donation Amount (IDR) *</label>
                    <div class="amount-input">
                        <span class="currency">Rp</span>
                        <input type="number" id="amount" name="amount" class="form-input" 
                               min="1000" step="1000" placeholder="50,000" required>
                    </div>
                    <div class="quick-amounts">
                        <button type="button" class="amount-btn" data-amount="25000">25K</button>
                        <button type="button" class="amount-btn" data-amount="50000">50K</button>
                        <button type="button" class="amount-btn" data-amount="100000">100K</button>
                        <button type="button" class="amount-btn" data-amount="250000">250K</button>
                        <button type="button" class="amount-btn" data-amount="500000">500K</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="donor_name">Full Name *</label>
                    <input type="text" id="donor_name" name="donor_name" class="form-input" 
                           value="<?= htmlspecialchars($userName ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="donor_email">Email *</label>
                    <input type="email" id="donor_email" name="donor_email" class="form-input" 
                           value="<?= htmlspecialchars($userEmail ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method *</label>
                    <select id="payment_method" name="payment_method" class="form-input" required>
                        <option value="">Select payment method</option>
                        <?php foreach ($paymentMethods as $value => $label): ?>
                            <option value="<?= $value ?>"><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_proof">Payment Reference/Proof</label>
                    <input type="text" id="payment_proof" name="payment_proof" class="form-input" 
                           placeholder="Transaction number or reference">
                </div>

                <div class="form-group">
                    <label for="message">Message (Optional)</label>
                    <textarea id="message" name="message" class="form-input" rows="3"
                              placeholder="Your message or encouragement..."></textarea>
                </div>

                <div class="form-actions">
                    <a href="/activities" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit Donation</button>
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

.donation-container {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 30px;
    margin: 40px 0 60px;
}

.info-card,
.form-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.info-card h2,
.form-card h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 22px;
    color: #043460;
    margin-bottom: 25px;
}

.benefits-list {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 0;
}

.benefits-list li {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #E2E8F0;
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    color: #1E293B;
}

.benefits-list li:last-child {
    border-bottom: none;
}

.benefits-list svg {
    color: #CA9F37;
    flex-shrink: 0;
}

.contact-info {
    background: #F5F7FA;
    padding: 20px;
    border-radius: 8px;
}

.contact-info h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 16px;
    color: #043460;
    margin-bottom: 10px;
}

.contact-info p {
    font-family: 'Crimson Pro', serif;
    font-size: 14px;
    color: #64748B;
    margin: 0;
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

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #E2E8F0;
    border-radius: 8px;
    font-family: 'Crimson Pro', serif;
    font-size: 16px;
    color: #1E293B;
    background: #F5F7FA;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #043460;
    background: white;
}

.amount-input {
    display: flex;
    align-items: center;
    background: #F5F7FA;
    border: 2px solid #E2E8F0;
    border-radius: 8px;
    overflow: hidden;
}

.amount-input .currency {
    padding: 12px 16px;
    background: #043460;
    color: white;
    font-family: 'Kanit', sans-serif;
    font-weight: 600;
}

.amount-input input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 12px 16px;
    font-family: 'Crimson Pro', serif;
    font-size: 18px;
}

.amount-input input:focus {
    outline: none;
}

.quick-amounts {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.amount-btn {
    padding: 8px 16px;
    border: 2px solid #E2E8F0;
    border-radius: 20px;
    background: white;
    color: #043460;
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.amount-btn:hover {
    border-color: #CA9F37;
    background: #CA9F37;
    color: white;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
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
    .donation-container {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.querySelector('input[name="amount"]');
    const quickAmounts = document.querySelectorAll('.amount-btn');
    
    quickAmounts.forEach(btn => {
        btn.addEventListener('click', function() {
            amountInput.value = this.dataset.amount;
        });
    });
});
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
