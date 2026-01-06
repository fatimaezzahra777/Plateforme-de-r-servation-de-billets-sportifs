<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil - Acheteur</title>
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
    form input, form select{width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:8px;}
    form button{margin-top:1rem;padding:0.5rem 1rem;border:none;border-radius:8px;cursor:pointer;background:#6366f1;color:#fff;}
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

    <h1>Mon Profil</h1>
    <form method="POST">
        <label>Nom</label>
        <input type="text" name="nom" value="<?= $user['nom'] ?>" placeholder="Nom complet">
        <label>Email</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" placeholder="Email">
        <label>Address</label>
        <input type="adresse" name="adresse" value="<?= $user['adresse'] ?>" placeholder="Adresse">
        <label>Telephone</label>
        <input type="telephone" name="telephone" value="<?= $user['telephone'] ?>" placeholder="Telephone">
        <label>Password</label>
        <input type="password" name="password" placeholder="Nouveau mot de passe">
        <button type="submit">Enregistrer</button>
    </form>
</div>
</body>
</html>
