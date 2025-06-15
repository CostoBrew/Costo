<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Costobrew</title>
</head>
<body>
    <div class="settings-container">
        <h1>Account Information</h1>
        
        <nav class="settings-nav">
            <ul>
                <li><a href="/settings/account" class="active">Account Information</a></li>
                <li><a href="/settings/security">Security</a></li>
                <li><a href="/settings/notifications">Notifications</a></li>
                <li><a href="/settings/cookies">Cookie Policy</a></li>
            </ul>
        </nav>
        
        <div class="settings-content">
            <?php if (isset($_GET['updated'])): ?>
                <div class="success-message">Account information updated successfully!</div>
            <?php endif; ?>
            
            <form action="/settings/account" method="POST">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($userInfo['full_name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($userInfo['email']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($userInfo['phone']) ?>">
                </div>
                
                <div class="form-group">
                    <label>Member Since:</label>
                    <span class="readonly"><?= htmlspecialchars($userInfo['member_since']) ?></span>
                </div>
                
                <button type="submit">Update Account</button>
            </form>
        </div>
    </div>
</body>
</html>
