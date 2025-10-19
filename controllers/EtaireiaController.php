<?php
require_once __DIR__ . '/../models/etaireia.php';

class EtaireiaController {
    private $etaireiaModel;

    public function __construct() {
        $this->etaireiaModel = new Etaireia();
    }

    // public function createEtaireia($data) {
    //     return $this->etaireiaModel->create($data);
    // }

    // public function getEtaireia($id) {
    //     return $this->etaireiaModel->get($id);
    // }

    // public function updateEtaireia($id, $data) {
    //     return $this->etaireiaModel->update($id, $data);
    // }

    // public function deleteEtaireia($id) {
    //     return $this->etaireiaModel->delete($id);
    // }
    public function getAllEtaireia() {
        try {
            return $this->etaireiaModel->all();
        } catch (Exception $e) {
            // Bubble up the exception message so the entry point can decide how to display it
            throw $e;
        }
    }

    public function createEtaireia(array $data) {
        // Basic validation: require at least a name
        if (empty($data['onoma'])) {
            throw new Exception('Το πεδίο "Όνομα" είναι υποχρεωτικό.');
        }

        // Call model create
        return $this->etaireiaModel->create($data);
    }

    public function getEtaireia($id) {
        return $this->etaireiaModel->get($id);
    }

    public function updateEtaireia($id, array $data) {
        if (empty($data['onoma'])) {
            throw new Exception('Το πεδίο "Όνομα" είναι υποχρεωτικό.');
        }
        return $this->etaireiaModel->update($id, $data);
    }

    public function deleteEtaireia($id) {
        if (empty($id)) {
            throw new Exception('Invalid id');
        }
        return $this->etaireiaModel->delete($id);
    }

    // function that sends email to all etaireies
    public function sendEmailToAllEtaireies($subject, $message) {
        // $etaireies = $this->getAllEtaireia();
        // fake etaireies with only khatziar@gmail.com
        $etaireies = [
            ['email' => 'khatziar@gmail.com', 'onoma' => 'Kostas']
        ];
        foreach ($etaireies as $etaireia) {
            if (!empty($etaireia['email'])) {
                mail($etaireia['email'], $subject, $message);
            }
        }
        }   
}
