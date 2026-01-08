<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'acheteur') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$db = Database::getConnection();


$matchs = $db->query("
    SELECT m.id_match, m.equipe1, m.equipe2, m.date_match, m.heure_match, m.lieu,
           c.id_categorie, c.nom_categorie, c.prix, c.nb_places
    FROM matchs m
    JOIN categories c ON m.id_match = c.id_match
    WHERE m.statut='valide' AND c.nb_places > 0
    ORDER BY m.date_match ASC
")->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['acheter'])) {
    $id_match = intval($_POST['id_match']);
    $id_categorie = intval($_POST['id_categorie']);

    // Vérifier que l'utilisateur n'a pas déjà 4 billets pour ce match
    $stmt = $db->prepare("SELECT COUNT(*) FROM Ticket WHERE id_user=? AND id_match=?");
    $stmt->execute([$id_user, $id_match]);
    if ($stmt->fetchColumn() >= 4) {
        $error = "Vous avez déjà acheté 4 billets pour ce match.";
    } else {
        // Vérifier si la catégorie a encore des places
        $stmt = $db->prepare("SELECT nb_places FROM categories WHERE id_categorie=?");
        $stmt->execute([$id_categorie]);
        $categorie = $stmt->fetch();
        if ($categorie && $categorie['nb_places'] > 0) {
            // Générer une place aléatoire
            $place = 'A'.rand(1, $categorie['nb_places']);

            // Insérer le billet
            $insert = $db->prepare("INSERT INTO Ticket (id_user, id_match, id_categorie, place) VALUES (?,?,?,?)");
            $insert->execute([$id_user, $id_match, $id_categorie, $place]);

            // Décrémenter le nombre de places
            $db->prepare("UPDATE categories SET nb_places = nb_places - 1 WHERE id_categorie=?")->execute([$id_categorie]);

            $success = "Billet acheté avec succès !";
        } else {
            $error = "Plus de place disponible dans cette catégorie.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Matchs disponibles - Acheteur</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
    body{background:#0f172a;color:white;display:flex;}
    .sidebar{width:260px;background:#020617;min-height:100vh;padding:25px;}
    .sidebar h2{color:#6366f1;margin-bottom:40px;}
    .sidebar a{display:block;color:#e5e7eb;text-decoration:none;margin-bottom:18px;padding:10px;border-radius:8px;}
    .sidebar a:hover{background:#1e293b;}
    .main{flex:1;padding:30px;}
    .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;}
    .topbar .user{display:flex;align-items:center;gap:0.5rem;}
    .topbar .user i{font-size:1.5rem;color:#6366f1;}
    table{width:100%;border-collapse:collapse;background:#1e293b;border-radius:12px;overflow:hidden;margin-top:2%;margin-bottom:2%;}
    th, td{padding:1rem;text-align:left;border-bottom:1px solid #eee;}
    th{background:#1e293b;color:white;}
    tr:hover{background:#1e298b;}
    .btn{padding:0.5rem 1rem;border:none;border-radius:8px;cursor:pointer;}
    .btn-primary{background:#6366f1;color:#fff;}
</style>
</head>
<body>
<div class="sidebar">
    <h2>🎫 SportTicket</h2>
    <a href="acheteur_d.php"><i class="fas fa-home"></i> Tableau de bord</a>
    <a href="profileA.php"><i class="fas fa-user"></i> Mon profil</a>
    <a href="matches.php"><i class="fas fa-calendar-check"></i> Matchs disponibles</a>
    <a href="my_tickets.php"><i class="fas fa-ticket-alt"></i> Mes billets</a>
    <a href="comments.php"><i class="fas fa-star"></i> Laisser un avis</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
</div>

<div class="main">
    <div class="topbar">
        <div class="user"><i class="fas fa-user"></i> <strong>Acheteur</strong></div>
    </div>

    <h1>Matchs disponibles</h1>
    <table>
    <thead>
        <tr>
            <th>Match</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Places</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($matchs as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['equipe1']) ?> vs <?= htmlspecialchars($m['equipe2']) ?></td>
            <td><?= $m['date_match'] ?> <?= $m['heure_match'] ?></td>
            <td><?= htmlspecialchars($m['lieu']) ?></td>
            <td><?= htmlspecialchars($m['nom_categorie']) ?></td>
            <td><?= $m['prix'] ?> DH</td>
            <td><?= $m['nb_places'] ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="id_match" value="<?= $m['id_match'] ?>">
                    <input type="hidden" name="id_categorie" value="<?= $m['id_categorie'] ?>">
                    <button name="acheter">Acheter</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
</body>
</html>
