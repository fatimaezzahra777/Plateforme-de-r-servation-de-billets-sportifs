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
                <li><a href=""></a></li>
                <li><a href="">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <a href="#" class="btn btn-primary">Mon compte</a>
        </nav>
    </header>
    <div class="page-content" id="contact-page">
        <!-- HERO -->
        <section class="hero-section">
            <h1>Contactez-nous</h1>
            <p>
                Une question ? Un projet ? Notre équipe est à votre écoute pour vous accompagner. 
                N'hésitez pas à nous contacter, nous vous répondrons dans les plus brefs délais.
            </p>
        </section>

        <!-- CONTACT SECTION -->
        <div class="contact-container">
            <!-- CONTACT INFO -->
            <div class="contact-info">
                <div>
                    <h2>Restons en contact</h2>
                    <p>
                        Que vous soyez acheteur, organisateur ou simplement curieux, 
                        nous sommes là pour répondre à toutes vos questions.
                    </p>
                </div>

                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-details">
                            <h4>Adresse</h4>
                            <p>123 Avenue Mohammed V<br>Casablanca, Maroc 20000</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-details">
                            <h4>Téléphone</h4>
                            <p>+212 5 22 XX XX XX<br>+212 6 XX XX XX XX</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-details">
                            <h4>Email</h4>
                            <p>contact@sportticket.ma<br>support@sportticket.ma</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-details">
                            <h4>Horaires</h4>
                            <p>Lun - Ven: 9h00 - 18h00<br>Sam: 10h00 - 14h00</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 style="margin-bottom: 1rem;">Suivez-nous</h4>
                    <div class="social-links">
                        <button class="social-btn">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="social-btn">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button class="social-btn">
                            <i class="fab fa-instagram"></i>
                        </button>
                        <button class="social-btn">
                            <i class="fab fa-linkedin-in"></i>
                        </button>
                        <button class="social-btn">
                            <i class="fab fa-youtube"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- CONTACT FORM -->
            <div class="contact-form-container">
                <h3>Envoyez-nous un message</h3>
                
                <div class="success-message" id="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>Votre message a été envoyé avec succès !</span>
                </div>

                <form id="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" class="form-control" placeholder="Votre prénom" required>
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" class="form-control" placeholder="Votre nom" required>
                        </div>
                    </div>

                    <div class="form-group">
                          <label>Téléphone</label>
                          <input type="tel" class="form-control" placeholder="+212 6XX XX XX XX">
                    </div>
                     <div class="form-group">
                    <label>Sujet</label>
                    <select class="form-control" required>
                        <option value="">Choisissez un sujet</option>
                        <option value="general">Question générale</option>
                        <option value="support">Support technique</option>
                        <option value="organizer">Devenir organisateur</option>
                        <option value="partnership">Partenariat</option>
                        <option value="other">Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" placeholder="Écrivez votre message ici..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-paper-plane"></i> Envoyer le message
                </button>
            </form>
        </div>
    </div>

    <!-- MAP -->
    <div class="map-container">
        <div class="map-wrapper">
            <h3>Notre localisation</h3>
            <div class="map-placeholder">
                <div style="text-align: center;">
                    <i class="fas fa-map-marked-alt" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem;"></i>
                    <p>Carte interactive - 123 Avenue Mohammed V, Casablanca</p>
                </div>
            </div>
        </div>
    </div>
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