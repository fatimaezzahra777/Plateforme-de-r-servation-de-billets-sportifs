<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$pdo = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id_match'], $_POST['statut'])) {

        $idMatch = (int) $_POST['id_match'];
        $statut = $_POST['statut'];

        if (!in_array($statut, ['valide', 'refuse'])) {
            die('Statut invalide');
        }

        $stmt = $pdo->prepare(
            "UPDATE matchs SET statut = ? WHERE id_match = ?"
        );
        $stmt->execute([$statut, $idMatch]);

        header("Location: admin_dashboard.php");
        exit;
    }
}


if (isset($_GET['toggle_user'])) {
    $idUser = (int) $_GET['toggle_user'];

    $stmt = $pdo->prepare("
        UPDATE users
        SET statut = IF(statut = 'actif', 'inactif', 'actif')
        WHERE id_user = ?
    ");
    $stmt->execute([$idUser]);

    header("Location: admin_dashboard.php");
    exit;
}


$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

$Matches = $pdo->query("
    SELECT COUNT(*) FROM matchs
")->fetchColumn();

$soldTickets = $pdo->query("
    SELECT IFNULL(SUM(nb_places),0) FROM categories
")->fetchColumn();

$revenue = $pdo->query("
    SELECT IFNULL(SUM(prix * nb_places),0) FROM categories
")->fetchColumn();


$recentUsers = $pdo->query("
    SELECT id_user, nom, email, role, statut
    FROM users
    ORDER BY id_user DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);


$pendingMatches = $pdo->query("
    SELECT m.*, u.nom AS organisateur
    FROM matchs m
    JOIN users u ON m.id_organisateur = u.id_user
    ORDER BY m.date_match ASC
")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM matchs ORDER BY date_match DESC");
$stmt->execute();
$matchs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SportTicket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--dark);
            color: var(--text);
        }

        /* TOPBAR */
        .topbar {
            background: var(--dark-light);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .topbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .notification-btn {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border: none;
            color: var(--text);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
            border-radius: 10px;
            font-weight: 700;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--info) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* MAIN CONTENT */
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            color: var(--text-muted);
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--dark-light);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.primary {
            background: rgba(99, 102, 241, 0.2);
            color: var(--primary);
        }

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .stat-icon.info {
            background: rgba(6, 182, 212, 0.2);
            color: var(--info);
        }

        .stat-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-badge.up {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .stat-badge.down {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* TABLES */
        .content-section {
            background: var(--dark-light);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .section-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.65rem 1.25rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem 0.75rem 3rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--text);
            position: relative;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .filter-select {
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--text);
            cursor: pointer;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: rgba(255, 255, 255, 0.03);
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        td {
            padding: 1rem;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--info) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info h4 {
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .user-info p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .badge {
            padding: 0.4rem 0.875rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .badge-info {
            background: rgba(6, 182, 212, 0.2);
            color: var(--info);
        }

        .logout{
            background:#ef4444;
            padding:10px 18px;
            border-radius:8px;
            color:white;
            text-decoration:none;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn.approve {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .action-btn.reject {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .action-btn.view {
            background: rgba(6, 182, 212, 0.2);
            color: var(--info);
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        /* CHART CONTAINER */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: var(--dark-light);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chart-header {
            margin-bottom: 1.5rem;
        }

        .chart-header h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .chart-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .chart-placeholder {
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-bar {
                flex-direction: column;
            }

            .table-responsive {
                overflow-x: scroll;
            }
        }

        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;}
.topbar .user{display:flex;align-items:center;gap:0.5rem;}
.topbar .user i{font-size:1.5rem;color:#6366f1;}
.match{background:#1e293b;padding:1.5rem;margin-bottom:2rem;border-radius:12px;}
.match h2{margin-bottom:1rem;}
.commentaire{background:#111827;padding:1rem;margin-bottom:1rem;border-radius:8px;border:1px solid #444;}
.commentaire strong{color:#6366f1;}
    </style>
</head><body>


<div class="topbar">
    <div class="logo">🎫 SportTicket Admin</div>
    <div class="topbar-actions">
        <div class="user-menu">
            <div class="user-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <strong style="font-size:0.9rem;">Admin</strong>
        </div>
        <a href="../logout.php" class="logout">Déconnexion</a>
    </div>
</div>

<div class="container">

    <!-- ===== PAGE HEADER ===== -->
    <div class="page-header">
        <h1>Tableau de bord</h1>
        <div class="breadcrumb">
            <i class="fas fa-home"></i> / Tableau de bord
        </div>
    </div>

    <!-- ===== STATISTIQUES ===== -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon primary"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value"><?= $totalUsers ?></div>
            <div class="stat-label">Utilisateurs</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon success"><i class="fas fa-ticket-alt"></i></div>
            </div>
            <div class="stat-value"><?= $soldTickets ?></div>
            <div class="stat-label">Billets vendus</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon warning"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="stat-value"><?= $Matches ?></div>
            <div class="stat-label">Matchs</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon info"><i class="fas fa-euro-sign"></i></div>
            </div>
            <div class="stat-value"><?= number_format($revenue, 2) ?> DH</div>
            <div class="stat-label">Revenus</div>
        </div>

    </div>

    <!-- ===== MATCHS EN ATTENTE ===== -->
    <div class="content-section">

        <div class="section-header">
            <h2>Matchs en attente</h2>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Match</th>
                        <th>Organisateur</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Places</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($pendingMatches as $match): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($match['equipe1']) ?> vs <?= htmlspecialchars($match['equipe2']) ?></strong></td>

                        <td><?= htmlspecialchars($match['organisateur']) ?></td>

                        <td>
                            <?= date('d/m/Y', strtotime($match['date_match'])) ?><br>
                            <small><?= date('H:i', strtotime($match['heure_match'])) ?></small>
                        </td>

                        <td><?= htmlspecialchars($match['lieu']) ?></td>

                        <td><?= (int)$match['nb_places'] ?></td>

                        <td>
                            <?php if ($match['statut'] === 'en_attente'): ?>
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> En attente
                                </span>

                            <?php elseif ($match['statut'] === 'valide'): ?>
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Validé
                                </span>

                            <?php elseif ($match['statut'] === 'refuse'): ?>
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> Refusé
                                </span>
                            <?php endif; ?>
                        </td>


                        <td>
                            <div class="action-buttons">

                                <!-- APPROUVER -->
                                <form method="post">
                                    <input type="hidden" name="id_match" value="<?= $match['id_match'] ?>">
                                    <input type="hidden" name="statut" value="valide">
                                    <button class="action-btn approve" title="Approuver">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <!-- REFUSER -->
                                <form method="post">
                                    <input type="hidden" name="id_match" value="<?= $match['id_match'] ?>">
                                    <input type="hidden" name="statut" value="refuse">
                                    <button class="action-btn reject" title="Refuser">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="content-section">

        <div class="section-header">
            <h2>Utilisateurs récents</h2>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($recentUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>

                       <td>
                            <?php if ($user['role'] === 'acheteur'): ?>
                                <span class="badge badge-info">Acheteur</span>

                            <?php elseif ($user['role'] === 'organisateur'): ?>
                                <span class="badge badge-warning">Organisateur</span>
                            <?php endif; ?>
                        </td>


                        <td>
                            <span class="badge <?= $user['statut']=='actif' ? 'badge-success' : 'badge-danger' ?>">
                                <?= ucfirst($user['statut']) ?>
                            </span>
                        </td>

                        <td>
                            <a href="?toggle_user=<?= $user['id_user'] ?>" class="action-btn reject">
                                <i class="fas fa-ban"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>

        <div>
           <h1>Tous les commentaires</h1>

            <?php if(!$matchs): ?>
                <p>Aucun match enregistré.</p>
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

    </div>

</div>

</body>
</html>
