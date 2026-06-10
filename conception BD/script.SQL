-- =====================================================
-- CREATION DE LA BASE DE DONNEES
-- =====================================================

CREATE DATABASE paracare
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE paracare;

-- =====================================================
-- TABLE : USERS
-- Gestion des utilisateurs et administrateurs
-- =====================================================

CREATE TABLE users (

    id_user INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    prenom VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    telephone VARCHAR(20),

    adresse TEXT,

    email_verified BOOLEAN DEFAULT FALSE,

    role ENUM('client', 'admin') DEFAULT 'client',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

-- =====================================================
-- TABLE : CATEGORIES
-- Gestion des catégories produits
-- =====================================================

CREATE TABLE categories (

    id_categorie INT AUTO_INCREMENT PRIMARY KEY,

    nom_categorie VARCHAR(100) NOT NULL UNIQUE,

    slug VARCHAR(100) NOT NULL UNIQUE,

    description TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;

-- =====================================================
-- TABLE : PRODUITS
-- Gestion des produits parapharmacie
-- =====================================================

CREATE TABLE produits (

    id_produit INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(150) NOT NULL,

    description TEXT NOT NULL,

    prix DECIMAL(10,2) NOT NULL,

    stock INT NOT NULL DEFAULT 0,

    image VARCHAR(255) NOT NULL,

    id_categorie INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_produit_categorie
    FOREIGN KEY (id_categorie)
    REFERENCES categories(id_categorie)
    ON DELETE SET NULL
    ON UPDATE CASCADE

) ENGINE=InnoDB;

-- =====================================================
-- TABLE : PANIER
-- Chaque utilisateur possède un panier
-- =====================================================

CREATE TABLE panier (

    id_panier INT AUTO_INCREMENT PRIMARY KEY,

    id_user INT UNIQUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_panier_user
    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB;

-- =====================================================
-- TABLE : PANIER_ITEMS
-- Produits ajoutés au panier
-- =====================================================

CREATE TABLE panier_items (

    id_item INT AUTO_INCREMENT PRIMARY KEY,

    id_panier INT NOT NULL,

    id_produit INT NOT NULL,

    quantite INT NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_panieritems_panier
    FOREIGN KEY (id_panier)
    REFERENCES panier(id_panier)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    CONSTRAINT fk_panieritems_produit
    FOREIGN KEY (id_produit)
    REFERENCES produits(id_produit)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB;

-- =====================================================
-- TABLE : COMMANDES
-- Gestion des commandes clients
-- =====================================================

CREATE TABLE commandes (

    id_commande INT AUTO_INCREMENT PRIMARY KEY,

    id_user INT NOT NULL,

    adresse_livraison VARCHAR(500) NOT NULL,

    total DECIMAL(10,2) NOT NULL,

    statut ENUM(
        'en_attente',
        'confirmee',
        'livree',
        'annulee'
    ) DEFAULT 'en_attente',

    statut_paiement ENUM(
        'non_paye',
        'paye',
        'rembourse'
    ) DEFAULT 'non_paye',

    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_commande_user
    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB;

-- =====================================================
-- TABLE : COMMANDE_DETAILS
-- Détails des produits commandés
-- =====================================================

CREATE TABLE commande_details (

    id_detail INT AUTO_INCREMENT PRIMARY KEY,

    id_commande INT NOT NULL,

    id_produit INT NOT NULL,

    quantite INT NOT NULL,

    prix_unitaire DECIMAL(10,2) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_detail_commande
    FOREIGN KEY (id_commande)
    REFERENCES commandes(id_commande)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    CONSTRAINT fk_detail_produit
    FOREIGN KEY (id_produit)
    REFERENCES produits(id_produit)
    ON DELETE RESTRICT
    ON UPDATE CASCADE

) ENGINE=InnoDB;

-- =====================================================
-- INSERTION DES CATEGORIES PAR DEFAUT
-- =====================================================

INSERT INTO categories (
    nom_categorie,
    slug,
    description
) VALUES

(
    'Skincare',
    'skincare',
    'Produits de soin pour la peau'
),

(
    'Haircare',
    'haircare',
    'Produits de soin pour les cheveux'
),

(
    'Body Care',
    'body-care',
    'Produits de soin du corps'
),

(
    'Vitamins',
    'vitamins',
    'Compléments alimentaires et vitamines'
);

-- =====================================================
-- CREATION ADMIN PAR DEFAUT
-- Email : admin@paracare.com
-- Password : admin123
-- =====================================================

INSERT INTO users (

    nom,
    prenom,
    email,
    password,
    role,
    email_verified

) VALUES (

    'Admin',
    'ParaCare',
    'admin@paracare.com',

    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

    'admin',
    TRUE
);

-- =====================================================
-- INDEX POUR OPTIMISATION DES PERFORMANCES
-- =====================================================

CREATE INDEX idx_produit_nom
ON produits(nom);

CREATE INDEX idx_commande_statut
ON commandes(statut);

CREATE INDEX idx_user_email
ON users(email);

CREATE INDEX idx_categorie_nom
ON categories(nom_categorie);

CREATE INDEX idx_panier_user
ON panier(id_user);

CREATE INDEX idx_produit_categorie
ON produits(id_categorie);

CREATE INDEX idx_commande_user
ON commandes(id_user);

CREATE INDEX idx_commande_date
ON commandes(date_commande);

-- =====================================================
-- VUE 1 : STATISTIQUES GENERALES DASHBOARD
-- =====================================================

CREATE VIEW vue_dashboard_stats AS

SELECT

    (SELECT COUNT(*) FROM users WHERE role = 'client')
    AS total_clients,

    (SELECT COUNT(*) FROM produits)
    AS total_produits,

    (SELECT COUNT(*) FROM commandes)
    AS total_commandes,

    (SELECT IFNULL(SUM(total),0) FROM commandes
     WHERE statut != 'annulee')
    AS chiffre_affaires;

-- =====================================================
-- VUE 2 : COMMANDES RECENTES
-- =====================================================

CREATE VIEW vue_commandes_recentes AS

SELECT

    c.id_commande,

    CONCAT(u.prenom, ' ', u.nom)
    AS client,

    c.total,

    c.statut,

    c.statut_paiement,

    c.date_commande

FROM commandes c

INNER JOIN users u
ON c.id_user = u.id_user

ORDER BY c.date_commande DESC;

-- =====================================================
-- VUE 3 : PRODUITS LES PLUS COMMANDES
-- =====================================================

CREATE VIEW vue_top_produits AS

SELECT

    p.id_produit,

    p.nom,

    p.image,

    SUM(cd.quantite)
    AS total_vendus

FROM commande_details cd

INNER JOIN produits p
ON cd.id_produit = p.id_produit

GROUP BY p.id_produit

ORDER BY total_vendus DESC;