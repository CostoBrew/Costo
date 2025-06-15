<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Policy - Costobrew</title>
</head>
<body>
    <div class="settings-container">
        <h1>Cookie Policy</h1>
        
        <nav class="settings-nav">
            <ul>
                <li><a href="/settings/account">Account Information</a></li>
                <li><a href="/settings/security">Security</a></li>
                <li><a href="/settings/notifications">Notifications</a></li>
                <li><a href="/settings/cookies" class="active">Cookie Policy</a></li>
            </ul>
        </nav>
        
        <div class="settings-content">
            <h3>How We Use Cookies</h3>
            <p>Costobrew uses cookies to enhance your browsing experience and provide personalized content.</p>
            
            <h4>Essential Cookies</h4>
            <p>These cookies are necessary for the website to function properly. They enable basic functions like page navigation and access to secure areas.</p>
            
            <h4>Analytics Cookies</h4>
            <p>We use analytics cookies to understand how visitors interact with our website by collecting and reporting information anonymously.</p>
            
            <h4>Marketing Cookies</h4>
            <p>These cookies track visitors across websites to display relevant and engaging advertisements.</p>
            
            <h3>Cookie Preferences</h3>
            <form action="/settings/cookies" method="POST">
                <label class="checkbox-label">
                    <input type="checkbox" name="essential_cookies" checked disabled>
                    Essential Cookies (Required)
                </label>
                
                <label class="checkbox-label">
                    <input type="checkbox" name="analytics_cookies">
                    Analytics Cookies
                </label>
                
                <label class="checkbox-label">
                    <input type="checkbox" name="marketing_cookies">
                    Marketing Cookies
                </label>
                
                <button type="submit">Save Cookie Preferences</button>
            </form>
        </div>
    </div>
</body>
</html>
