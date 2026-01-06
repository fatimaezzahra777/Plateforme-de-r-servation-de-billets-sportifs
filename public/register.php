<?php
session_start();
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Acheteur.php';
require_once __DIR__ . '/../classes/Organisateur.php';
require_once __DIR__ . '/../classes/Admin.php';
require_once __DIR__ . '/../config/Database.php'; 

$db = new Database();
$pdo = $db->getConnection();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['nom'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if(!$name || !$email || !$adresse || !$telephone || !$password || !$role){
        echo json_encode(['success'=>false,'message'=>'Tous les champs sont requis']);
        exit;
    }

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
            echo json_encode(['success'=>false,'message'=>'Rôle invalide']);
            exit;
    }

    $user->setName($name);
    $user->setAdresse($adresse);
    $user->setTelephone($telephone);
    $user->setEmail($email);
    $user->setPassword($password);

    if($user->register()){
        echo json_encode(['success'=>true,'message'=>'Inscription réussie']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Email déjà utilisé ou erreur']);
    }
}
?>
