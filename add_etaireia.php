<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';
require_once __DIR__ . '/utils/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

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
    if (!csrf_validate($_POST['csrf_token'] ?? '')) {
        throw new Exception('Invalid CSRF token');
    }

    $insertId = $controller->createEtaireia($payload);
    // Redirect back with success
    header('Location: index.php?created=1&id=' . urlencode($insertId));
    exit;
} catch (Exception $e) {
    // Redirect back with error message (urlencoded)
    $msg = urlencode($e->getMessage());
    header('Location: index.php?error=1&msg=' . $msg);
    exit;
}
