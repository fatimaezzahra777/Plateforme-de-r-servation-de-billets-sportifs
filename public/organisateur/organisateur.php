<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'organisateur') {
    header('Location: ../login.php');
    exit;
}

$pdo = Database::getConnection();
$idOrganisateur = $_SESSION['id_user'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM matchs WHERE id_organisateur = ?");
$stmt->execute([$idOrganisateur]);
$nbMatchs = $stmt->fetchColumn();

$stmt = $pdo->prepare("
    SELECT AVG(c.note)
    FROM Commentaires c
    JOIN matchs m ON c.id_match = m.id_match
    WHERE m.id_organisateur = ?
");
$stmt->execute([$idOrganisateur]);
$noteMoyenne = round($stmt->fetchColumn(), 1) ?? 0;

$pdo = Database::getConnection();
$idOrganisateur = $_SESSION['id_user'];

// Récupérer tous les matchs de cet organisateur
$stmt = $pdo->prepare("
    SELECT * 
    FROM matchs
    WHERE id_organisateur = ?
    ORDER BY date_match DESC, heure_match DESC
");
$stmt->execute([$idOrganisateur]);
$matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Organisateur | SportTicket</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}
body{
    background:#0f172a;
    color:white;
    display:flex;
}

/* SIDEBAR */
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

/* MAIN */
.main{
    flex:1;
    padding:30px;
}
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}
.header h1{
    font-size:26px;
}
.logout{
    background:#ef4444;
    padding:10px 18px;
    border-radius:8px;
    color:white;
    text-decoration:none;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:40px;
}
.stat-card{
    background:#1e293b;
    padding:25px;
    border-radius:15px;
}
.stat-card h3{
    color:#94a3b8;
    font-size:14px;
}
.stat-card p{
    font-size:28px;
    margin-top:10px;
    color:#38bdf8;
}

/* EVENTS */
.section{
    margin-bottom:40px;
}
.section h2{
    margin-bottom:15px;
}
.btn{
    background:#6366f1;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    display:inline-block;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th, td{
    padding:12px;
    border-bottom:1px solid #334155;
}
th{
    color:#94a3b8;
    text-align:left;
}
.status{
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}
.pending{background:#f59e0b;}
.approved{background:#22c55e;}
.rejected{background:#ef4444;}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🎫 SportTicket</h2>
    <a href="#">📊 Dashboard</a>
    <a href="matchO.php">➕ Créer un événement</a>
    <a href="commentsO.php">💬 Commentaires</a>
    <a href="statiqueO.php">📈 Statistiques</a>
    <a href="profileO.php">⚙️ Profil</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="header">
        <h1>Bienvenue Organisateur 👋</h1>
        <a href="../logout.php" class="logout">Déconnexion</a>
    </div>

    <!-- STATISTICS -->
    <div class="stats">
        <div class="stat-card">
            <h3>Matchs créés</h3>
            <p><?= $nbMatchs ?></p>
        </div>
        <div class="stat-card">
            <h3>Note moyenne</h3>
            <p>⭐  <?= $noteMoyenne ?></p>
        </div>
    </div>

    <!-- CREATE EVENT -->
    <div class="section">
        <h2>Créer un événement sportif</h2>
        <a href="matchO.php" class="btn">➕ Nouvelle demande</a>
    </div>

    <!-- EVENTS LIST -->
    <div class="section">
        <h2>Mes matchs</h2>

        <table>
            <thead>
                <tr>
                    <th>Match</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Lieu</th>
                    <th>Billets</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($matchs as $match): ?>
                <tr>
                    <td><?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($match['date_match']))) ?></td>
                    <td><?= htmlspecialchars(date('H:i', strtotime($match['heure_match']))) ?></td>
                    <td><?= htmlspecialchars($match['lieu']) ?></td>
                    <td><?= htmlspecialchars($match['nb_places']) ?></td>
                    <td>
                        <?php
                        $statusClass = '';
                        switch($match['statut']){
                            case 'en_attente': $statusClass = 'pending'; $statusText = 'En attente'; break;
                            case 'valide': $statusClass = 'approved'; $statusText = 'Validé'; break;
                            case 'refuse': $statusClass = 'rejected'; $statusText = 'Refusé'; break;
                            default: $statusClass = ''; $statusText = '';
                        }
                        ?>
                        <span class="status <?= $statusClass ?>"><?= $statusText ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if(count($matchs) === 0): ?>
                <tr>
                    <td colspan="6" style="text-align:center; color:#94a3b8;">Aucun match créé pour le moment</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
