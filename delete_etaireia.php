<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$controller = new EtaireiaController();
try {
    $deleted = $controller->deleteEtaireia($id);
    header('Location: index.php?deleted=1&id=' . urlencode($id));
    exit;
} catch (Exception $e) {
    header('Location: index.php?error=1&msg=' . urlencode($e->getMessage()));
    exit;
}
