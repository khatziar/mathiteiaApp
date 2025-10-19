<?php
require_once __DIR__ . '/../config/database.php';

class Etaireia {
    public function all() {
        $database = new Database();
        // Attempt to get a connection — Database::connect now throws on failure
        $db = $database->getConnection();
        if ($db === null) {
            throw new Exception('Database connection is not available.');
        }

        $query = "SELECT * FROM etaireies";
        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Re-throw with more context
            throw new Exception('Database query error: ' . $e->getMessage());
        }
    }

    public function create(array $data) {
        $database = new Database();
        $db = $database->getConnection();
        if ($db === null) {
            throw new Exception('Database connection is not available.');
        }

        $sql = "INSERT INTO etaireies (onoma, dieuthinsi, tk, til, email, www, sxolia) VALUES (:onoma, :dieuthinsi, :tk, :til, :email, :www, :sxolia)";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':onoma', $data['onoma'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':dieuthinsi', $data['dieuthinsi'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':tk', $data['tk'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':til', $data['til'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':www', $data['www'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':sxolia', $data['sxolia'] ?? null, PDO::PARAM_STR);
            $stmt->execute();

            // Return last inserted id when supported
            return $db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception('Database insert error: ' . $e->getMessage());
        }
    }

    public function get($id) {
        $database = new Database();
        $db = $database->getConnection();
        if ($db === null) {
            throw new Exception('Database connection is not available.');
        }

        $sql = "SELECT * FROM etaireies WHERE id = :id LIMIT 1";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Database fetch error: ' . $e->getMessage());
        }
    }

    public function update($id, array $data) {
        $database = new Database();
        $db = $database->getConnection();
        if ($db === null) {
            throw new Exception('Database connection is not available.');
        }

        $sql = "UPDATE etaireies SET onoma = :onoma, dieuthinsi = :dieuthinsi, tk = :tk, til = :til, email = :email, www = :www, sxolia = :sxolia WHERE id = :id";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':onoma', $data['onoma'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':dieuthinsi', $data['dieuthinsi'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':tk', $data['tk'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':til', $data['til'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':www', $data['www'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':sxolia', $data['sxolia'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Database update error: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        $database = new Database();
        $db = $database->getConnection();
        if ($db === null) {
            throw new Exception('Database connection is not available.');
        }

        $sql = "DELETE FROM etaireies WHERE id = :id";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Database delete error: ' . $e->getMessage());
        }
    }
}