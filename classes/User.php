<?php
abstract class User {
    protected $id;
    protected $name;
    protected $adresse;
    protected $telephone;
    protected $email;
    protected $password;
    protected $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    abstract public function register();


    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row['password'])) {
                $this->id = $row['id_user'];
                $this->name = $row['nom'];
                $this->email = $row['email'];
                return true;
            }
        }
        return false;
    }
}
?>
