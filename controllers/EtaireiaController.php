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
}