-- Création de la base de données
CREATE DATABASE IF NOT EXISTS bank ;
USE bank;

-- Table users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table accounts
CREATE TABLE accounts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    account_type ENUM('courant', 'epargne') NOT NULL,
    balance DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table transactions
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    account_id INT NOT NULL,
    transaction_type ENUM('depot', 'retrait', 'transfert') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    beneficiary_account_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (beneficiary_account_id) REFERENCES accounts(id) ON DELETE SET NULL ON UPDATE CASCADE
);



-- Insertion des utilisateurs
INSERT INTO users (name, email, password) VALUES
('Jean Dupont', 'jean.dupont@email.com', '$2y$10$abcdef123456789'),
('Marie Martin', 'marie.martin@email.com', '$2y$10$ghijkl987654321'),
('Pierre Durand', 'pierre.durand@email.com', '$2y$10$mnopqr456789123');

-- Insertion des comptes
INSERT INTO accounts (user_id, account_type, balance) VALUES
(1, 'courant', 1500.00),
(1, 'epargne', 5000.00),
(2, 'courant', 2500.00),
(2, 'epargne', 10000.00),
(3, 'courant', 3000.00);

-- Insertion des transactions
INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id) VALUES
-- Dépôts
(1, 'depot', 1000.00, NULL),
(2, 'depot', 2000.00, NULL),
(3, 'depot', 1500.00, NULL),

-- Retraits
(1, 'retrait', 200.00, NULL),
(3, 'retrait', 500.00, NULL),

-- Transferts
(1, 'transfert', 300.00, 3),
(2, 'transfert', 500.00, 4),
(3, 'transfert', 250.00, 5);

-- Ajout de l'administrateur
INSERT INTO users (id, name, email, password) VALUES 
(1, 'admin', 'admin@gmail.com', '$2y$10$abcdef123456789'); 