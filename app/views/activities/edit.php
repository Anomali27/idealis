<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$activity = $data['activity'] ?? [];
$statuses = $data['statuses'] ?? [];

?>

<!-- Edit Activity Page -->
<div class="page-header">
    <div class="container">
        <h1>Edit Activity</h1>
        <p>Update activity details</p>
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

    <div class="form-container">
        <form action="/activities/<?= $activity['id'] ?>/update" method="POST" class="activity-form">
            <!-- Basic Info -->
            <div class="form-section">
                <h2>Basic Information</h2>
                
                <div class="form-group">
                    <label for="title">Activity Title *</label>
                    <input type="text" id="title" name="title" class="form-input" required
                           value="<?= htmlspecialchars($activity['title'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="5"><?= htmlspecialchars($activity['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="requirements">Requirements</label>
                    <textarea id="requirements" name="requirements" class="form-input" rows="3"><?= htmlspecialchars($activity['requirements'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Date & Time -->
            <div class="form-section">
                <h2>Date & Time</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="activity_date">Activity Date *</label>
                        <input type="date" id="activity_date" name="activity_date" class="form-input" required
                               value="<?= htmlspecialchars($activity['activity_date'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="activity_time">Activity Time *</label>
                        <input type="time" id="activity_time" name="activity_time" class="form-input" required
                               value="<?= htmlspecialchars($activity['activity_time'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Location & Capacity -->
            <div class="form-section">
                <h2>Location & Capacity</h2>
                
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" class="form-input" required
                           value="<?= htmlspecialchars($activity['location'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="max_volunteers">Maximum Volunteers</label>
                    <input type="number" id="max_volunteers" name="max_volunteers" class="form-input" 
                           min="0" value="<?= htmlspecialchars($activity['max_volunteers'] ?? 0) ?>">
                    <small>Leave as 0 for unlimited volunteers</small>
                </div>
            </div>

            <!-- Status -->
            <div class="form-section">
                <h2>Status</h2>
                
                <div class="form-group">
                    <label for="status">Activity Status</label>
                    <select id="status" name="status" class="form-input">
                        <?php foreach ($statuses as $value => $label): ?>
                            <option value="<?= $value ?>" <?= ($activity['status'] ?? '') === $value ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="/activities/<?= $activity['id'] ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Activity</button>
            </div>
        </form>
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

.form-container {
    max-width: 800px;
    margin: 40px auto;
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.form-section {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #E2E8F0;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section h2 {
    font-family: 'Kanit', sans-serif;
    font-size: 18px;
    color: #043460;
    margin-bottom: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
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
    box-shadow: 0 0 0 3px rgba(4,52,96,0.1);
}

.form-group small {
    display: block;
    font-family: 'Crimson Pro', serif;
    font-size: 13px;
    color: #64748B;
    margin-top: 5px;
}

textarea.form-input {
    resize: vertical;
    min-height: 100px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
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
}

.btn-primary:hover {
    background: #D8B25A;
    transform: translateY(-2px);
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

@media (max-width: 600px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-container {
        padding: 25px;
    }
}
</style>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
