<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'acheteur') {
    die('Accès refusé');
}

$pdo = Database::getConnection();


$stmt = $pdo->query("SELECT id_match, equipe1, equipe2, date_match FROM matchs ORDER BY date_match DESC");
$matchs = $stmt->fetchAll();


$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_match = $_POST['id_match'] ?? null;
    $note = $_POST['note'] ?? null;
    $commentaire = trim($_POST['commentaire'] ?? '');

    if (!$id_match || !$note || !$commentaire || $note < 1 || $note > 5) {
        $error = "Tous les champs sont obligatoires et la note doit être entre 1 et 5.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Commentaires (id_match, id_user, commentaire, note) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_match, $_SESSION['id_user'], $commentaire, $note]);
        $success = "Merci ! Votre avis a été ajouté.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laisser un avis - Acheteur</title>
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
form{background:#1e293b;padding:2rem;border-radius:12px;box-shadow:0 4px 6px rgba(0,0,0,0.1);max-width:600px;}
form label{display:block;margin:0.75rem 0 0.25rem;font-weight:600;}
form input, form select, form textarea{width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:8px;}
form button{margin-top:1rem;padding:0.5rem 1rem;border:none;border-radius:8px;cursor:pointer;background:#6366f1;color:#fff;}
.alert{padding:0.75rem;margin-bottom:1rem;border-radius:8px;}
.success{background:#16a34a;color:white;}
.error{background:#dc2626;color:white;}
.commentaires{margin-top:2rem;}
.commentaire{background:#1e293b;padding:1rem;margin-bottom:1rem;border-radius:8px;border:1px solid #444;}
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

    <h1>Laisser un avis</h1>

    <?php if($success): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Match :</label>
        <select name="id_match" required>
            <option value="">-- Sélectionner un match --</option>
            <?php foreach($matchs as $match): ?>
                <option value="<?= $match['id_match'] ?>">
                    <?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?> - <?= date("d/m/Y", strtotime($match['date_match'])) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Note :</label>
        <select name="note" required>
            <option value="5">5 étoiles</option>
            <option value="4">4 étoiles</option>
            <option value="3">3 étoiles</option>
            <option value="2">2 étoiles</option>
            <option value="1">1 étoile</option>
        </select>

        <label>Commentaire :</label>
        <textarea name="commentaire" rows="4" required></textarea>

        <button type="submit">Envoyer l'avis</button>
    </form>

    <div class="commentaires">
        <h2>Commentaires précédents</h2>
        <?php
        $stmt = $pdo->query("
            SELECT c.commentaire, c.note, c.date_commentaire, u.nom 
            FROM Commentaires c
            JOIN users u ON u.id_user = c.id_user
            ORDER BY c.date_commentaire DESC
        ");
        $comments = $stmt->fetchAll();
        if($comments):
            foreach($comments as $c):
        ?>
            <div class="commentaire">
                <strong><?= htmlspecialchars($c['nom']) ?></strong> - <?= $c['note'] ?> étoiles<br>
                <small><?= date("d/m/Y H:i", strtotime($c['date_commentaire'])) ?></small>
                <p><?= nl2br(htmlspecialchars($c['commentaire'])) ?></p>
            </div>
        <?php 
            endforeach;
        else: 
        ?>
            <p>Aucun commentaire pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
