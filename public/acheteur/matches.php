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
</div>
</body>
</html>
