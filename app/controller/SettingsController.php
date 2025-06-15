<?php

/**
 * Settings Controller
 * Handles multi-page settings (Account, Security, Notifications, Cookie Policy)
 */

class SettingsController
{
    /**
     * Settings main page
     */
    public function index()
    {
        require_once __DIR__ . '/../view/settings/index.php';
    }
    
    /**
     * Account information settings
     */
    public function account()
    {
        // Get current user account info
        $userInfo = $this->getCurrentUserInfo();
        
        require_once __DIR__ . '/../view/settings/account.php';
    }
    
    /**
     * Security settings
     */
    public function security()
    {
        require_once __DIR__ . '/../view/settings/security.php';
    }
    
    /**
     * Notification settings
     */
    public function notifications()
    {
        // Get current notification preferences
        $notificationSettings = $this->getNotificationSettings();
        
        require_once __DIR__ . '/../view/settings/notifications.php';
    }
    
    /**
     * Cookie policy settings
     */
    public function cookiePolicy()
    {
        require_once __DIR__ . '/../view/settings/cookies.php';
    }
    
    /**
     * Update account information
     */
    public function updateAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process account update
            $fullName = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            
            // TODO: Implement account update logic
            
            // Redirect back to account settings with success message
            header('Location: /settings/account?updated=1');
            exit;
        }
    }
    
    /**
     * Update security settings
     */
    public function updateSecurity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process security update
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // TODO: Implement security update logic
            
            header('Location: /settings/security?updated=1');
            exit;
        }
    }
    
    /**
     * Update notification settings
     */
    public function updateNotifications()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process notification preferences
            $emailNotifications = isset($_POST['email_notifications']);
            $smsNotifications = isset($_POST['sms_notifications']);
            $pushNotifications = isset($_POST['push_notifications']);
            
            // TODO: Implement notification settings update
            
            header('Location: /settings/notifications?updated=1');
            exit;
        }
    }
    
    /**
     * Get current user info (placeholder)
     */
    private function getCurrentUserInfo()
    {
        // TODO: Replace with actual user data from database
        return [
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'member_since' => '2024-01-15'
        ];
    }
    
    /**
     * Get notification settings (placeholder)
     */
    private function getNotificationSettings()
    {
        // TODO: Replace with actual settings from database
        return [
            'email_notifications' => true,
            'sms_notifications' => false,
            'push_notifications' => true
        ];
    }
}
