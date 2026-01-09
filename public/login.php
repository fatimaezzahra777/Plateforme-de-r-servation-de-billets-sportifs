<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires";
    } else {

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $error = "Email ou mot de passe incorrect";
        } else {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nom']     = $user['nom'];
            $_SESSION['role']    = $user['role'];

            
            if ($user['role'] === 'admin') {
                header('Location: ../admin/admin_dashboard.php');
            } elseif ($user['role'] === 'organisateur') {
                header('Location: ../organisateur/organisateur.php');
            } elseif ($user['role'] === 'acheteur') {
                header('Location: ../acheteur/acheteur_d.php');
            }else {
                header('Location: login.php');
            }
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription - SportTicket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --dark: #0f172a;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            animation: float 15s ease-in-out infinite reverse;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(15, 23, 42, 0.95);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(90deg); }
            50% { transform: translate(0, 100px) rotate(180deg); }
            75% { transform: translate(-50px, 50px) rotate(270deg); }
        }

        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .logo p {
            color: rgba(255,255,255,0.9);
            margin-top: 0.5rem;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .tab-buttons {
            display: flex;
            background: rgba(255, 255, 255, 0.05);
        }

        .tab-btn {
            flex: 1;
            padding: 1.25rem;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.6);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab-btn.active {
            color: white;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: white;
            box-shadow: 0 0 20px rgba(255,255,255,0.5);
        }

        .form-content {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: white;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.5);
        }

        .form-control {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.4);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: white;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255,255,255,0.8);
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .forgot-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: white;
        }

        .btn-submit {
            width: 100%;
            padding: 1.1rem;
            background: white;
            color: var(--primary);
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0;
            color: rgba(255,255,255,0.6);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.2);
        }

        .social-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .social-btn {
            padding: 0.9rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .role-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .role-card {
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .role-card:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .role-card.selected {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
        }

        .role-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .role-card span {
            color: white;
            font-weight: 600;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            padding: 1rem;
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 12px;
            color: white;
            margin-bottom: 1.5rem;
            display: none;
        }

        .alert.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .auth-container {
                max-width: 100%;
            }

            .form-content {
                padding: 1.5rem;
            }

            .social-login {
                grid-template-columns: 1fr;
            }

            .role-selection {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <nav class="navbar">
            <div class="logo">🎫 SportTicket</div>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="propos.php">À propos</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-outline">Connexion</a>
                <a href="login.php" class="btn btn-primary">Inscription</a>
            </div>
        </nav>
    </header>
    <div class="auth-container">
        <div class="logo">
            <h1>🎫 SportTicket</h1>
            <p>Votre plateforme de billetterie sportive</p>
        </div>

        <div class="auth-card">
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="login">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </button>
                <button class="tab-btn" data-tab="register">
                    <i class="fas fa-user-plus"></i> Inscription
                </button>
            </div>

            <!-- LOGIN FORM -->
            <div class="tab-content active" id="login">
                <form class="form-content" method="POST" action="login.php">
                    <div class="alert" id="login-alert">
                        <i class="fas fa-exclamation-circle"></i> Identifiants incorrects
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mot de passe</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" class="form-control" id="login-password" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="remember">
                            <label for="remember">Se souvenir de moi</label>
                        </div>
                        <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </button>

                    <div class="divider">ou continuer avec</div>

                    <div class="social-login">
                        <button type="button" class="social-btn">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button type="button" class="social-btn">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>
                </form>
            </div>

            <!-- REGISTER FORM -->
            <div class="tab-content" id="register">
                <form class="form-content" id="register-form" action="register.php" method="POST">
                    <div class="alert" id="register-alert">
                        <i class="fas fa-exclamation-circle"></i> Veuillez remplir tous les champs
                    </div>
                    <input type="hidden" id="role" name="role" value="acheteur">

                    <div class="form-group">
                        <label>Type de compte</label>
                        <div class="role-selection">
                            <div class="role-card selected" data-role="acheteur">
                                <i class="fas fa-user"></i>
                                <span>Acheteur</span>
                            </div>
                            <div class="role-card" data-role="organisateur">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Organisateur</span>
                            </div>
                            <div class="role-card" data-role="admin">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Admin</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nom complet</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-control" name="nom" placeholder="Jean Dupont" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Adresse</label>
                        <div class="input-wrapper">
                            <i class="fas fa-home"></i>
                            <input type="text" class="form-control" name="adresse" placeholder="Votre adresse" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Telephone</label>
                        <div class="input-wrapper">
                            <i class="fas fa-home"></i>
                            <input type="text" class="form-control" name="telephone" placeholder="Votre adresse" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control" name="email" placeholder="votre@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mot de passe</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" class="form-control" id="register-password" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('register-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Confirmer le mot de passe</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-control" id="confirm-password" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">J'accepte les CGU</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i> Créer mon compte
                    </button>

                    <div class="divider">ou s'inscrire avec</div>

                    <div class="social-login">
                        <button type="button" class="social-btn">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button type="button" class="social-btn">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <script>
    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById(tab).classList.add('active');
        });
    });

    // Password toggle
    function togglePassword(id){
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Role selection
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            document.getElementById('role').value = card.dataset.role;
        });
    });

    // Confirm password (client side)
    document.getElementById('register-form').addEventListener('submit', function(e){
        const p1 = document.getElementById('register-password').value;
        const p2 = document.getElementById('confirm-password').value;
        if(p1 !== p2){
            alert("Les mots de passe ne correspondent pas");
            e.preventDefault();
        }
    });
</script>

</body>
</html>