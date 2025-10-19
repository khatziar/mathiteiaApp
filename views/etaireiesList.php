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
        /* Use automatic table layout so columns size to content */
        .table-fixed {
            table-layout: auto;
            width: 100%;
        }

        /* Reduce padding for many columns */
        .table-sm td, .table-sm th {
            padding: .3rem .5rem;
        }

        /* Allow most columns to wrap, but keep compact columns on a single line */
        .table-fixed td, .table-fixed th {
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal; /* default: allow wrapping for long text */
        }

        /* Keep these compact columns on one line to reduce row height */
        .table-fixed td:nth-child(1), .table-fixed th:nth-child(1),
        .table-fixed td:nth-child(2), .table-fixed th:nth-child(2),
        .table-fixed td:nth-child(4), .table-fixed th:nth-child(4),
        .table-fixed td:nth-child(5), .table-fixed th:nth-child(5),
        .table-fixed td:nth-child(6), .table-fixed th:nth-child(6),
        .table-fixed td:nth-child(10), .table-fixed th:nth-child(10) {
            white-space: nowrap;
        }

        /* Make table cells more compact vertically */
        .table-fixed td, .table-fixed th {
            padding-top: .25rem;
            padding-bottom: .25rem;
            vertical-align: middle;
        }

        /* Tweak small buttons inside the table to be shorter */
        .table-fixed .btn-sm {
            padding: .15rem .35rem;
            font-size: .78rem;
            line-height: 1;
        }
    </style>
</head>
<body>
        <!-- Top navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Μαθητεία App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- left aligned items could go here -->
                    </ul>
                    <div class="d-flex">
                        <a href="views/addEtaireia.php" class="btn btn-success">Add Etaireia</a>
                    </div>
                </div>
            </div>
        </nav>

    <div class="container-fluid mt-4">
        <h1 class="text-center mb-4 text-primary">Εταιρείες Μαθητείας</h1>

        <div>
            <table class="table table-sm table-striped table-hover table-bordered table-fixed">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">α/α</th>
                        <th scope="col">ID</th>
                        <th scope="col">Όνομα</th>
                        <th scope="col">Διεύθυνση</th>
                        <th scope="col">ΤΚ</th>
                        <th scope="col">Τηλέφωνο</th>
                        <th scope="col">Email</th>
                        <th scope="col">URL</th>
                        <th scope="col">Σχόλια</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
            <?php $i = 1; foreach ($etaireies as $etaireia): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($etaireia['id']); ?></td>
                    <td><strong><?php echo htmlspecialchars($etaireia['onoma']); ?></strong></td>
                    <td><?php echo htmlspecialchars($etaireia['dieuthinsi']); ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($etaireia['tk']); ?></span></td>
                    <td><?php echo htmlspecialchars((string)$etaireia['til']); ?></td>
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
                    <td><?php echo htmlspecialchars((string) ($etaireia['sxolia'] ?? '')); ?></td>
                    <td>
                        <a href="views/editEtaireia.php?id=<?php echo urlencode($etaireia['id']); ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>

                        <form action="delete_etaireia.php" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($etaireia['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
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