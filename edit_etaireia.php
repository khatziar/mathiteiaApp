<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$payload = [
    'onoma' => $_POST['onoma'] ?? null,
    'dieuthinsi' => $_POST['dieuthinsi'] ?? null,
    'tk' => $_POST['tk'] ?? null,
    'til' => $_POST['til'] ?? null,
    'email' => $_POST['email'] ?? null,
    'www' => $_POST['www'] ?? null,
    'sxolia' => $_POST['sxolia'] ?? null,
];

$controller = new EtaireiaController();
try {
    $updated = $controller->updateEtaireia($id, $payload);
    header('Location: index.php?updated=1&id=' . urlencode($id));
    exit;
} catch (Exception $e) {
    header('Location: index.php?error=1&msg=' . urlencode($e->getMessage()));
    exit;
}
