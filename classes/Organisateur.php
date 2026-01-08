<?php
require_once 'User.php';

class Organisateur extends User {
    protected $role = 'organisateur';

    public function register() {
        $check = $this->conn->prepare("SELECT id_user FROM users WHERE email = :email");
        $check->bindParam(':email', $this->email);
        $check->execute();
        if($check->rowCount() > 0) return false;

        $query = "INSERT INTO users SET nom=:nom, adresse=:adresse, telephone=:telephone, email=:email, password=:password, role=:role";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom', $this->name);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':role', $this->role);

        return $stmt->execute();
    }


    public function creerMatch($data){
        $sql = "INSERT INTO matchs 
        (id_organisateur,equipe1,equipe2,date_match,heure_match,lieu,nb_places)
        VALUES (:org,:e1,:e2,:date,:heure,:lieu,:places)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':org' => $data['id_organisateur'],
            ':e1' => $data['equipe1'],
            ':e2' => $data['equipe2'],
            ':date' => $data['date'],
            ':heure' => $data['heure'],
            ':lieu' => $data['lieu'],
            ':places' => $data['nb_places']
        ]);
    }

    public function statistiques($idOrganisateur){
        $sql = "SELECT COUNT(*) as total_matchs
                FROM matchs
                WHERE id_organisateur = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id'=>$idOrganisateur]);
        return $stmt->fetch();
    }
}
?>
