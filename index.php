<?php
require_once __DIR__ . '/controllers/EtaireiaController.php';

$controller = new EtaireiaController();
try {
	$etaireies = $controller->getAllEtaireia();
	require_once __DIR__ . '/views/etaireiesList.php';
} catch (Exception $e) {
	// Provide an actionable message for local development
	$msg = $e->getMessage();
	echo "<h2>Application error</h2>";
	echo "<p>" . htmlspecialchars($msg) . "</p>";
	echo "<p>Possible causes: the PDO driver for your database is not enabled in php.ini (for example, pdo_pgsql for PostgreSQL or pdo_mysql for MySQL).\n";
	echo "Check your php.ini and enable the appropriate extension, then restart Laragon.</p>";
}
// This file serves as the entry point for the application
// It initializes the controller, fetches the data, and includes the view