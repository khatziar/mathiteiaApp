<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Εταιρείες</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for pink hover -->
    <style>
        .table-hover tbody tr:hover {
            background-color: #ffc0cb !important; /* Light pink */
        }
        .table-hover tbody tr:hover td {
            background-color: transparent;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4 text-primary">Εταιρείες Μαθητείας</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Όνομα</th>
                        <th scope="col">Διεύθυνση</th>
                        <th scope="col">ΤΚ</th>
                        <th scope="col">Τηλέφωνο</th>
                        <th scope="col">Email</th>
                        <th scope="col">URL</th>
                        <th scope="col">Σχόλια</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($etaireies as $etaireia): ?>
                <tr>
                    <td><?php echo htmlspecialchars($etaireia['id']); ?></td>
                    <td><strong><?php echo htmlspecialchars($etaireia['onoma']); ?></strong></td>
                    <td><?php echo htmlspecialchars($etaireia['dieuthinsi']); ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($etaireia['tk']); ?></span></td>
                    <td><?php echo htmlspecialchars($etaireia['til']); ?></td>
                    <td>
                        <?php if (!empty($etaireia['email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($etaireia['email']); ?>" class="text-decoration-none">
                                <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($etaireia['email']); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($etaireia['www'])): ?>
                            <a href="<?php echo htmlspecialchars($etaireia['www']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-globe"></i> Επίσκεψη
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($etaireia['sxolia']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <!-- button for sending email to all etaireies using the function sendEmailToAllEtaireies in EtaireiaController.php -->
        <div class="text-center mt-4">
            <form action="send_email.php" method="post">
                <div class="mb-3">
                    <label for="subject" class="form-label">Θέμα</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Μήνυμα</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Αποστολή Email σε Όλες τις Εταιρείες</button>
            </form>
        </div>

    <!-- Bootstrap JS (optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>