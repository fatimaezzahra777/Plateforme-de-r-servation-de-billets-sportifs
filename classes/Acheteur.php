<?php
require_once 'User.php';

class Acheteur extends User {

    protected $role = 'acheteur';

    public function register() {
        $check = $this->conn->prepare(
            "SELECT id_user FROM users WHERE email = :email"
        );
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
}


?>