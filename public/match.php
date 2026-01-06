<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Acheteur</title>
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
            --dark: #0f172a;
            --dark-light: #1e293b;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--dark);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            background: var(--dark-light);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            margin-bottom: 3rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .user-details h4 {
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .user-details p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(99, 102, 241, 0.2);
            color: var(--primary);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
        }

        /* SEAT SELECTION */
        .seat-selection-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .stadium-container {
            background: var(--dark-light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stadium-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .stadium-header h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .stadium-info {
            color: var(--text-muted);
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .field {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
            border: 2px solid rgba(16, 185, 129, 0.4);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            margin: 2rem 0;
            font-weight: 600;
            color: var(--success);
        }

        .category-sections {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .category-section {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .category-name {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .category-price {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
        }

        .seats-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 0.5rem;
        }

        .seat {
            aspect-ratio: 1;
            background: rgba(148, 163, 184, 0.2);
            border: 2px solid rgba(148, 163, 184, 0.4);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .seat:hover:not(.occupied):not(.selected) {
            background: rgba(99, 102, 241, 0.2);
            border-color: var(--primary);
            transform: scale(1.1);
        }

        .seat.selected {
            background: linear-gradient(135deg, var(--primary) 0%, #4f46e5 100%);
            border-color: var(--primary);
            color: white;
            transform: scale(1.05);
        }

        .seat.occupied {
            background: rgba(239, 68, 68, 0.2);
            border-color: var(--danger);
            cursor: not-allowed;
            opacity: 0.5;
        }

        /* LEGEND */
        .legend {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-box {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 2px solid;
        }

        .legend-box.available {
            background: rgba(148, 163, 184, 0.2);
            border-color: rgba(148, 163, 184, 0.4);
        }

        .legend-box.selected {
            background: var(--primary);
            border-color: var(--primary);
        }

        .legend-box.occupied {
            background: rgba(239, 68, 68, 0.2);
            border-color: var(--danger);
        }

        /* ORDER SUMMARY */
        .order-summary {
            background: var(--dark-light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 2rem;
            height: fit-content;
        }

        .order-summary h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .match-details {
            margin-bottom: 2rem;
        }

        .match-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .team {
            text-align: center;
        }

        .team-logo {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 1.5rem;
        }

        .vs {
            font-weight: 800;
            color: var(--text-muted);
        }

        .match-info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .match-info-item i {
            color: var(--primary);
            width: 20px;
        }

        .selected-seats {
            margin-bottom: 2rem;
        }

        .selected-seats h4 {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .seat-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .seat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .seat-item-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .seat-number {
            font-weight: 600;
        }

        .seat-category {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .remove-seat {
            background: transparent;
            border: none;
            color: var(--danger);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .remove-seat:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .empty-seats {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--text-muted);
        }

        .price-breakdown {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            color: var(--text-muted);
        }

        .price-row.total {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text);
        }

        .btn-checkout {
            width: 100%;
            padding: 1.1rem;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .max-tickets-warning {
            text-align: center;
            padding: 0.75rem;
            background: rgba(245, 158, 11, 0.2);
            border: 1px solid rgba(245, 158, 11, 0.4);
            border-radius: 10px;
            color: var(--warning);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        @media (max-width: 1200px) {
            .seat-selection-container {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .seats-grid {
                grid-template-columns: repeat(8, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">🎫 SportTicket</div>
        </div>

        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <h4>Ahmed Benali</h4>
                <p>Acheteur</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-th-large"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>Mes billets</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-circle"></i>
                    <span>Mon profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="header">
            <div>
                <h1>Sélection des places</h1>
                <p style="color: var(--text-muted); margin-top: 0.5rem;">
                    Choisissez jusqu'à 4 places pour ce match
                </p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Retour aux matchs
                </button>
            </div>
        </div>

        <div class="seat-selection-container">
            <!-- STADIUM -->
            <div class="stadium-container">
                <div class="stadium-header">
                    <h3>Plan du Stade</h3>
                    <div class="stadium-info">
                        <span><i class="fas fa-map-marker-alt"></i> Parc des Princes</span>
                        <span><i class="fas fa-users"></i> Capacité: 2000 places</span>
                    </div>
                </div>

                <div class="field">
                    <i class="fas fa-futbol"></i> TERRAIN
                </div>

                <div class="category-sections">
                    <!-- VIP Category -->
                    <div class="category-section">
                        <div class="category-header">
                            <span class="category-name">
                                <i class="fas fa-crown" style="color: #f59e0b;"></i> VIP
                            </span>
                            <span class="category-price">120€</span>
                        </div>
                        <div class="seats-grid" id="vip-seats"></div>
                    </div>

                    <!-- Platinum Category -->
                    <div class="category-section">
                        <div class="category-header">
                            <span class="category-name">
                                <i class="fas fa-star" style="color: #6366f1;"></i> Platinum
                            </span>
                            <span class="category-price">75€</span>
                        </div>
                        <div class="seats-grid" id="platinum-seats"></div>
                    </div>

                    <!-- Standard Category -->
                    <div class="category-section">
                        <div class="category-header">
                            <span class="category-name">
                                <i class="fas fa-ticket-alt" style="color: #10b981;"></i> Standard
                            </span>
                            <span class="category-price">45€</span>
                        </div>
                        <div class="seats-grid" id="standard-seats"></div>
                    </div>
                </div>

                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-box available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box selected"></div>
                        <span>Sélectionnée</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box occupied"></div>
                        <span>Occupée</span>
                    </div>
                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="order-summary">
                <h3>Récapitulatif</h3>

                <div class="match-details">
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">⚽</div>
                            <strong>PSG</strong>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">⚽</div>
                            <strong>OM</strong>
                        </div>
                    </div>

                    <div class="match-info-item">
                        <i class="fas fa-calendar"></i>
                        <span>15 Janvier 2026 - 20:45</span>
                    </div>
                    <div class="match-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Parc des Princes, Paris</span>
                    </div>
                    <div class="match-info-item">
                        <i class="fas fa-clock"></i>
                        <span>Durée: 90 minutes</span>
                    </div>
                </div>

                <div class="selected-seats">
                    <h4>Places sélectionnées (<span id="seat-count">0</span>/4)</h4>
                    <div class="seat-list" id="seat-list">
                        <div class="empty-seats">
                            <i class="fas fa-chair" style="font-size: 2rem; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                            <p>Aucune place sélectionnée</p>
                        </div>
                    </div>
                </div>

                <div class="price-breakdown">
                    <div class="price-row">
                        <span>Sous-total</span>
                        <span id="subtotal">0€</span>
                    </div>
                    <div class="price-row">
                        <span>Frais de service</span>
                        <span id="fees">0€</span>
                    </div>
                    <div class="price-row total">
                        <span>Total</span>
                        <span id="total">0€</span>
                    </div>
                </div>

                <button class="btn btn-primary btn-checkout btn-disabled" id="checkout-btn" disabled>
                    <i class="fas fa-shopping-cart"></i> Procéder au paiement
                </button>

                <div class="max-tickets-warning" id="max-warning" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Vous avez atteint le maximum de 4 billets
                </div>
            </div>
        </div>
    </main>

    <script>
        // Configuration
        const categories = {
            vip: { name: 'VIP', price: 120, seats: 30, occupied: [3, 7, 12, 18] },
            platinum: { name: 'Platinum', price: 75, seats: 50, occupied: [5, 15, 25, 35, 40] },
            standard: { name: 'Standard', price: 45, seats: 70, occupied: [10, 20, 30, 40, 50, 60] }
        };

        const selectedSeats = new Map();
        const MAX_TICKETS = 4;

        // Generate seats
        function generateSeats() {
            Object.keys(categories).forEach(categoryId => {
                const container = document.getElementById(`${categoryId}-seats`);
                const category = categories[categoryId];

                for (let i = 1; i <= category.seats; i++) {
                    const seat = document.createElement('div');
                    seat.className = 'seat';
                    seat.dataset.category = categoryId;
                    seat.dataset.number = i;
                    seat.textContent = i;

                    if (category.occupied.includes(i)) {
                        seat.classList.add('occupied');
                    } else {
                        seat.addEventListener('click', () => toggleSeat(seat, categoryId, i, category.price));
                    }

                    container.appendChild(seat);
                }
            });
        }

        // Toggle seat selection
        function toggleSeat(seatElement, category, number, price) {
            const seatKey = `${category}-${number}`;

            if (selectedSeats.has(seatKey)) {
                selectedSeats.delete(seatKey);
                seatElement.classList.remove('selected');
            } else {
                if (selectedSeats.size >= MAX_TICKETS) {
                    showMaxWarning();
                    return;
                }
                selectedSeats.set(seatKey, { category, number, price });
                seatElement.classList.add('selected');
            }

            updateSummary();
        }

        // Update order summary
        function updateSummary() {
            const seatCount = selectedSeats.size;
            document.getElementById('seat-count').textContent = seatCount;

            // Update seat list
            const seatList = document.getElementById('seat-list');
            if (seatCount === 0) {
                seatList.innerHTML = `
                    <div class="empty-seats">
                        <i class="fas fa-chair" style="font-size: 2rem; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                        <p>Aucune place sélectionnée</p>
                    </div>
                `;
            } else {
                seatList.innerHTML = '';
                selectedSeats.forEach((seat, key) => {
                    const seatItem = document.createElement('div');
                    seatItem.className = 'seat-item';
                    seatItem.innerHTML = `
                        <div class="seat-item-info">
                            <div class="seat-number">Place ${seat.number}</div>
                            <div class="seat-category">${categories[seat.category].name}</div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <strong>${seat.price}€</strong>
                            <button class="remove-seat" onclick="removeSeat('${key}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    seatList.appendChild(seatItem);
                });
            }

            // Calculate prices
            let subtotal = 0;
            selectedSeats.forEach(seat => subtotal += seat.price);
            const fees = Math.round(subtotal * 0.05); // 5% service fee
            const total = subtotal + fees;

            document.getElementById('subtotal').textContent = `${subtotal}€`;
            document.getElementById('fees').textContent = `${fees}€`;
            document.getElementById('total').textContent = `${total}€`;

            // Enable/disable checkout button
            const checkoutBtn = document.getElementById('checkout-btn');
            if (seatCount > 0) {
                checkoutBtn.disabled = false;
                checkoutBtn.classList.remove('btn-disabled');
            } else {
                checkoutBtn.disabled = true;
                checkoutBtn.classList.add('btn-disabled');
            }

            // Show/hide max warning
            document.getElementById('max-warning').style.display = 
                seatCount >= MAX_TICKETS ? 'block' : 'none';
        }

        // Remove seat
        function removeSeat(seatKey) {
            const [category, number] = seatKey.split('-');
            const seatElement = document.querySelector(
                `.seat[data-category="${category}"][data-number="${number}"]`
            );
            if (seatElement) {
                seatElement.classList.remove('selected');
            }
            selectedSeats.delete(seatKey);
            updateSummary();
        }

        // Show max tickets warning
        function showMaxWarning() {
            const warning = document.getElementById('max-warning');
            warning.style.display = 'block';
            setTimeout(() => {
                warning.style.animation = 'none';
                setTimeout(() => {
                    warning.style.animation = '';
                }, 10);
            }, 0);
        }

        // Checkout
        document.getElementById('checkout-btn').addEventListener('click', () => {
            if (selectedSeats.size > 0) {
                alert('Redirection vers la page de paiement...\n\nPlaces sélectionnées: ' + 
                      selectedSeats.size + '\nTotal: ' + 
                      document.getElementById('total').textContent);
            }
        });

        // Initialize
        generateSeats();
    </script>
</body>
</html>