<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'acheteur') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$db = Database::getConnection();

$stmt = $db->prepare("
    SELECT t.id_ticket, m.equipe1, m.equipe2, m.date_match, m.heure_match,
           c.nom_categorie, t.place
    FROM Ticket t
    JOIN matchs m ON t.id_match = m.id_match
    JOIN categories c ON t.id_categorie = c.id_categorie
    WHERE t.id_user = ?
    ORDER BY m.date_match ASC
");
$stmt->execute([$id_user]);
$billets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes billets - Acheteur</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:'Segoe UI',sans-serif;
    }
    body{
        background:#0f172a;
        color:white;
        display:flex;
    }
    .sidebar{
        width:260px;
        background:#020617;
        min-height:100vh;
        padding:25px;
    }
    .sidebar h2{
        color:#6366f1;
        margin-bottom:40px;
    }
    .sidebar a{
        display:block;
        color:#e5e7eb;
        text-decoration:none;
        margin-bottom:18px;
        padding:10px;
        border-radius:8px;
    }
    .sidebar a:hover{
        background:#1e293b;
    }
    .main{
        flex:1;
        padding:30px;
    }
    .topbar{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:30px;
    }
    .topbar .user{
        display:flex;
        align-items:center;
        gap:0.5rem;
    }
    .topbar .user i{
        font-size:1.5rem;
        color:#6366f1;
    }
    table{
        width:100%;
        border-collapse:collapse;
        background:#1e293b;
        border-radius:12px;
        overflow:hidden;
        margin-top:2%;
        margin-bottom:2%;
    }
    th, td{
        padding:1rem;
        text-align:left;
        border-bottom:1px solid #eee;
    }
    th{
        background:#1e293b;
        color:white;
    }
    tr:hover{
        background:#1e298b;
    }
    .btn{
        padding:0.5rem 1rem;
        border:none;
        border-radius:8px;
        cursor:pointer;
    }
    .btn-outline{
        background:#6366f1;
        color:#fff;
        border:1px solid #6366f1;
    }
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

    <h1>Mes billets</h1>
    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Catégorie</th>
                <th>Place</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($billets)): ?>
                <?php foreach($billets as $b): ?>
                <tr>
                    <td><?= htmlspecialchars($b['equipe1']) ?> vs <?= htmlspecialchars($b['equipe2']) ?></td>
                    <td><?= $b['date_match'] ?></td>
                    <td><?= $b['heure_match'] ?></td>
                    <td><?= htmlspecialchars($b['nom_categorie']) ?></td>
                    <td><?= htmlspecialchars($b['place']) ?></td>
                    <td><a href="pdf.php?id_ticket=<?= $b['id_ticket'] ?>" class="btn btn-outline">Télécharger</a></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Vous n'avez acheté aucun billet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
