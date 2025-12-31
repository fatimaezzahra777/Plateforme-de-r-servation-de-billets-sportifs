# 🎟️ Plateforme de Gestion et Vente de Billets de Matchs Sportifs

## 📌 Description du projet
Cette plateforme web permet la **gestion et la vente de billets pour des événements sportifs**.  
Elle offre une interface adaptée à chaque type d’utilisateur : visiteurs, acheteurs de billets, organisateurs d’événements et administrateurs.

Le projet est développé en **PHP orienté objet**, avec une **base de données MySQL**, en respectant les principes fondamentaux et avancés de la **programmation orientée objet (POO)** ainsi que la **modélisation UML**.

---

## 🎯 Objectifs du projet
- Centraliser la gestion des matchs sportifs
- Faciliter l’achat de billets en ligne
- Offrir un système sécurisé et structuré
- Mettre en pratique la POO en PHP
- Utiliser les bonnes pratiques de conception logicielle

---

## 👥 Acteurs du système

### 👁️ Visiteur
- Consulter la liste des matchs publiés
- Filtrer les matchs (lieu, date, catégorie, etc.)
- Voir les détails d’un match :
  - Équipes
  - Date et heure
  - Catégories
  - Prix
- S’inscrire sur la plateforme
- Se connecter

⚠️ *Aucune réservation n’est possible sans inscription.*

---

### 🎫 Utilisateur (Acheteur de billets)
Après authentification, l’utilisateur peut :
- Gérer son profil
- Consulter les matchs disponibles
- Acheter jusqu’à **4 billets maximum par match**
- Choisir :
  - Catégorie
  - Place numérotée dans le stade
- Générer un **billet PDF** contenant :
  - Informations du match
  - Numéro de place
  - Catégorie
  - QR Code ou identifiant unique
- Recevoir le billet par **email**
- Consulter l’historique de ses billets
- Laisser un commentaire et un avis après la fin du match

---

### 🏟️ Organisateur
Après authentification, l’organisateur peut :
- Gérer son profil
- Créer une demande d’événement sportif
- Définir :
  - Deux équipes (nom et logo)
  - Date et heure
  - Lieu
  - Durée (90 minutes)
  - Nombre de places (maximum 2000)
  - Jusqu’à 3 catégories
  - Prix par catégorie
- Consulter les statistiques :
  - Billets vendus
  - Chiffre d’affaires
- Consulter les commentaires et avis

⚠️ *Les matchs doivent être validés par l’administrateur avant publication.*

---

### 🛠️ Administrateur
Après authentification, l’administrateur peut :
- Gérer les utilisateurs (activation / désactivation)
- Accepter ou refuser les demandes de matchs
- Consulter les statistiques globales
- Accéder aux commentaires et avis

---

## ⚙️ Contraintes techniques

### 🧩 PHP & Programmation Orientée Objet
- Encapsulation (`private`, `protected`)
- Héritage
- Polymorphisme
- Abstraction (classes abstraites)
- Composition et agrégation
- Constructeurs
- Getters / Setters

---

### 🗄️ Base de données
- MySQL
- PDO
- Relations cohérentes
- Vue SQL (1 exemple)
- Procédure stockée (1 exemple)

---

### 🧰 Autres fonctionnalités techniques
- Page 404 personnalisée via `.htaccess`
- Envoi d’emails avec **PHPMailer**
- Génération de **PDF**
- Code commenté, structuré et organisé

---

## ⭐ Bonus
- Système de notation (1 à 5 étoiles)
- Calcul automatique de la note moyenne d’un match
- Téléchargement d’un **PDF récapitulatif** des billets achetés depuis l’espace utilisateur

---

## 🧪 Outils et technologies
- PHP 8+
- MySQL
- HTML / CSS / JavaScript
- UML (diagrammes de classes, cas d’utilisation)
- PHPMailer
- Librairie PDF

---

## 📁 Structure du projet
```txt
/config          → Configuration (connexion BD, constantes)
/classes         → Classes PHP (POO)
/controllers     → Logique métier
/views           → Interfaces utilisateur
/assets          → CSS, JS, images
/database        → Script SQL (database.sql)
/public          → Point d’entrée (index.php)
