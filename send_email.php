<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';
require_once __DIR__ . '/config/email.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($subject) || empty($message)) {
        $error = "Παρακαλώ συμπληρώστε όλα τα πεδία.";
    } else {
        try {
            $controller = new EtaireiaController();

            // For development - use fake data with your Gmail for testing
            if (EmailConfig::DEVELOPMENT_MODE) {
                // Use only your Gmail for testing
                $etaireies = [
                    ['email' => 'khatziar@gmail.com', 'onoma' => 'Test Company Development']
                ];
            } else {
                // Use real database data when ready
                // $etaireies = $controller->getAllEtaireia();
                $etaireies = [
                    ['email' => 'khatziar@gmail.com', 'onoma' => 'Kostas'],
                    ['email' => 'khatziar@sch.gr', 'onoma' => 'KostasSCH']
                ];
            }

            $emailSender = new EmailSender(true); // Enable SMTP for Gmail

            // Personalization callback
            $personalizeCallback = function ($message, $recipient) {
                return "Αγαπητοί κύριοι της εταιρείας " . $recipient['onoma'] . ",\n\n" . $message;
            };

            $results = $emailSender->sendBulkEmails($etaireies, $subject, $message, $personalizeCallback);

            if ($results['sent'] > 0) {
                $success = "Επιτυχής αποστολή σε " . $results['sent'] . " εταιρείες!";
            }

            if (count($results['failed']) > 0) {
                $errors = $results['errors'];
            }
        } catch (Exception $e) {
            $error = "Σφάλμα: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Αποστολή Email</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4 text-primary">Αποτέλεσμα Αποστολής Email</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($errors) && count($errors) > 0): ?>
                    <div class="alert alert-warning" role="alert">
                        <h6>Προβλήματα αποστολής:</h6>
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Επιστροφή στη Λίστα Εταιρειών
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>

</html>