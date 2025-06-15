<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Settings - Costobrew</title>
</head>
<body>
    <div class="settings-container">
        <h1>Security Settings</h1>
        
        <nav class="settings-nav">
            <ul>
                <li><a href="/settings/account">Account Information</a></li>
                <li><a href="/settings/security" class="active">Security</a></li>
                <li><a href="/settings/notifications">Notifications</a></li>
                <li><a href="/settings/cookies">Cookie Policy</a></li>
            </ul>
        </nav>
        
        <div class="settings-content">
            <?php if (isset($_GET['updated'])): ?>
                <div class="success-message">Security settings updated successfully!</div>
            <?php endif; ?>
            
            <h3>Change Password</h3>
            <form action="/settings/security" method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit">Update Password</button>
            </form>
            
            <h3>Two-Factor Authentication</h3>
            <div class="security-option">
                <p>Enable two-factor authentication for added security.</p>
                <button class="secondary-btn">Enable 2FA</button>
            </div>
        </div>
    </div>
</body>
</html>
