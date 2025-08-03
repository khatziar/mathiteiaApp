<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';

$controller = new EtaireiaController();
$etaireies = $controller->getAllEtaireia();

require_once __DIR__ . '/views/etaireiesList.php';
// This file serves as the entry point for the application
// It initializes the controller, fetches the data, and includes the view