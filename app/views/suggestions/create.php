<?php
// Include header
require_once dirname(__DIR__) . '/layouts/header.php';

use App\Core\Session;

$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');
$categories = $data['categories'] ?? [];
$csrf_token = $data['csrf_token'] ?? '';
?>

<!-- Suggestion Page -->
<div class="page-header">
    <div class="container">
        <h1>Submit a Suggestion</h1>
        <p>Help us improve PIC social activities with your ideas</p>
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

    <div class="suggestion-container">
        <div class="form-card">
            <h2>Your Suggestion</h2>
            
            <form action="/suggestions/store" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" class="form-input" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $value => $label): ?>
                            <option value="<?= $value ?>"><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" class="form-input" 
                           placeholder="Brief title of your suggestion" required>
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" class="form-input" rows="6"
                              placeholder="Describe your suggestion in detail. What problem does it solve? How can it be implemented?" required></textarea>
                </div>

                <div class="form-info">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <p>Your suggestion will be reviewed by our admin team. We appreciate your input in making PIC activities better!</p>
                </div>

                <div class="form-actions">
                    <a href="/" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit Suggestion</button>
                </div>
            </form>
        </div>

        <div class="info-card">
            <h2>What can you suggest?</h2>
            <ul class="suggestion-types">
                <li>
                    <div class="type-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>New Activity Ideas</h3>
                        <p>Propose new social activities that could benefit the school community</p>
                    </div>
                </li>
                <li>
                    <div class="type-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M10.5 8.5a.5.5 0 0 1-1 0V5.707l-4.146 4.147a.5.5 0 0 1-.708-.708L8.793 5H6a.5.5 0 0 1 0-1h4.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V8.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>System Improvements</h3>
                        <p>Suggest ways to improve our volunteer management system</p>
                    </div>
                </li>
                <li>
                    <div class="type-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>Feedback</h3>
                        <p>Share your thoughts about past activities or our services</p>
                    </div>
                </li>
                <li>
                    <div class="type-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>Other Ideas</h3>
                        <p>Any other suggestions that could help our community</p>
                    </div>
                </li>
            </ul>
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

.suggestion-container {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 30px;
    margin: 40px 0 60px;
}

.form-card,
.info-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.form-card h2,
.info-card h2 {
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

textarea.form-input {
    resize: vertical;
    min-height: 120px;
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

.btn-secondary {
    background: #6B7280;
    color: white;
}

.suggestion-types {
    list-style: none;
    padding: 0;
    margin: 0;
}

.suggestion-types li {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #E2E8F0;
}

.suggestion-types li:last-child {
    border-bottom: none;
}

.type-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #F5F7FA;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #CA9F37;
    flex-shrink: 0;
}

.suggestion-types h3 {
    font-family: 'Kanit', sans-serif;
    font-size: 15px;
    color: #043460;
    margin-bottom: 5px;
}

.suggestion-types p {
    font-family: 'Crimson Pro', serif;
    font-size: 13px;
    color: #64748B;
    margin: 0;
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
    .suggestion-container {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
