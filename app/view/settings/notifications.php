<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Settings - Costobrew</title>
</head>
<body>
    <div class="settings-container">
        <h1>Notification Settings</h1>
        
        <nav class="settings-nav">
            <ul>
                <li><a href="/settings/account">Account Information</a></li>
                <li><a href="/settings/security">Security</a></li>
                <li><a href="/settings/notifications" class="active">Notifications</a></li>
                <li><a href="/settings/cookies">Cookie Policy</a></li>
            </ul>
        </nav>
        
        <div class="settings-content">
            <?php if (isset($_GET['updated'])): ?>
                <div class="success-message">Notification settings updated successfully!</div>
            <?php endif; ?>
            
            <form action="/settings/notifications" method="POST">
                <div class="notification-group">
                    <h3>Email Notifications</h3>
                    <label class="checkbox-label">
                        <input type="checkbox" name="email_notifications" 
                               <?= $notificationSettings['email_notifications'] ? 'checked' : '' ?>>
                        Receive email notifications about orders and promotions
                    </label>
                </div>
                
                <div class="notification-group">
                    <h3>SMS Notifications</h3>
                    <label class="checkbox-label">
                        <input type="checkbox" name="sms_notifications" 
                               <?= $notificationSettings['sms_notifications'] ? 'checked' : '' ?>>
                        Receive SMS notifications about order status
                    </label>
                </div>
                
                <div class="notification-group">
                    <h3>Push Notifications</h3>
                    <label class="checkbox-label">
                        <input type="checkbox" name="push_notifications" 
                               <?= $notificationSettings['push_notifications'] ? 'checked' : '' ?>>
                        Receive push notifications on mobile app
                    </label>
                </div>
                
                <button type="submit">Save Preferences</button>
            </form>
        </div>
    </div>
</body>
</html>
