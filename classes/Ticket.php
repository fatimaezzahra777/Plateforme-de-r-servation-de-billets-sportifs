<?php
require_once __DIR__ . '/../config/Database.php';

class Ticket {
    private $db;

    public $id_ticket;
    public $id_user;
    public $id_match;
    public $id_categorie;
    public $place;
    public $date_achat;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($id_user, $id_match, $id_categorie, $place) {
        $stmt = $this->db->prepare(
            "INSERT INTO Ticket (id_user, id_match, id_categorie, place) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$id_user, $id_match, $id_categorie, $place]);
    }

    public function countByUserMatch($id_user, $id_match) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Ticket WHERE id_user=? AND id_match=?");
        $stmt->execute([$id_user, $id_match]);
        return $stmt->fetchColumn();
    }

    public function getByUser($id_user) {
        $stmt = $this->db->prepare("
            SELECT t.id_ticket, m.equipe1, m.equipe2, m.date_match, m.heure_match, m.lieu,
                   c.nom_categorie, t.place, t.date_achat
            FROM Ticket t
            JOIN matchs m ON t.id_match = m.id_match
            JOIN categories c ON t.id_categorie = c.id_categorie
            WHERE t.id_user = ?
            ORDER BY t.date_achat DESC
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll();
    }
}
