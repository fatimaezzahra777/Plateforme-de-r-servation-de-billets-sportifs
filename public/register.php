<?php
session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Acheteur.php';
require_once __DIR__ . '/../classes/Organisateur.php';
require_once __DIR__ . '/../classes/Admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name      = $_POST['nom'] ?? '';
    $adresse   = $_POST['adresse'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email     = $_POST['email'] ?? '';
    $password  = $_POST['password'] ?? '';
    $role      = $_POST['role'] ?? '';

    if (!$name || !$adresse || !$telephone || !$email || !$password || !$role) {
        die("Tous les champs sont obligatoires");
    }

    $pdo = Database::getConnection();

    switch ($role) {
        case 'acheteur':
            $user = new Acheteur($pdo);
            break;

        case 'organisateur':
            $user = new Organisateur($pdo);
            break;

        case 'admin':
            $user = new Admin($pdo);
            break;

        default:
            die("Rôle invalide");
    }

 
    $user->setName($name);
    $user->setAdresse($adresse);
    $user->setTelephone($telephone);
    $user->setEmail($email);
    $user->setPassword($password);

    if ($user->register()) {
        header("Location: login.php?success=1");
        exit;
    } else {
        echo "Email déjà utilisé";
    }
}
