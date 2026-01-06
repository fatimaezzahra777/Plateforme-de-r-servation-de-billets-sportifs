<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'organisateur') {
    header('Location: ../login.php');
    exit;
}

$pdo = Database::getConnection();
$userId = $_SESSION['id_user'];
$message = '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    die("Utilisateur introuvable");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nom) || empty($email) || empty($adresse) || empty($telephone)) {
        $message = "Les informations sont obligatoires";
    } else {

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "UPDATE users SET nom = ?, email = ?, adresse = ?, telephone = ?, password = ? WHERE id_user = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $email, $adresse, $telephone, $hashedPassword, $userId]);

        } else {
            $sql = "UPDATE users SET nom = ?, email = ?, adresse = ?, telephone =?  WHERE id_user = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $email, $adresse, $telephone, $userId]);
        }

        $_SESSION['nom'] = $nom;
        $message = "Profil mis à jour avec succès";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil Organisateur</title>
<style>
body{background:#020617;color:white;font-family:Segoe UI;}
.box{
    max-width:500px;
    margin:80px auto;
    background:#1e293b;
    padding:30px;
    border-radius:15px;
}
input{
    width:95%;
    padding:12px;
    margin-top:12px;
    border-radius:8px;
    border:none;
}
button{
    margin-top:20px;
    width:100%;
    padding:12px;
    background:#22c55e;
    border:none;
    border-radius:10px;
    color:white;
}
</style>
</head>

<body>
<div class="box">
<h2>⚙️ Mon Profil</h2>
<form method="POST">
<input type="text" name="nom" value="<?= $user['nom'] ?>" placeholder="Nom complet">
<input type="email" name="email" value="<?= $user['email'] ?>" placeholder="Email">
<input type="adresse" name="adresse" value="<?= $user['adresse'] ?>" placeholder="Adresse">
<input type="telephone" name="telephone" value="<?= $user['telephone'] ?>" placeholder="Telephone">
<input type="password" name="password" placeholder="Nouveau mot de passe">
<button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>
