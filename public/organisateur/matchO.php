<?php
session_start();
require_once '../../config/Database.php';

if ($_SESSION['role'] !== 'organisateur') {
    die('Accès refusé');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = Database::getConnection();

    $logo1 = null;
    $logo2 = null;

    if (!empty($_FILES['logo_equipe1']['name'])) {
        $logo1 = uniqid() . '_' . $_FILES['logo_equipe1']['name'];
        move_uploaded_file($_FILES['logo_equipe1']['tmp_name'], "../assets/images/" . $logo1);
    }

    if (!empty($_FILES['logo_equipe2']['name'])) {
        $logo2 = uniqid() . '_' . $_FILES['logo_equipe2']['name'];
        move_uploaded_file($_FILES['logo_equipe2']['tmp_name'], "../assets/images/" . $logo2);
    }


    $stmt = $pdo->prepare("
        INSERT INTO matchs 
        (id_organisateur, equipe1, logo_equipe1, equipe2, logo_equipe2, date_match, heure_match, lieu, nb_places)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['id_user'],
        $_POST['equipe1'],
        $logo1,
        $_POST['equipe2'],
        $logo2,
        $_POST['date'],
        $_POST['heure'],
        $_POST['lieu'],
        $_POST['nb_places']
    ]);

    $id_match = $pdo->lastInsertId();

    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];

    $stmt_cat = $pdo->prepare("
        INSERT INTO categories (id_match, nom_categorie, prix, nb_places)
        VALUES (?, ?, ?, ?)
    ");

    $stmt_cat->execute([
        $id_match,
        $categorie,
        $prix,
        $_POST['nb_places']  
    ]);

    header("Location: organisateur.php?success=1");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Créer un Match | Organisateur</title>
<style>
body{
    background:#0f172a;
    font-family:Segoe UI;
    color:white;
    padding:10px;
}
.container{
    max-width:900px;
    margin:auto;
    background:#1e293b;
    padding:30px;
    border-radius:15px;
}
h1{margin-bottom:25px;}
label{display:block;margin-top:15px;}
input{
    width: 95%;
    padding:12px;
    border-radius:8px;
    border:none;
    margin-top:8px;
}
select{
    width: 98%;
    padding:12px;
    border-radius:8px;
    border:none;
    margin-top:8px;
}
button{
    margin-top:30px;
    background:#6366f1;
    padding:14px;
    border:none;
    border-radius:10px;
    color:white;
    font-size:16px;
    cursor:pointer;
}
</style>
</head>

<body>
    
<div class="container">
<h1>➕ Nouvelle demande de match</h1>

<form method="POST" action="matchO.php" enctype="multipart/form-data">
<label>Équipe 1</label>
<input type="text" name="equipe1" placeholder="Nom équipe 1">

<label>Logo Équipe 1</label>
<input type="file" name="logo_equipe1" placeholder="Logo équipe 1">

<label>Équipe 2</label>
<input type="text" name="equipe2" placeholder="Nom équipe 2">

<label>Logo Équipe 2</label>
<input type="file" name="logo_equipe2" placeholder="Logo équipe 2">

<label>Date </label>
<input type="date" name="date">

<label>Heure </label>
<input type="time" name="heure">

<label>Lieu</label>
<input type="text" name="lieu" placeholder="Stade / Ville">

<label>Nombre de places (max 2000)</label>
<input type="number" name="nb_places" max="2000">

<label>Catégorie</label>
<select name="categorie">
    <option value="VIP">VIP</option>
    <option value="Premium">Premium</option>
    <option value="Standard">Standard</option>
</select>

<label>Prix (DH)</label>
<input type="number" name="prix">

<button type="submit">Envoyer pour validation</button>
</form>
</div>
</body>
</html>
