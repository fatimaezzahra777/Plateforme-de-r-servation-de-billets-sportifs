<?php

require_once __DIR__ . '/../config/Database.php';

class Categorie {
    private $db;

    public $id_categorie;
    public $id_match;
    public $nom_categorie;
    public $prix;
    public $nb_places;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les catégories d'un match
    public function getByMatch($id_match) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id_match=?");
        $stmt->execute([$id_match]);
        return $stmt->fetchAll();
    }

    // Récupérer une catégorie avec des places disponibles
    public function getAvailable($id_match) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id_match=? AND nb_places>0 LIMIT 1");
        $stmt->execute([$id_match]);
        return $stmt->fetch();
    }

    // Décrémenter le nombre de places
    public function decrementPlace($id_categorie) {
        $stmt = $this->db->prepare("UPDATE categories SET nb_places = nb_places - 1 WHERE id_categorie=?");
        return $stmt->execute([$id_categorie]);
    }
}
