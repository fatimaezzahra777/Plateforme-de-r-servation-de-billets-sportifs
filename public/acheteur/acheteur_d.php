<?php
session_start();
require_once '../../config/Database.php';



$sql = "
SELECT 
    m.id_match,
    m.equipe1,
    m.equipe2,
    m.date_match,
    m.lieu,
    SUM(c.nb_places) AS places_dispo
FROM matchs m
JOIN categories c ON m.id_match = c.id_match
WHERE m.statut = 'valide'
GROUP BY m.id_match
";

$matchs = $pdo->query($sql)->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acheteur - SportTicket</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    .topbar {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:30px;
    }
    .topbar .user { display:flex; align-items:center; gap:0.5rem; }
    .topbar .user i { font-size:1.5rem; color:#6366f1; }

    .stats-grid { 
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:40px; 
    }

    .stat-card { 
        background:#1e293b;
        padding:25px;
        border-radius:15px;
    }
    .stat-card i { font-size:2rem; margin-bottom:0.5rem; color:#6366f1; }
    .stat-card h3 { font-size:1.25rem; margin-bottom:0.25rem; }
    .stat-card p { color:#666; font-size:0.9rem; }
 
    table { width:100%; border-collapse:collapse; background:#1e293b;  border-radius:12px; overflow:hidden; margin-top:2%; margin-bottom:2%; box-shadow: #1e293b; }
    th, td { padding:1rem; text-align:left; border-bottom:1px solid #eee; }
    th { background:#1e293b; color:white; }
    tr:hover { background:#1e298b; }
    .btn { padding:0.5rem 1rem; border:none; border-radius:8px; cursor:pointer; }
    .btn-primary { background:#6366f1; color:#fff; }
    .btn-outline { background:#6366f1; color:#fff; border:1px solid #6366f1; }
    .btn-primary:hover { opacity:0.9; }
    .btn-outline:hover { background:#6366f1; color:#fff; }

    form { background:#1e293b; margin-top:4px; padding:2rem; border-radius:12px; box-shadow:0 4px 6px rgba(0,0,0,0.1); max-width:600px; }
    form label { display:block; margin:0.75rem 0 0.25rem; font-weight:600; }
    form input, form select, form textarea { width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:8px; }
    form button { margin-top:1rem;}

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

    <h1>Tableau de bord</h1>
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-ticket-alt"></i>
            <h3>0</h3>
            <p>Billets achetés</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar-check"></i>
            <h3>0</h3>
            <p>Matchs à venir</p>
        </div>
    </div>

    <h2>Matchs disponibles</h2>
    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Places dispo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>FC Barca vs RM Madrid</td>
                <td>12 Jan 2026</td>
                <td>Stade Santiago</td>
                <td>50</td>
                <td><button class="btn btn-primary">Acheter</button></td>
            </tr>
            <tr>
                <td>PSG vs OM</td>
                <td>15 Jan 2026</td>
                <td>Parc des Princes</td>
                <td>30</td>
                <td><button class="btn btn-primary">Acheter</button></td>
            </tr>
        </tbody>
    </table>

    <h2>Mes billets</h2>
    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>Catégorie</th>
                <th>Place</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>FC Barca vs RM Madrid</td>
                <td>12 Jan 2026</td>
                <td>VIP</td>
                <td>A12</td>
                <td><button class="btn btn-outline">Télécharger</button></td>
            </tr>
        </tbody>
    </table>

    <h2>Laisser un avis</h2>
    <form>
        <label>Match :</label>
        <select>
            <option>FC Barca vs RM Madrid</option>
        </select>
        <label>Note :</label>
        <select>
            <option>5 étoiles</option>
            <option>4 étoiles</option>
        </select>
        <label>Commentaire :</label>
        <textarea rows="4"></textarea>
        <button type="submit" class="btn btn-primary">Envoyer l'avis</button>
    </form>
</div>

</body>
</html>
