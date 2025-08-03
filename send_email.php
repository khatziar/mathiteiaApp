<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($subject) || empty($message)) {
        $error = "Παρακαλώ συμπληρώστε όλα τα πεδία.";
    } else {
        try {
            $controller = new EtaireiaController();
            // $etaireies = $controller->getAllEtaireia();
            // fake etaireies with only khatziar@gmail.com
            $etaireies = [
                ['email' => 'khatziar@gmail.com', 'onoma' => 'Kostas']
            ];
            $emailsSent = 0;
            $errors = [];

            foreach ($etaireies as $etaireia) {
                if (!empty($etaireia['email'])) {
                    $to = $etaireia['email'];
                    $companyName = $etaireia['onoma'];

                    // Customize message with company name
                    $personalizedMessage = "Αγαπητοί κύριοι της εταιρείας " . $companyName . ",\n\n" . $message;

                    $headers = "From: noreply@mathiteia.gr\r\n";
                    $headers .= "Reply-To: noreply@mathiteia.gr\r\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                    if (mail($to, $subject, $personalizedMessage, $headers)) {
                        $emailsSent++;
                    } else {
                        $errors[] = "Αποτυχία αποστολής στην εταιρεία: " . $companyName;
                    }
                }
            }

            if ($emailsSent > 0) {
                $success = "Επιτυχής αποστολή σε $emailsSent εταιρείες!";
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