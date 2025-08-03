<?php
require_once __DIR__ . '/config/email.php';

echo "<h2>Email Debug Test</h2>";

// Create email sender
$emailSender = new EmailSender(true);

echo "<h3>Configuration:</h3>";
echo "Development Mode: " . (EmailConfig::DEVELOPMENT_MODE ? 'true' : 'false') . "<br>";
echo "Log Emails: " . (EmailConfig::LOG_EMAILS ? 'true' : 'false') . "<br>";
echo "Use School Email: " . (EmailConfig::USE_SCHOOL_EMAIL ? 'true' : 'false') . "<br>";

echo "<h3>Sending Test Email...</h3>";

// Send test email
$result = $emailSender->sendEmail(
    'khatziar@gmail.com',
    'Direct Test Email',
    'This is a direct test to debug email sending.',
    'Debug Test'
);

echo "<p>Result: " . ($result ? '<span style="color:green">SUCCESS</span>' : '<span style="color:red">FAILED</span>') . "</p>";

echo "<h3>Check your email inbox and PHP error logs for more details.</h3>";
echo "<p>PHP Error Log locations:</p>";
echo "<ul>";
echo "<li>C:\\xampp\\php\\logs\\php_error_log</li>";
echo "<li>C:\\xampp\\apache\\logs\\error.log</li>";
echo "</ul>";
?>
