<?php
require_once __DIR__ . '/../config/database.php';

class Etaireia {
    public function all() {
        $database = new Database();
        $db = $database->getConnection();
        $query = "SELECT * FROM etaireies";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}