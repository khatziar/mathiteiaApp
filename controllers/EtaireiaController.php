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
        return $this->etaireiaModel->all();
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
