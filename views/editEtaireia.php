<?php
require_once __DIR__ . '/../controllers/EtaireiaController.php';

$controller = new EtaireiaController();
$id = $_GET['id'] ?? null;
if (empty($id)) {
    header('Location: ../index.php?error=1&msg=' . urlencode('Missing id'));
    exit;
}

try {
    $etaireia = $controller->getEtaireia($id);
    if (!$etaireia) {
        header('Location: ../index.php?error=1&msg=' . urlencode('Record not found'));
        exit;
    }
} catch (Exception $e) {
    header('Location: ../index.php?error=1&msg=' . urlencode($e->getMessage()));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Etaireia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Μαθητεία App</a>
  </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Edit Etaireia</h1>
    <form action="../edit_etaireia.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($etaireia['id']); ?>">
        <div class="mb-3">
            <label for="onoma" class="form-label">Όνομα</label>
            <input type="text" class="form-control" id="onoma" name="onoma" value="<?php echo htmlspecialchars($etaireia['onoma']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="dieuthinsi" class="form-label">Διεύθυνση</label>
            <input type="text" class="form-control" id="dieuthinsi" name="dieuthinsi" value="<?php echo htmlspecialchars($etaireia['dieuthinsi']); ?>">
        </div>
        <div class="mb-3">
            <label for="tk" class="form-label">ΤΚ</label>
            <input type="text" class="form-control" id="tk" name="tk" value="<?php echo htmlspecialchars($etaireia['tk']); ?>">
        </div>
        <div class="mb-3">
            <label for="til" class="form-label">Τηλέφωνο</label>
            <input type="text" class="form-control" id="til" name="til" value="<?php echo htmlspecialchars($etaireia['til']); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($etaireia['email']); ?>">
        </div>
        <div class="mb-3">
            <label for="www" class="form-label">URL</label>
            <input type="url" class="form-control" id="www" name="www" value="<?php echo htmlspecialchars($etaireia['www']); ?>">
        </div>
        <div class="mb-3">
            <label for="sxolia" class="form-label">Σχόλια</label>
            <textarea class="form-control" id="sxolia" name="sxolia" rows="3"><?php echo htmlspecialchars($etaireia['sxolia'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="../index.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>