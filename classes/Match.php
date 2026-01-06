<?php
class MatchS{
    private $conn;

    public function __construct(PDO $db){
        $this->conn = $db;
    }

    public function getMatchOrganisateur($id){
        $sql = "SELECT * FROM matchs WHERE id_organisateur = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
