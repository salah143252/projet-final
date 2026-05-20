# 📘 Cahier des Charges : Application ParaCare – Parapharmacie en Ligne

---

# 🧾 Contexte du projet

Dans un contexte où le commerce en ligne connaît une croissance importante, les utilisateurs recherchent de plus en plus des solutions simples et rapides pour acheter des produits de parapharmacie (soins de la peau, beauté, hygiène, bien-être et vitamines).

Cependant, de nombreuses boutiques physiques ne disposent pas encore d’une plateforme digitale centralisée permettant de gérer efficacement leurs produits, commandes et clients.

Ce projet vise donc à développer une application web **ParaCare – Parapharmacie en Ligne** permettant de digitaliser la vente, d’améliorer l’expérience utilisateur et d’optimiser la gestion administrative et commerciale.

---

# 🎯 Objectifs du projet

L’objectif principal de ce projet est de développer une application web destinée aux utilisateurs et aux administrateurs afin de :

- Faciliter l’achat en ligne de produits de parapharmacie (skincare, hygiène, beauté, vitamines…)
- Centraliser la gestion des produits, commandes et utilisateurs
- Améliorer l’expérience utilisateur grâce à une interface simple et intuitive
- Assurer une gestion efficace des stocks et des commandes
- Fournir un tableau de bord avec statistiques et graphiques pour le suivi des performances

---

# 👥 Acteurs du système

## 👤 Client

Le client peut :

- Consulter les produits de parapharmacie
- Ajouter des produits au panier
- Passer des commandes
- Suivre ses achats et commandes
- Se connecter / s’inscrire

---

## 🛠️ Administrateur

L’administrateur peut :

- Gérer les produits (CRUD)
- Gérer les catégories
- Gérer les commandes clients
- Gérer les utilisateurs
- Consulter les statistiques et rapports

---

# ⚙️ Fonctionnalités principales

## 4.1 Gestion des utilisateurs

- Création de comptes clients
- Authentification sécurisée (Login / Register)
- Gestion des rôles (Client / Admin)
- Gestion des sessions utilisateurs

---

## 4.2 Gestion des produits

- Ajout, modification et suppression des produits
- Organisation par catégories :
  - Skincare
  - Haircare
  - Body Care
  - Vitamins
- Affichage des détails produits
- Recherche et filtrage des produits

---

## 4.3 Gestion du panier et des commandes

- Ajout au panier
- Modification des quantités
- Suppression de produits
- Calcul automatique du total
- Validation des commandes
- Suivi du statut :
  - En attente
  - Confirmée
  - Livrée

---

## 4.4 Gestion administrative

- Gestion complète des produits (CRUD)
- Gestion des commandes
- Gestion des utilisateurs
- Suivi des stocks

---

## 4.5 Tableau de bord et statistiques

- Ventes mensuelles
- Produits les plus vendus
- Nombre de commandes
- Nombre d’utilisateurs
- Répartition des commandes par statut
- Graphiques interactifs avec Chart.js

---

# 💻 Technologies utilisées

## Backend

- PHP (Architecture MVC)

## Base de données

- MySQL

## Frontend

- HTML
- CSS
- JavaScript

## Bibliothèques

- Chart.js (statistiques et graphiques)

## Outils

- VS Code
- Figma (maquettes UI/UX)
- Git / GitHub (gestion de version)

---

# 📊 Charte graphique

## 6.1 Logo

Le logo représente l’univers de la parapharmacie et du bien-être.

Il symbolise :

- La santé et la beauté
- La confiance et la sécurité
- L’accompagnement vers le bien-être

---

## 6.2 Typographie

- Police principale : **Poppins**
- Styles :
  - Regular
  - Medium
  - Bold

---

## 6.3 Palette de couleurs

| Élément | Couleur |
|---|---|
| 🎨 Primaire | `#2D9CDB` |
| 🎨 Secondaire | `#27AE60` |
| 🎨 Background | `#F2F5F9` |
| 🎨 Texte | `#333333` |

---

# 🖥️ Interfaces utilisateur

- Page d’accueil (Home)
- Catalogue des produits
- Page détail produit
- Panier (Cart)
- Page de commande (Checkout)
- Authentification (Login / Register)
- Dashboard administrateur
- Page statistiques (Charts)

---

# 🔒 Contraintes techniques

- Application responsive (Mobile / Desktop)
- Sécurisation des mots de passe (Hash)
- Protection contre les injections SQL (PDO)
- Validation des formulaires côté client et serveur
- Utilisation d’une architecture MVC
- Gestion sécurisée des sessions
- Optimisation des performances

---

# 📌 Conclusion

Le projet **ParaCare – Parapharmacie en Ligne** vise à développer une plateforme moderne permettant la vente de produits de soins et de bien-être en ligne.

L’application offrira une gestion complète des produits, des commandes et des utilisateurs tout en garantissant une expérience utilisateur simple, rapide et sécurisée grâce à un système centralisé et des outils de visualisation avancés.
