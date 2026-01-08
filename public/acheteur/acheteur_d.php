<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once '../../config/Database.php';
require_once '../../classes/Ticket.php';
require_once '../../classes/Categorie.php';




// Vérifier que l'utilisateur est un acheteur
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'acheteur') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$db = Database::getConnection();


$ticket = new Ticket($db);
$categorie = new Categorie($db);

// Achat d'un billet
if (isset($_POST['acheter'])) {
    $id_match = intval($_POST['id_match']);

    // Vérifier limite 4 billets
    if ($ticket->countByUserMatch($id_user, $id_match) >= 4) {
        $error = "Maximum 4 billets par match";
    } else {
        // Récupérer une catégorie disponible
        $cat = $categorie->getAvailable($id_match);
        if ($cat) {
            $place = 'A'.rand(1, $cat['nb_places']); // Numéro de place aléatoire
            $ticket->create($id_user, $id_match, $cat['id_categorie'], $place);
            $categorie->decrementPlace($cat['id_categorie']);
            $success = "Billet acheté avec succès !";
        } else {
            $error = "Plus de place disponible pour ce match";
        }
    }
}

// Récupérer tous les matchs valides avec le nombre de places restantes
$matchs = $db->query("
    SELECT m.id_match, m.equipe1, m.equipe2, m.date_match, m.lieu,
           SUM(c.nb_places) AS nb_places
    FROM matchs m
    JOIN categories c ON m.id_match = c.id_match
    WHERE m.statut='valide'
    GROUP BY m.id_match
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Matchs disponibles - Acheteur</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body{background:#0f172a;color:white;font-family:'Segoe UI',sans-serif;margin:0;padding:0;}
.sidebar{width:260px;background:#020617;min-height:100vh;padding:25px;float:left;}
.sidebar h2{color:#6366f1;margin-bottom:40px;}
.sidebar a{display:block;color:#e5e7eb;text-decoration:none;margin-bottom:18px;padding:10px;border-radius:8px;}
.sidebar a:hover{background:#1e293b;}
.main{margin-left:260px;padding:30px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th, td{padding:12px;text-align:left;border-bottom:1px solid #444;}
th{background:#1e293b;color:white;}
tr:hover{background:#1e293b;}
button{padding:8px 12px;border:none;border-radius:8px;background:#6366f1;color:white;cursor:pointer;}
.success{color:lightgreen;margin-bottom:15px;}
.error{color:red;margin-bottom:15px;}
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
    <h1>Matchs disponibles</h1>

    <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Places disponibles</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($matchs as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['equipe1']) ?> vs <?= htmlspecialchars($m['equipe2']) ?></td>
                <td><?= $m['date_match'] ?></td>
                <td><?= htmlspecialchars($m['lieu']) ?></td>
                <td><?= $m['nb_places'] ?></td>
                <td>
                    <?php if($m['nb_places'] > 0): ?>
                    <form method="post">
                        <input type="hidden" name="id_match" value="<?= $m['id_match'] ?>">
                        <button name="acheter">Acheter</button>
                    </form>
                    <?php else: ?>
                        Complet
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>