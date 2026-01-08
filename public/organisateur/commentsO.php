<?php
session_start();
require_once '../../config/Database.php';

// Vérification rôle
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'organisateur') {
    die('Accès refusé');
}

$pdo = Database::getConnection();

// Récupérer tous les matchs créés par cet organisateur
$stmt = $pdo->prepare("SELECT * FROM matchs WHERE id_organisateur = ? ORDER BY date_match DESC");
$stmt->execute([$_SESSION['id_user']]);
$matchs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commentaires des matchs - Organisateur</title>
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
.match{background:#1e293b;padding:1.5rem;margin-bottom:2rem;border-radius:12px;}
.match h2{margin-bottom:1rem;}
.commentaire{background:#111827;padding:1rem;margin-bottom:1rem;border-radius:8px;border:1px solid #444;}
.commentaire strong{color:#6366f1;}
</style>
</head>
<body>

<div class="sidebar">
    <h2>🎫 SportTicket</h2>
    <a href="../organisateur/organisateur.php"><i class="fas fa-home"></i> Tableau de bord</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
</div>

<div class="main">
    <div class="topbar">
        <div class="user"><i class="fas fa-user"></i> <strong>Organisateur</strong></div>
    </div>

    <h1>Commentaires par match</h1>

    <?php if(!$matchs): ?>
        <p>Vous n'avez encore créé aucun match.</p>
    <?php else: ?>
        <?php foreach($matchs as $match): ?>
            <div class="match">
                <h2><?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?> - <?= date("d/m/Y", strtotime($match['date_match'])) ?></h2>

                <?php
                // Récupérer les commentaires pour ce match
                $stmt = $pdo->prepare("
                    SELECT c.commentaire, c.note, c.date_commentaire, u.nom 
                    FROM Commentaires c
                    JOIN users u ON u.id_user = c.id_user
                    WHERE c.id_match = ?
                    ORDER BY c.date_commentaire DESC
                ");
                $stmt->execute([$match['id_match']]);
                $comments = $stmt->fetchAll();
                ?>

                <?php if($comments): ?>
                    <?php foreach($comments as $c): ?>
                        <div class="commentaire">
                            <strong><?= htmlspecialchars($c['nom']) ?></strong> - <?= $c['note'] ?> étoiles<br>
                            <small><?= date("d/m/Y H:i", strtotime($c['date_commentaire'])) ?></small>
                            <p><?= nl2br(htmlspecialchars($c['commentaire'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun commentaire pour ce match.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
