<?php
// Set timezone for the application
date_default_timezone_set('Europe/Athens'); // Change to your timezone

/**
 * Simple Email Class using PHP's built-in mail() with better configuration
 * Alternative: Use Gmail SMTP (recommended for development)
 */

class EmailSender {
    private $smtpEnabled = true;                // Enable SMTP for Gmail
    private $smtpHost = 'smtp.gmail.com';       // Gmail SMTP
    private $smtpPort = 587;                    // Gmail port (use 587 for STARTTLS)
    private $smtpUsername = 'khatziar@gmail.com';   // Your Gmail
    private $smtpPassword = '';      // Gmail app password

    public function __construct($useSmtp = true) {
        $this->smtpEnabled = $useSmtp;
    }
    
    public function sendEmail($to, $subject, $message, $fromName = 'Mathiteia App') {
        // Log the email attempt
        EmailConfig::logEmail($to, $subject, $message);
        
        // Debug: Log the current mode
        error_log("DEVELOPMENT_MODE: " . (EmailConfig::DEVELOPMENT_MODE ? 'true' : 'false'));
        error_log("SMTP_ENABLED: " . ($this->smtpEnabled ? 'true' : 'false'));
        
        // In development mode, simulate email sending
        if (EmailConfig::DEVELOPMENT_MODE) {
            // Simulate successful email sending for development
            error_log("DEV EMAIL SIMULATED: TO=$to, SUBJECT=$subject");
            return true;
        }
        
        // Try to send real email
        $result = false;
        if ($this->smtpEnabled) {
            error_log("Attempting SMTP send to: $to");
            $result = $this->sendViaSmtp($to, $subject, $message, $fromName);
            error_log("SMTP result: " . ($result ? 'SUCCESS' : 'FAILED'));
        } else {
            error_log("Attempting mail() send to: $to");
            $result = $this->sendViaMail($to, $subject, $message, $fromName);
            error_log("mail() result: " . ($result ? 'SUCCESS' : 'FAILED'));
        }
        
        return $result;
    }
    
    private function sendViaMail($to, $subject, $message, $fromName) {
        $headers = "From: $fromName <khatziar@gmail.com>\r\n";
        $headers .= "Reply-To: khatziar@gmail.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        return mail($to, $subject, $message, $headers);
    }
    
    private function sendViaSmtp($to, $subject, $message, $fromName) {
        error_log("Starting SMTP connection to: {$this->smtpHost}:{$this->smtpPort}");
        
        // Connect to Gmail SMTP
        $smtp = fsockopen($this->smtpHost, $this->smtpPort, $errno, $errstr, 30);
        if (!$smtp) {
            error_log("SMTP connection failed: $errstr ($errno)");
            return false;
        }
        error_log("SMTP connection established");
        
        // Read server greeting
        $response = fgets($smtp, 256);
        error_log("Server greeting: " . trim($response));
        if (substr($response, 0, 3) != '220') {
            error_log("Invalid greeting response: " . trim($response));
            fclose($smtp);
            return false;
        }
        
        // Send EHLO command
        fputs($smtp, "EHLO localhost\r\n");
        $response = fgets($smtp, 256);
        error_log("EHLO response: " . trim($response));
        
        // Read all EHLO responses (Gmail sends multiple lines)
        while (substr($response, 3, 1) == '-') {
            $response = fgets($smtp, 256);
            error_log("EHLO continuation: " . trim($response));
        }
        
        // Start TLS encryption
        fputs($smtp, "STARTTLS\r\n");
        $response = fgets($smtp, 256);
        error_log("STARTTLS response: " . trim($response));
        if (substr($response, 0, 3) != '220') {
            error_log("STARTTLS failed: " . trim($response));
            fclose($smtp);
            return false;
        }
        
        // Enable crypto
        $crypto_result = stream_socket_enable_crypto($smtp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        if (!$crypto_result) {
            error_log("TLS encryption failed");
            fclose($smtp);
            return false;
        }
        error_log("TLS encryption enabled");
        
        // Send EHLO again after STARTTLS
        fputs($smtp, "EHLO localhost\r\n");
        $response = fgets($smtp, 256);
        error_log("EHLO after TLS response: " . trim($response));
        
        // Read all EHLO responses after TLS
        while (substr($response, 3, 1) == '-') {
            $response = fgets($smtp, 256);
            error_log("EHLO after TLS continuation: " . trim($response));
        }
        
        // Authenticate
        fputs($smtp, "AUTH LOGIN\r\n");
        $response = fgets($smtp, 256);
        error_log("AUTH LOGIN response: " . trim($response));
        
        fputs($smtp, base64_encode($this->smtpUsername) . "\r\n");
        $response = fgets($smtp, 256);
        error_log("Username response: " . trim($response));
        
        fputs($smtp, base64_encode($this->smtpPassword) . "\r\n");
        $response = fgets($smtp, 256);
        error_log("Password response: " . trim($response));
        
        if (substr($response, 0, 3) != '235') {
            fclose($smtp);
            error_log("Gmail authentication failed: " . trim($response));
            return false;
        }
        error_log("Authentication successful");
        
        // Send MAIL FROM
        fputs($smtp, "MAIL FROM: <{$this->smtpUsername}>\r\n");
        $response = fgets($smtp, 256);
        error_log("MAIL FROM response: " . trim($response));
        
        // Send RCPT TO
        fputs($smtp, "RCPT TO: <$to>\r\n");
        $response = fgets($smtp, 256);
        error_log("RCPT TO response: " . trim($response));
        
        // Send DATA command
        fputs($smtp, "DATA\r\n");
        $response = fgets($smtp, 256);
        error_log("DATA response: " . trim($response));
        
        // Send email headers and body
        $headers = "From: $fromName <{$this->smtpUsername}>\r\n";
        $headers .= "To: $to\r\n";
        $headers .= "Subject: $subject\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "Date: " . date('r') . "\r\n";
        $headers .= "\r\n";
        
        fputs($smtp, $headers . $message . "\r\n.\r\n");
        $response = fgets($smtp, 256);
        error_log("Final send response: " . trim($response));
        
        // Send QUIT
        fputs($smtp, "QUIT\r\n");
        fclose($smtp);
        
        // Check if email was accepted
        $success = substr($response, 0, 3) == '250';
        if (!$success) {
            error_log("Gmail send failed: " . trim($response));
        } else {
            error_log("Email sent successfully!");
        }
        
        return $success;
    }
    
    public function sendBulkEmails($recipients, $subject, $message, $personalizeCallback = null) {
        $results = [
            'sent' => 0,
            'failed' => [],
            'errors' => []
        ];
        
        foreach ($recipients as $recipient) {
            if (empty($recipient['email'])) {
                continue;
            }
            
            $personalizedMessage = $message;
            if ($personalizeCallback && is_callable($personalizeCallback)) {
                $personalizedMessage = $personalizeCallback($message, $recipient);
            }
            
            if ($this->sendEmail($recipient['email'], $subject, $personalizedMessage)) {
                $results['sent']++;
            } else {
                $results['failed'][] = $recipient;
                $results['errors'][] = "Failed to send to: " . $recipient['email'];
            }
        }
        
        return $results;
    }
}

// Email configuration for Gmail sending
class EmailConfig {
    const DEVELOPMENT_MODE = false;             // Disable to send real emails
    const LOG_EMAILS = true;
    const USE_SCHOOL_EMAIL = false;             // Use Gmail instead
    
    public static function getEmailSettings() {
        if (self::USE_SCHOOL_EMAIL) {
            return [
                'smtp_host' => 'websitemail.sch.gr',
                'smtp_port' => 25,
                'username' => 'khatziar',
                'from_email' => 'khatziar@sch.gr',
                'from_name' => 'Μαθητεία App - Σχολείο'
            ];
        } else {
            return [
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'username' => 'khatziar@gmail.com',
                'from_email' => 'khatziar@gmail.com',
                'from_name' => 'Μαθητεία App - Development'
            ];
        }
    }
    
    public static function getDevelopmentEmails() {
        // For testing - only send to this email
        return [
            'khatziar@gmail.com'
        ];
    }
    
    public static function logEmail($to, $subject, $message) {
        if (self::LOG_EMAILS) {
            // Set timezone to Greece (you can change this to your local timezone)
            date_default_timezone_set('Europe/Athens');
            $log = date('Y-m-d H:i:s') . " (Athens) - TO: $to - SUBJECT: $subject\n";
            file_put_contents(__DIR__ . '/../logs/email.log', $log, FILE_APPEND | LOCK_EX);
        }
    }
}
?>
