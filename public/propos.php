<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos & Contact - SportTicket</title>
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
            --dark-light: #1e293b;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
            --success: #10b981;
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--dark);
            color: var(--text);
            line-height: 1.6;
        }

        /* HEADER */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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

        /* PAGE NAVIGATION */
        .page-nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 100px auto 3rem;
            max-width: 600px;
            padding: 0 2rem;
        }

        .page-nav-btn {
            flex: 1;
            padding: 1rem;
            background: var(--dark-light);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            font-weight: 600;
        }

        .page-nav-btn:hover, .page-nav-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* PAGE CONTENT */
        .page-content {
            display: none;
        }

        .page-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ABOUT PAGE */
        .hero-section {
            max-width: 1400px;
            margin: 0 auto 4rem;
            padding: 0 2rem;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-section p {
            font-size: 1.3rem;
            color: var(--text-muted);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .section {
            max-width: 1400px;
            margin: 0 auto 4rem;
            padding: 0 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: var(--dark-light);
            padding: 2.5rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.8;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .team-member {
            background: var(--dark-light);
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }

        .member-avatar {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .member-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .member-role {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .member-bio {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .stats-section {
            background: var(--dark-light);
            border-radius: 30px;
            padding: 4rem 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin: 4rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            text-align: center;
        }

        .stat-item {
            padding: 1.5rem;
        }

        .stat-value {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* CONTACT PAGE */
        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .contact-info h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .contact-info p {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .info-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: var(--dark-light);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateX(5px);
            border-color: var(--primary);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .info-details h4 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .info-details p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .contact-form-container {
            background: var(--dark-light);
            padding: 3rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-form-container h3 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: var(--text);
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-submit {
            width: 100%;
            padding: 1.1rem;
            font-size: 1.1rem;
            margin-top: 1rem;
        }

        .success-message {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid var(--success);
            padding: 1rem;
            border-radius: 12px;
            color: var(--success);
            margin-bottom: 1.5rem;
            display: none;
        }

        .success-message.show {
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        .map-container {
            max-width: 1400px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .map-wrapper {
            background: var(--dark-light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .map-wrapper h3 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .map-placeholder {
            width: 100%;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1.2rem;
        }

        /* FOOTER */
        .footer {
            background: var(--dark-light);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 4rem 2rem 2rem;
            margin-top: 6rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .footer-brand p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .footer-links h4 {
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 0.75rem;
        }

        .footer-links ul li a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links ul li a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: var(--text-muted);
        }

        /* RESPONSIVE */
        @media (max-width: 968px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .contact-container {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .nav-links {
                display: none;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page-nav {
                flex-direction: column;
            }

            .features-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }

            .contact-form-container {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <nav class="navbar">
            <div class="logo">🎫 SportTicket</div>
            <ul class="nav-links">
                <li><a href="#home">Accueil</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <a href="#" class="btn btn-primary">Mon compte</a>
        </nav>
    </header>

    <!-- ABOUT PAGE -->
    <div class="page-content active" id="about-page">
        <!-- HERO -->
        <section class="hero-section">
            <h1>À propos de SportTicket</h1>
            <p>
                Nous sommes la plateforme de billetterie sportive la plus innovante au Maroc. 
                Notre mission est de rendre l'accès aux événements sportifs simple, rapide et sécurisé pour tous.
            </p>
        </section>

        <!-- FEATURES -->
        <section class="section">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Réservation Instantanée</h3>
                    <p>Réservez vos billets en quelques clics. Recevez votre billet par email immédiatement après le paiement.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Sécurisé & Fiable</h3>
                    <p>Paiements 100% sécurisés. Vos données sont protégées avec les meilleurs standards de sécurité.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Communauté Active</h3>
                    <p>Rejoignez une communauté de passionnés de sport. Partagez vos avis et découvrez de nouveaux événements.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile First</h3>
                    <p>Accédez à vos billets depuis n'importe quel appareil. Interface optimisée pour mobile et desktop.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Support 24/7</h3>
                    <p>Notre équipe est disponible à tout moment pour vous aider. Service client réactif et professionnel.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Pour Organisateurs</h3>
                    <p>Outils puissants pour gérer vos événements, suivre les ventes et analyser vos statistiques en temps réel.</p>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="section">
            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">150K+</div>
                        <div class="stat-label">Utilisateurs actifs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">2,500+</div>
                        <div class="stat-label">Événements organisés</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">1M+</div>
                        <div class="stat-label">Billets vendus</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">4.9/5</div>
                        <div class="stat-label">Note moyenne</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TEAM -->
        <section class="section">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">Notre Équipe</h2>
                <p style="color: var(--text-muted); font-size: 1.2rem;">
                    Des passionnés de sport et de technologie au service de votre expérience
                </p>
            </div>

            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="member-name">Youssef Alami</div>
                    <div class="member-role">CEO & Fondateur</div>
                    <p class="member-bio">
                        Expert en technologie avec 10+ ans d'expérience dans le développement de plateformes digitales.
                    </p>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="member-name">Samira Benkirane</div>
                    <div class="member-role">CTO</div>
                    <p class="member-bio">
                        Passionnée d'innovation, elle dirige l'équipe technique pour créer la meilleure expérience utilisateur.
                    </p>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="member-name">Karim Tazi</div>
                    <div class="member-role">Responsable Partenariats</div>
                    <p class="member-bio">
                        Spécialiste des relations avec les organisateurs et les clubs sportifs à travers tout le Maroc.
                    </p>
                </div>

                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="member-name">Leila Mansouri</div>
                    <div class="member-role">Chef de Projet</div>
                    <p class="member-bio">
                        Coordonne les projets et assure la qualité de chaque événement publié sur la plateforme.
                    </p>
                </div>
            </div>
        </section>
    </div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-brand">
            <h3>🎫 SportTicket</h3>
            <p>La plateforme n°1 pour réserver vos billets d'événements sportifs en ligne. Simple, rapide, sécurisé.</p>
        </div>
        <div class="footer-links">
            <h4>Liens rapides</h4>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Matchs</a></li>
                <li><a href="#">Organisateurs</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Légal</h4>
            <ul>
                <li><a href="#">CGU</a></li>
                <li><a href="#">Confidentialité</a></li>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Cookies</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Support</h4>
            <ul>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Aide</a></li>
                <li><a href="#">Remboursement</a></li>
                <li><a href="#">Nous contacter</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 SportTicket. Tous droits réservés. Réalisé avec ❤️ au Maroc</p>
    </div>
</footer>

<script>
    // Page Navigation
    const pageButtons = document.querySelectorAll('.page-nav-btn');
    const pages = document.querySelectorAll('.page-content');

    pageButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetPage = btn.dataset.page;

            // Update buttons
            pageButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Update pages
            pages.forEach(page => page.classList.remove('active'));
            document.getElementById(`${targetPage}-page`).classList.add('active');

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Contact Form Submission
    document.getElementById('contact-form').addEventListener('submit', (e) => {
        e.preventDefault();

        // Show success message
        const successMessage = document.getElementById('success-message');
        successMessage.classList.add('show');

        // Reset form
        e.target.reset();

        // Hide success message after 5 seconds
        setTimeout(() => {
            successMessage.classList.remove('show');
        }, 5000);

        console.log('Formulaire envoyé avec succès!');
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe feature cards and team members
    document.querySelectorAll('.feature-card, .team-member, .info-card').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.6s ease';
        observer.observe(element);
    });
</script>
</body>
</html>