<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';
require_once __DIR__ . '/utils/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$controller = new EtaireiaController();
try {
    if (!csrf_validate($_POST['csrf_token'] ?? '')) {
        throw new Exception('Invalid CSRF token');
    }

    $deleted = $controller->deleteEtaireia($id);
    header('Location: index.php?deleted=1&id=' . urlencode($id));
    exit;
} catch (Exception $e) {
    header('Location: index.php?error=1&msg=' . urlencode($e->getMessage()));
    exit;
}
